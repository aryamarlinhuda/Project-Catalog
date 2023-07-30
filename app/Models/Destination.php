<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    use HasFactory;

    protected $table = 'table_destination';
    protected $primaryKey = 'id';
    protected $fillable = ['name','description','category_id','address','province_id','city_id','budget','latitude','longitude'];
    protected $hidden = ['budget','category_id','province_id','city_id','category_name','province_name','city_name'];

    public function category_name() {
        return $this->belongsTo('App\Models\Category', 'category_id');
    }

    public function province_name() {
        return $this->belongsTo('App\Models\Province', 'province_id');
    }

    public function city_name() {
        return $this->belongsTo('App\Models\City', 'city_id');
    }
}