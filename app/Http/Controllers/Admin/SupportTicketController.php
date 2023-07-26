<?php

namespace App\Http\Controllers\Admin;

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
        $supportTicket_items=$this->supportTicketRepository->getAllList($request);
        (new ResponsePaginatedApiData($supportTicket_items, $request));
    }

    public function show(SupportTicket $supportTicket){
        $supportTicket_item=$this->supportTicketRepository->details($supportTicket);
        responseData('data',$supportTicket_item,200);
    }

    public function store(Request $request){
        $created_supportTicket_item=$this->supportTicketRepository->store($request);
        responseData('data',$created_supportTicket_item,200);
    }

    public function getReplies(Request $request){
        $replies=$this->supportTicketRepository->getReplies($request);
        responseData('data',$replies,200);
    }

    public function toggleSupportTicket(Request $request){
        $this->supportTicketRepository->toggleSupportTicket($request);
        return responseTrue('SupportTicket successfully closed  ');
    }

    public function destroy(SupportTicket $supportTicket){
        ($this->supportTicketRepository->delete($supportTicket)) ?
         responseTrue('SupportTicket Delete Successfully ') : responseFalse();
    }
}
