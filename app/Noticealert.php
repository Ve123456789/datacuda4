<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Noticealert extends Model
{

    protected $fillable = [
        'lang_code',
        'title',
        'message',
    ];
  
    
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
