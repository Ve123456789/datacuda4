<?php 
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Validator;
use App\AdminHomebanner;
use DB;
use Mail;

class Homebanner extends Controller{
	 
	public function __construct()
	{        
		$this->middleware(function ($request, $next) {
            if(! session()->has('admin_userid')){
					return Redirect('/admin')->send();
			}
            return $next($request);
        });


	}


	
	public function index(Request $request){

		$data['title'] ='Home Banner';
		$data['heading'] ='Home Banner';
		$homebanner_table = \Config::get('constants.db.prefix').\Config::get('constants.db.homebanner'); 
		if($request->input('titles')){
			$titles = $request->input('titles');
			$data['titles'] = $titles;
			$validator = Validator::make($request->all(), [
					'titles' => 'max:150|alpha_dash',
				]);
			if ($validator->fails()) {
				return redirect('admin/homebanner')->withErrors($validator)->withInput();
			}

			$data['listdatas'] = DB::table($homebanner_table)
            ->select($homebanner_table.'.*')
            ->where($homebanner_table.'.homebanner_title', 'LIKE', '%' . $titles . '%')
            ->orderBy($homebanner_table.'.homebanner_id',"desc")
            ->paginate(6);
			$data['listdatas']->appends(['titles' => $titles]);
		}else{
			$data['titles'] = '';
			$data['listdatas'] = DB::table($homebanner_table)
            ->select($homebanner_table.'.*')
            ->orderBy($homebanner_table.'.homebanner_id',"desc")
            ->paginate(6);
		}
		
		
		return view('admin/homebanner',$data);
	}
	
	public function add(Request $request){
		$data['title'] ='Home Banner';
		$data['heading'] ='Home Banner';

		

		$data['titles']     	= ($request->old('titles') !='' ) ? $request->old('titles') : '' ;
		
		
		if($request->input('save')){
			$titles    = trim($request->input('titles'));
			
			$validator = Validator::make($request->all(), [
				'titles' 	=> 'required|max:300',
				'image' => 'required|image|mimes:jpeg,png,jpg,JPEG,PNG,JPG|max:2048',
				
			]);
			
			if ($validator->fails()) {
				return redirect('admin/homebanner/add')
							->withErrors($validator)
							->withInput();
			}

			$file     = $request->file('image');
			$destinationPath = public_path('/images');
			$image_name        = time().'_'.$file->getClientOriginalName(); 
			$file->move($destinationPath, $image_name);

			$add_data = array(  
							\Config::get('constants.db.homebanner').'_title'       => $titles,
							\Config::get('constants.db.homebanner').'_image'       => $image_name,
							\Config::get('constants.db.homebanner').'_status'      => '1'
						);
			
			$created = \App\AdminHomebanner::create($add_data);
			if($created)
				return Redirect('admin/homebanner');
			
		}
		
		return view('admin/homebanner',$data);
	}
	
	
	
	public function edit(Request $request){
		$data['title'] ='Home Banner';
		$data['heading'] ='Home Banner';
		
		$id = $request->segment(4);
		$editdata = \App\AdminHomebanner::where(\Config::get('constants.db.homebanner').'_id',$id)->first(); 

		
		$data['titles']     = ($request->old('titles') !='' ) ? $request->old('titles') : $editdata->{\Config::get('constants.db.homebanner').'_title'} ;
		$data['imageold']     = $editdata->{\Config::get('constants.db.homebanner').'_image'} ;





		if($request->input('save')){

			$titles    = trim($request->input('titles'));
			
			$validator = Validator::make($request->all(), [
				'titles' 	=> 'required|max:300',
				'image' => 'image|mimes:jpeg,png,jpg,JPEG,PNG,JPG|max:2048',
				
			]);
			
			
			if ($validator->fails()) {
				return redirect('admin/homebanner/edit/'.$id)
							->withErrors($validator)
							->withInput();
			}

			
			$edit_data = array(
							\Config::get('constants.db.homebanner').'_title'       => $titles,
						);

			$file            = $request->file('image');
	   		if(!empty($file)){
	   			$destinationPath = public_path('/images');
	   			if(!empty($data['imageold'])){
	   				unlink($destinationPath.'/'.$data['imageold']);
	   			}
		        $image_name        = time().'_'.$file->getClientOriginalName(); 
				$file->move($destinationPath, $image_name);
				$edit_data[\Config::get('constants.db.homebanner').'_image'] = $image_name;
	   		}
			
			$edited = \App\AdminHomebanner::where(\Config::get('constants.db.homebanner').'_id',$id)->update($edit_data);
			return Redirect('admin/homebanner');
			
		}
		
		return view('admin/homebanner',$data);
	}


	
	
	
	public function status(Request $request){
		$status = $request->segment(4);
		$id = $request->segment(5);
			$status_data = array(
							\Config::get('constants.db.homebanner').'_status' => $status
						);
			
			$edited = \App\AdminHomebanner::where(\Config::get('constants.db.homebanner').'_id',$id)->update($status_data);
			return Redirect('admin/homebanner');

	}



	
	
	public function del(Request $request){
		$id = $request->segment(4);
		$edited = \App\AdminHomebanner::destroy($id);
		return Redirect('admin/homebanner');

	}


	
}

?>