<?php

namespace App\Http\Actions\NameTranslation;

class NameSearching
{
    public function search($search_input, $type, $collection)
    {
        $input = $search_input;
        $model = Model($type);
        if ($input == null || $input == "") {
            $query = $model::with('name_translations:id,name,language_code,name_translationable_id')->orderBy('created_at', 'desc');
        } else {
            $query = $model::with('name_translations:id,name,language_code,name_translationable_id')
                ->whereHas('name_translations', function ($q) use ($input) {
                    $q->where('name', 'LIKE', '%' . $input . '%');
                })
                ->orderBy('created_at', 'desc');
        }

        #only style and pack search
        if ($type === 'style') {
                if (isset($collection['type']) || $collection != null || $collection != "") {
                    $query->whereType($collection['type']);
                }
        }
        #end

        #only delivery man by delivery id
        if ($type === 'delivery_man') {
                if (isset($collection['delivery_id']) || $collection != null || $collection != "") {
                    return $query->where('delivery_id',$collection['delivery_id'])->get();
                }
        }
        #end
        return $query->get();
        }



    public function searchName($model,$input){
        return $model->whereHas('name_translations', function ($q) use ($input) {
            $q->where('name', 'LIKE', '%' . $input . '%');
        });
    }

}
