<?php

namespace App\Http\Repositories\Country;

use App\Models\Country;

interface CountryRepositoryInterface {

    public function list();

    public function details(Country $country);
}
