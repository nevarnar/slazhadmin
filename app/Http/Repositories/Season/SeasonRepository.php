<?php
namespace App\Http\Repositories\Season;

use App\Models\Season;
use App\Http\Repositories\Season\SeasonRepositoryInterface;


class SeasonRepository implements SeasonRepositoryInterface{
    
    private $select_data =  ['id','name'];
    public function list(){
        return Season::select($this->select_data)->get();
    }
}