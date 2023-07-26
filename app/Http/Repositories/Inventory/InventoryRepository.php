<?php

namespace App\Http\Repositories\Inventory;

use App\Http\Actions\Inventory\Common;
use App\Models\Inventory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use function PHPUnit\Framework\isJson;

use function PHPUnit\Framework\isEmpty;
use App\Http\Actions\NameTranslation\NameSaving;
use App\Http\Actions\NameTranslation\NameSearching;

class InventoryRepository implements InventoryRepositoryInterface
{
    private array $select_data = ['id', 'sku','is_available'];

    function list($request) {
        $inv = Inventory::with(['name_translations:id,name,language_code,name_translationable_id', 'shelves'])->orderBy('created_at', 'desc')
        ->select($this->select_data)
        ->where('is_available',1);
        if ($request->search_input != null || $request->search_input != "") {
            (new NameSearching())->searchName($inv, $request->search_input);
        }
        return $inv->get();
    }

    public function createOrUpdate($request)
    {
        DB::beginTransaction();
        try {
            $data = $request->all();
            if (!isset($request->id)) {
                $data['id'] = null;
            }
            $created_model = Inventory::updateOrCreate(
                ['id' => $data['id']],
                $data
            );
            if(count(json_decode($request->shelves,1))!==0){
              $this->saveShelf($created_model,$request);
            }
            $json_name_data = JsonDecode($request->data);
            (new NameSaving())->run($json_name_data, $created_model);
            DB::commit();

        } catch (\Exception$e) {
            DB::rollback();
            responseStatus($e->getMessage(), 402);
            throw $e;
        }
        return $this->details($created_model);
    }

    public function delete($inv)
    {
        (new Common())->checkStockExistToDelete($inv,'floor.shelf.inventory');
        // (new NameSaving())->detachName($inv,['en']);
        return $inv->delete();
    }

    public function details($inv)
    {
        $inv->name_translations = $inv->name_translations;
        $inv->shelves = $inv->shelves;
        return $inv;
    }

    public function saveShelf($created_model, $request)
    {
            $shelves = JsonDecode($request->shelves);
            foreach($shelves as $shelf){
                $savedShelf=$created_model->createShelf([
                    'name'=>$shelf->name,
                    'floor_number'=>$shelf->floor_number,
                ]);
                if($savedShelf){
                        for ($i = 1; $i <= $savedShelf->floor_number; $i++) {
                            $savedShelf->createFloor([
                                'name'=>$savedShelf->name.'-'.$i,
                            ]);
                        }
                }
            }
       
    }
    public function deleteShelf($shelf){
        (new Common())->checkStockExistToDelete($shelf,'floor.shelf');
        return $shelf->delete();
    }

}
