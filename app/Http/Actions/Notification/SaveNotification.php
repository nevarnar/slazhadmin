<?php  
namespace App\Http\Actions\Notification;

use App\Models\Notify;
use App\Models\Notification;

class SaveNotification
{
    public function save($notify,$auth_user,$type){
        return Notification::create([
            'notify_id'=>$notify->id,
            'notificationable_id'=>$auth_user->id,
            'notificationable_type'=>$type,
        ]);
    }

    public function saveNotify($model,$title,$type){
         return Notify::create([
            'title'=>$title,
            'date_time'=>now(),
            'notifiable_id'=>$model->id,
            'notifiable_type'=>$type,
        ]);
    }
}