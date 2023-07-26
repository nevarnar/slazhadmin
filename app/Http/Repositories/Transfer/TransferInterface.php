<?php

namespace App\Http\Repositories\Transfer;


interface TransferInterface
{
    public function list($request);

    public function create($request);

    public function detail($invoice);

    public function delete($transfer);


    public function createAcceptTransfer($request);
    
}
