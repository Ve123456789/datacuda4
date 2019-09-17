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

use ZanySoft\Zip\Zip;
use ZipArchive;
use File;

class AuthController extends Controller
{
    

    /**
        function name : Countries
        parameter     : none
        functionality : array list of countries
        table         : countries
    */
    public function countries(){
        $countries_data = DB::table('countries')->get();
        if($countries_data){
            return response()->json(['status' => 201,'data'=> $countries_data]);
        }else{
            return response()->json(['error'=>$validator->errors(),'status'=>'401'], 401);
        }
    }

    /**
        function name : State
        parameter     : countriesId
        functionality : array list of Regions
        table         : regions
    */
    public function state(Request $request){
        $c_id = $request->input('c_id');
        $regions_data = DB::table('regions')->where('country_id','=',$c_id)->get();
        if($regions_data){
            return response()->json(['status' => 201,'data'=> $regions_data]);
        }else{
            return response()->json(['error'=>$validator->errors(),'status'=>'401'], 401);
        }
    }

    /*
        function name : google_login
        working : login using google detail.
    */

    public function google_login(Request $request){
        // Validate data coming from front end.

        $client = DB::table('oauth_clients')
            ->where('password_client', true)
            ->first();
        //dd($client);
        $validator = Validator::make($request->json()->all(), [
            'U3' => 'required|email',
            //'password' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors(), 'status' => '401'], 401);
        }

        $username = $request->json()->get('ig');
        $email = $request->json()->get('U3');
        $password = "12345678";
        $user = User::whereEmail($email)->first();

        if (!$user) {

            $create=   User::create([
                'username' => $username,
                'email' => $email,
                'password' => bcrypt($password)
            ]);

            $user = User::where('email', $email)->first();
            //$stripeCardToken = $this->createStripeCardToken($request->all());
            //$user->newSubscription('main', $data['pay_plan'])->trialDays(14)->create($stripeCardToken->id);
            if($create){ 
                $mail_details = [
                    'email_id' =>$email,
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

            //$this.google_register($username,$email,$password);
            // return response()->json([
            //     'message' => 'Wrong email',
            //     'status' => 422
            // ], 422);

        }

        // If a user with the email was found - check if the specified password
        // belongs to this user
        // if (!Hash::check(request('password'), $user->password)) {
        //     return response()->json([
        //         'message' => 'Wrong password',
        //         'status' => 422
        //     ], 422);
        // }

        // Send an internal API request to get an access token
        $data = [
            'grant_type' => 'password',
            'client_id' => $client->id,
            'client_secret' => $client->secret,
            'username' => $email,
            'password' => $password,
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

    //Register new user
    public function google_register($username,$email,$password){
        echo $username; die();
        //Save data into the table
        $create=   User::create([
            'username' => $username,
            'email' => $email,
            'password' => bcrypt($password)
        ]);

        $user = User::where('email', $data['email'])->first();
        //$stripeCardToken = $this->createStripeCardToken($request->all());
        //$user->newSubscription('main', $data['pay_plan'])->trialDays(14)->create($stripeCardToken->id);
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




    //Register new user
    public function register(Request $request){
        // validate data coming from front end.
        $data = $request->all();
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'c_password' => 'required|same:password',
            /*'card_no' => 'required',
            'month' => 'required',
            'year' => 'required',
            'cvc' => 'required',*/
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors(), 'status' => '401', 'message' => 'Please fill all required fields']);
        }

        $link_encrypt  = key_encryption(request('email'));
        $link_encrypt2 = key_encryption($link_encrypt);

        $verification_link = url('/') . '/signup-verification/' . $link_encrypt2;
        //echo $verification_link; die();
        //Save data into the table
        $create=   User::create([
            'username' => request('name'),
            'email'    => request('email'),
            'password' => bcrypt(request('password'))
        ]);

        $user = User::where('email', $data['email'])->first();
        //$stripeCardToken = $this->createStripeCardToken($request->all());
        //$user->newSubscription('main', $data['pay_plan'])->trialDays(14)->create($stripeCardToken->id);
 


        if($create){ 

            DB::table('company_profile')->insert(["user_id"=>$user->id]);
            $mail_details = [
                'email_id' =>$data['email'],
                'from_id' => 'info@datatcuda.com',
                'subject' => 'Welcome to Datacuda.',
                'view' => 'mail_template/register_mail',
                'data' => array('link'=>$verification_link,'username'=>request('name')),
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
                $client = DB::table('oauth_clients')
                    ->where('password_client', true)
                    ->first();
                //dd($client);

                $username = request('email');
                $password = request('password');

                $user = User::whereEmail($username)->first();

                if (!$user) {
                    return response()->json([
                        'message' => 'Wrong email',
                        'status' => 422
                    ], 422);
                }

                // If a user with the email was found - check if the specified password
                // belongs to this user
                if (!Hash::check($password, $user->password)) {
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
                    'username' => $username,
                    'password' => $password,
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
                $user['user_profile']       = $user->user_profile;
                $user['company_profile']    = $user->company_profile;
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
                
        //return response()->json(['status' => 201, 'message' => 'User registered successfully']);
    }


   


    public function login(Request $request){
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
            'subject' => 'DataCuda  Reset Password',
            'view' => 'mail_template/forgetpass_mail',
            'data' => array('user'=>$user,'link'=>$reset_link),
        ];
        if (!send_mail($mail_details)) {
            return response()->json([
                'message' => 'Some Think Wrong',
                'status' => 422
            ], 422);

        }
        return response()->json(['status' => 201, 'message' => 'Reset Password Link Send Your Mail Id Successfully!']);
    }

    public function reset_password(Request $request){

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
        // $validator = Validator::make($request->all(), [
        //     'pay_plan' => 'required',
        //     'card_no' => 'required',
        //     'month' => 'required',
        //     'year' => 'required',
        //     'cvc' => 'required',
        // ]);
        // if ($validator->fails()) {
        //     return response()->json(['error' => $validator->errors(), 'status' => '401'], 401);
        // }
        // $user = User::where('id', auth()->user()->id)->first();
        // $stripeCardToken = $this->createStripeCardToken($request->all());
        // $user->newSubscription('main', $data['pay_plan'])->create($stripeCardToken->id);


        \Stripe\Stripe::setApiKey("sk_test_zh5dQ9OgeCGRYvK0fxnKLVs200KBZm7LzN");
        \Stripe\Charge::create([
          "amount" => 2000,
          "currency" => "usd",
          "source" => $data['id'], // obtained with Stripe.js
          //"description" => "Charge for jenny.rosen@example.com"
        ]);
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


    public function shareprojectbuy(Request $request){

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
            $s_path  = storage_path('app/usersdata/'.$dir_data['id'].'/');
            $cf_path = public_path('database/'.$data['project_data']['user']['email'].'/');
            $d_path  = public_path('database/'.$dir_data['email'].'/'.$dir_data['project_path'].$dir_data['id'].'/');
            foreach ($medias as $m_data):
                if (in_array($m_data->ext, array('jpg', 'png', 'jpeg', 'gif'))) {
                    \File::copy($s_path.$m_data->filename,$d_path.'original/'.$m_data->filename);
                } else {
                    \File::copy($s_path.$m_data->filename,$d_path.'file/'.$m_data->filename);
                }
            endforeach;

            if ($data['project_data']['share_data']['include_condition'] == "1") {
                
                if ($data['project_data']['company']['company_logo']!='') {
                    $x = \File::copy($cf_path.$data['project_data']['company']['company_logo'],$d_path.'original/'.$data['project_data']['company']['company_logo']);
                }
                if ($data['project_data']['company']['other_image']!='') {
                    \File::copy($cf_path.$data['project_data']['company']['other_image'],$d_path.'original/'.$data['project_data']['company']['other_image']);
                }
                 
            }

            $link_dencrypt = key_encryption($data['rep_id'], 'd');
            $key = key_encryption($link_dencrypt, 'd');
            ShareImage::where('recipient_id',$key)->update(['email'=> $dir_data['email'],'buy_status'=>1]);

            $share_data = ShareImage::where('recipient_id',$key)->first();
            $user_data  = User::where('id',$data['project_data']['user_id'])->first();
            $user_company_data  = DB::table('company_profile')->where('user_id',$data['project_data']['user_id'])->first();
            $country = DB::table('countries')->where('id',$user_company_data->company_country)->first();
            $state   = DB::table('regions')->where('id',$user_company_data->company_state)->first();

            $company_data = DB::table('company_profile')->where("user_id",$data['project_data']['user_id'])->first(); 

            $d_path = public_path('database/'.$dir_data['email'].'/'.$dir_data['project_path'].$dir_data['id'].'/');
            $file_name    = $d_path.'zip/'.$project_data->project_name.'.zip';

            $images = [];
            if ($share_data->include_condition == "1") {
                
                if ($company_data->company_logo !='') {
                    $images[] = $d_path.'original/'.$company_data->company_logo;
                }
                if ($company_data->other_image !='') {
                    $images[] = $d_path.'original/'.$company_data->other_image;
                }
                 
            }

            if ($images) {
                $is_valid = file_exists($file_name);
                if($is_valid): unlink($file_name); endif;
                $zip = Zip::create($file_name);
                $zip->add($images);
                $zip->close();
            }
            

            Purchase::create([
                'project_id' => $data['project_data']['id'],
                'share_id'=>$share_data->id,
                'name'   =>$data['buyerName'],
                'email'  =>$data['buyerEmail'],
                'by_amount'=>$share_data->buy_amount,
                'status' => 1
            ]);



            $mail_details = [
                'email_id' => $data['buyerEmail'],
                'from_id' => 'info@datatcuda.com',
                'subject' => 'Invoice Detail',
                'view'    => 'mail_template/mail_invoice',
                'invoice_no' =>$share_data->invoice_no,
                'date' => date("F d, Y",strtotime($share_data->created_at)),
                //'buyer_name' =>$data['buyerName'],
                'buyer_name' =>$share_data->fist_name." ".$share_data->last_name,
                'massage'   => $share_data->massage,
                'buy_amount' =>$share_data->buy_amount,
                'address' =>$share_data->address,
                'city' =>$share_data->city,
                'state' =>$share_data->state,
                'zip' =>$share_data->zip,                
                'amount'     =>explode('","',substr(substr($share_data->amount,2),0,-2)),
                'description'=>explode('","',substr(substr($share_data->description,2),0,-2)),
                'c_address'=>$user_company_data->company_address,
                'c_city'=>$user_company_data->company_city,
                'c_country'=>isset($country->name)?$country->name:'',
                'c_state'=>isset($state->name)?$state->name:'',
                'c_zip'=>$user_company_data->company_zip,
                'c_phone'=>$user_company_data->company_phone_buss,
                'c_fax'=>$user_company_data->company_phone_fax,
                'c_email'=>$user_company_data->company_business_email,
                'c_website'=>$user_company_data->company_website,
                'include_condition'=>$share_data->include_condition,
                'company_logo'=>isset($company_data->company_logo)?$company_data->company_logo:'',
                'company_flim'=>isset($company_data->other_image)?$company_data->other_image:'',
                'attechment'=>$file_name,
                'include' =>$share_data->include_condition,
            ];

            //print_r($mail_details['amount']);
            //print_r($mail_details['description']);
            //die('dhfghg');

            send_mail_invoice($mail_details);

            return response()->json(['status' => 201, 'message' => 'User Pay successfully']);
        else:
            return response()->json([
                'message' => 'Please enter valid card details',
                'status' => 422
            ], 422);
        endif;
    }



    protected function createStripeCardToken(array $data){

        //Get StripeApiKey
        \Stripe\Stripe::setApiKey(env('STRIPE_KEY'));
        //echo env('STRIPE_KEY');die;
        $eCard = null;
        try{
            // Create Stripe CardToken
            $stripeCardToken = \Stripe\Token::create(array(
                "card" => array(
                    "number" => $data['card_no'],
                    "exp_month" => $data['month'],
                    "exp_year" => $data['year'],
                    "cvc" => $data['cvc']
                )
            ));
        }catch(\Stripe\Error\RateLimit $eCard){

            // Too many requests made to the API too quickly
            //Session()->flash('flash_danger', trans('admin/payplans.ratelimit_error'));

        }catch(\Stripe\Error\InvalidRequest $eCard) {

            // Invalid parameters were supplied to Stripe's API
            //Session()->flash('flash_danger', trans('admin/payplans.invalidparameters_error'));

        }catch(\Stripe\Error\Authentication $eCard) {

            // Authentication with Stripe's API failed
            // (maybe you changed API keys recently)
            //Session()->flash('flash_danger', trans('admin/payplans.authentication_error'));

        }catch(\Stripe\Error\ApiConnection $eCard) {

            // Network communication with Stripe failed
            //Session()->flash('flash_danger', trans('admin/payplans.apiconnection_error'));

        }catch(\Stripe\Error\Base $eCard) {

            // Display a very generic error to the user, and maybe send
            // yourself an email
            //Session()->flash('flash_danger', trans('admin/payplans.created_error'));

        }catch(Exception $eCard) {

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
