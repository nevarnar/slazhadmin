<?php

namespace App\Http\Repositories\Color;

use App\Models\Color;

interface ColorRepositoryInterface {

    public function list($request);

    public function availableList($request);
    
    public function createOrUpdate($request);

    public function delete(Color $color);

    public function details(Color $color);
}
