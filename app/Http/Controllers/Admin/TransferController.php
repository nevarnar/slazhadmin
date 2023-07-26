<?php

namespace App\Http\Controllers\Admin;

use App\Http\Actions\ResponseData\ResponsePaginatedApiData;
use App\Http\Controllers\Controller;
use App\Http\Repositories\Floor\FloorRepositoryInterface;
use App\Http\Repositories\Transfer\TransferInterface;
use App\Models\Transfer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransferController extends Controller
{
    //
    private $transferRepository, $floorRepository;
    public function __construct(TransferInterface $repo, FloorRepositoryInterface $floor_repo)
    {
        $this->transferRepository = $repo;
        $this->floorRepository = $floor_repo;
    }
    public function index(Request $request)
    {
        $transfers = $this->transferRepository->list($request);
        (new ResponsePaginatedApiData($transfers, $request));
    }

    public function store(Request $request)
    {
        $this->transferRepository->create($request);
        responseStatus("Stocks trasnfered successfully", 200);
    }

    public function show(Transfer $transfer)
    {
        $transfer = $this->transferRepository->detail($transfer);
        responseData('data', $transfer, 200);
    }

    // public function updateStatus(Request $request)
    // {
    //     $this->transferRepository->updateStatus($request);
    //     responseStatus("Stock status updated successfully", 200);
    // }

    public function destroy(Transfer $transfer)
    {
        $transfer = $this->transferRepository->delete($transfer);
        responseData('data', $transfer, 200);
    }

    public function createAcceptTransfer(Request $request){
        $this->transferRepository->createAcceptTransfer($request);
        responseStatus("Stocks Transfer Accept successfully", 200);
    }

    public function acceptTransfer(Transfer $transfer)
    {
        // $inventory_id = Auth::user()->inventory_id ? Auth::user()->inventory_id : responseFalse();
        $transfer = $this->transferRepository->detail($transfer);
        // $transfer->available_floors = $this->floorRepository->floorByInventory($inventory_id);
        responseData('data', $transfer, 200);
    }

    public function transferCreateView(){
        $id=\App\Models\Transfer::latest()->first();
        $no=$id==null ? 1 :$id+1;
        $transaction_id='Trs'.str_pad($no, 7, "0", STR_PAD_LEFT);
        return view('stock.transfer',compact('transaction_id'));
    }

}
