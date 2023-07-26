<?php

namespace App\Http\Repositories\Occasion;

use App\Models\Occasion;

interface OccasionRepositoryInterface {

    public function list($request);

    public function availableList($request);
    
    public function createOrUpdate($request);

    public function delete(Occasion $occasion);

    public function details(Occasion $occasion);

}
