<?php

namespace App\Http\Controllers\API;

use App\Models\Review;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\ReviewRequestValidate;
use App\Http\Actions\ResponseData\ResponsePaginatedApiData;
use App\Http\Repositories\Review\ReviewRepositoryInterface;

class ReviewController extends Controller
{
    //
    private $reviewRepo;
    public function __construct(ReviewRepositoryInterface $repo)
    {
        $this->reviewRepo=$repo;
    }
    public function index(Request $request){
        $reviews=$this->reviewRepo->list($request);
        return (new ResponsePaginatedApiData($reviews, $request));
    }

    public function store(ReviewRequestValidate $request){
        $this->reviewRepo->create($request);
        responseStatus('Review created successfully',200);
    }

    public function getReviewList(Request $request){
        $reviews = $this->reviewRepo->getReviews($request->id,$request->type);
        responseData('reviews',$reviews,200);
    }

    public function show(Review $review){

    }

    public function actionStatus(Request $request){
        $review= Review::find($request->id);
        if ($review) {
            $review->status = $request->status;
            $review->save();
            responseStatus('Status updated successfully', 200);
        }
        responseStatus("Status can't update for this review,Pls try again", 403);
    }

    public function destroy(Review $review){
        $review->delete();
        responseStatus('Review deleted successfully',200);
    }
}
