<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Hashids\Hashids;

class ToDoList extends Model
{
    //
    use SoftDeletes;

    protected $table = 'to_do_lists';
    protected $primaryKey = 'id';

    protected $fillable = [
        'task',        
        'task_created_by',
        'task_modified_by',
    ];

    protected $appends = ['hashid'];

    // create HashId
    public function getHashidAttribute()
    {
        $hashids = new Hashids('', 20, 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890');
        return $hashids->encode($this->attributes['id']);
    }
}
