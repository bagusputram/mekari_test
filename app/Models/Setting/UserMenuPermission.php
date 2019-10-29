<?php

namespace App\Models\Setting;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Setting\Menu;
use App\Models\Setting\MenuType;
use App\Models\Setting\UserRole;

use Hashids\Hashids;

class UserMenuPermission extends Model
{
    use SoftDeletes;

    protected $table = 'user_menu_permissions';
    protected $primaryKey = 'id';

    protected $fillable = [
        'user_role_id',
        'menu_id',
        'menu_type_id',
        'permission',
    ];

    protected $appends = ['hashid'];

    public function getHashidAttribute()
    {
        $hashids = new Hashids('', 20, 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890');
        return $hashids->encode($this->attributes['id']);
    }

    public function userRoleName(){
        return $this->belongsTo( UserRole::class, 'user_role_id' );
    }

    public function menuName(){
        return $this->belongsTo( Menu::class, 'menu_id' );
    }

    public function menuTypeName(){
        return $this->belongsTo( MenuType::class, 'menu_type_id' );
    }
}
