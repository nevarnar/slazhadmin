<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Repositories\Tag\TagRepository;
use App\Http\Actions\UniqueCheck\UniqueCheck;
use App\Http\Requests\API\Tag\TagCreateOrUpdateRequest;

class TagController extends Controller
{
    //
    private $tagRepository;

    public function __construct(TagRepository $repo)
    {
        $this->tagRepository=$repo;
    }

    public function getTags(){
        $tags=$this->tagRepository->list();
        responseData('data',$tags,200); 
    }
    public function create(TagCreateOrUpdateRequest $request){
        (new UniqueCheck())->run($request,'tag');
        $tag = $this->tagRepository->createTag($request);
        responseData('data', $tag, 200);
    }
}
