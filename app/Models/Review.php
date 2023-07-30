<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $table = 'table_review';
    protected $primaryKey = 'id';
    protected $fillable = ['rating','description','destination_id','created_by'];
    protected $hidden = ['destination_id','created_by','destination_name','maker_name'];

    public function destination_name() {
        return $this->belongsTo('App\Models\Destination', 'destination_id');
    }

    public function maker_name() {
        return $this->belongsTo('App\Models\User', 'created_by');
    }
}
