<?php

namespace App\Http\Repositories\Review;

use App\Models\Review;

interface ReviewRepositoryInterface
{

    public function list($request);

    public function create($request);

    public function delete(Review $review);

    public function details(Review $review);

    public function getReviews($id,$type);

}
