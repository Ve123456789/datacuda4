<?php 
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Validator;
use App\AdminAdviser;
use DB;
use Mail;

class Adviser extends Controller{
	 
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

		$data['title'] ='Adviser';
		$data['heading'] ='Adviser';
		$user_table = \Config::get('constants.db.prefix').\Config::get('constants.db.user'); 
		if($request->input('fname')){
			$fname = $request->input('fname');
			$data['fname'] = $fname;
			$validator = Validator::make($request->all(), [
					'fname' => 'max:150|alpha_dash',
				]);
			if ($validator->fails()) {
				return redirect('adviser')->withErrors($validator)->withInput();
			}

			$data['listdatas'] = DB::table($user_table)
            ->select($user_table.'.*')
            ->where($user_table.'.user_fname', 'LIKE', '%' . $fname . '%')
            ->orderBy($user_table.'.user_id',"desc")
            ->where($user_table.'.user_type', '=', '2')->paginate(6);
			$data['listdatas']->appends(['fname' => $fname]);
		}else{
			$data['fname'] = '';
			$data['listdatas'] = DB::table($user_table)
            ->select($user_table.'.*')
            ->where($user_table.'.user_type', '=', '2')
            ->orderBy($user_table.'.user_id',"desc")
            ->paginate(6);
		}
		
		
		return view('admin/adviser',$data);
	}
	
	public function add(Request $request){
		$data['title'] ='Adviser';
		$data['heading'] ='Adviser';

		

		$data['fname']     	= ($request->old('fname') !='' ) ? $request->old('fname') : '' ;
		$data['lname'] 	   	= ($request->old('lname') !='' ) ? $request->old('lname') : '' ;
		$data['email']      = ($request->old('email') !='' ) ? $request->old('email') : '' ;
		$data['password'] 	= ($request->old('password') !='' ) ? $request->old('password') : '' ;
		$data['phone']      = ($request->old('phone') !='' ) ? $request->old('phone') : '' ;
		
		
		if($request->input('save')){
			$fname    = trim($request->input('fname'));
			$lname    = trim($request->input('lname'));
			$email    = $request->input('email');
			$password = $request->input('password');
			$phone 	  = $request->input('phone');
			
			$validator = Validator::make($request->all(), [
				'fname' 	=> 'required|max:300|regex:/^[\pL\s\-]+$/u',
				'lname' 	=> 'required|max:300|regex:/^[\pL\s\-]+$/u',
				'email' 	=> 'required|max:250|email|unique:'.\Config::get('constants.db.prefix').\Config::get('constants.db.user').','.\Config::get('constants.db.user').'_email',
				'password' 	=> 'required',
				'phone' 	=> 'digits_between:10,14',
			]);
			
			if ($validator->fails()) {
				return redirect('adviser/add')
							->withErrors($validator)
							->withInput();
			}

			
			$add_data = array(  
							\Config::get('constants.db.user').'_fname'       => $fname,
							\Config::get('constants.db.user').'_lname'       => $lname,
							\Config::get('constants.db.user').'_email'       => $email,
							\Config::get('constants.db.user').'_password'    => bcrypt($password),
							\Config::get('constants.db.user').'_phone'       => $phone,
							\Config::get('constants.db.user').'_type'        => '2',
							\Config::get('constants.db.user').'_status'      => '1'
						);
			
			$created = \App\AdminAdviser::create($add_data);
			if($created)
				return Redirect('adviser');
			
		}
		
		return view('admin/adviser',$data);
	}
	
	
	
	public function edit(Request $request){
		$data['title'] ='Adviser';
		$data['heading'] ='Adviser';
		
		$id = $request->segment(3);
		$editdata = \App\AdminAdviser::where(\Config::get('constants.db.user').'_id',$id)->first(); 

		
		$data['fname']     = ($request->old('fname') !='' ) ? $request->old('fname') : $editdata->{\Config::get('constants.db.user').'_fname'} ;
		$data['lname']     = ($request->old('lname') !='' ) ? $request->old('lname') : $editdata->{\Config::get('constants.db.user').'_lname'} ;
		$data['email']     = ($request->old('email') !='' ) ? $request->old('email') : $editdata->{\Config::get('constants.db.user').'_email'} ;
		$data['password']  = ($request->old('password') !='' ) ? $request->old('password') : $editdata->{ \Config::get('constants.db.user').'_password' } ;
		$data['phone']     = ($request->old('phone') !='' ) ? $request->old('phone') : $editdata->{ \Config::get('constants.db.user').'_phone' } ;




		if($request->input('save')){
			$fname    = trim($request->input('fname'));
			$lname    = trim($request->input('lname'));
			$email    = $request->input('email');
			$password = $request->input('password');
			$phone 	  = $request->input('phone');
			
			
			
			if($editdata->user_email != $email){
				
				$email_valid = 'required|max:250|email|unique:'.\Config::get('constants.db.prefix').\Config::get('constants.db.user').','.\Config::get('constants.db.user').'_email';
			}else{
				$email_valid = '';
			}
			
						
			$validator = Validator::make($request->all(), [
				'fname' 	=> 'required|max:300|regex:/^[\pL\s\-]+$/u',
				'lname' 	=> 'required|max:300|regex:/^[\pL\s\-]+$/u',
				'email' 	=> $email_valid,
				'password' 	=> 'required',
				'phone' 	=> 'digits_between:10,14',
			]);
			
			
			if ($validator->fails()) {
				return redirect('adviser/edit/'.$id)
							->withErrors($validator)
							->withInput();
			}

			
			$edit_data = array(
							\Config::get('constants.db.user').'_fname'       => $fname,
							\Config::get('constants.db.user').'_lname'       => $lname,
							\Config::get('constants.db.user').'_email'       => $email,
							\Config::get('constants.db.user').'_password'    => bcrypt($password),
							\Config::get('constants.db.user').'_phone'       => $phone,
						);
			
			$edited = \App\AdminAdviser::where(\Config::get('constants.db.user').'_id',$id)->update($edit_data);
			return Redirect('adviser');
			
		}
		
		return view('admin/adviser',$data);
	}


	public function view(Request $request){
		$data['heading'] = "Adviser ";
		$id = $request->segment(3);
		$data['list'] = DB::table(\Config::get('constants.db.prefix').\Config::get('constants.db.user'))
			->leftJoin(\Config::get('constants.db.prefix').\Config::get('constants.db.user_detail'),\Config::get('constants.db.user')."_id","=",\Config::get('constants.db.user_detail')."_user_id")
			->leftJoin(\Config::get('constants.db.prefix').\Config::get('constants.db.college'),\Config::get('constants.db.user_detail')."_college_id","=",\Config::get('constants.db.college')."_id")
			->leftJoin(\Config::get('constants.db.prefix').\Config::get('constants.db.topic'),\Config::get('constants.db.user_detail')."_topic_id","=",\Config::get('constants.db.topic')."_id")
			->leftJoin(\Config::get('constants.db.prefix').\Config::get('constants.db.payment'),\Config::get('constants.db.user')."_id","=",\Config::get('constants.db.payment')."_user_id")
			->where(\Config::get('constants.db.user')."_id","=",$id)
			->where(\Config::get('constants.db.user')."_type","=","2")
			->first();

		return view('admin/adviser-view',$data);
		
	}
	
	
	
	public function status(Request $request){
		$status = $request->segment(3);
		$id = $request->segment(4);
			$status_data = array(
							\Config::get('constants.db.user').'_status' => $status
						);
			
			$edited = \App\AdminAdviser::where(\Config::get('constants.db.user').'_id',$id)->update($status_data);
			return Redirect('adviser');

	}


	public function adminstatus(Request $request){
		$status = $request->segment(3);
		$id = $request->segment(4);
			$status_data = array(
							\Config::get('constants.db.user').'_adminstatus' => $status
						);
			
			$edited = \App\AdminAdviser::where(\Config::get('constants.db.user').'_id',$id)->update($status_data);
				if($status == '1') {
			$user_data = DB::table(\Config::get('constants.db.prefix').\Config::get('constants.db.user'))
            ->select(\Config::get('constants.db.prefix').\Config::get('constants.db.user').'.user_email')
            ->where(\Config::get('constants.db.prefix').\Config::get('constants.db.user').'.user_id', '=', $id)
            ->first();
             $email = $user_data->user_email;
             $url  = url(''); 
             $data = array( "url" => $url);
				Mail::send('emails.statusApproved', $data, function($message) use($email){
            $message->to($email)
                    ->subject('AdviseMe -Account Approved');
            $message->from('support@getadviseme.com','Adviseme');
        		});
			}
			return Redirect('adviser');

	}
	
	
	public function del(Request $request){
		$id = $request->segment(3);
		$edited = \App\AdminAdviser::destroy($id);
		return Redirect('adviser');

	}


	
}

?>