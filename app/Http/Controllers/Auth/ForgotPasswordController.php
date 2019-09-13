<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use App\User;
use DB;
class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }
    public  function reset_password($key){
        $dencrypt = key_encryption($key,'d');
        $user_email = key_encryption($dencrypt,'d');
        $user = User::whereEmail($user_email)->first();
        if (!$user) {
                return redirect('/Notfound/404');
        }
        return view('ForgetPassword');
    }

    public  function signup_verification($key){
        $dencrypt = key_encryption($key,'d');
        $user_email = key_encryption($dencrypt,'d');
        $user = User::whereEmail($user_email)->first();
        $user = User::whereEmail($user_email)->first();

        if (!$user) {
                return redirect('/Notfound/404');
        }

        $r_url = url('/').'#/login';
        User::where('email', $user_email)
          ->update([
            'vstatus' =>'1',
        ]);

        $notoclear_data = array(
            "title"=>"Account Verification",
            "message"=>"Your account has been verified successfully!",
            "created_at"=>date("Y-m-d H:i:s"),
        );

        $noticealerts_id = DB::table('noticealerts')->insertGetId($notoclear_data);

        $notoclear_relation = array(
            "user_id"=>$user->id,
            "noticealert_id"=>$noticealerts_id,
            "status"=>'1',
        );
        DB::table('user_noticealerts')->insert($notoclear_relation);
        return redirect($r_url);
        die();
    }
}
