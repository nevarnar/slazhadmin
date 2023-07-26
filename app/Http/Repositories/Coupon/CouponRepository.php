<?php

namespace App\Http\Repositories\Coupon;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Coupon;
use App\Models\Notify;
use App\Models\CouponType;
use App\Models\Notification;
use App\Models\CouponLimitation;
use App\Models\CouponDiscountType;
use App\Models\MinBuyingCondition;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Actions\NameTranslation\NameSaving;
use App\Http\Actions\NameTranslation\NameSearching;
use App\Http\Actions\Notification\SaveNotification;
use App\Http\Actions\DescriptionTranslation\DescriptionSaving;

class CouponRepository implements CouponInterface
{
    private $select_data =  ['id','code','start_date','end_date','discount_value'];

    public function list($request)
    {
        $query= Coupon::orderBy('created_at', 'desc')
        ->select($this->select_data);
        if($request->search_input!=null || $request->search_input!=""){
            (new NameSearching())->searchName($query,$request->search_input);
        }
        return $query->get();
    }

    public function createOrUpdate($request){
        $data = $request->all();
        $coupon_limitation_feature = $request->coupon_limitation_feature!=null ?json_decode($request->coupon_limitation_feature) : null;
        $coupon_limitation_feature_one =$request->coupon_limitation_feature_one!=null ? json_decode($request->coupon_limitation_feature_one) :null;
        $users= json_decode($request->users) ;
        DB::beginTransaction();
        try {
            if (!isset($request->id)) {
                $data['id'] = null;
            }
            $data['start_date'] = Carbon::parse($data['start_date'])->format('Y-m-d');
            $data['end_date'] = Carbon::parse($data['end_date'])->format('Y-m-d');

            if(isset($request->id)){
                $coupon_updated=Coupon::find($request->id);
                if($request->coupon_type_id==1){
                    $coupon_updated->users()->detach();
                    $data['count']=0;
                }elseif($request->coupon_type_id==2){
                    $data['count']=0;
                }elseif($request->coupon_type_id==3){
                    $coupon_updated->users()->detach();
                }
            }
            if (isset($request->photo)) {
                $path = UploadImage($request, 'photo');
                $data['photo'] = $path;
                if (isset($request->id)) {
                    DeleteImage($coupon_updated->photo);
                }
            }
            $coupon=Coupon::updateOrCreate(
                ['id' => $data['id']],
                $data
            );

              #insert name translation
              $json_name_data = JsonDecode($request->data);
              (new NameSaving())->run($json_name_data, $coupon);
              // $brand=Brand::find(json_decode($request->brand)->id);
              #end

              # insert description translation
              $json_description_data = JsonDecode($request->descriptions);
              (new DescriptionSaving())->run($json_description_data, $coupon);
              #end
            if($request->coupon_type_id==2){
                $noti_user=User::whereIn('id',array_values($users))->get();
                if(count($users)<=0){
                    responseStatus('User is required',402);
                }
                $coupon->users()->sync($users);
            }else{
                $noti_user=User::all();
            }

            if($coupon_limitation_feature!=null){
                if (isset($request->id)) {
                    CouponLimitation::where('coupon_id',$request->id)->delete();
                }
                foreach($coupon_limitation_feature as $limitation){
                    $this->couponLimitationCreate($coupon,$limitation);
                }
                // $this->couponLimitationCreate($coupon,$coupon_limitation_feature);

            }else{
                if (isset($request->id)) {
                    CouponLimitation::where('coupon_id',$coupon->id)->delete();
                }
            }

            if($coupon_limitation_feature_one!=null){
                if (isset($request->id)) {
                        MinBuyingCondition::where('coupon_id',$request->id)->delete();
                }
                foreach($coupon_limitation_feature_one as $min_buying_condition){   
                    $this->minbuyingConditionCreate($coupon,$min_buying_condition);
                }
                    // $this->minbuyingConditionCreate($coupon,$coupon_limitation_feature_one);
            }
            else{
                if (isset($request->id)) {
                    MinBuyingCondition::where('coupon_id',$coupon->id)->delete();
                }
            }
            if (!isset($request->id)) {
                if($coupon && ($request->coupon_type_id==1 || $request->coupon_type_id==2)){
                    $notify = (new SaveNotification())->saveNotify($coupon, 'You received new coupon', 'coupon');
                    if ($notify) {
                        $notification = (new SaveNotification())->save($notify, Auth::User(), 'admin');
                        $url = 'http://127.0.0.1:8001';
                        $data=[
                            'id'=>$notification->id,
                            'notification_count' => Notification::notificationIsRead(0)->countNotiForUser(),
                            'type' => $notification->notify->notifiable_type,
                            'code' => $coupon->code
                        ];
                        $notification->toMultipleDevice($noti_user,'Coupon', 'You received new coupon', null, $url,$data);
                    }
                }
            }
            
         DB::commit();
         return $coupon;
    } catch (\Exception$e) {
        DB::rollback();
        responseStatus($e->getMessage(), 402);
        throw $e;
    }
    }

    public function detail($coupon){
        $coupon->name_translations = $coupon->name_translations;
        $coupon->description_translations = $coupon->description_translations;
        $coupon->coupon_type=$coupon->coupon_type;
        $coupon->coupon_discount_type=$coupon->coupon_discount_type;
        $coupon->coupon_limitation=$coupon->coupon_limitation;
        $coupon->min_buying_condition=$coupon->min_buying_condition;
        $coupon->users= $coupon->users;
        // $coupon->users=$coupon->coupon_type_id==2 ? $coupon->users : null;
        return $coupon;

    }

    public function couponLimitationCreate($coupon,$limitation){
        CouponLimitation::create([
            'coupon_id'=>$coupon->id,
            'limitable_id'=>$limitation->id,
            'limitable_type'=>$limitation->type,
        ]);
    }
    public function minbuyingConditionCreate($coupon,$min_buying_condition){
        MinBuyingCondition::create([
            'coupon_id'=>$coupon->id,
            'buyable_id'=>$min_buying_condition->id,
            'buyable_type'=>$min_buying_condition->type,
        ]);
    }

    public function delete($coupon){
        (new NameSaving())->detachName($coupon, ['mm', 'en']);
        (new DescriptionSaving())->detachName($coupon, ['mm', 'en']);
        CouponLimitation::where('coupon_id',$coupon->id)->delete();
        MinBuyingCondition::where('coupon_id',$coupon->id)->delete();
        #delete notification
        Notify::where('notifiable_id',$coupon->id)
        ->where('notifiable_type','coupon')->delete();
        return $coupon->delete();
    }

    public function getCouponType($request){
        return CouponType::orderBy('id')->get();
    }

    public function getCouponDiscountType($request)
    {
        return CouponDiscountType::orderBy('id')->get();
    }


}
