<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

use Illuminate\Foundation\Auth\User as Authenticatable;

class UserFiles extends Authenticatable
{
    use HasApiTokens, Notifiable;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'file_name', 'file_path', 'file_slug', 'file_type', 'project_id', 'created_at', 'updated_at'
    ];

    public function medias()
    {
        return $this->belongsToMany('App\Models\Media');
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];
}
