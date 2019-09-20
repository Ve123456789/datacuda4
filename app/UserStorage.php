<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
//use Laravel\Scout\Searchable;

use Illuminate\Foundation\Auth\User as Authenticatable;

class UserStorage extends Authenticatable
{
    use HasApiTokens, Notifiable;
    protected $table = 'user_storage';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'storage_name', 'storage_logo','storage_price','storage_slug','storage_path','type'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];

    public function medias()
    {
        return $this->belongsToMany('App\Media');
    }

    public function scopeOfStatus($query, $status)
    {
        if ($status != '') {
            return $query->where('status', $status);
        }
    }

    public function scopeOfMediaStatus($query, $media_id)
    {
            $media_id = 1;
            $query->whereHas('medias', function ($query) use($media_id) {
                $query->where('medias.status', 1);
            });

        return $query;
    }

    public function users()
    {
        return $this->hasOne('App\User','id', 'user_id');
    }

    public function purchase()
    {
        return $this->hasOne('App\Purchase','id', 'storage_id');
    }

}
