<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserNoticealert extends Model
{

    protected $fillable = [
        'user_id',
        'noticealert_id',
        'status',
    ];

    public function noticealerts() {
        return $this->hasOne(Noticealert::class, 'id','noticealert_id')->where('deleted_at', null);
    }
    
    public function scopeOfSearch($query, $search)
    {
        if (isset($search) and ($search != '')) {
            $query->where('title', 'LIKE', '%' . $search . '%')
                ->orWhere('message', 'LIKE', '%' . $search . '%');
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
        if ($deleted == '1') {
            return $query->whereNotNull('deleted_at');
        } else if ($deleted == '0') {
            return $query->whereNull('deleted_at');
        }
    }  
}
