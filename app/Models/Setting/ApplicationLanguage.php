<?php

namespace App\Models\Setting;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Hashids\Hashids;

class ApplicationLanguage extends Model
{
    use SoftDeletes;

    protected $table = 'application_languages';
    protected $primaryKey = 'id';

    protected $fillable = [
        'language'        
    ];

    protected $appends = ['hashid'];

    public function getHashidAttribute()
    {
        $hashids = new Hashids('', 20, 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890');
        return $hashids->encode($this->attributes['id']);
    }

    public function languageLabel(){
        return $this->belongsTo( Language::class, 'language' );
    }
}
