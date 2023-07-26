<?php

namespace App\Http\Repositories\Tag;

interface TagRepositoryInterface{
    
    public function list();

    public function createTag($request);
}