<?php

namespace App\Http\Repositories\Campaign;

use App\Models\Campaign;
use Illuminate\Support\Facades\DB;
use App\Http\Actions\NameTranslation\NameSaving;
use App\Http\Actions\DescriptionTranslation\DescriptionSaving;

class CampaignRepository implements CampaignInterface
{
    public function list($request){
        return Campaign::with(['name_translations','description_translations','discount_sub_products'])->orderBy('id', 'DESC')->get();
    }

    public function createOrUpdate($request){
         $data = $request->all();
         # photo
         if (isset($request->photo)) {
            $path = UploadImage($request, 'photo');
            $data['photo'] = $path;
            if (isset($request->id)) {
                $campaign = Campaign::find($request->id);
                DeleteImage($campaign->photo);
            }
         }
         #end
         if (!isset($request->id)) {
             $data['id'] = null;
         }
         DB::beginTransaction();
         try{
             #Campaign create
              $campaign =  Campaign::updateOrCreate(
                 ['id' => $data['id']],
                 $data
             );
             #end Campaign create
 
             //*Discount Sub Product 
                 $discount_sub_products = JsonDecode($request->discount_sub_products);
                     foreach($discount_sub_products as $p){
                         $syncData[]=$p->discount_sub_product_id;
                     }
                 $campaign->discount_sub_products()->sync($syncData);
             //*end
 
 
             #insert name translation
             $json_name_data = JsonDecode($request->data);
             (new NameSaving())->run($json_name_data, $campaign);
             #end
 
             # insert description translation
             $json_description_data = JsonDecode($request->description);
             (new DescriptionSaving())->run($json_description_data, $campaign);
             #end
             DB::commit();
         }catch(\Exception $e){
             DB::rollback();
             responseStatus($e->getMessage(),402);
             throw $e;
         }
         return $this->details($campaign);
    }

    public function details($campaign){
        $campaign->name_translations = $campaign->name_translations;
        $campaign->description_translations = $campaign->description_translations;
        $campaign->discount_sub_products=$campaign->discount_sub_products;
        $campaign->discount=$campaign->discount_sub_products[0]->discount;
        foreach($campaign->discount_sub_products as $camp){
            $camp->sub_product->discount_sub_product_id=$camp->id;
        }
        return $campaign;
    } 

    public function delete($campaign){
        DeleteImage($campaign->logo);
        (new NameSaving())->detachName($campaign,['mm','en']);
        (new DescriptionSaving())->detachName($campaign,['mm','en']);
        return $campaign->delete();
    }
}
