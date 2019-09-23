<?php

namespace App\Models;

use Laravel\Cashier\Subscription as CashierSubscription;

class Subscription extends CashierSubscription
{

    public function user ()
	{
		return $this->belongsTo(User::class, 'user_id');
	}
	
	public function yourCustomMethod()
    {
        // your custom code here
    }

}
