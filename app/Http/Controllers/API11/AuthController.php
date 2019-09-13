<?php

namespace App\Http\Controllers\API;

use App\Media;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\UserProfile;
use App\UserProjects;
use App\CompanyProfile;
use App\ShareImage;

use Hash;
use DB;
use App\Quotation;
use Illuminate\Support\Facades\Storage;
use PharIo\Manifest\Email;
use Validator;
use App\Purchase;
use Illuminate\Support\Facades\Mail;


class AuthController extends Controller
{
    //
    public function register(Request $request)
    {
        // validate data coming from front end.
        $data = $request->all();
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
            /*'card_no' => 'required',
            'month' => 'required',
            'year' => 'required',
            'cvc' => 'required',*/
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors(), 'status' => '401', 'message' => 'Please fill all required fields'], 401);
        }
        //Save data into the table
        $create=   User::create([
            'username' => request('name'),
            'email' => request('email'),
            'password' => bcrypt(request('password'))
        ]);

        $user = User::where('email', $data['email'])->first();
//			$stripeCardToken = $this->createStripeCardToken($request->all());
//			$user->newSubscription('main', $data['pay_plan'])->trialDays(14)->create($stripeCardToken->id);
if($create){ 
    $mail_details = [
        'email_id' =>$data['email'],
        'from_id' => 'info@datatcuda.com',
        'subject' => 'Welcome to Datacuda.',
        'view' => 'mail_template/register_mail',
        'data' => "forget_message"
        // 'data' => $reset_link
    ];
    if (!send_mail($mail_details)) {
        return response()->json([
            'message' => 'Some Think Wrong',
            'status' => 422
        ], 422);

    }
}

        $dir_data = [
            'email' => $user->email,
        ];
        create_public_dir($dir_data,'r');
        return response()->json(['status' => 201, 'message' => 'User registered successfully']);
    }

    public function login(Request $request)
    {
        // Validate data coming from front end.
        $client = DB::table('oauth_clients')
            ->where('password_client', true)
            ->first();
        //dd($client);
        $validator = Validator::make($request->all(), [
            'username' => 'required|email',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors(), 'status' => '401'], 401);
        }
        $user = User::whereEmail(request('username'))->first();

        if (!$user) {
            return response()->json([
                'message' => 'Wrong email',
                'status' => 422
            ], 422);
        }

        // If a user with the email was found - check if the specified password
        // belongs to this user
        if (!Hash::check(request('password'), $user->password)) {
            return response()->json([
                'message' => 'Wrong password',
                'status' => 422
            ], 422);
        }
        // Send an internal API request to get an access token
        $data = [
            'grant_type' => 'password',
            'client_id' => $client->id,
            'client_secret' => $client->secret,
            'username' => request('username'),
            'password' => request('password'),
        ];

        $request = Request::create('/oauth/token', 'POST', $data);

        $response = app()->handle($request);
        // Check if the request was successful
        if ($response->getStatusCode() != 200) {
            return response()->json([
                'message' => 'Wrong email and password',
                'status' => 422
            ], 422);
        }
        $user['user_profile'] = $user->user_profile;
        $user['company_profile'] = $user->company_profile;
        // Get the data from the response
        //dd($user);
        $data = json_decode($response->getContent());
        // Format the final response in a desirable format
        return response()->json([
            'token' => $data->access_token,
            'user' => $user,
            'status' => 200,
            'message' => "Login successfull"
        ]);
    }


    public function logout()
    {
        $accessToken = auth()->user()->token();

        if (empty($accessToken)) {
            return response()->json(['status' => 200, 'message' => 'Already Logged Out']);
        }

        $refreshToken = DB::table('oauth_refresh_tokens')
            ->where('access_token_id', $accessToken->id)
            ->update([
                'revoked' => true
            ]);

        $accessToken->revoke();
        return response()->json(['status' => 200, 'message' => 'Logout successful']);
    }

    public function forget_password(Request $request)
    {
        // validate data coming from front end.
        $data = $request->all();
        $validator = Validator::make($request->all(), [
            'username' => 'required|email',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors(), 'status' => '401'], 401);
        }
        $user = User::whereEmail(request('username'))->first();
        if (!$user) {
            return response()->json([
                'message' => 'Wrong email',
                'status' => 422
            ], 422);
        }
        $link_encrypt = key_encryption($user->email);
        $link_encrypt2 = key_encryption($link_encrypt);
        $reset_link = url('/') . '/reset-password-confirm/' . $link_encrypt2;
        $mail_details = [
            'email_id' => $user->email,
            'from_id' => 'info@datatcuda.com',
            'subject' => 'Datacuda Reset Password',
            'view' => 'mail_template/forgetpass_mail',
            'data' => $reset_link
        ];
        if (!send_mail($mail_details)) {
            return response()->json([
                'message' => 'Some Think Wrong',
                'status' => 422
            ], 422);

        }
        return response()->json(['status' => 201, 'message' => 'Reset Password Link Send Your Mail Id Successfully!']);
    }

    public function reset_password(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'password' => 'required',
            'c_password' => 'required|same:password'
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors(), 'status' => '401'], 401);
        }
        $password = bcrypt($request->password);
        $key = explode("reset-password-confirm/", $request->UserID);
        $dencrypt = key_encryption($key[1], 'd');
        $user_email = key_encryption($dencrypt, 'd');
        $user = User::whereEmail($user_email)->first();
        if (!$user) {
            return response()->json([
                'message' => 'Wrong Link',
                'status' => 422
            ], 422);
        }
        User::whereEmail($user_email)->update(['password' => $password]);
        return response()->json(['status' => 201, 'message' => 'Your Password Reset Successfully.']);
    }

    public function getUserDetail()
    {
        dd(auth()->user());

        return auth()->user();
    }

    public function planpay(Request $request)
    {
        // validate data coming from front end.
        $data = $request->all();
        $validator = Validator::make($request->all(), [
            'pay_plan' => 'required',
            'card_no' => 'required',
            'month' => 'required',
            'year' => 'required',
            'cvc' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors(), 'status' => '401'], 401);
        }
        $user = User::where('id', auth()->user()->id)->first();
        $stripeCardToken = $this->createStripeCardToken($request->all());
        $user->newSubscription('main', $data['pay_plan'])->create($stripeCardToken->id);
        return response()->json(['status' => 201, 'message' => 'User Pay successfully']);
    }

    public function image_buy(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($request->all(), [
            'card_no' => 'required',
            'month' => 'required',
            'year' => 'required',
            'cvc' => 'required',
        ]);
        // print_r($data);die;
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors(), 'status' => '401'], 401);
        }
        $user = User::where('id', auth()->user()->id)->first();
        $stripeCardToken = $this->createStripeCardToken($data);
        $senddata = [
            'id' => $stripeCardToken->id,
            'amount' => $data['amount']
        ];
        $status = $this->stripamountpay($senddata);
        if (!$status == 0):
            $project_data = UserProjects::where('id', $data['project_data']['id'])->first();
            $medias       = $project_data->medias()->where('status', 1)->get();
            $dir_data = [
                'id'         =>  $data['project_data']['id'],
                'email'      =>  auth()->user()->email,
                'project_path' =>  $project_data->project_path,
            ];
            create_public_dir($dir_data,'share_project');
            $s_path = storage_path('app/usersdata/'.$dir_data['id'].'/');
            $d_path = public_path('database/'.$dir_data['email'].'/'.$dir_data['project_path'].$dir_data['id'].'/');
            foreach ($medias as $m_data):
                if (in_array($m_data->ext, array('jpg', 'png', 'jpeg', 'gif'))) {
                    \File::copy($s_path.$m_data->filename,$d_path.'original/'.$m_data->filename);
                } else {
                    \File::copy($s_path.$m_data->filename,$d_path.'file/'.$m_data->filename);
                }
            endforeach;
            Purchase::create([
                'user_id' => auth()->user()->id,
                'project_id' => $data['project_data']['id'],
                'password' => encrypt('123456'),
                'status' => 1                
            ]);
            return response()->json(['status' => 201, 'message' => 'User Pay successfully']);
        else:
            return response()->json([
                'message' => 'Please enter valid card details',
                'status' => 422
            ], 422);
        endif;
    }
    public function shareimagebuy(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($request->all(), [
            'card_no' => 'required',
            'month' => 'required',
            'year' => 'required',
            'cvc' => 'required',
            'buyerName' => 'required',
            'buyerEmail' => 'required',
        ]);
        // print_r($data);die;
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors(), 'status' => '401'], 401);
        }
        $stripeCardToken = $this->createStripeCardToken($data);
        $senddata = [
            'id' => $stripeCardToken->id,
            'amount' => $data['amount'].'00'
        ];
        $status = $this->stripamountpay($senddata);
        if (!$status == 0):
            $share_data = ShareImage::where('id', $data['share_data']['id'])->first();
            $medias       = Media::where('id',$share_data->image_id)->where('status', 1)->get();
            $dir_data = [
                    'id'    => $share_data->user_id,
                    'email' => $request->buyerEmail,
                    'project_path' => 'singleimages',
            ];
            create_public_dir($dir_data,'r');
            create_public_dir($dir_data,'share_single_images');
            $s_path = storage_path('app/users/'.$dir_data['id'].'/');
            $d_path = public_path('database/'.$dir_data['email'].'/'.$dir_data['project_path'].'/');
            foreach ($medias as $m_data):
                if (in_array($m_data->ext, array('jpg', 'png', 'jpeg', 'gif'))) {
                    \File::copy($s_path.$m_data->filename,$d_path.'original/'.$m_data->filename);
                } else {
                    \File::copy($s_path.$m_data->filename,$d_path.'file/'.$m_data->filename);
                }
            endforeach;
            ShareImage::where('id',$share_data->id)->update(['email'=> $dir_data['email'],'buy_status'=>1]);
            Purchase::create([
                'image_id' => $share_data->image_id,
                'name'   =>$data['buyerName'],
                'email'  =>$data['buyerEmail'],
                'status' => 1
            ]);
            return response()->json(['status' => 201, 'message' => 'User Pay successfully']);
        else:
            return response()->json([
                'message' => 'Please enter valid card details',
                'status' => 422
            ], 422);
        endif;
    }
    public function shareprojectbuy(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($request->all(), [
            'card_no' => 'required',
            'month' => 'required',
            'year' => 'required',
            'cvc' => 'required',
            'buyerName' => 'required',
            'buyerEmail' => 'required',
        ]);
        // print_r($data);die;
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors(), 'status' => '401'], 401);
        }
        $stripeCardToken = $this->createStripeCardToken($data);
        $senddata = [
            'id' => $stripeCardToken->id,
            'amount' => $data['amount'].'00'
        ];
        $status = $this->stripamountpay($senddata);
        if (!$status == 0):
            $project_data = UserProjects::where('id', $data['project_data']['id'])->first();
            $medias       = $project_data->medias()->where('status', 1)->get();
            $dir_data = [
                'id'         =>  $data['project_data']['id'],
                'email'      =>  $data['buyerEmail'],
                'project_path' =>  $project_data->project_path,
            ];
            create_public_dir($dir_data,'r');
            create_public_dir($dir_data,'share_project');
            $s_path = storage_path('app/usersdata/'.$dir_data['id'].'/');
            $d_path = public_path('database/'.$dir_data['email'].'/'.$dir_data['project_path'].$dir_data['id'].'/');
            foreach ($medias as $m_data):
                if (in_array($m_data->ext, array('jpg', 'png', 'jpeg', 'gif'))) {
                    \File::copy($s_path.$m_data->filename,$d_path.'original/'.$m_data->filename);
                } else {
                    \File::copy($s_path.$m_data->filename,$d_path.'file/'.$m_data->filename);
                }
            endforeach;
            $link_dencrypt = key_encryption($data['rep_id'], 'd');
            $key = key_encryption($link_dencrypt, 'd');
            ShareImage::where('recipient_id',$key)->update(['email'=> $dir_data['email'],'buy_status'=>1]);
            Purchase::create([
                'project_id' => $data['project_data']['id'],
                'name'   =>$data['buyerName'],
                'email'  =>$data['buyerEmail'],
                'status' => 1
            ]);
            return response()->json(['status' => 201, 'message' => 'User Pay successfully']);
        else:
            return response()->json([
                'message' => 'Please enter valid card details',
                'status' => 422
            ], 422);
        endif;
    }
    protected function createStripeCardToken(array $data)
    {
        // Get StripeApiKey
        // \Stripe\Stripe::setApiKey(env('STRIPE_KEY'));
        // echo env('STRIPE_KEY');die;
        \Stripe\Stripe::setApiKey('pk_test_wi1SzpP6ebYdps5JcF9dDkwO');
        $eCard = null;
        try {

            // Create Stripe CardToken
            $stripeCardToken = \Stripe\Token::create(array(
                "card" => array(
                    "number" => $data['card_no'],
                    "exp_month" => $data['month'],
                    "exp_year" => $data['year'],
                    "cvc" => $data['cvc']
                )
            ));


        } catch (\Stripe\Error\RateLimit $eCard) {

            // Too many requests made to the API too quickly
            //Session()->flash('flash_danger', trans('admin/payplans.ratelimit_error'));

        } catch (\Stripe\Error\InvalidRequest $eCard) {

            // Invalid parameters were supplied to Stripe's API
            //Session()->flash('flash_danger', trans('admin/payplans.invalidparameters_error'));

        } catch (\Stripe\Error\Authentication $eCard) {

            // Authentication with Stripe's API failed
            // (maybe you changed API keys recently)
            //Session()->flash('flash_danger', trans('admin/payplans.authentication_error'));

        } catch (\Stripe\Error\ApiConnection $eCard) {

            // Network communication with Stripe failed
            //Session()->flash('flash_danger', trans('admin/payplans.apiconnection_error'));

        } catch (\Stripe\Error\Base $eCard) {

            // Display a very generic error to the user, and maybe send
            // yourself an email
            //Session()->flash('flash_danger', trans('admin/payplans.created_error'));

        } catch (Exception $eCard) {

            // Something else happened, completely unrelated to Stripe
            //Session()->flash('flash_danger', trans('admin/payplans.created_error'));
        }

        if ($eCard) {
            return false;
        } else {
            return $stripeCardToken;
        }
    }

    protected function stripamountpay(array $data)
    {

        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        $charge = \Stripe\Charge::create([
            'card' => $data['id'],
            'currency' => 'USD',
            'amount' => $data['amount'],
            'description' => 'Add in wallet',
        ]);
        //  print_r($charge);
        if ($charge['status'] == 'succeeded') {

            return $charge;

        } else {

            return 0;
        }
    }

    public function CheckIfProjectBuy($project_id)
    {
              
    $project_data = Purchase::where('project_id', $project_id)
    // ->where('user_id',auth()->user()->id)
    ->where('user_id',7)
    ->first();
     if($project_data):
            return response()->json(['status' => 201, 'data' => 1]);
        else:
            return response()->json(['status' => 201, 'data' => 0]);
        endif;
    }

    
    public function ProjectLogin(Request $request)
    {
    
        $validator = Validator::make($request->all(), [
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors(), 'status' => '401'], 401);
        }
        $user = ShareImage::where('email',request('password'))->first();

       
        // If a user with the email was found - check if the specified password
        // belongs to this user
        if (!Hash::check(request('password'), $user->project_password)) {
            return response()->json([
                'message' => 'Wrong password',
                'status' => 422
            ], 422);
        }
        // Send an internal API request to get an access token
        /*$data = [
            'grant_type' => 'password',
            'client_id' => $client->id,
            'client_secret' => $client->secret,
            'username' => request('username'),
            'password' => request('password'),
        ];*/

        $request = Request::create('/oauth/token', 'POST', $data);

        $response = app()->handle($request);
        // Check if the request was successful
        if ($response->getStatusCode() != 200) {
            return response()->json([
                'message' => 'Wrong email and password',
                'status' => 422
            ], 422);
        }
        $user['user_profile'] = $user->user_profile;
        $user['company_profile'] = $user->company_profile;
        // Get the data from the response
        //dd($user);
        $data = json_decode($response->getContent());
        // Format the final response in a desirable format
        return response()->json([
            'token' => $data->access_token,
            'user' => $user,
            'status' => 200,
            'message' => "Login successfull"
        ]);
    }

}
