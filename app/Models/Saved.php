<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Saved extends Model
{
    use HasFactory;

    protected $table = 'saved_destination';
    protected $primaryKey = 'id';
    protected $fillable = ['saved_by','destination_id'];

    protected $hidden = ['saved_by','destination_id','destination_name'];

    public function destination_name() {
        return $this->belongsTo('App\Models\Destination', 'destination_id');
    }
}
