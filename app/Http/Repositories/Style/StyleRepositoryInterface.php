<?php

namespace App\Http\Repositories\Style;

interface StyleRepositoryInterface
{
    public function list($request);

    public function availableList($request);

    public function createOrUpdate($request);

    public function details($style);

    public function getStyleListByGenderId($request);

    public function getStyleDetails($style_id);

    public function styleNameList();

    public function createStyleName($request);

}
