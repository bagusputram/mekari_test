<?php

namespace App\Models\Setting;

use Iatstuti\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Setting\RouteList;

use Hashids\Hashids;

class RouteType extends Model
{
    use SoftDeletes, CascadeSoftDeletes;

    protected $cascadeDeletes = ['routeLists'];

    protected $dates = ['deleted_at'];

    protected $table = 'route_types';
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

    public function routeLists()
    {
        return $this->hasMany(RouteList::class);
    }
}
