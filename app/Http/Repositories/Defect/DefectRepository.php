<?php

namespace App\Http\Repositories\Defect;

use App\Http\Actions\Stock\StockModule;
use App\Models\Defect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class DefectRepository implements DefectRepositoryInterface
{
    private $select_data = ['id', 'quantity', 'sub_product_id', 'floor_id', 'remark', 'created_at'];

    function list($request) {
        $status = Route::currentRouteName() === 'confirmation_list' ? 0 : 1;
        $query = Defect::with(['sub_product', 'floor.shelf.inventory'])->orderBy('created_at', 'desc')
            ->select($this->select_data);
        if ($request->date != null || $request->date != "") {
                $query->whereDate('created_at', $request->date);
        }
        if (Auth::user()->hasPermission('admin-management')) {
            $query->where('status', $status);
            if ($request->inventory_id != null || $request->inventory_id != "") {
                $query->whereHas('floor.shelf.inventory', function ($q) use ($request) {
                    $q->where('id', $request->inventory_id);
                });
            }
        }
        if (Auth::user()->hasPermission('inventory-management')) {
            $query->whereHas('floor.shelf.inventory', function ($q) use ($request) {
                $q->where('id', $request->inventory_id);
            });
        }
        return $query->get();
    }

    public function create($request)
    {
        DB::beginTransaction();
        try {
            $auth_user = Auth::user()->hasPermission('admin-management');
            $defect = Defect::create([
                'sub_product_id' => $request->sub_product_id,
                'floor_id' => $request->floor_id,
                'quantity' => $request->quantity,
                'remark' => $request->remark,
                'status' => $auth_user ? 1 : 0,
            ]);
            if ($auth_user) {
                (new StockModule())->actionStocks($request, 'subtract');
            }
            DB::commit();
        } catch (\Exception$e) {
            DB::rollback();
            responseStatus($e->getMessage(), 402);
            throw $e;
        }
        return $defect;
    }

    public function updateStatus($request)
    {
        DB::beginTransaction();
        try {
            $query = Defect::whereId($request->id);
            $defect = $query->first();
            $query->update([
                'status' => $request->status,
            ]);
            (new StockModule())->actionStocks($defect, 'subtract');
            DB::commit();
        } catch (\Exception$e) {
            DB::rollback();
            responseStatus($e->getMessage(), 402);
            throw $e;
        }

    }

    public function delete($defect)
    {
        return $defect->delete();
    }

}
