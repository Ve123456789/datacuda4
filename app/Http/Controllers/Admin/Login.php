<?php 
namespace App\Http\Controllers\Admin;
use App\Adminlogin;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Hash;

class Login extends Controller{
	
	public function index(Request $request){
		return view('admin/index');
	}
	
	public function login(Request $request){
		//\App\Adminlogin::setTable(\Config::get('constants.db.user'));
		$uname = $request->input('username');
		$password = $request->input('password');
		
		 $validator = Validator::make($request->all(), [
            'username' => 'required|max:255',
            'password' => 'required|min:8',
        ]);
		
		if ($validator->fails()) {
            return redirect('admin')
                        ->withErrors($validator)
                        ->withInput();
        }
		$login_data = \App\Adminlogin::select(\Config::get('constants.db.user').'_password',\Config::get('constants.db.user').'_id',\Config::get('constants.db.user').'_username',\Config::get('constants.db.user').'_type')->where(\Config::get('constants.db.user').'_username', $uname)->first();
		if($login_data){
			if(Hash::check($password, $login_data->user_password)){
				session()->put('admin_userid', $login_data->{\Config::get('constants.db.user').'_id'});
				session()->put('admin_type', $login_data->{\Config::get('constants.db.user').'_type'});
				Session::save();
				return Redirect('admin/dashboard')->send();
			}else{
				$request->session()->flash('msg', 'Invalid Username And Password');
				return Redirect('/admin')->send();
			}
		}else{
			$request->session()->flash('msg', 'Invalid Username And Password');
			return Redirect('/admin')->send();
		}
			

		
			return view('admin/index');
	}
	
}

?>