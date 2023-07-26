<?php

namespace App\Http\Repositories\Notification;

use DB;
use stdClass;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Actions\Notification\NotificationOverview;

class NotificationRepository implements NotificationInterface
{
    private $select_data=['id','is_read','notificationable_id','notificationable_type','read_at','notify_id'];
    public function list($request){
        $route_name=Route::currentRouteName();
        $types=[];
        if(Auth::user()->hasPermission('order-management')){
            $types=['order','sale_return'];
        }elseif(Auth::user()->hasPermission('customer-support-management')){
            $types=['support_ticket'];
        }elseif(Auth::user()->admin_type_id==1){
            $types=['order','sale_return','support_ticket'];
        }
        if(count($types)>0){
            foreach($types as $t){
                $noti_std[$t]=new stdClass();
                $notification=$route_name=='navbar_notification_list' ? $this->homeNotificationList($t) :  $this->notificationList($t);
                $notifications=(new NotificationOverview())->setCouponUser($notification);
                $noti_std[$t]=$notifications;
            }
            return $noti_std;
        }else{
            $new_std['order']=[];
            $new_std['sale_return']=[];
            $new_std['support_ticket']=[];
            return $new_std;
        }
    }
    public function homeNotificationList($t){
        return Notification::with('notify')
        ->select($this->select_data)
        ->notificationType('user')
        ->withType($t)
        ->orderBy('id','desc')
        ->latest()
        ->take(5)
        ->get();
    }

    public function notificationList($t){
        return Notification::with('notify') 
        ->select($this->select_data)
        ->withType($t)
        ->orderBy('id','desc')
        ->get();
    }

    public function readNotification($request)
    {
        return Notification::where('id',$request->id)->update([
            'read_at'=>now(),
            'is_read'=>$request->is_read,
        ]);
    }
    
    // public function readNotification($request)
    // {
    //     return Notification::where('id',$request->id)->update([
    //         'read_at'=>now(),
    //         'is_read'=>$request->is_read,
    //     ]);
    // }

}