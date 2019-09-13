<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class Media extends Model
{
    use HasApiTokens, Notifiable;
    public $timestamps = true;

    protected $table = 'medias';

	protected $fillable =  ['media_type', 'title', 'filename', 'ext', 'status'];


	public function users()
	{
		return $this->belongsToMany('App\User');
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

}
