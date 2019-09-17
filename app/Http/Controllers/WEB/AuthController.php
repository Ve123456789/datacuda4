<?php

namespace App\Http\Controllers\WEB;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\UserProfile;
use App\UserProjects;

use Hash;
use DB;
use App\Quotation;
use Validator;


class AuthController extends Controller
{
    //

    public function home(Request $request){
			// validate data coming from front end.
			
	}

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


	public function user_profile(Request $request){

		// validate data coming from front end.
			$validator = Validator::make($request->all(), [ 
	            'user_id' => 'required', 
	            'company_name' => 'required', 
	            'full_name' => 'required', 
	            'address' => 'required', 
	            'logo' => 'required',
	            'phone' => 'required'
        	]);
			if ($validator->fails()) { 
            	return response()->json(['error'=>$validator->errors(),'status'=>'401'], 401);            
        	}
        	//Save data into the table
        	$user_present = UserProfile::whereUserId(request('user_id'))->first();
        	if($user_present){
        		    $user_present->update($request->all());

        		//$user_present->company_name = 'company_name';
        		// $user_present->full_name = request('full_name');
        		// $user_present->address = request('address');
        		// $user_present->logo = request('logo');
        		// $user_present->phone = request('phone');

        		//$user_present->save();
        		echo "ayush"; die;
        	} else {
        		UserProfile::create([
		        'user_id' => request('user_id'),
		        'company_name' => request('company_name'),
		        'full_name' => request('full_name'),
		        'address' => request('address'), 
	            'logo' => request('logo'),
	            'phone' => request('phone')
		    ]);

        	}
		    

		    return response()->json(['status' => 200,'token' => $data->access_token,'message'=> 'User profile updated']);
	}

	public function login(Request $request){
			    // Validate data coming from front end.

				$validator = Validator::make($request->all(), [
		            'username' => 'required|email', 
		            'password' => 'required', 
        		]);
        		if ($validator->fails()) { 
            		return response()->json(['error'=>$validator->errors(),'status'=>'401'], 401);            
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
			        'client_id' => '2',
			        'client_secret' => 'Bb0Y5akwON8qLXPALv5epn7Z7xcl0iops4ETK75s',
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

			    // Get the data from the response
			    $data = json_decode($response->getContent());

			    // Format the final response in a desirable format
			    return response()->json([
			        'token' => $data->access_token,
			        'user' => $user,
			        'status' => 200
			    ]);
		}



		public function logout(){
			    $accessToken = auth()->user()->token();

				if(empty($accessToken)){
					return response()->json(['status' => 200,'message'=>'Already Logged Out']);
				}

			    $refreshToken = DB::table('oauth_refresh_tokens')
			        ->where('access_token_id', $accessToken->id)
			        ->update([
			            'revoked' => true
			        ]);

			    $accessToken->revoke();
				return response()->json(['status' => 200,'message'=>'Logout successful']);
		}

		public function getUser(){
			return auth()->user();
		}
}
