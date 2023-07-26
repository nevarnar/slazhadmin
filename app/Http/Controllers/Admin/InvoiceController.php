<?php

namespace App\Http\Controllers\Admin;

use App\Models\Invoice;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Repositories\Invoice\InvoiceInterface;
use App\Http\Actions\ResponseData\ResponsePaginatedApiData;

class InvoiceController extends Controller
{
    private $invoiceRepository;
    public function __construct(InvoiceInterface $repo)
    {
        $this->invoiceRepository=$repo;
    }

    public function index(Request $request){
        $invoices = $this->invoiceRepository->list($request);
        (new ResponsePaginatedApiData($invoices, $request));
    }
    public function show(Invoice $invoice){
        $invoice = $this->invoiceRepository->details($invoice);
        responseData('data', $invoice, 200);

    }
}
