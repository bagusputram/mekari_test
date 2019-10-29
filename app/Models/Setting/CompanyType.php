<?php

namespace App\Models\Setting;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Hashids\Hashids;

class CompanyType extends Model
{
    use SoftDeletes;

    protected $table = 'company_types';
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'label'
    ];

    protected $appends = ['hashid'];

    public function getHashidAttribute()
    {
        $hashids = new Hashids('', 20, 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890');
        return $hashids->encode($this->attributes['id']);
    }
}
