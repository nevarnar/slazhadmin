<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\SupportTicket;
use App\Http\Controllers\Controller;
use App\Http\Actions\ResponseData\ResponsePaginatedApiData;
use App\Http\Repositories\SupportTicket\SupportTicketInterface;

class SupportTicketController extends Controller
{
    //
    private $supportTicketRepository;

    public function __construct(SupportTicketInterface $repo)
    {
        $this->supportTicketRepository=$repo;
    }

    public function index(Request $request){
        $supportTicket_items=$this->supportTicketRepository->list($request);
        (new ResponsePaginatedApiData($supportTicket_items, $request));
    }

    public function store(Request $request){
        $created_supportTicket_item=$this->supportTicketRepository->store($request);
        responseData('data',$created_supportTicket_item,200);
    }

    public function supportTicketDetails(Request $request){
        $support_ticket=$this->supportTicketRepository->supportTicketDetails($request);
        responseData('data',$support_ticket,200);
    }
    public function getSupportTicket(Request $request){
        $supportTicket_items=$this->supportTicketRepository->list($request);
        (new ResponsePaginatedApiData($supportTicket_items, $request));
    }

   
    public function replyTicket(Request $request){
        $replied_ticked=$this->supportTicketRepository->replyTicket($request);
        responseData('data',$replied_ticked,200);
    }

   
    
   

    
}
