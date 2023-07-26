<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Gender;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class GenderController extends Controller
{
    private array $select_data =  ['id','name'];

    public function listQuery(){
        return Gender::orderBy('id', 'desc')->select($this->select_data)->whereIn('id',[1,2]);
    }

    public function getGender()
    {
        $g =  $this->setGender();
        responseData('genders',$g,200);
        $genders = Redis::get('genders');
        if(isset($genders)) {
            $data = JsonDecode($genders);
            responseData('data',$data,200);
        }else {
            $genders = $this->setGender();
            $a_genders = Redis::set('genders',$genders);
            responseData('data',$a_genders,201);
        }

    }

    protected function setGender(){
        //$genders =  $this->listQuery()->get();
        $en_all_name = new \stdClass();
        $en_all_name->id = 1;
        $en_all_name->name = 'All';
        $en_all_name->language_code = 'en';
        $en_all_name->name_translationable_id = 0;
        $mm_all_name = new \stdClass();
        $mm_all_name->id =2;
        $mm_all_name->name = 'အကုန်';
        $mm_all_name->language_code = 'mm';
        $mm_all_name->name_translationable_id = 0;
        $all = new \stdClass();
        $all->id = 0;
        $all->icon = null;
        $all->is_available = 1;
        $all->name_translations =  [$en_all_name, $mm_all_name ];

        $en_male_name = new \stdClass();
        $en_male_name->id = 3;
        $en_male_name->name = 'Male';
        $en_male_name->language_code = 'en';
        $en_male_name->name_translationable_id = 1;
        $mm_male_name = new \stdClass();
        $mm_male_name->id = 4;
        $mm_male_name->name = 'ကျားဝတ်';
        $mm_male_name->language_code = 'mm';
        $mm_male_name->name_translationable_id = 1;
        $male = new \stdClass();
        $male->id = 1;
        $male->icon = null;
        $male->is_available = 1;
        $male->name_translations =  [$en_male_name, $mm_male_name ];

        $en_female_name = new \stdClass();
        $en_female_name->id = 5;
        $en_female_name->name = 'Female';
        $en_female_name->language_code = 'en';
        $en_female_name->name_translationable_id = 2;
        $mm_female_name = new \stdClass();
        $mm_female_name->id =6;
        $mm_female_name->name = 'မဝတ်';
        $mm_female_name->language_code = 'mm';
        $mm_female_name->name_translationable_id = 2;
        $female = new \stdClass();
        $female->id = 2;
        $female->icon = null;
        $female->is_available = 1;
        $female->name_translations =  [$en_female_name, $mm_female_name ];
        return  [ $female , $male];
    }
}
