<?php

namespace App\Models\Setting;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Setting\City;
use App\Models\Setting\Province;
use App\Models\Setting\District;

use Hashids\Hashids;

class Subdistrict extends Model
{
    use SoftDeletes;

    protected $table = 'subdistricts';
    protected $primaryKey = 'id';

    protected $fillable = [
        'province_id',
        'city_id',
        'district_id',
        'name',
        'postcode',
    ];

    protected $appends = ['hashid'];

    public function getHashidAttribute()
    {
        $hashids = new Hashids('', 20, 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890');
        return $hashids->encode($this->attributes['id']);
    }

    public function provinceName(){
        return $this->belongsTo( Province::class, 'province_id' );
    }

    public function cityName(){
        return $this->belongsTo( City::class, 'city_id' );
    }

    public function districtName(){
        return $this->belongsTo( District::class, 'district_id' );
    }

}
