<?php

namespace App\Http\Actions\Listing;

use App\Models\Collection;

class CollectionListing
{
    public function card($collection){
        $collection = $this->getCollectionById($collection->id,['name_translations', 'description_translations','collection_photo']);
        $collection->feature_photo = $collection->collection_photo->name;
        UnsetData($collection, ['thing', 'collection_photo','color']);
        return $collection->only('id','feature_photo','name_translations','description_translations');
    }

    public function getCollectionById($collection_id, $with)
    {
        $collection = Collection::with($with)
            ->where('id', $collection_id)
            ->select('id')
            ->first();
        return ($collection) ?: responseStatus('Collection is not found', 404);
    }
}
