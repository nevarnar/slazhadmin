<?php

namespace App\Http\Repositories\Category;

use App\Models\Category;

use App\Models\Notification;
use App\Models\NameTranslation;
use Illuminate\Support\Facades\DB;
use App\Http\Actions\NameTranslation\NameSaving;
use App\Http\Actions\NameTranslation\NameSearching;

class CategoryRepository implements CategoryRepositoryInterface
{

    private array $select_data = ['id', 'icon', 'is_available', 'type', 'gender_id'];

    function list($request)
    {
        $a = $this->listQuery();
        if ($request->search_input != null || $request->search_input != "") {
            (new NameSearching())->searchName($a, $request->search_input);
        }
        return $a->get();
    }

    public function listQuery()
    {
        return Category::with(['name_translations:id,name,language_code,name_translationable_id', 'gender'])->orderBy('created_at', 'desc')->select($this->select_data);
    }

    public function listWithType($request, $type)
    {
        return $this->listQuery($request)
            ->whereType($type)
            ->isAvailable(1)
            ->get();
    }

    public function delete(Category $category)
    {
        DeleteImage($category->icon);
        (new NameSaving())->detachName($category, ['mm', 'en']);
        return $category->delete();
    }

    public function createOrUpdate($request)
    {
        // dd($request->all());
        $data = $request->all();
        if (isset($request->icon)) {
            $path = UploadImage($request, 'icon');
            $data['icon'] = $path;
            if (isset($request->id)) {
                $get_name = Category::find($request->id);
                DeleteImage($get_name->icon);
            }
        }
        if (!isset($request->id)) {
            $data['id'] = null;
        }
        $category = Category::updateOrCreate(
            ['id' => $data['id']],
            $data
        );
        $json_name_data = JsonDecode($request->data);
        (new NameSaving())->run($json_name_data, $category);
       
        return $this->details($category);
    }

    public function details(Category $category)
    {
        $category->name_translations = $category->name_translations;
        $category->gender = $category->gender;
        return $category;
    }

    //Mobile API
    public function getCategoriesByGender($gender_id)
    {
        $gender_ids = GetGenderIds($gender_id);
        return DB::table('categories')
            ->join('name_translations', function ($join) use ($gender_ids) {
                $join->on('categories.id', '=', 'name_translations.name_translationable_id')
                    ->where('name_translations.name_translationable_type', 'category')
                    ->where('categories.is_available', 1)
                    ->whereIn('categories.gender_id', $gender_ids);
            })
            ->orderBy('name_translations.name')
            ->select('categories.id', 'name_translations.name', 'categories.icon', 'name_translations.language_code')
            ->get()
            ->toArray();


    }
}
