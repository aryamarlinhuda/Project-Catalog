<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\City;
use App\Models\Destination;
use App\Models\Image;
use App\Models\Province;
use App\Models\Review;
use Illuminate\Http\Request;

class DestinationController extends Controller
{
    public function list(Request $request) {
        $katakunci = $request->katakunci;

        if(strlen($katakunci)) {
            $data = Destination::where('name','like','%'.$katakunci.'%')->paginate(10);
        } else {
            $data = Destination::paginate(10);
        }
        
        return view('destination.list-destination')->with('data',$data);
    }

    public function detail($id) {
        $data = Destination::findOrFail($id);
        $images = Image::where('destination_id',$id)->get();
        $reviews = Review::where('destination_id',$id)->get();

        if(!$data->budget) {
            $data->budget = "Free";
        } else {
            $data->budget = "Rp ".number_format($data->budget).",00";
        }

        $check = Review::where('destination_id',$id)->first();
        if(!$check) {
            $data->rating = "No Reviews Yet";
        } else {
            $average_rating = Review::where('destination_id',$id)->average('rating');
            $getRating = substr($average_rating, 0, 3);
            $formattedRating = str_replace('.', ',', $getRating);
            $data->rating = $formattedRating;
        }

        return view('destination.detail-destination', compact('data','images','reviews')); 
    }
    
    public function create() {
        $categories = Category::orderBy('category','asc')->get();
        $provinces = Province::orderBy('name','asc')->get();
        $cities = City::orderBy('name','asc')->get();

        return view('destination.create-destination', compact('categories','provinces','cities'));
    }

    public function create_process(Request $request) {
        $request->validate([
            "name" => "required",
            "description" => "required",
            "category_id" => "required",
            "province_id" => "required",
            "city" => "required",
            "address" => "required",
            "latitude" => "required",
            "longitude" => "required"
        ],[
            "name.required" => "Destination Name is required!",
            "description.required" => "Description is required!",
            "category_id.required" => "Category is required!",
            "province_id.required" => "Province is required!",
            "city.required" => "City is required!",
            "address.required" => "Address is required!",
            "latitude.required" => "Latitude is required!",
            "longitude.required" => "Longitude is required!",
        ]);

        $named = Destination::where('name',$request->input('name'))->first();
        if($named) {
            return redirect('destination/create')->with('unique','Destination Name already exists!');
        }

        $check = $request->has('free');
        if($check) {
            $budget = $request->input('name');
        } else {
            $budget = null;
        }

        $request->validate([
            'files.*' => 'max:3048'
        ],[
            "photo.max" => "Photo size must be less than 3MB!",
        ]);

        $files = $request->file('files');

        if($files) {
            foreach($files as $file) {
                $format = $file->getClientOriginalExtension();
                if(!strtolower($format) === 'jpg' || !strtolower($format) === 'jpeg' || !strtolower($format) === 'png') {
                    return redirect('admin/create')->with('format','The photo destination format must be jpg, jpeg, or png!');
                }
            }
        }

        Destination::create([
            "name" => $request->input('name'),
            "description" => $request->input('description'),
            "category_id" => $request->input('category_id'),
            "province_id" => $request->input('province_id'),
            "city_id" => $request->input('city'),
            "address" => $request->input('address'),
            "budget" => $budget,
            "latitude" => $request->input('latitude'),
            "longitude" => $request->input('longitude'),
        ]);

        if($files) {
            foreach($files as $file) {
                $photo = $file->store('destination');
                $destination_id = Destination::where('name',$request->input('name'))->first();
                Image::create([
                    "image" => $photo,
                    "destination_id" => $destination_id->id
                ]);
            }
        }

        return redirect('destination/list')->with('success','Destination successfully created');
    }

    public function edit($id) {
        $data = Destination::find($id);
        $photos = Image::where('destination_id',$id)->get();
        $categories = Category::whereNotIn('id',[$data->category_id])->orderBy('category','asc')->get();
        $provinces = Province::whereNotIn('id',[$data->province_id])->orderBy('name','asc')->get();
        $cities = City::whereNotIn('id',[$data->city_id])->orderBy('name','asc')->get();

        return view('destination.edit-destination', compact('data','photos','categories','provinces','cities'));
    }

    public function edit_process($id, Request $request) {
        $data = Destination::find($id);
        $request->validate([
            "name" => "required",
            "description" => "required",
            "category_id" => "required",
            "province_id" => "required",
            "city" => "required",
            "address" => "required",
            "latitude" => "required",
            "longitude" => "required"
        ],[
            "name.required" => "Destination Name is required!",
            "description.required" => "Description is required!",
            "category_id.required" => "Category is required!",
            "province_id.required" => "Province is required!",
            "city.required" => "City is required!",
            "address.required" => "Address is required!",
            "latitude.required" => "Latitude is required!",
            "longitude.required" => "Longitude is required!",
        ]);

        $named = Destination::whereNotIn('id',[$id])->where('name',$request->input('name'))->first();
        if($named) {
            return redirect('destination/edit/'.$id)->with('unique','Destination Name already exists!');
        }

        $check = $request->has('free_budget');
        if($check) {
            $budget = $request->input('name');
        } else {
            $budget = null;
        }

        $request->validate([
            'files.*' => 'max:3048'
        ],[
            "photo.max" => "Photo size must be less than 3MB!",
        ]);

        $files = $request->file('files');

        if($files) {
            foreach($files as $file) {
                $format = $file->getClientOriginalExtension();
                if(!strtolower($format) === 'jpg' || !strtolower($format) === 'jpeg' || !strtolower($format) === 'png') {
                    return redirect('destination/edit/'.$id)->with('format','The photo destination format must be jpg, jpeg, or png!');
                }
            }
        }

        Destination::where('id',$id)->update([
            "name" => $request->input('name'),
            "description" => $request->input('description'),
            "category_id" => $request->input('category_id'),
            "province_id" => $request->input('province_id'),
            "city_id" => $request->input('city'),
            "address" => $request->input('address'),
            "budget" => $budget,
            "latitude" => $request->input('latitude'),
            "longitude" => $request->input('longitude'),
        ]);

        if($files) {
            foreach($files as $file) {
                $photo = $file->store('destination');
                $destination_id = Destination::where('name',$request->input('name'))->first();
                Image::create([
                    "image" => $photo,
                    "destination_id" => $destination_id->id
                ]);
            }
        }

        return redirect('destination/list')->with('success','Destination successfully edited');
    }

    public function del_photo($id) {
        $data = Image::where('id',$id)->first();
        Image::where('id',$id)->delete();

        return redirect('destination/edit/'.$data->destination_id)->with('deleted','Image successfully deleted');
    }
    public function delete($id) {
        Destination::where('id',$id)->delete();
        Image::where('destination_id',$id)->delete();

        return redirect('destination/list')->with('success','Destination successfully deleted');
    }
}
