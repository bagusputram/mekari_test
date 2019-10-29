<?php

namespace App\Models\Setting;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Hashids\Hashids;

class Office extends Model
{
    use SoftDeletes;

    protected $table = 'offices';
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'company_id',
        'province_id',
        'city_id',
        'district_id',
        'subdistrict_id',
        'address',
        'phone_number',
    ];

    protected $appends = ['hashid'];

    public function getHashidAttribute()
    {
        $hashids = new Hashids('', 20, 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890');
        return $hashids->encode($this->attributes['id']);
    }

    public function Province() {
        return $this->belongsTo( Province::class, 'province_id' );
    }

    public function Company() {
        return $this->belongsTo( Company::class, 'company_id' );
    }

    public function City() {
        return $this->belongsTo( City::class, 'city_id' );
    }

    public function District() {
        return $this->belongsTo( District::class, 'district_id' );
    }

    public function Subdistrict() {
        return $this->belongsTo( Subdistrict::class, 'subdistrict_id' );
    }
}
