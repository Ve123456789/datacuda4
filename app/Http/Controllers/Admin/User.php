<?php 
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Validator;
use DB;
use Mail;

class User extends Controller{
	 
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

		$data['title'] ='Photographer';
		$data['heading'] ='Photographer';
		if($request->input('fname')){
			$fname = $request->input('fname');
			$data['fname'] = $fname;
			$validator = Validator::make($request->all(), [
					'fname' => 'max:150|alpha_dash',
				]);
			if ($validator->fails()) {
				return redirect('adviser')->withErrors($validator)->withInput();
			}

			$data['listdatas'] = DB::table("users")
            ->select('users.*')
            ->where('users.username', 'LIKE', '%' . $fname . '%')
            ->orderBy('users.id',"desc")->paginate(6);
			$data['listdatas']->appends(['fname' => $fname]);
		}else{
			$data['fname'] = '';
			$data['listdatas'] = DB::table("users")
            ->select('users.*')
            ->orderBy('users.id',"desc")->paginate(6);
		}
		
		
		return view('admin/user',$data);
	}



	public function edit(Request $request){
		$data['title'] ='Photographer ';
		$data['heading'] ='Photographer ';
		
		$id = $request->segment(4);
		$editdata = DB::table("users")->where('id',$id)->first(); 

		
		$data['name']      = ($request->old('name') !='' ) ? $request->old('name') : $editdata->username;
		$data['email']     = ($request->old('email') !='' ) ? $request->old('email') : $editdata->email;
		$data['fname']     = ($request->old('fname') !='' ) ? $request->old('fname') : $editdata->name;
		$data['lname']     = ($request->old('lname') !='' ) ? $request->old('lname') : $editdata->lastname;
		
		$data['imageold'] = $editdata->picture;


		if($request->input('save')){

			$name     = trim($request->input('name'));
			$fname    = trim($request->input('fname'));
			$lname    = trim($request->input('lname'));
			$password = trim($request->input('password'));

			$validator = Validator::make($request->all(), [
				'name' 	=> 'required|max:300',
				'fname' 	=> 'required|max:300',
				'lname' 	=> 'required|max:300',
				//'email' 	=> 'required|email',
				'image' => 'image|mimes:jpeg,png,jpg,JPEG,PNG,JPG|max:2048',
			]);
			
			
			if ($validator->fails()) {
				return redirect('admin/user/edit/'.$id)
							->withErrors($validator)
							->withInput();
			}

			
			$edit_data = array(
							"username" => $name,
							"name" => $fname,
							"lastname"=>$lname
						);

			$file            = $request->file('image');
			if(!empty($password)){
				$edit_data['password'] = bcrypt($password);
			}

	   		if(!empty($file)){
	   			$destinationPath = public_path('/database/'.$editdata->email.'/');
	   			if(!empty($data['imageold'])){
	   				unlink($destinationPath.'/'.$data['imageold']);
	   			}
		        $image_name        = time().'_'.$file->getClientOriginalName(); 
				$file->move($destinationPath, $image_name);
				$edit_data['picture'] = $image_name;
	   		}
			
			$edited = DB::table("users")->where('id',$id)->update($edit_data);
			return Redirect('admin/user');
			
		}
		
		return view('admin/user',$data);
	}

	
	public function status(Request $request){
		$status = $request->segment(4);
		$id = $request->segment(5);
			$status_data = array(
							'vstatus' => $status
						);
			
			$edited = DB::table('users')->where('id',$id)->update($status_data);
			return Redirect('admin/user');

	}


	
	
	public function del(Request $request){
		$id = $request->segment(4);
		$edited = DB::table('users')->where('id','=',$id)->delete();
	    return Redirect('admin/user');

	}


	
}

?>