<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ReviewController extends Controller
{
    public function add_review(Request $request) {
        $id = auth()->id();

        try {
            $request->validate([
                "rating" => "required | numeric | between:1,5",
                "destination_id" => "required",
            ],[
                "rating.required" => "Rating is required!",
                "rating.numeric" => "Rating must be a number!",
                "rating.between" => "Rating must be between the numbers 1 to 5!",
                "destination_id.required" => "Destination ID is required!",
            ]);

            $rated = Review::where('created_by',$id)->first();
            if($rated) {
                return response()->json([
                    "status" => 400,
                    "message" => "You have already rated this destination",
                ], 400);
            }

            Review::create([
                "rating" => $request->input('rating'),
                "description" => $request->input('review_description'),
                "destination_id" => $request->input('destination_id'),
                "created_by" => $id
            ]);

            return response()->json([
                "status" => 200,
                "message" => "Review has been sent successfully",
            ], 200);

        } catch (ValidationException $e) {
            return response()->json([
                "status" => 400,
                "errors" => $e->errors(),
            ], 400);
        }
    }

    public function edit_review(Request $request) {
        $id = auth()->id();

        try {
            $request->validate([
                "rating" => "required | numeric | between:1,5",
                "destination_id" => "required",
            ],[
                "rating.required" => "Rating is required!",
                "rating.numeric" => "Rating must be a number!",
                "rating.between" => "Rating must be between the numbers 1 to 5!",
                "destination_id.required" => "Destination ID is required!",
            ]);

            $data = Review::where('id',$request->input('review_id'))->where('created_by',$id)->first();
            if(!$data) {
                return response()->json([
                    "status" => 404,
                    "message" => "Data not found",
                ], 404);
            } else {
                Review::where('id',$request->input('review_id'))->update([
                    "rating" => $request->input('rating'),
                    "description" => $request->input('review_description'),
                    "destination_id" => $request->input('destination_id'),
                    "created_by" => $id
                ]);
            }

            return response()->json([
                "status" => 200,
                "message" => "Review has been sent successfully",
            ], 200);

        } catch (ValidationException $e) {
            return response()->json([
                "status" => 400,
                "errors" => $e->errors(),
            ], 400);
        }
    }

    public function delete_review(Request $request) {
        $id = auth()->id();

        try {
            $request->validate([
                "review_id" => "required"
            ],[
                "review.required" => "Review ID is required!"
            ]);

            $data = Review::where('id',$request->input('review_id'))->where('created_by',$id)->first();
            if(!$data) {
                return response()->json([
                    "status" => 404,
                    "message" => "Data not found",
                ], 404);
            } else {
                Review::where('id',$request->input('review_id'))->where('created_by',$id)->delete();

                return response()->json([
                    "status" => 200,
                    "message" => "Review has been deleted successfully",
                ], 200);
            }
        } catch (ValidationException $e) {
            return response()->json([
                "status" => 400,
                "errors" => $e->errors(),
            ], 400);
        }
    }
}
