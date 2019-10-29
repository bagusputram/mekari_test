<?php

namespace App\Models\Setting;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Hashids\Hashids;

class UserRole extends Model
{
    use SoftDeletes;

    protected $table = 'user_roles';
    protected $primaryKey = 'id';

    protected $fillable = [
        'user_role_name',
        'description'
    ];

    protected $appends = ['hashid'];

    public function getHashidAttribute()
    {
        $hashids = new Hashids('', 20, 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890');
        return $hashids->encode($this->attributes['id']);
    }///

    public function userNoSuperAdmin(){
        return UserRole::where('id', '!=', 1)->get();
    }
}
