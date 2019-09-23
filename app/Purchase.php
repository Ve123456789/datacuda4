<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class Purchase extends Model
{
    use HasApiTokens, Notifiable;
    public $timestamps = true;
    protected $table = 'purchases';
    protected $fillable =  ['user_id','share_id','by_amount','project_id', 'filename', 'ext', 'status','email', 'user_name', 'admin_amount'];

    public function users()
    {
        return $this->hasOne('App\User','id', 'user_id');
    }
    public function projects_one()
    {
        return $this->hasOne('App\UserProjects','id', 'project_id');
    }

    public function users1() {
        return $this->belongsToMany(User::class, 'users', 'id', 'user_id');
    }
    public function projects()
    {
        return $this->belongsToMany('App\UserProject');
    }
    public function scopeOfSearch($query, $search)
    {
        if (isset($search) and ($search != '')) {
            $query->where('title', 'LIKE', '%' . $search . '%')
                ->orWhere('title', 'LIKE', '%' . $search . '%');
        }
    }

    public function scopeOfStatus($query, $status)
    {
        if ($status != '') {
            return $query->where('status', $status);
        }
    }

    public function scopeOfDeleted($query, $deleted)
    {
        if ($deleted == '2') {
            return $query->whereNotNull('deleted_at');
        } else if ($deleted == '1') {
            return $query->whereNull('deleted_at');
        }
    }

    public function shareImage () {
        return $this->belongsTo (ShareImage::class, 'share_id');
    }

    public function getByAmountAttribute ($by_amount) {
        return $by_amount - $this->admin_amount;
    }

}
