<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Repositories\Season\SeasonRepositoryInterface;

class SeasonController extends Controller
{
    //
    private $seasonRepository;

    public function __construct(SeasonRepositoryInterface $repo){
        $this->seasonRepository=$repo;
    }

    public function getSeasons(){
        $seasons=$this->seasonRepository->list();
        responseData('data',$seasons,200);
    }
}
