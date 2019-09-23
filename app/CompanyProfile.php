<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

use Illuminate\Foundation\Auth\User as Authenticatable;

class CompanyProfile extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $table = 'company_profile';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id','company_name', 'company_address', 'company_city', 'company_state', 'company_zip', 'company_country', 'payment_type', 'company_phone_buss','company_mobile_buss','company_phone_fax', 'company_business_email', 'company_website', 'company_currency', 'company_logo', 'other_image', 'company_join_date'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];
}
