<?php 
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Validator;
use App\AdminHomethird;
use DB;
use Mail;
 
class HomeThird extends Controller{
	 
	public $destinationPath = '';
	public $dbAndTableName = '';
	public $tablePrefix = '';

	public function __construct()
	{        
		$this->destinationPath = public_path('/images/');
		$this->dbAndTableName = \Config::get('constants.db.prefix').\Config::get('constants.db.homethird'); 
		$this->tablePrefix = \Config::get('constants.db.homethird');

		$this->middleware(function ($request, $next) {
            if(! session()->has('admin_userid')){
				return Redirect('/admin')->send();
			}
            return $next($request);
        });
	}
	

	public function index(Request $request){
		
		$data['title_heading'] ='Home Third Section';
        $data['section_heading'] ='Home Third Section';

		$data['search_heading'] ='';
		if($request->input('search_heading')){
			$data['search_heading'] = $search_heading = $request->input('search_heading');
			$validator = Validator::make($request->all(), [
					'search_heading' => 'max:150|alpha_dash',
				]);
			if ($validator->fails()) {
				return redirect('admin/homethird')->withErrors($validator)->withInput();
			}
			//search heading in Table
			$data['getSectionData'] = Adminhomethird::searchHeading($search_heading); 
		}else{
			//get all records from table
			$data['getSectionData'] = Adminhomethird::getAllData();
		}
		return view('admin/homethird',$data);
	}
	
	/**
	 * Add a new record
	 * 
	 * @params $request Request
	 * 
	 * @return view
	 */
	public function add(Request $request){

        $data['title_heading'] ='Add Home Third Section Details';
        $data['section_heading'] ='Add Section Details';
        
		$assetsPath = asset('/images\/');
		$data['heading'] = ($request->old('heading') !='' ) ? $request->old('heading') : '' ;
		$data['content'] = ($request->old('content') !='' ) ? $request->old('content') : '' ;
		
		if($request->input('save')){
			//validate user input
			$this->validateAddRecord($request);
			//process image informationn and return $add_data Array
            $add_data = $this->processImages($request);
            //add data to table
			$insert_status = \App\AdminHomethird::create($add_data);
			if($insert_status)
				return Redirect('admin/homethird');
		}
		return view('admin/homethird',$data);
	}
	
	/**
	 * Edit record information
	 * 
	 * @params $request Request
	 * 
	 * @return view
	 */
	public function edit(Request $request){
 
		$data['title_heading'] ='Edit Home Third Section Details';
        $data['section_heading'] ='Edit Section Details';
		$assetsPath = asset('/images\/');

		$id = $request->segment(4);
		$editdata = \App\AdminHomethird::where($this->tablePrefix.'_id',$id)->first(); 
		
		$data['heading']  = ($request->old('heading') !='' ) ? $request->old('heading') : $editdata->{$this->tablePrefix.'_heading'} ;
		$data['content']  = ($request->old('content') !='' ) ? $request->old('content') : $editdata->{$this->tablePrefix.'_content'} ;
		$data['image']   = $editdata->{$this->tablePrefix.'_image'} ;

		if($request->input('save')){

			$heading = trim($request->input('heading'));
			$content = trim($request->input('content'));
			//validate input
			$this->validateUserInput($request, $id);

			$edit_data = [
                $this->tablePrefix.'_heading' => $heading,
                $this->tablePrefix.'_content' => $content
            ];
			
			$image_upload = $this->checkAndUpdateImage($request->file('image'), $data);
			if($image_upload['status']){
				$edit_data[$this->tablePrefix.'_image'] = $image_upload['image_name'];
			}
			$edited = \App\AdminHomethird::where($this->tablePrefix.'_id',$id)->update($edit_data);
			return Redirect('admin/homethird');	
		}
		return view('admin/homethird',$data);
	}

	/**
	 * Toggle record status
	 * 
	 * @params $request Request
	 * 
	 * @return view
	 */
	public function status(Request $request){
		$status = $request->segment(4);
		$id = $request->segment(5);
			$status_data = [ $this->tablePrefix.'_status' => $status];
			
		$edited = \App\AdminHomethird::where($this->tablePrefix.'_id',$id)->update($status_data);
		return Redirect('admin/homethird');
	}
	
	/**
	 * Delete Record
	 * 
	 * @params $id integer
	 * 
	 * @return view
	 */
	public function del(Request $request){
		$id = $request->segment(4);
		$edited = \App\AdminHomethird::destroy($id);
		return Redirect('admin/homethird');
	}

	/**
	 * Check and update images
	 * 
	 * @params $image array
	 * @params $data array
	 * 
	 * @return $result array
	 */
	private function checkAndUpdateImage($image, $data){
		
		$result['status'] = false;
		if(!empty($image)){
	   			
			if(!empty($data['image'])){
				unlink($this->destinationPath.basename($data['image']));
			}
			$image_name = time().'_'.$image->getClientOriginalName(); 
			$image->move($this->destinationPath, $image_name);		
			$result['status'] = true;
			$result['image_name'] = $image_name;
		}
		return $result;
	}
	
	/**
	 * Validate User Input
	 * 
	 * @params $request 
	 * 
	 * @return Errors
	 */
	private function validateUserInput($request, $id){

		$validator = Validator::make($request->all(), [
			'heading' => 'required|max:100|regex:/^[\pL\s\-]+$/u',
			'content' => 'required|max:300|regex:/^[\pL\s\-]+$/u',
		]);
		
		if ($validator->fails()) {
			return redirect('admin/homethird/edit/'.$id)
						->withErrors($validator)
						->withInput();
		}
	}

	/**
	 * Validate User Input
	 * 
	 * @params $request 
	 * 
	 * @return Errors
	 */
	private function validateAddRecord($request){

		$validator = Validator::make($request->all(), [
			'heading' => 'required|max:100|regex:/^[\pL\s\-]+$/u',
			'content' => 'required|max:300|regex:/^[\pL\s\-]+$/u',
			'image'  => 'required|image|mimes:jpeg,png,jpg,JPEG,PNG,JPG|max:2048',		
		]);
		
		if ($validator->fails()) {
			return redirect('admin/homethird/add')
						->withErrors($validator)
						->withInput();
		}
	}

	/**
	 * Process uploaded images
	 * 
	 * @params $request 
	 * 
	 * @return Errors
	 */
	private function processImages($request){

		$heading = trim($request->input('heading'));
		$content = trim($request->input('content'));
		$image     = $request->file('image');

		$image_name        = time().'_'.$image->getClientOriginalName(); 
		$image->move($this->destinationPath, $image_name);

		return $add_data = array(  
					$this->tablePrefix.'_heading' => $heading,
					$this->tablePrefix.'_content' => $content,
					$this->tablePrefix.'_image'   => $image_name,
					$this->tablePrefix.'_status'   => '1'
				);
	}
}

?>