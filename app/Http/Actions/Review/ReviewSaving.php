<?php

namespace App\Http\Actions\Review;

use App\Models\Review;
use Illuminate\Support\Facades\DB;

class ReviewSaving
{
    public function store($data)
    {
        DB::beginTransaction();
        try {
            $review = new Review();
            $review->title = $data->title;
            $review->comment = $data->comment;
            $review->rating = $data->rating;
            $review->user_id = UserData()->id;
            $review->reviewable_id=$data->id;
            $review->reviewable_type=$data->type;
            $review->save();
            // $model->reviews()->save($review);
            DB::commit();
        } catch (\Exception$e) {
            DB::rollback();
            responseStatus($e->getMessage(), 402);
            throw $e;
        }
    }
}
