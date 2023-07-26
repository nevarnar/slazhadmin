<?php

namespace App\Http\Repositories\SupportTicket;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Admin;
use AWS\CRT\HTTP\Request;
use App\Models\TicketReply;
use App\Models\Notification;
use App\Models\SupportTicket;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Actions\Notification\SaveNotification;

class SupportTicketRepository implements SupportTicketInterface
{
    public function getAllList($request){
        $query= SupportTicket::with(['user','admin','ticket_reply'])
        ->orderBy('updated_at', 'DESC');
        if ($request->status != null || $request->status != "") {
            $query->byStatus($request->status);
        }
        return $query->get();
    }
    public function list($request){
        $route_name=Route::currentRouteName();
        $query= SupportTicket::with(['user','admin','latest_reply.replyable'])
        ->orderBy('updated_at', 'DESC');
        if ($request->status != null || $request->status != "") {
            if($request->status=='open'){
                $query->whereStatus('open')->orWhere('status','inprocess');
            }
        }
        if ($route_name==='support_ticket_by_user') {
            $query->where('user_id',UserData()->id);
        }
        $support_tickets= $query->get();
        // return $support_tickets;
        foreach($support_tickets as $st){
            // return $st->latest_reply->replyable_type;
            $st->dateTime=Carbon::create($st->date_time)->format('h:i:s A d-M-Y');
            if($st->latest_reply!=null){
                $st->latest_reply->reply_by=$st->latest_reply->replyable_type=='admin'?$st->latest_reply->replyable->user_name : $st->latest_reply->replyable->name;
                $st->latest_reply->dateTime=Carbon::create($st->latest_reply->date_time)->format('h:i:s A d-M-Y');
            }

            UnsetData($st,['user','admin','created_at','updated_at','photo','admin_id','user_id','date_time']);
            UnsetData($st->latest_reply,['replyable','replyable_id','date_time']);
        }
        return $support_tickets;
    }

    public function getReplies($request)
    {
        $query=TicketReply::with('replyable')->where('support_ticket_id',$request->support_ticket_id)->get();
        return $query;
    }

    public function store($request){
        $data=$request->all();
        DB::beginTransaction();
        try {
            if (isset($request->photo)) {
                // $photo = basename($request->file('photo')->store('images', 's3'));
                $path = UploadImage($request, 'photo');
                $data['photo'] = $path;
            }
            $id=SupportTicket::max('id');
            $no=$id==null ? 0 :$id;
            $ticket_id='TICK-'.str_pad($no+1, 7, "0", STR_PAD_LEFT);
           $data['date_time']=now();
           $data['user_id']=UserData()->id;
           $data['ticket_id']=$ticket_id;
           $data['status']='open';
            $supportTicket = SupportTicket::create(
                $data
            );
            DB::commit();
            return $supportTicket->ticket_id;
        } catch (\Exception$e) {
            DB::rollback();
            responseStatus($e->getMessage(), 402);
            throw $e;
        }
    }

    public function replyTicket($request)
    {
        $data=$request->all();
        $support_ticket = SupportTicket::where('id',$data['support_ticket_id'])->first();
       if (!$support_ticket) responseStatus('Ticket is not found !',404);

        DB::beginTransaction();
        try {
            if (isset($request->photo)) {
                // $photo = basename($request->file('photo')->store('images', 's3'));
                $path = UploadImage($request, 'photo');
                $data['photo'] = $path;
            }
           $data['date_time']=now();
           $data['replyable_id']=$request->type=='admin' ? Auth::user()->id : UserData()->id;
           $user=$request->type=='admin' ? User::all() : Admin::all() ;
           $data['replyable_type']=$request->type;
            $replyTicket = TicketReply::create(
                $data
            );
            #support ticket status update
            $support_ticket=SupportTicket::find($request->support_ticket_id);
            $support_ticket->status='inprocess';
            $support_ticket->admin_id=Auth::user()->id;
            $support_ticket->save();
            #end
            
            if($support_ticket){
                $notify = (new SaveNotification())->saveNotify($support_ticket, $support_ticket->title, 'support_ticket');
                if ($notify) {
                    $notification = (new SaveNotification())->save($notify,Auth::user(), 'admin');
                    $url = 'http://127.0.0.1:8001';
                    $data=[
                        'id'=>$notification->id,
                        'notification_count' => Notification::notificationIsRead(0)->countNotiForUser(),
                        'type' => $notification->notify->notifiable_type,
                        'ticket_id'=>$support_ticket->ticket_id,
                        'status'=>$support_ticket->status,
                        'date'=>$support_ticket->updated_at,
                    ];
                    $notification->toMultipleDevice(User::where('id',$support_ticket->user_id)->get(),$request->comment, 'Ticket replied by admin', null, $url,$data);
                }
            }
            DB::commit();
            return $replyTicket;
        } catch (\Exception$e) {
            DB::rollback();
            responseStatus($e->getMessage(), 402);
            throw $e;
        }
    }

    public function supportTicketDetails($request){
        $support_ticket=SupportTicket::with(['ticket_reply','ticket_reply.replyable'])->whereId($request->support_ticket_id)->first();
        if($support_ticket){
            $support_ticket->dateTime=Carbon::create($support_ticket->date_time)->format('h:i:s A d-M-Y');
            foreach($support_ticket->ticket_reply as $tr){
                $tr->dateTime=Carbon::create($support_ticket->date_time)->format('h:i:s A d-M-Y');
                $tr->reply_by=$tr->replyable_type=='admin'?$tr->replyable->user_name : $tr->replyable->name;
                UnsetData($tr,['replyable','replyable_id','replyable_type','support_ticket_id','date_time']);
            }
            UnsetData($support_ticket,['admin_id','user_id','created_at','updated_at','date_time']);
            return $support_ticket;
        }
        return responseStatus('Ticket is not found !',404);

    }
    public function toggleSupportTicket($request){
        $ticket=TicketReply::where('support_ticket_id',$request->id)->latest()->first();
        if($ticket && $ticket->replyable_type=='admin'){
            SupportTicket::whereId($request->id)->update([
                'status'=>'close',
            ]);
        }else{
            return responseStatus("Firstly, you need to be replied  and then You can close ticket!",422);
        }
    }

    public function details($supportTicket){
        $supportTicket->user=$supportTicket->user;
        $supportTicket->admin=$supportTicket->admin;
        $supportTicket->ticket_reply=$supportTicket->ticket_reply;
        return $supportTicket;
    }
    public function delete($supportTicket){
        if($supportTicket->status!=='close'){
            return responseStatus("Firstly, You need to close ticket  and then You can delete ticket!",422);
        }
        DeleteImage($supportTicket->photo);
        foreach($supportTicket->ticket_reply as $tk){
            DeleteImage($tk->photo);
        }
        $supportTicket->ticket_reply()->delete();
        return $supportTicket->delete();
    }
}
