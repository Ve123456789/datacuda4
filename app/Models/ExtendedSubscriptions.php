<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExtendedSubscriptions extends Model
{
    public function userSubscription () {
        return $this->belongsTo (UserSubscription::class, 'user_subscription_id');
    }

    public function plan () {
        return $this->belongsTo (Plan::class, 'plan_id');
    }
}
