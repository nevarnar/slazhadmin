<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Repositories\Floor\FloorRepositoryInterface;

class FloorController extends Controller
{
    //
    private $floorRepository;
    public function __construct(FloorRepositoryInterface $repo)
    {
        $this->floorRepository=$repo;
    }

    public function getFloorByInventory(Request $request){
        // $inv_id=Auth::user()->isAdmin() ? $request->inventory_id : Auth::user()->inventory_id;
        $floors=$this->floorRepository->floorByInventory($request->inventory_id);
        responseData('data', $floors, 200);
    }
}
