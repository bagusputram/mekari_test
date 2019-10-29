<?php

namespace App\Models\Setting;

use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Hashids\Hashids;
use Auth;

class Menu extends Model
{
    use SoftDeletes, SoftCascadeTrait;

    protected $softCascade = ['routeLists','userMenuPermissionLists'];

    protected $table = 'menus';
    protected $primaryKey = 'id';

    protected $fillable = [
        'menu_name',
        'menu_icon',
        'menu_language',
        'menu_controller',
        'menu_position',
        'menu_parent_id',
        'user_role_id',
    ];

    protected $appends = ['hashid'];

    public function getHashidAttribute()
    {
        $hashids = new Hashids('', 20, 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890');
        return $hashids->encode($this->attributes['id']);
    }

    public function scopeOnlyRole($query) {
        $role    = Auth::user()->user_role_id;
        return $query->where('user_role_id', 'LIKE', '%"' . $role . '"%');
    }

    public function scopeBase($query) {
        return $query->where('menu_parent_id', '0');
    }

    public function parent() {
        return $this->belongsTo( Menu::class, 'menu_parent_id' );
    }

    public function childs() {
        return $this->hasMany( Menu::class, 'menu_parent_id', 'id' )->orderBy('menu_position','asc')->onlyRole();
    }

    public function role() {
        return $this->belongsTo( UserRole::class, 'user_role_id' );
    }

    public function menu() {
        return $this->belongsTo( Menu::class, 'id' );
    }

    public function routeLists()
    {
        return $this->hasMany( RouteList::class );
    }

    public function userMenuPermissionLists(){
        return $this->hasMany( UserMenuPermission::class );
    }
}
