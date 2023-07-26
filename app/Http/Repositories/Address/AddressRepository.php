<?php

namespace App\Http\Repositories\Address;

use App\Models\Address;
use Illuminate\Support\Facades\DB;

class AddressRepository implements AddressInterface
{
    protected $selected_data=['id','name','address','phone_number','is_default','township_id'];
    public function listByUser($request){
        return Address::with(['township'])
        ->orderBy('id')
        ->where('user_id',UserData()->id)
        ->select($this->selected_data)
        ->get();
    }
    public function store($request){
        $data=$request->all();
        DB::beginTransaction();
        try {
            if(!isset($request->id)){
                $data['id'] = null ;
            }
            if($request->is_default===1 || $request->is_default==="1"){
                Address::where('is_default',1)
                ->where('user_id',UserData()->id)
                ->update([
                    'is_default'=>0
                ]);
            }
            $data['user_id']=UserData()->id;
            $address =  Address::updateOrCreate(
                ['id'=> $data['id']],
                $data
            );
            DB::commit();
        }catch (\Exception$e) {
            DB::rollback();
            responseStatus($e->getMessage(), 402);
            throw $e;
        }
        return $address;
    }
    public function delete($id){
        $address=Address::find($id);
       if($address){
         $address->delete();
         responseTrue("Deleted Successfully");
       }
       responseStatus("Address isn't found",404);
        
    }
}
