<?php 
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Validator;
use DB;
use Mail;
use Hash;

class Changepassword extends Controller{
	 
	public function __construct()
	{        
		$this->middleware(function ($request, $next) {
            if(! session()->has('admin_userid')){
					return Redirect('/')->send();
			}
            return $next($request);
        });


	}


	
	public function index(Request $request){

		$data['title'] ='Change Password';
		$data['heading'] ='Change Password';
		
		return view('admin/changepassword',$data);
	}
	
	public function changepassword(Request $request){
		$data['title'] ='Change Password';
		$data['heading'] ='Change Password';

		
		if($request->input('save')){
			$oldpassword        = trim($request->input('oldpassword'));
			$newpassword        = trim($request->input('newpassword'));
			$confirmpassword    = $request->input('confirmpassword');

			
			$validator = Validator::make($request->all(), [
				'oldpassword' 		=> 'required|max:100',
				'newpassword' 		=> 'required|max:100|min:8|same:confirmpassword',
				'confirmpassword' 	=> 'required|max:100|min:8|same:newpassword'
			]);
			
			if ($validator->fails()) {
				return redirect('admin/changepassword')
							->withErrors($validator)
							->withInput();
			}

			$login_data = DB::table(\Config::get('constants.db.prefix').\Config::get('constants.db.user'))->select(\Config::get('constants.db.user').'_password',\Config::get('constants.db.user').'_id',\Config::get('constants.db.user').'_username',\Config::get('constants.db.user').'_type')->where(\Config::get('constants.db.user').'_id',session('admin_userid'))->first();

			if(Hash::check($oldpassword, $login_data->user_password)){
				$password = bcrypt($newpassword);
				DB::table(\Config::get('constants.db.prefix').\Config::get('constants.db.user'))
	            ->where(\Config::get('constants.db.user').'_id',session('admin_userid'))
	            ->update([\Config::get('constants.db.user').'_password' => $password]);
	            $request->session()->flash('msg', 'Password Successfully Changed');
				return Redirect('admin/changepassword')->send();
			}else{
				$request->session()->flash('errmsg', 'Invalid Old Password');
				return Redirect('admin/changepassword')->send();
			}
	
			
			// if($created)
			// 	return Redirect('adviser');
			
		}

		return view('admin/changepassword',$data);
	}
	
	
	
	


	
}

?>