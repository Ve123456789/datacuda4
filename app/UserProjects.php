<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
//use Laravel\Scout\Searchable;

use Illuminate\Foundation\Auth\User as Authenticatable;

class UserProjects extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'project_name', 'project_logo','project_price','project_slug','project_path','type'
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
        return $this->hasOne('App\Purchase','id', 'project_id');
    }

}
