<?php
namespace App;
use Laravel\Passport\HasApiTokens;
use Auth;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Mail;
use App\UserProfile;
use App\CompanyProfile;
use App\Models\Subscription;
use Laravel\Cashier\Billable;

class User extends Authenticatable 
{
    use HasApiTokens;

    use Notifiable;
    use Billable;
    
    public function link()
    {
        return $this->hasOne(Sharelink::class);
    }

   // Tax for Billable
    public function taxPercentage() {
        return 25;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 
        'firstname', 
        'lastname', 
        'email', 
        'country_id',
        'password',
        'stripe_id',
        'card_brand',
        'card_last_four',
        'status',
        'vstatus',
        'active',
        'picture'    
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function user_profile(){
        return $this->hasOne('App\UserProfile','user_id')->withDefault(function () {
            return new UserProfile();
        });
    }

    public function company_profile(){
        return $this->hasOne('App\CompanyProfile','user_id')->withDefault(function () {
            return new CompanyProfile();
        });
    }

    public function medias()
    {
        return $this->belongsToMany('App\Media');
    }

    public function languages() {
        return $this->belongsToMany(Option::class, 'user_languages', 'user_id', 'option_id');
    }

    public function noticealerts() {
        return $this->belongsToMany(Noticealert::class, 'user_noticealerts', 'user_id', 'noticealert_id')->orderBy('id', 'desc')->where('deleted_at', null)->withPivot('status')->wherePivot('status', '!=', '2');
    }

    public function noticealertsNotOpened() {
        return $this->belongsToMany(Noticealert::class, 'user_noticealerts', 'user_id', 'noticealert_id')->where('status', 0);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles', 'user_id', 'role_id');
    }

    public function country()
    {
        return $this->hasOne(Country::class, 'id', 'country_id');
    }
    
    public function playlist()
    {
        return $this->belongsToMany(Video::class, 'user_playlist', 'user_id', 'video_id');
    }

    public function mysubscription ()
    {
        $userId = Auth::User()->id; 
        
        return $this->hasOne(Subscription::class, 'user_id', 'id')->where('user_id', $userId)->where('ends_at', '>', date('Y-m-d H:i:s'))->orWhere('ends_at', NULL)->where('user_id', $userId);
    }

    public function mysubscriptions ()
    {
        $userId = Auth::User()->id; 
        
        return $this->hasMany(Subscription::class, 'user_id', 'id');
    }

    public function payplan(){

        //Get payplan through the subscriptions table, look for user_id and stripe_id to combine.
        //Usage in a controller: return $user->payplan; gives the payplan details for the user.
        //return $this->belongsToMany('App\Payplan', 'subscriptions', 'user_id', 'stripe_id');
                        
    }

    public function scopeOfJoinSubscriptionsXXX($query)
    {
        return $query->leftjoin('subscriptions as s', 's.user_id', '=', 'users.id')
            ->addSelect(
                'users.*',
                's.id as subscription_id',
                's.name as subscription_name'
            )->groupby('users.id');
    }


    public function scopeOfSearch($query, $search)
    {
        if (isset($search) and ($search != '')) {
            $query->where('users.username', 'LIKE', '%' . $search . '%')
                ->orWhere('users.firstname', 'LIKE', '%' . $search . '%')
                ->orWhere('users.lastname', 'LIKE', '%' . $search . '%');
        }
    }

    public function scopeOfCountry($query, $country_id)
    {
        if (isset($country_id) and ($country_id != '')) {
            $country_id = explode(',', $country_id);
            $query->whereIn('country_id', $country_id);
        }
    }

    public function scopeOfPayplan($query, $payplan)
    {
        if (!empty($payplan)) {
            $payplan = explode(',', $payplan);
            $query->whereHas('subscriptions', function ($query) use($payplan) {
                $query->where('stripe_plan', $payplan);
            });
            return $query;
        }
    }    

    public function scopeOfRole($query, $role)
    {
        if (!empty($role)) {
            $role = explode(',', $role);
            $query->whereHas('roles', function ($query) use($role) {
                $query->whereIn('user_roles.role_id', $role);
            });
            return $query;
        }
    }  

    public function scopeOfStatus($query, $status)
    {
        if ($status != '') {
            return $query->where('users.status', $status);
        }
    }

    public function scopeOfDeleted($query, $deleted)
    {
        if ($deleted == '1') {
            return $query->whereNotNull('users.deleted_at');
        } else if ($deleted == '0') {
            return $query->whereNull('users.deleted_at');
        }
    }

    static function isAdmin() 
    {
        //Check if logedin
        if (Auth::check())
        {
            $userID = Auth::user()->id;
            $roles = User::find($userID)->roles;
            //dd($roles);
            //Foreach the users roles
            foreach ($roles as $key => $role) 
            {
                $roleID = $role->id;

                //Check if role have all rights
                if ($role->all == '1') 
                {   

                    //Send to adminpanel
                    return true;
                }elseif($role->all == '3'){

                    //Send to adminpanel as editor role
                    return 'Editor';
                }

                //Get permissions for the role
                $permissions = Role::find($roleID)->permissions;

                //Foreach the roles permissions
                foreach ($permissions as $key2 => $permission) 
                {
                    //If this Users role have permission for viewing adminpanel
                    if ($permission->name == 'view-backend') 
                    {
                        //Send to adminpanel
                        return true;
                    }
                }
            }   
        }
        return false;
    }

    //Check for a specific permission name
    static function roleCheck($permission_name) 
    {
        //Check if logedin
        if (Auth::check())
        {
            $userID = Auth::user()->id;
            $roles = User::find($userID)->roles;
            //Foreach the users roles
            foreach ($roles as $key => $role) 
            {
                $roleID = $role->id;

                //Check if role have all rights
                if ($role->all == '1') 
                {
                    //Send to adminpanel
                    return true;
                }

                //Get permissions for the role
                $permissions = Role::find($roleID)->permissions;

                //Foreach the roles permissions
                foreach ($permissions as $key2 => $permission) 
                {
                    //If this Users role have permission for viewing adminpanel
                    if ($permission->name == $permission_name) 
                    {
                        //Send to adminpanel
                        return true;
                    }
                }
            }   
        }
    }
    public function registrationEMail($data){
			if(!empty($data)){	
				Mail::send(['html'=>'registrationmailtheme'], ['data'=>$data], function($message)use($data){        
				$message->to($data['email'],'Registration confirmation')->subject('Registration confirmation');
				$message->from('no-reply@yogateket.com','Yogateket');	    
				});  
	        return false;
			}else{
				return true;
			}
		
    }
    
    public function subscriptions () {
        return $this->hasMany (Models\UserSubscription::class, 'user_id');
    }
}