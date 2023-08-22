<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\City;
use App\Models\Destination;
use App\Models\Image;
use App\Models\Province;
use App\Models\Review;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class DestinationController extends Controller
{
    public function list() {
        $data = Destination::all();

        foreach($data as $x => $item) {
            $image = Image::where('destination_id',$item->id)->first();
            if($image) {
                $data[$x]->photo = url("storage/".$image->image);
            } else {
                $data[$x]->photo = null;
            }

            if($item->category_id) {
                $data[$x]->category = $item->category_name->category;
            } else {
                $data[$x]->category = null;
            }

            $data[$x]->province = $item->province_name->name;
            $data[$x]->city = $item->city_name->name;

            if($item->budget) {
                $budgetInRupiah = 'Rp ' . number_format($item->budget, 2, ',', '.');
                $data[$x]->price = $budgetInRupiah;
            } else {
                $data[$x]->price = "Free";
            }

            $reviews = Review::where('destination_id',$item->id)->first();
            if(!$reviews) {
                $data[$x]->rating = null;
            } else {
                $average_rating = Review::where('destination_id',$item->id)->average('rating');
                $getRating = substr($average_rating, 0, 3);
                $formattedRating = str_replace('.', ',', $getRating);
                $data[$x]->rating = $formattedRating;
            }
        }

        return response()->json([
            "status" => 200,
            "data" => $data],
            200
        );
    }

    public function detail($id) {
        $data = Destination::findOrFail($id);

        $image = Image::where('destination_id',$data->id)->pluck('image');
        $data->photo = $image;
        $url = url("storage");
        $url_image = collect($image)->map(function ($image) use ($url) {
            return $url ."/". $image;
        }); 
        $data->photo = $url_image;

        if($data->category_id) {
            $data->category = $data->category_name->category;
        } else {
            $data->category = null;
        }

        $data->province = $data->province_name->name;
        $data->city = $data->city_name->name;   
        $budgetInRupiah = 'Rp ' . number_format($data->budget, 2, ',', '.');
        $data->price = $budgetInRupiah;

        $reviews = Review::where('destination_id',$data->id)->first();
        if(!$reviews) {
            $data->rating = null;
        } else {
            $average_rating = Review::where('destination_id',$data->id)->average('rating');
            $getRating = substr($average_rating, 0, 3);
            $formattedRating = str_replace('.', ',', $getRating);
            $data->rating = $formattedRating;
        }

        $review = Review::where('destination_id',$id)->get();

        foreach($review as $x => $item) {
            $review[$x]->username = $item->maker_name->name;

            $updated_at = $item->updated_at;

            if(now()->diffInSeconds($updated_at) === 0) {
                $review[$x]->last_made = "now";
            } else if(now()->diffInSeconds($updated_at) < 60) {
                $review[$x]->last_made = now()->diffInSeconds($updated_at) . " seconds ago";
            } else if(now()->diffInSeconds($updated_at) < 3600) {
                $review[$x]->last_made = now()->diffInMinutes($updated_at) . " minutes ago";
            } else if(now()->diffInSeconds($updated_at) < 86400) {
                $review[$x]->last_made = now()->diffInHours($updated_at) . " hours ago";
            } else if(now()->diffInSeconds($updated_at) < 172800) {
                $review[$x]->last_made = "yesterday";
            } else if(now()->diffInSeconds($updated_at) >= 172800) {
                $dateTime = new DateTime($updated_at);
                $formated_date = $dateTime->format('H:i d-M-Y');
                $date = Carbon::createFromFormat('H:i d-M-Y', $formated_date);
                $review[$x]->last_made = $date->format('H.i l, d F Y');
            }
        }

        return response()->json([
            "status" => 200,
            "data" => $data,
            "review" => $review],
            200
        );
    }

    public function list_category() {
        $data = Category::orderBy('category','asc')->get();

        return response()->json([
            "status" => 200,
            "data" => $data
        ], 200);
    }

    public function filter_by_category($id) {
        $data = Destination::where('category_id',$id)->get();

        foreach($data as $x => $item) {
            $image = Image::where('destination_id',$item->id)->first();
            if($image) {
                $data[$x]->photo = url("storage/".$image->image);
            } else {
                $data[$x]->photo = null;
            }

            if($item->category_id) {
                $data[$x]->category = $item->category_name->category;
            } else {
                $data[$x]->category = null;
            }

            $data[$x]->province = $item->province_name->name;
            $data[$x]->city = $item->city_name->name;
            $budgetInRupiah = 'Rp ' . number_format($item->budget, 2, ',', '.');
            $data[$x]->price = $budgetInRupiah;

            $reviews = Review::where('destination_id',$item->id)->first();
            if(!$reviews) {
                $data[$x]->rating = null;
            } else {
                $average_rating = Review::where('destination_id',$item->id)->average('rating');
                $getRating = substr($average_rating, 0, 3);
                $formattedRating = str_replace('.', ',', $getRating);
                $data[$x]->rating = $formattedRating;
            }
        }

        return response()->json([
            "status" => 200,
            "data" => $data],
            200
        );
    }
    public function list_province() {
        $data = Province::orderBy('name','asc')->get();

        return response()->json([
            "status" => 200,
            "data" => $data
        ], 200);
    }

    public function filter_by_province($id) {
        $data = Destination::where('province_id',$id)->get();

        foreach($data as $x => $item) {
            $image = Image::where('destination_id',$item->id)->first();
            if($image) {
                $data[$x]->photo = url("storage/".$image->image);
            } else {
                $data[$x]->photo = null;
            }

            if($item->category_id) {
                $data[$x]->category = $item->category_name->category;
            } else {
                $data[$x]->category = null;
            }

            $data[$x]->province = $item->province_name->name;
            $data[$x]->city = $item->city_name->name;
            $budgetInRupiah = 'Rp ' . number_format($item->budget, 2, ',', '.');
            $data[$x]->price = $budgetInRupiah;

            $reviews = Review::where('destination_id',$item->id)->first();
            if(!$reviews) {
                $data[$x]->rating = null;
            } else {
                $average_rating = Review::where('destination_id',$item->id)->average('rating');
                $getRating = substr($average_rating, 0, 3);
                $formattedRating = str_replace('.', ',', $getRating);
                $data[$x]->rating = $formattedRating;
            }
        }

        return response()->json([
            "status" => 200,
            "data" => $data],
            200
        );
    }

    public function list_city() {
        $data = City::orderBy('name','asc')->get();

        foreach($data as $x => $item) {
            $data[$x]->province = $item->province_name->name;
        }

        return response()->json([
            "status" => 200,
            "data" => $data
        ], 200);
    }

    public function list_city_by_province($id) {
        $data = City::where('province_id',$id)->orderBy('name','asc')->get();
        
        foreach($data as $x => $item) {
            $data[$x]->province = $item->province_name->name;
        }

        return response()->json([
            "status" => 200,
            "data" => $data
        ], 200);
    }

    public function filter_by_city($id) {
        $data = Destination::where('city_id',$id)->get();

        foreach($data as $x => $item) {
            $image = Image::where('destination_id',$item->id)->first();
            if($image) {
                $data[$x]->photo = url("storage/".$image->image);
            } else {
                $data[$x]->photo = null;
            }

            if($item->category_id) {
                $data[$x]->category = $item->category_name->category;
            } else {
                $data[$x]->category = null;
            }

            $data[$x]->province = $item->province_name->name;
            $data[$x]->city = $item->city_name->name;
            $budgetInRupiah = 'Rp ' . number_format($item->budget, 2, ',', '.');
            $data[$x]->price = $budgetInRupiah;

            $reviews = Review::where('destination_id',$item->id)->first();
            if(!$reviews) {
                $data[$x]->rating = null;
            } else {
                $average_rating = Review::where('destination_id',$item->id)->average('rating');
                $getRating = substr($average_rating, 0, 3);
                $formattedRating = str_replace('.', ',', $getRating);
                $data[$x]->rating = $formattedRating;
            }
        }

        return response()->json([
            "status" => 200,
            "data" => $data],
            200
        );
    }

}
