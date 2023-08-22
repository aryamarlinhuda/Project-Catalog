<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $table = 'image_destination';
    protected $primaryKey = 'id';
    protected $fillable = ['image','destination_id'];
    protected $hidden = ['image','destination_id','destination_name'];

    public function destination_name() {
        return $this->belongsTo('App\Models\Destination', 'destination_id');
    }
}
