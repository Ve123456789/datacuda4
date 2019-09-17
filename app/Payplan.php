<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payplan extends Model
{
    protected $fillable = [
        'plan_id',
        'object',
        'name',
        'currency',
        'amount',
        'amount_ordinary',
        'interval',
        'interval_count',
        'trial_perioddays',
        'statement_descriptor',
        'status',
        'plan_type',
    ];

    public function scopeOfSearch($query, $search)
    {
        if (isset($search) and ($search != '')) {
            $query->where('name', 'LIKE', '%' . $search . '%')
                ->orWhere('name', 'LIKE', '%' . $search . '%');
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
