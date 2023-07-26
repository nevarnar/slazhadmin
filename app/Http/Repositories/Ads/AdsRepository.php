<?php

namespace App\Http\Repositories\Ads;

use App\Models\Ads;
use App\Models\User;
use App\Models\Notify;
use App\Models\AdsType;
use App\Models\Notification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Actions\NameTranslation\NameSaving;
use App\Http\Actions\NameTranslation\NameSearching;
use App\Http\Actions\Notification\SaveNotification;

class AdsRepository implements AdsRepositoryInterface
{
    private $select_data = ['id', 'title', 'text', 'ads_type_id', 'adsable_type', 'adsable_id','photo','mobile_photo'];
    function list($request) {
        $ads = Ads::with(['ads_type', 'adsable'])->orderBy('created_at', 'desc')->select($this->select_data);
        if ($request->search_input != null || $request->search_input != "") {
            (new NameSearching())->searchName($ads, $request->search_input);
        }
        return $ads->get();
    }
    public function createOrUpdate($request)
    {
        $data = $request->all();
        DB::beginTransaction();
        try {
            if (isset($request->photo) ) {
                $path = UploadImage($request, 'photo');
                $data['photo'] = $path;
                if (isset($request->id)) {
                    $brand = Ads::find($request->id);
                    DeleteImage($brand->photo);
                }
                // $this->savePhoto($request,$data,'photo');
            }
            if (isset($request->mobile_photo)) {
                if($request->mobile_photo!=null){
                    $path = UploadImage($request, 'mobile_photo');
                    $data['mobile_photo'] = $path;
                    if (isset($request->id)) {
                        $brand = Ads::find($request->id);
                        DeleteImage($brand->mobile_photo);
                    }
                }
            }
            if (!isset($request->id)) {
                $data['id'] = null;
            }
            $ads = Ads::updateOrCreate(
                ['id' => $data['id']],
                $data
            );
            if(isset($request->data)){
                $json_name_data = JsonDecode($request->data);
                (new NameSaving())->run($json_name_data,$ads);
            }

            if($ads && $ads->checkMarketingAds()){
                $notify = (new SaveNotification())->saveNotify($ads, $ads->title, 'ads');
                if ($notify) {
                    $notification = (new SaveNotification())->save($notify, Auth::User(), 'admin');

                    $url = 'http://127.0.0.1:8001';
                    $data=[
                        'id'=>$notification->id,
                        'notification_count' => Notification::notificationIsRead(0)->countNotiForUser(),
                        'type' => $notification->notify->notifiable_type,
                    ];
                    $notification->toMultipleDevice(User::all(),$ads->title, $ads->text, null, $url,$data);

                }
            }
            DB::commit();
        } catch (\Exception$e) {
            DB::rollback();
            responseStatus($e->getMessage(), 402);
            throw $e;
        }
        return $this->getDetails($ads->id);
    }

    public function savePhoto($request,$data,$photo){
        $path = UploadImage($request, $photo);
        $data[$photo] = $path;
        if (isset($request->id)) {
            $ads = Ads::find($request->id);
            DeleteImage($ads->$photo);
        }
        return $data;
    }
    public function delete($ads_id)
    {
        $ads = Ads::find($ads_id);
        DeleteImage($ads->photo);
        (new NameSaving())->detachName($ads, ['en']);
        Notify::where('notifiable_id',$ads->id)
        ->where('notifiable_type','ads')->delete();
        return $ads->delete();
    }

    public function getDetails($ads_id)
    {
        return Ads::with(['ads_type', 'adsable.name_translations'])->findOrfail($ads_id);
    }
    public function details(Ads $ads)
    {
        return $ads;
        //  return Ads::with('ads_type')->findOrfail($ads_id);
    }

    public function getAdsType()
    {
        return AdsType::orderBy('created_at', 'desc')->select(['id', 'name'])->get();
    }
}
