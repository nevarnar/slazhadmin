<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Country\CountryRepositoryInterface;
use App\Models\Country;
use App\Http\Requests\API\Country\CountryCreateOrUpdateRequest;

class CountryController extends Controller {

    private CountryRepositoryInterface $countryRepository;

    public function __construct(CountryRepositoryInterface $repo)
    {
        $this->countryRepository = $repo;
    }
    public function getAllCountries(){
        $countries = $this->countryRepository->list();
        responseData('data', $countries, 200);
    }
    public function getcountry(Country $country){
        responseData('data', $country, 200);
    }
}
