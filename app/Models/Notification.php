<?php

namespace App\Models;

use FCM;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notification extends Model
{
    use HasFactory;

    protected $fillable=['is_read','read_at','notify_id','notificationable_id','notificationable_type'];
    public function notificationable(){
        return $this->morphTo();
    }

    public function notify(){
        return $this->belongsTo(\App\Models\Notify::class);
    }

    public function scopeNotificationIsRead($query,$type){
        return $query->where('is_read',$type);
    }

    public function scopeWithType($query,$type){
        return $query->whereHas('notify',function($q)use($type){
            $q->where('notifiable_type',$type);
        });
    }

    public function scopeNotificationType($query,$type){
        return $query->where('notificationable_type',$type);
    }

    public function scopeCountNotiForUser($query,){
        return $query->where('notificationable_type','admin')
        ->whereHas('notify',function($q){
            $q->where('notifiable_type','ads')
            ->orWhere('notifiable_type','coupon')
            ->orWhere('notifiable_type','order')
            ->orWhere('notifiable_type','support_ticket');
        })->distinct()->count();
    }

    public function scopeCountNotiForAdmin($query,$auth_admin){
        $noti_type=[];
        $type=null;
        if($auth_admin->hasPermission('order-management')){
            $type='user';
            $noti_type=['sale_return','order'];
        }elseif($auth_admin->hasPermission('customer-support-management')){
            $type='user';
            $noti_type=['super-admin','support_ticket'];
        }elseif($auth_admin->admin_type_id==1){
            $type='user';
            $noti_type=['support_ticket','order','sale_return'];
        }
        return $query->where('notificationable_type',$type)
        ->whereHas('notify',function($q)use($noti_type){
            $q->whereIn('notifiable_type',$noti_type);
        })->distinct()->count();
    }
    public function scopeCountNoti($query){
        return $query->where('notificationable_type','user')
        ->whereHas('notify',function($q){
            $q->where('notifiable_type','order')
            ->orWhere('notifiable_type','ads');
        })->count();
    }

    public function toSingleDevice($query ,$token=null,$title=null,$body=null,$icon=null,$click_action){
        $optionBuilder = new OptionsBuilder();
        $optionBuilder->setTimeToLive(60*20);

        $notificationBuilder = new PayloadNotificationBuilder($title);
        $notificationBuilder->setBody($body)
                            ->setSound('default')
                            ->setBadge(10)
                            ->setIcon($icon)
                            ->setClickAction($click_action);
        $dataBuilder = new PayloadDataBuilder();
        $option = $optionBuilder->build();
        $notification = $notificationBuilder->build();
        $data = $dataBuilder->build();
        $downstreamResponse = FCM::sendTo($token, $option, $notification, $data);

        $downstreamResponse->numberSuccess();
        $downstreamResponse->numberFailure();
        $downstreamResponse->numberModification();

        $downstreamResponse->tokensToDelete();

        $downstreamResponse->tokensToModify();

        $downstreamResponse->tokensToRetry();

        $downstreamResponse->tokensWithError();
    }

    public  function scopeToMultipleDevice($query,$model,$title=null,$body=null,$icon,$click_action="http://127.0.0.1:8001",$add_data){
        $optionBuilder = new OptionsBuilder();
        $optionBuilder->setTimeToLive(60*20);

        $notificationBuilder = new PayloadNotificationBuilder($title);
        $notificationBuilder->setBody($body)
                            ->setSound('default')
                            ->setBadge($this->where('is_read',0)->count())
                            ->setIcon($icon)
                            ->setClickAction($click_action);
        $dataBuilder = new PayloadDataBuilder();
        $dataBuilder->addData($add_data);
        // $dataBuilder->addData(['id' => $noti->id]);
        // $dataBuilder->addData(['notification_count' => $this->where('is_read',0)->count()]);
        // $dataBuilder->addData(['type' => $noti->notify->notifiable_type]);
        // if($noti->notify->notifiable_type=='coupon'){
        //     $dataBuilder->addData(['code' => $noti->notify->code]);
        // }
        $option = $optionBuilder->build();
        $notification = $notificationBuilder->build();
        $data = $dataBuilder->build();

        // You must change it to get your tokens
        $tokens = $model->pluck('device_token')->toArray();

        $downstreamResponse = FCM::sendTo($tokens, $option, $notification, $data);

        $downstreamResponse->numberSuccess();
        $downstreamResponse->numberFailure();
        $downstreamResponse->numberModification();

        $downstreamResponse->tokensToDelete();

        $downstreamResponse->tokensToModify();

        $downstreamResponse->tokensToRetry();

        $downstreamResponse->tokensWithError();
    }
    public function scopeCountOfUnread(){
        return $this->where('is_read',0);
    }
}
