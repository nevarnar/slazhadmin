<?php

namespace App\Http\Controllers\Admin;

use App\Models\Notification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Actions\Notification\NotificationOverview;
use App\Http\Repositories\Notification\NotificationInterface;


class NotificationController extends Controller
{
    //
    protected $notificationRepository;
    public function __construct(NotificationInterface $repo)
    {
        $this->notificationRepository=$repo;
    }

    public function notificationList(Request $request){
        $noti=$this->notificationRepository->list($request);
        // $unread_notification_count=Notification::countNoti();

        return response()->json([
            'data'=>$noti,
            'count'=>Notification::countNotiForAdmin(Auth::user()),
        ],200)->send() && exit(1);
    }
    public function readNotification(Request $request){
        $this->notificationRepository->readNotification($request);
        responseTrue(200);
     }
}
