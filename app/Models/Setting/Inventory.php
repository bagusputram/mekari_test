<?php

namespace App\Models\Setting;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Hashids\Hashids;

class Inventory extends Model
{
    use SoftDeletes;

    protected $table = 'inventories';
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'office_id',
        'price',
        'stock_in',
        'stock_out',
        'filename',
        'mime',
        'original_filename',
    ];

    protected $appends = ['hashid'];

    public function getHashidAttribute()
    {
        $hashids = new Hashids('', 20, 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890');
        return $hashids->encode($this->attributes['id']);
    }

    public function Office() {
        return $this->belongsTo( Office::class, 'office_id' );
    }
}
