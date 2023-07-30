<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Destination;
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
}
