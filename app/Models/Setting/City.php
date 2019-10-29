<?php

namespace App\Models\Setting;

use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Setting\Province;
use App\Models\Setting\District;
use App\Models\Setting\Subdistrict;

use Hashids\Hashids;

class City extends Model
{
    use SoftDeletes, SoftCascadeTrait;

    protected $softCascade = ['districtLists','subDistrictLists'];

    protected $table = 'cities';
    protected $primaryKey = 'id';

    protected $fillable = [
        'province_id',
        'name',
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

    public function districtLists()
    {
        return $this->hasMany(District::class);
    }

    public function subDistrictLists()
    {
        return $this->hasMany(Subdistrict::class);
    }
}
