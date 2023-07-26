<?php

namespace App\Http\Controllers\Admin;

use App\Http\Actions\ResponseData\ResponsePaginatedApiData;
use App\Http\Actions\Stock\StockModule;
use App\Http\Controllers\Controller;
use App\Http\Repositories\Stock\StockRepositoryInterface;
use App\Http\Requests\API\Stock\StockCreateRequest;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use stdClass;

class StockController extends Controller
{
    //
    private $stockRepository;

    public function __construct(StockRepositoryInterface $repo)
    {
        $this->stockRepository = $repo;
    }

    public function index(Request $request)
    {
        $stocks = $this->stockRepository->list($request);
        (new ResponsePaginatedApiData($stocks, $request));
    }

    public function createOrUpdate(StockCreateRequest $request)
    {
        $this->stockRepository->createOrUpdate($request);
        responseStatus("Adding stocks successfully", 200);
    }

    public function editStock(Request $request)
    {
        $stock = $this->stockRepository->editStock($request);
        responseData('data', $stock, 200);
    }

    public function saveStock(Request $request)
    {
        DB::beginTransaction();
        try {
            #not change floor
            $stock = Stock::findOrfail($request->stock_id);
            if ($stock->quantity != (int) $request->quantity) {
                $quantity = $stock->quantity - $request->quantity;
                $stock->quantity = (int) $request->quantity;
                $stock->save();
                $params = new stdClass();
                $params->sub_product_id = $request->sub_product_id;
                $params->floor_id = $stock->floor_id;
                $action = $quantity > 0 ? 'subtract' : 'add';
                $params->quantity = $quantity > 0 ? $quantity : (-1 * $quantity);
                (new StockModule())->actionStocks($params, $action);
            }
            #end

            #when change floor
            // $stock = Stock::findOrfail($request->stock_id);
            // if ($request->floor_id != $stock->floor_id) {
            //             $sub = new stdClass();
            //             $sub->quantity = (int)$request->quantity >(int)$stock->quantity ? $stock->quantity : (int)$request->quantity;
            //             $sub->sub_product_id = $request->sub_product_id;
            //             $sub->floor_id = $stock->floor_id;
            //             (new StockModule())->actionStocks($sub, 'subtract');
            //             $add = new stdClass();
            //             $add->quantity = (int)$request->quantity;
            //             $add->sub_product_id = $request->sub_product_id;
            //             $add->floor_id = $request->floor_id;
            //             (new StockModule())->actionStocks($add, 'add');
            // }else{
            //     $quantity = (int)$stock->quantity - (int)$request->quantity;
            //     if ($stock->quantity != (int) $request->quantity) {
            //         $params = new stdClass();
            //         $params->sub_product_id = $request->sub_product_id;
            //         $params->floor_id = $request->floor_id;
            //         $action = $quantity > 0 ? 'subtract' : 'add';
            //         $params->quantity = $quantity > 0 ? $quantity : (-1 * $quantity);
            //         (new StockModule())->actionStocks($params, $action);
            //     }
            // }
            // $stock->floor_id = $request->floor_id;
            // $stock->quantity = (int)$request->quantity;
            // $stock->save();
            #end
            DB::commit();
            return $stock;
        } catch (\Exception $e) {
            DB::rollback();
            responseStatus($e->getMessage(), 402);
            throw $e;
        }
    }
    public function getStockBySubProduct(Request $request)
    {
        $stock = $this->stockRepository->getStockBySubProduct($request);
        responseData('data', $stock, 200);
    }

    public function getSubProductInStock(Request $request)
    {
        $stock = $this->stockRepository->getSubProductInStock($request);
        responseData('data', $stock, 200);
    }

    public function getDiscountSubProductInStock(Request $request)
    {
        $stock = $this->stockRepository->getDiscountSubProductInStock($request);
        responseData('data', $stock, 200);
    }

    public function getSubProductBySeriesAndBrand(Request $request)
    {
        $stocks = $this->stockRepository->getSubProductBySeriesAndBrand($request);
        responseData('data', $stocks, 200);
    }

    public function getItemWithTypeInStock(Request $request)
    {
        $stocks = $this->stockRepository->getItemWithTypeInStock($request);
        responseData('data', $stocks, 200);
    }

}
