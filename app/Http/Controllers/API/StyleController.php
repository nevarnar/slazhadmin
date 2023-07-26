<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Style\StyleRepositoryInterface;
use Illuminate\Http\Request;

class StyleController extends Controller
{
    private $styleRepository;

    public function __construct(StyleRepositoryInterface $repo)
    {
        $this->styleRepository=$repo;
    }

    public function getStyleListByGender(Request $request){
           $styles =  $this->styleRepository->getStyleListByGenderId($request);
           $paginated_styles = paginate($styles,$request);
           responseData('styles',$paginated_styles,200);
    }

    public function getStyleDetails(Request $request){

        $style =  $this->styleRepository->getStyleDetails($request->style_id);
        responseData('style',$style,200);
    }
}
