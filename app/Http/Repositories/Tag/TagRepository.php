<?php

namespace App\Http\Repositories\Tag;

use App\Http\Repositories\Tag\TagRepositoryInterface;
use App\Http\Actions\NameTranslation\NameSaving;
use App\Models\Tag;

class TagRepository implements TagRepositoryInterface
{
    private $select_data=['id','is_feature'];
    public function list()
    {
        $tags = Tag::with('name_translations:id,name,language_code,name_translationable_id')->select($this->select_data)->orderBy('created_at','desc')->get();
        return $tags;
    }
    public function createTag($request)
    {
        $data = $request->all();
        $tag = Tag::create(
            $data
        );
        $json_name_data = JsonDecode($request->data);
        (new NameSaving())->run($json_name_data, $tag);
        return $this->list();
    }
}
