<?php
namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\UserProfile;
use App\UserProjects;
use Storage;
use Auth;
use Hash;
use DB;
use App\CompanyProfile;
use App\Models\Payplan;
use App\Purchase;
use App\Quotation;
use Validator;
use App\ShareImage;
use App\contact;
use App\admin;
use Mail;

class UserController extends Controller
{
    

    //function register
    public function register(Request $request){
        // validate data coming from front end.
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors(),'status'=>'401'], 401);
        }
        //Save data into the table

        User::create([
            'name' => request('name'),
            'email' => request('email'),
            'password' => bcrypt(request('password'))
        ]);

        return response()->json(['status' => 201,'message'=> 'User registered successfully']);
    }


    public function uploadProfilePic(Request $request){
        $id = Auth::user()->id;
        $data = $request->file()['file'];
        $validator = Validator::make($request->all(), [
            'file' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors(),'status'=>'401'], 401);
        }
        if (!empty($data)) {
            $file_name = $data->getClientOriginalName();
            $ext = pathinfo($file_name, PATHINFO_EXTENSION);
            $ext = strtolower($ext);
            /*$file_name = $id.'.'.$ext;
            $file_folder = 'public/';
            Storage::put(
                $file_folder.$file_name,
                file_get_contents($data->getRealPath())
            );*/
            $file_name = 'profilepic.'.$ext;
            $destinationPath = public_path('database/'.Auth::user()->email);
            if(file_exists($destinationPath.'/'.$file_name)):
                unlink($destinationPath.'/'.$file_name);
            endif;
            $data->move($destinationPath,$file_name);
            $user = User::find($id);
            if($user) {
                $user->picture = $file_name;
                $user->save();
            }
            return response()->json(['status' => 200,'token' => request('auth_token'),'message'=> 'User profile picture updated','file_name'=>$file_name]);

        } else {
            return response()->json(['status' => 300,'token' => request('auth_token'),'message'=> 'User profile updated']);
        }


    }
    public  function company_file_upload(Request $request, $route)
    {
        $id = Auth::user()->id;
        $data = $request->file()['file'];
        $validator = Validator::make($request->all(), [
            'file' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors(),'status'=>'401'], 401);
        }
        if (!empty($data)) {
            $file_name = $data->getClientOriginalName();
            $ext = pathinfo($file_name, PATHINFO_EXTENSION);
            $ext = strtolower($ext);
           // $file_name = $id.'-'.$route.'.'.$ext;
            $file_name = $route.'.'.$ext;
            $destinationPath = public_path('database/'.Auth::user()->email);
            if(file_exists($destinationPath.'/'.$file_name)):
                unlink($destinationPath.'/'.$file_name);
            endif;
            $data->move($destinationPath,$file_name);
            /*$file_folder = 'public/';
            Storage::put(
                $file_folder.$file_name,
                file_get_contents($data->getRealPath())
            );*/
            $field_name = '';
            if($route == 'logo'):
                $field_name = 'company_logo';
            elseif ($route == 'other'):
                $field_name = 'other_image';
            endif;

            CompanyProfile::where('user_id', $id)
                ->update([$field_name => $file_name]);
                
            return response()->json(['status' => 200,'token' => request('auth_token'),'message'=> 'Company picture updated','file_name'=>$file_name]);

        } else {
            return response()->json(['status' => 300,'token' => request('auth_token'),'message'=> 'Company picture updated']);
        }
    }

    public function getUserDetail(){
        $user = User::where('id', auth()->user()->id)->first();
        $user['user_profile'] = $user->user_profile;
        $user['company_profile'] = $user->company_profile;
        return response()->json(['status' => 200,'token' => request('auth_token'),'message'=> 'User profile updated','user'=>$user]);
    }


    public function getPatplans()
    {
        $user           = User::where('id', auth()->user()->id)->first();
        $subscripation  = $user->mysubscription;
        $payplandata    = Payplan::all()->toArray();
        $payplan        = [];
        foreach ($payplandata as $pdata)
        {
            $payplan[] =
                [
                    'id'           =>$pdata['id'],
                    //'plan_id'      =>$pdata['plan_id'],
                    'name'         =>$pdata['name'],
                    'amount'       =>$pdata['amount'],
                    'activeplan'   => (!empty($subscripation)) ? ($pdata['plan_id'] == $subscripation['stripe_plan']) ? 'Active' : 'In-Active' :'In-Active',
                ];
        }
        return response()->json(['status' => 200,'token' => request('auth_token'),'message'=> 'Success','payplans'=>$payplan]);
    }

    

    public function getUserSubscriptionDetails()
    {
        $user           = User::where('id', auth()->user()->id)->first();
        $subscription   = $user->mysubscription;
        if($subscription){
            $subscription['active_plan_detail']    = Payplan::where('plan_id',$subscription->stripe_plan)->first();
            return response()->json(['status' => 200,'token' => request('auth_token'),'message'=> 'Success','subscription_details'=>$subscription]);
        }
        
    }

    public function getplandetails(Request $request)
    {
        $data   =Payplan::where('id',$request->id)->get()->first();
        if($data):
            return response()->json(['status' => 200,'token' => request('auth_token'),'message'=> 'Success','data'=>$data]);
        else:
            return response()->json([
                'message' =>'Wrong id',
                'status' => 422
            ], 422);
        endif;
    }

    public function user_profile(Request $request){

        // validate data coming from front end.
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            //'full_name' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors(),'status'=>'401'], 401);
        }
        //Save data into the table
        $user_present = UserProfile::whereUserId(request('user_id'))->first();
 
        if($user_present){
            
            $user_present->update([
                'user_id' => request('user_id'),
                'dob'     => request('dob'),
                'full_name' => request('first_name')." ".request('last_name'),
                'first_name'=>request('first_name'),
                'last_name'=>request('last_name'),
                'address' => request('address'),
                'logo' => request('logo'),
                'phone' => request('phone')
            ]);

        } else {

            UserProfile::create([
                'user_id' => request('user_id'),
                'dob'     => request('dob'),
                'full_name' => request('first_name').request('last_name'),
                'first_name'=>request('first_name'),
                'last_name'=>request('last_name'),
                'address' => request('address'),
                'logo' => request('logo'),
                'phone' => request('phone')
            ]);
        }
        /*$user = User::where('id', auth()->user()->id)->first();
        $user['user_profile'] = $user->user_profile;
        $user['company_profile'] = $user->company_profile;*/
        return response()->json(['status' => 200,'token' => request('auth_token'),'message'=> 'User profile updated'/*,'user'=>$user*/]);
    }

    /***
    * Table   : company_profile.
    * Working : Updating company profile.
    */

    public function company_profile(Request $request){

        $data = '';
        $user_present = CompanyProfile::where('user_id',$request->user_id)->first();
        $userData     = User::where('id',$request->user_id)->first();
        $user_profile = UserProfile::where('user_id',$request->user_id)->first();

        //user first name and last name retrive 
        $nameData   = explode(" ",$userData->username);
        $fname      = $nameData[0];
        $lname      = $nameData[1];

        //User dob explode. 
        $dob = explode("-",$user_profile->dob);

        /* ==== Stripe connect account create start here ===*/
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));


       if (empty($userData->connect_id)) {
           /**
            * Created Stripe connect account.
            * Updated user table.
            */
            $connect = \Stripe\Account::create([
                "type"    => "custom",
                "country" => "US",
                "email"   => $userData->user_email,
                "business_type" => "individual",
                "requested_capabilities" => ["card_payments", "transfers"],
            ]);

            $userData->update([
                'connect_id' => $connect->id,
            ]);
            $payment_account_id  = $connect->id;

       }else{
            $payment_account_id  = $userData->connect_id;
       }
        

        $account = \Stripe\Account::retrieve($payment_account_id);

  
        //chacking unvarifidy account
        if(count($account->requirements->currently_due) > 0){

            $stripe_user_data = [
                'individual' => [
                    'first_name' => $fname,
                    'last_name'  => $lname,
                    'dob'   =>[
                            'day'=>$dob[2],
                            'month'=>$dob[1],
                            'year' => $dob[0],
                        ],
                    'phone'=>$request->company_phone_buss,
                    'email'=>$userData->email,
                    'address'=>[
                            'postal_code'   =>$request->company_zip,
                            'line1'         =>$request->company_address,
                            //'line2'         =>'8 Prospect st',
                            'city'          =>$request->company_city,
                            'state'         =>$request->company_state,
                            'country'       =>'US'
                        ],
                    'ssn_last_4'=>$request->ssn,
                    // 'verification'=>[
                    //         'document'=>[
                    //                 'front'=>$stripeUpload->id,
                    //                 'back'=>'file_5dtoJkOhAxrMWb',
                    //             ]
                    //     ],
                ],
                'tos_acceptance'=>[
                    'date'=>time(),
                    'ip'  =>$_SERVER['REMOTE_ADDR'],
                ],
                'business_profile'=>[
                    'url'=>'http://datacuda.com',
                    'mcc'=>8299
                ],
            ];
            
          

            $file            = $request->file('file');
            $profile_photo  = time() . '_' . $file->getClientOriginalName();
            $destinationPath = public_path('/stripedoc');
            $file->move($destinationPath,$profile_photo);
            
            $stripeUpload  = \Stripe\FileUpload::create(
              [
                "purpose" => "identity_document",
                "file" => fopen($destinationPath.'/'.$profile_photo, 'r')
              ],
              ["stripe_account" => $payment_account_id]
            );

            $stripe_user_data['individual']['verification']['document']['front'] = $stripeUpload->id;
            /**
            * Updating stripe connect account
            */
            \Stripe\Account::update($payment_account_id,$stripe_user_data);
        }
        

        /**
        * Create stripe token.
        * Retrive stripe connect account and adding card on stripe account.
        */
        if(!empty($request->card_no) && !empty($request->month) && !empty($request->year) && !empty($request->cvc)){

            $tokenData = \Stripe\Token::create([
              'card' => [
                'currency'=>'USD',
                'number' => $request->card_no,
                'exp_month' => $request->month,
                'exp_year' => $request->year,
                'cvc' => $request->cvc
              ]
            ]);

            $account1 = $account->external_accounts->create(["external_account" => $tokenData->id,'default_for_currency'=>true]);
            $account = \Stripe\Account::retrieve($payment_account_id);
            print_r($account->external_accounts->data);
            if (count($account->external_accounts->data) > 1) {
                $extaccount_id = $account->external_accounts->data[1]->id;
                $account->external_accounts->retrieve($extaccount_id)->delete();
            }
        }
        

        /* ====// Stripe connect account create end here. ====*/

        if($user_present){
            $data = $user_present->update($request->all());
        } else{
            $data = CompanyProfile::create($request->all());
        }

        $user = User::where('id', auth()->user()->id)->first();
        $user['user_profile']       = $user->user_profile;
        $user['company_profile']    = $user->company_profile;
        
        return response()->json(['status' => 200,'token' => request('auth_token'),'message'=> 'Company profile updated'.$fname ,'user'=>$user]);
        //return response()->json(['status' => 200,'message'=> $data]);
    }


    public function paymentWithdraw(Request $request){

        $user   = User::where('id', auth()->user()->id)->first();
        $amount = 100;
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        $transfer = \Stripe\Transfer::create([
            "amount"      => ($amount*100),
            "currency"    => "usd",
            "destination" => $user->connect_id,
        ]);
        print_r( $transfer); die();
        
    }

    public function store(Request $request){
        // validate data coming from front end.
        dd($request);
        $id = Auth::user()->id;

        $data = $request->file()['file'];
        $validator = Validator::make($request->all(), [
            'file' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors(),'status'=>'401'], 401);
        }
        if (!empty($data)) {
            $file_name = $data->getClientOriginalName();
            $ext = pathinfo($file_name, PATHINFO_EXTENSION);
            $ext = strtolower($ext);
            $file_name = $id.'.'.$ext;

            $file_folder = 'public/';
            $file_folder = 'public/';

            Storage::put(
                $file_folder.$file_name,
                file_get_contents($data->getRealPath())
            );
            $user = User::find($id);
            if($user) {
                $user->picture = $file_name;
                $user->save();
            }
            return response()->json(['status' => 200,'token' => request('auth_token'),'message'=> 'User profile picture updated','file_name'=>$file_name]);

        } else {
            return response()->json(['status' => 300,'token' => request('auth_token'),'message'=> 'User profile updated']);
        }


    }

    public function getUserFiles(){
        $user = User::where('id', Auth::user()->id)->first();
        $user['medias'] = $user->medias()->where('status',1)->orderBy('id', 'DESC')->get();
        $path = 'database/'.Auth::user()->email.'/singleimages/';
        //dd($user['medias']);
        return response()->json(['status' => 200,'token' => request('auth_token'),'message'=> 'Success','user_medias'=> $user['medias'],'image_path'=> $path]);

    }

    public function getUserProjectBuyDetails(){
        $project_purchase = UserProjects::where('user_id',Auth::user()->id)->where('status','1')->get();
        foreach($project_purchase as $key => $project){
            $project_purchase[$key]['user_detail'] = $project->users()->first();
            // $project_purchase[$key]['purchase_details'] = $project->purchase()->count();
            $project_purchase[$key]['purchase_details'] = Purchase::where('project_id', $project->id)->count();

            $project_purchase[$key]['project_purchase'] = Purchase::where('project_id', $project->id)->get();

            $project_purchase[$key]['project_ShareImage'] = ShareImage::where('project_id', $project->id)->where('buy_status','0')->get();
            
        }
        return response()->json(['status' => 200,'message'=> 'Success','user_project_data'=> $project_purchase]);
    }

    public function getUserProjectBuyDetailsForClient(){
        $project_purchase = Purchase::where('user_id',Auth::user()->id)->get();
        foreach($project_purchase as $key => $project){
            $project_purchase[$key]['user_detail'] = $project->users()->first();
            $project_purchase[$key]['project_detail'] = $project->projects_one()->first();
        }
        return response()->json(['status' => 200,'message'=> 'Success','user_project_data'=> $project_purchase]);

    }

    public function getUserSharedDetail(){
        $project_shared = ShareImage::where('user_id',Auth::user()->id)->get();
        foreach($project_shared as $key => $project){
            $project_shared[$key]['user_detail'] = $project->users()->first();
            $project_shared[$key]['project_detail'] = $project->projects_one()->first();
            $project_shared[$key]['purchase_details'] = $project->purchase()->first();

        }
        return response()->json(['status' => 200,'message'=> 'Success','user_project_data'=> $project_shared]);

    }
    public function contact(Request $request)
    {
        $contact = new contact();
        $contact->first        = $request->first;
        $contact->last         = $request->last;
        $contact->email        = $request->email;
        $contact->phone        = $request->phone;
        $contact->organization = $request->organization;
        $contact->companysize  = $request->companysize;
        $contact->description  = $request->description;
        if($contact->save()){
            //send email
            $this->sendEmail($request->first, $request->email);
            return response()->json(['status' => 200,'message'=> 'Success']);
        }else{
            return response()->json([
                'message' => 'Some Went Wrong',
                'status' => 422
            ], 422);
        }
    }

    /**
     * Send email to user
     * 
     * @param $user_data Array
     * @return $status Boolean
     */
    private function sendEmail($name, $email ){

        $data = ['name'=>$name];
			Mail::send('mail_template.contactUsEmail', $data, function($message) use($email){
            $message->to($email)
                    ->subject('Your query is received.');
            $message->from('support@datacuda.com','Datacuda Admin Team');
        		});
    }
}
