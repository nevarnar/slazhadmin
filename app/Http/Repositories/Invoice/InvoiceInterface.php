<?php

namespace App\Http\Repositories\Invoice;

interface InvoiceInterface
{
    public function list($request);

    public function details($invoice);
    
}
