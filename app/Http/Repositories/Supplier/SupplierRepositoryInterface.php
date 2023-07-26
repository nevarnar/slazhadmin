<?php

namespace App\Http\Repositories\Supplier;

use App\Models\Supplier;

interface SupplierRepositoryInterface{

    public function list($request);

    public function createOrUpdate($request);

    public function delete(Supplier $supplier);

    public function details(Supplier $supplier);
}
