<?php  
namespace App\Http\Actions\Notification;
use App\Models\Notify;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class NotificationOverview
{
   public function setCouponUser($notification){
    $notifications=[];
    foreach($notification as $noti){
        if($noti->notify->notifiable!=null){
            // if($noti->notify->notifiable_type=='coupon'){
            //     if($noti->notify->notifiable->coupon_type->name=='private'){
            //         if(!UserData()){
            //             responseStatus("User isn't found",401); 
            //         }
            //          $private_coupon= $noti->notify->notifiable->users->whereIn('id',UserData()->id);
            //          if($private_coupon->isNotEmpty()){
            //             array_push($notifications,$noti);
            //          }
            //     }elseif($noti->notify->notifiable->coupon_type->name=='public'){
            //         array_push($notifications,$noti);
            //     }
            // }
            if($noti->notify->notifiable_type=='sale_return'){
                if(Auth::user()->hasPermission('order-management') ||  Auth::user()->admin_type_id==1){
                    $noti->order_id=$noti->notify->notifiable->order->order_id;
                    $noti->reason=$noti->notify->notifiable->reason->name;
                    array_push($notifications , $noti);
                }
            }
            else{
                array_push($notifications , $noti);
            }
        }
        
    }
    return $notifications;
   }
}