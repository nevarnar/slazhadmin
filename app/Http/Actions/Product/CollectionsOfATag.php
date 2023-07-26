<?php

namespace App\Http\Actions\Product;

use App\Models\Collection;
use App\Models\NameTranslation;
use Illuminate\Support\Facades\DB;

class CollectionsOfATag
{
    public function run($tag,$gender_id)
    {
        $gender_ids = GetGenderIds($gender_id);
        $tag_id = NameTranslation::where([['name_translationable_type', 'tag'], ['name', $tag]])
            ->pluck('name_translationable_id')->all();
        $collection_ids = DB::table('kindables')
            ->join('things', function ($join) {
                $join->on('things.id', '=', 'kindables.thing_id')
                    ->where('things.thingable_type', '=', 'collection');
            })
            ->where('kindable_type', 'tag')
            ->where('kindable_id', $tag_id)
            ->pluck('things.thingable_id');
        $collections = Collection::with('name_translations', 'description_translations')
            ->whereIn('id', $collection_ids)
            ->WhereHas('thing.genders', function ($query) use ($gender_ids) {
                $query->whereIn('id', $gender_ids);
            })
            ->take(6)->get();
        foreach ($collections as $collection) {
            $collection->feature_photo = $collection->collection_photo->name;
            UnsetData($collection, ['thing', 'collection_photo']);
        }
        return $collections;
    }
}
