<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSubscription extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_subscription';

    public function user () {
        return $this->belongsTo (\App\User::class, 'user_id');
    }

    public function plan () {
        return $this->belongsTo (Plan::class, 'plan_id');
    }

    public function additional () {
        return $this->hasMany (ExtendedSubscriptions::class, 'user_subscription_id');
    }

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'status' => true,
    ];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];
}
