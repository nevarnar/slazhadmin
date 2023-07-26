<?php

namespace App\Http\Repositories\SupportTicket;

interface SupportTicketInterface
{
    public function list($request);

    public function getAllList($request);

    public function store($request);

    public function replyTicket($request);

    public function getReplies($request);

    public function supportTicketDetails($request);

    public function toggleSupportTicket($request);

    public function details($supportTicket);

    public function delete($supportTicket);
}
