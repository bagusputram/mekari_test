<?php

namespace App\Models\Setting;

use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Setting\City;
use App\Models\Setting\District;
use App\Models\Setting\Subdistrict;

use Hashids\Hashids;

class Province extends Model
{
    use SoftDeletes, SoftCascadeTrait;

    protected $softCascade = ['cityLists','districtLists','subDistrictLists'];

    protected $table = 'provinces';
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
    ];

    protected $appends = ['hashid'];

    public function getHashidAttribute()
    {
        $hashids = new Hashids('', 20, 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890');
        return $hashids->encode($this->attributes['id']);
    }

    public function cityLists()
    {
        return $this->hasMany(City::class);
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
