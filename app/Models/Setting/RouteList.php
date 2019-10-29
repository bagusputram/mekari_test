<?php

namespace App\Models\Setting;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Setting\Menu;
use App\Models\Setting\MenuType;
use App\Models\Setting\RouteControllerType;
use App\Models\Setting\RouteType;

use Hashids\Hashids;

class RouteList extends Model
{
    use SoftDeletes;

    protected $table = 'route_lists';
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'route_type_id',
        'route_controller_type_id',
        'route_controller_name',
        'route_menu_name',
        'menu_type_id',
        'menu_id',
        'route_link',
    ];

    protected $appends = ['hashid'];

    public function getHashidAttribute()
    {
        $hashids = new Hashids('', 20, 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890');
        return $hashids->encode($this->attributes['id']);
    }

    public function RouteControllerType() {
        return $this->belongsTo( RouteControllerType::class, 'route_controller_type_id' );
    }

    public function RouteType() {
        return $this->belongsTo( RouteType::class, 'route_type_id' );
    }

    public function Menu(){
        return $this->belongsTo( Menu::class, 'menu_id' );
    }

    public function MenuType(){
        return $this->belongsTo( MenuType::class, 'menu_type_id' );
    }
}
