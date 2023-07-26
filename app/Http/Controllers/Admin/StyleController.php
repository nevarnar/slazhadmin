<?php

namespace App\Http\Controllers\Admin;

use App\Models\Style;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Actions\UniqueCheck\UniqueCheck;
use App\Http\Requests\API\Style\StyleRequest;
use App\Http\Repositories\Style\StyleRepositoryInterface;
use App\Http\Actions\ResponseData\ResponsePaginatedApiData;

class StyleController extends Controller
{
    private $styleRepository;

    public function __construct(StyleRepositoryInterface $repo)
    {
        $this->styleRepository=$repo;
    }

    public function getAllStyles(Request $request){
        $styles=$this->styleRepository->list($request);
        (new ResponsePaginatedApiData($styles, $request));
    }
    public function getStyles(Request $request){
        $styles=$this->styleRepository->availableList($request);
        responseData('data',$styles,200);
    }

    public function getStyle(Style $style){
        $styles=$this->styleRepository->details($style);
        responseData('data',$styles,200);
    }

    public function createOrUpdate(Request $request){
        (new UniqueCheck())->run($request,'style');
        $style=$this->styleRepository->createOrUpdate($request);
        responseData('data',$style,200);
    }

    public function changeStyleIsAvailable(Request $request){
        $style= Style::find($request->id);
        if ($style) {
            $style->is_available = $request->is_available;
            $style->save();
            responseStatus('Available update successfully', 200);
        }
        responseStatus("Available can't update for this product,Pls try again", 200);
    }

    public function getStyleName(){
        $styles=$this->styleRepository->styleNameList();
        responseData('data',$styles,200);
    }

    public function createStyleName(Request $request){
        (new UniqueCheck())->run($request,'style_name');
        $style=$this->styleRepository->createStyleName($request);
        responseData('data',$style,200);
    }

    public function checkBuyingStyle(Request $request){
        $style=Style::find($request->style_id);
        if($style){
            $order_item=OrderItem::whereHas('order',function($q)use($request){
                $q->where('status','confirmed')
                ->where('user_id',$request->user_id);
            })
            ->where('orderable_type','style')
            ->where('orderable_id',$request->style_id)
            ->first();
            if($order_item){
                responseStatus('This style have been bought by user',402);
            }
            responseStatus("This style haven't been bought by user",402);
        }
        responseStatus("Style isn't found",404);

         
    }

   
}
