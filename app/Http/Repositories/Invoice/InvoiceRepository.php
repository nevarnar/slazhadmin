<?php

namespace App\Http\Repositories\Invoice;

use App\Models\Invoice;
use Illuminate\Support\Facades\Auth;

class InvoiceRepository implements InvoiceInterface
{
    private $select_data = ['id', 'invoice_no', 'supplier_id', 'created_at'];

    function list($request) {
        $query = Invoice::with(['supplier', 'instocks.floor.shelf.inventory'])->orderBy('created_at', 'desc')
            ->select($this->select_data);
        if ($request->date != null || $request->date != "") {
            $query->whereDate('created_at', $request->date);
        }
        if (Auth::user()->hasPermission('admin-management')) {
            if ($request->inventory_id != null || $request->inventory_id != "") {
                $query->byInventory($request);
            }
        }
        if (Auth::user()->hasPermission('inventory-management')) {
            $query->byInventory($request);
        }
        return $query->get();
    }
    public function details($invoice)
    {
        $invoice->stocks = $invoice->stocks;
        return $invoice;
    }
}
