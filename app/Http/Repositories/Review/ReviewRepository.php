<?php

namespace App\Http\Repositories\Review;

use App\Http\Actions\Review\ReviewSaving;
use App\Models\Review;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class ReviewRepository implements ReviewRepositoryInterface
{
    private $selecte_data=['title','comment','rating','user_id','created_at','reviewable_id','reviewable_type'];
    public function list($request){
        $name=Route::currentRouteName();
        $query=Review::orderBy('id','desc');
        if($name=='get_reviews'){
            if($request->status){
                $query->status($request->status);
            }
            if($request->type){
                $query->getWithType($request->type);

            }
            return $query->with('user','reviewable')
            // ->where('reviewable_type',$request->type)
            ->get();

        }
        return $query->with(['user:id,name'])->select($this->selecte_data)->status('approved')->whereProductId($request->product_id)->get();

    }

    public function create($request){
        // $model=$request->type==='product' ? \App\Models\Product::find($request->id) :\App\Models\Style::find($request->id);
         (new ReviewSaving())->store($request);
    }

    public function delete(Review $review){

    }

    public function details(Review $review){

    }


    public function getReviews($id,$type)
    {
        $query = DB::table('reviews')
            ->where([['status','approved'],['reviewable_id',$id],['reviewable_type',$type]]);
        $ratings = $query
            ->select(DB::raw('count(*) as count'),'rating')
            ->groupBy('rating')
            ->get();
        $contents  =$query
            ->join('users', 'users.id','=','reviews.user_id')
            ->select(DB::raw('DATE_FORMAT(reviews.created_at , "%d %b %Y") as date'),
                DB::raw('users.name as user_name'),
                'reviews.title','reviews.comment','reviews.rating')
            ->orderBy('reviews.id','desc')
            ->get();

        $reviews = new \stdClass();
        $reviews->ratings = $ratings;
        $reviews->contents = $contents;
        return $reviews;

    }
}
