<?php

namespace App\Http\Repositories\Notification;

interface NotificationInterface
{
    
    public function list($request);

    public function readNotification($request);

}