<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShareImage extends Model
{
    //

    public function users()
    {
        return $this->hasOne('App\User','id', 'user_id');
    }

    public function projects()
    {
        return $this->belongsToMany('App\UserProjects','share_images', 'id','project_id');
    }

    public function projects_one()
    {
        return $this->hasOne('App\UserProjects','id', 'project_id');
    }

    public function purchase()
    {
        return $this->hasOne('App\Purchase','id', 'project_id');
    }
}
