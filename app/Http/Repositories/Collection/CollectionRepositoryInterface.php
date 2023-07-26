<?php

namespace App\Http\Repositories\Collection;

interface CollectionRepositoryInterface
{
    public function list($request);

    public function createOrUpdate($request);

    public function details($collection);

    public function destroy($collection);

    public function getListByGender($request);

    public function collectionDetail($collection_id,$request);

    public function getProductsByCollection($collection_id,$request);

    public function getStylesByCollection($collection_id,$request);
}
