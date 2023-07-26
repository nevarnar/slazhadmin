<?php

namespace App\Http\Repositories\Division;

use App\Models\Division;

class DivisionRepository implements DivisionInterface
{
    public function list($request){
        return Division::with(['name_translations:id,name,language_code,name_translationable_id',])->orderBy('id', 'DESC')->select(['id'])->get();
    }
    public function delete($township){
        return $township->delete();
    }
}
