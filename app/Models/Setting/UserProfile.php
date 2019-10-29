<?php

namespace App\Models\Setting;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;
use Spatie\Image\Manipulations;


use Hashids\Hashids;

use App\Models\Setting\ApplicationThemeColor;
use App\Models\Setting\Language;

class UserProfile extends Model implements HasMedia
{
    use SoftDeletes, HasMediaTrait;

    protected $table = 'user_profiles';
    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'profile_picture_id',
        'application_language',
        'application_theme_color'
    ];

    protected $appends = ['hashid'];

    public function getHashidAttribute()
    {
        $hashids = new Hashids('', 20, 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890');
        return $hashids->encode($this->attributes['id']);
    }

    public function applicationThemeColorCode(){
        return $this->belongsTo( ApplicationThemeColor::class, 'application_theme_color' );
    }

    public function applicationLanguageId(){
        return $this->belongsTo( Language::class, 'application_language' );
    }

    public function profilePicture(){
        return $this->hasOne(Media::class, 'id', 'profile_picture_id');
    }

    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')->width(368)->height(232)->sharpen(10);
        $this->addMediaConversion('large-mobile')->width(750)->height(549);
        $this->addMediaConversion('large')->width(920)->height(400);
        $this->addMediaConversion('medium')->width(600)->height(400);
        $this->addMediaConversion('small')->width(300)->height(200);
        $this->addMediaConversion('slider')->width(1920)->height(1080);
        $this->addMediaConversion('slider_mobile')->width(750)->height(1079);
    }
}
