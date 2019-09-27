<?php
namespace App;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class BankingProfile extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $table = 'banking_profile';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id','first_name', 'last_name', 'phone', 'email', 'dob', 'address', 'state', 'city','zip','card_no', 'month', 'year', 'cvc', 'ssn', 'status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];
}
