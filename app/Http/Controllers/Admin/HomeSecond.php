<?php 
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Validator;
use App\AdminHomesecond;
use DB;
use Mail;
 
class HomeSecond extends Controller{
	 
	public $destinationPath = '';
	public $dbAndTableName = '';
	public $tablePrefix = '';

	public function __construct()
	{        
		$this->destinationPath = public_path('/images/');
		$this->dbAndTableName = \Config::get('constants.db.prefix').\Config::get('constants.db.homesecond'); 
		$this->tablePrefix = \Config::get('constants.db.homesecond');

		$this->middleware(function ($request, $next) {
            if(! session()->has('admin_userid')){
					return Redirect('/admin')->send();
			}
            return $next($request);
        });
	}
	

	public function index(Request $request){
		
		$data['heading'] ='Home Second Section';
		$data['search_heading'] ='';
		
		if($request->input('search_heading')){
			$data['search_heading'] = $search_heading = $request->input('search_heading');
			$validator = Validator::make($request->all(), [
					'search_heading' => 'max:150|alpha_dash',
				]);
			if ($validator->fails()) {
				return redirect('admin/homesecond')->withErrors($validator)->withInput();
			}
			//search heading in Table
			$data['getSectionData'] = AdminHomesecond::searchHeading($search_heading); 
		}else{
			//get all records from table
			$data['getSectionData'] = AdminHomesecond::getAllData();
		}
		return view('admin/homesecond',$data);
	}
	
	/**
	 * Add a new record
	 * 
	 * @params $request Request
	 * 
	 * @return view
	 */
	public function add(Request $request){

		$assetsPath = asset('/images\/');
		$data['heading'] ='Add Home Second Section Details';
		$data['section_heading'] ='Add Section Details';

		$data['top_heading_1'] = ($request->old('top_heading_1') !='' ) ? $request->old('top_heading_1') : '' ;
		$data['top_heading_2'] = ($request->old('top_heading_2') !='' ) ? $request->old('top_heading_2') : '' ;
		
		$data['heading_1'] = ($request->old('heading_1') !='' ) ? $request->old('heading_1') : '' ;
		$data['heading_2'] = ($request->old('heading_2') !='' ) ? $request->old('heading_2') : '' ;
		$data['heading_3'] = ($request->old('heading_3') !='' ) ? $request->old('heading_3') : '' ;

		$data['content_1'] = ($request->old('content_1') !='' ) ? $request->old('content_1') : '' ;
		$data['content_2'] = ($request->old('content_2') !='' ) ? $request->old('content_2') : '' ;
		$data['content_3'] = ($request->old('content_3') !='' ) ? $request->old('content_3') : '' ;
		
		if($request->input('save')){
			
			//validate user input
			$this->validateAddRecord($request);
			//process image informationn and return $add_data Array
			$add_data = $this->processImages($request);

			$insert_status = \App\AdminHomesecond::create($add_data);
			if($insert_status)
				return Redirect('admin/homesecond');
		}
		return view('admin/homesecond',$data);
	}
	
	/**
	 * Edit record information
	 * 
	 * @params $request Request
	 * 
	 * @return view
	 */
	public function edit(Request $request){
		$data['heading'] ='Edit Home Second Section Details';
		$data['section_heading'] ='Edit Section Details';

		$assetsPath = asset('/images\/');

		$id = $request->segment(4);
		$editdata = \App\AdminHomesecond::where($this->tablePrefix.'_id',$id)->first(); 
		
		$data['top_heading_1']  = ($request->old('top_heading_1') !='' ) ? $request->old('top_heading_1') : $editdata->{$this->tablePrefix.'_topheading1'} ;
		$data['top_heading_2']  = ($request->old('top_heading_2') !='' ) ? $request->old('top_heading_2') : $editdata->{$this->tablePrefix.'_topheading2'} ;
		
		$data['heading_1']  = ($request->old('heading_1') !='' ) ? $request->old('heading_1') : $editdata->{$this->tablePrefix.'_heading1'} ;
		$data['heading_2']  = ($request->old('heading_2') !='' ) ? $request->old('heading_2') : $editdata->{$this->tablePrefix.'_heading2'} ;
		$data['heading_3']  = ($request->old('heading_3') !='' ) ? $request->old('heading_3') : $editdata->{$this->tablePrefix.'_heading3'} ;
		
		$data['content_1']  = ($request->old('content_1') !='' ) ? $request->old('content_1') : $editdata->{$this->tablePrefix.'_content1'} ;
		$data['content_2']  = ($request->old('content_2') !='' ) ? $request->old('content_2') : $editdata->{$this->tablePrefix.'_content2'} ;
		$data['content_3']  = ($request->old('content_3') !='' ) ? $request->old('content_3') : $editdata->{$this->tablePrefix.'_content3'} ;
		
		$data['image1']   = $editdata->{$this->tablePrefix.'_image1'} ;
		$data['image2']   = $editdata->{$this->tablePrefix.'_image2'} ;
		$data['image3']   = $editdata->{$this->tablePrefix.'_image3'} ;
		
		if($request->input('save')){
			
			//validate input
			$this->validateUserInput($request, $id);

			//return array to update data in DB
			$edit_data = $this->getDataToUpdate($request, $data);
			$edited = \App\AdminHomesecond::where($this->tablePrefix.'_id',$id)->update($edit_data);
			
			return Redirect('admin/homesecond');	
		}
		return view('admin/homesecond',$data);
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
			
		$edited = \App\AdminHomesecond::where($this->tablePrefix.'_id',$id)->update($status_data);
		return Redirect('admin/homesecond');
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
		$edited = \App\AdminHomesecond::destroy($id);
		return Redirect('admin/homesecond');
	}
	
	/**
	 * Validate User Input
	 * 
	 * @params $request 
	 * 
	 * @return Errors
	 */
	private function validateUserInput($request, $id){

		$validator = Validator::make($request->all(), $this->getValidationArray());
		
		if ($validator->fails()) {
			return redirect('admin/homesecond/edit/'.$id)
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

		$validator = Validator::make($request->all(), $this->getValidationArray());
		
		if ($validator->fails()) {
			return redirect('admin/homesecond/add')
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

		$top_heading_1 = trim($request->input('top_heading_1'));
		$top_heading_2 = trim($request->input('top_heading_2'));
		
		$heading_1 = trim($request->input('heading_1'));
		$heading_2 = trim($request->input('heading_2'));
		$heading_3 = trim($request->input('heading_3'));

		$content_1 = trim($request->input('content_1'));
		$content_2 = trim($request->input('content_2'));
		$content_3 = trim($request->input('content_3'));

		$image_1     = $request->file('image1');
		$image_2     = $request->file('image2');
		$image_3     = $request->file('image3');

		$image_name_1        = time().'_'.$image_1->getClientOriginalName(); 
		$image_1->move($this->destinationPath, $image_name_1);

		$image_name_2        = time().'_'.$image_2->getClientOriginalName(); 
		$image_2->move($this->destinationPath, $image_name_2);
		
		$image_name_3        = time().'_'.$image_3->getClientOriginalName(); 
		$image_3->move($this->destinationPath, $image_name_3);

		return $add_data = array(  
					$this->tablePrefix.'_topheading1' => $top_heading_1,
					$this->tablePrefix.'_topheading2' => $top_heading_2,
					$this->tablePrefix.'_heading1' => $heading_1,
					$this->tablePrefix.'_heading2' => $heading_2,
					$this->tablePrefix.'_heading3' => $heading_3,
					$this->tablePrefix.'_content1' => $content_1,
					$this->tablePrefix.'_content2' => $content_2,
					$this->tablePrefix.'_content3' => $content_3,
					$this->tablePrefix.'_image1'   => $image_name_1,
					$this->tablePrefix.'_image2'   => $image_name_2,
					$this->tablePrefix.'_image3'   => $image_name_3,
					$this->tablePrefix.'_status'   => '1'
				);
	}

	/**
	 * Return Validation Array for Add and Edit form 
	 * 
	 * @return $validation_array Array
	 */
	private function getValidationArray(){
		return [
			'top_heading_1' => 'required|max:50|regex:/^[\pL\s\-]+$/u',
			'top_heading_2' => 'required|max:100|regex:/^[\pL\s\-]+$/u',
			'heading_1' => 'required|max:100|regex:/^[\pL\s\-]+$/u',
			'heading_2' => 'required|max:100|regex:/^[\pL\s\-]+$/u',
			'heading_3' => 'required|max:100|regex:/^[\pL\s\-]+$/u',
			'content_1' => 'required|max:300|regex:/^[\pL\s\-]+$/u',
			'content_2' => 'required|max:300|regex:/^[\pL\s\-]+$/u',
			'content_3' => 'required|max:300|regex:/^[\pL\s\-]+$/u',
			'image1'  => 'required|image|mimes:jpeg,png,jpg,JPEG,PNG,JPG|max:2048',
			'image2'  => 'required|image|mimes:jpeg,png,jpg,JPEG,PNG,JPG|max:2048',
			'image3'  => 'required|image|mimes:jpeg,png,jpg,JPEG,PNG,JPG|max:2048',
			
		];
	}


	/**
	 * Return Array to Update in table
	 * 
	 * @params $request Request
	 * 
	 * @return $edit_data Array
	 */
	private function getDataToUpdate(Request $request, $data){
		
		$top_heading_1 = trim($request->input('top_heading_1'));
		$top_heading_2 = trim($request->input('top_heading_2'));
		$heading_1 = trim($request->input('heading_1'));
		$heading_2 = trim($request->input('heading_2'));
		$heading_3 = trim($request->input('heading_3'));
		$content_1 = trim($request->input('content_1'));
		$content_2 = trim($request->input('content_2'));
		$content_3 = trim($request->input('content_3'));

		$edit_data = [
			$this->tablePrefix.'_topheading1' => $top_heading_1,
			$this->tablePrefix.'_topheading2' => $top_heading_2,
			$this->tablePrefix.'_heading1' => $heading_1,
			$this->tablePrefix.'_heading2' => $heading_2,
			$this->tablePrefix.'_heading3' => $heading_3,
			$this->tablePrefix.'_content1' => $content_1,
			$this->tablePrefix.'_content2' => $content_2,
			$this->tablePrefix.'_content3' => $content_3,
		];

		$image_1_upload = $this->checkAndUpdateImage($request->file('image1'), $data);
		$image_2_upload = $this->checkAndUpdateImage($request->file('image2'), $data);
		$image_3_upload = $this->checkAndUpdateImage($request->file('image3'), $data);

		if($image_1_upload['status']){
			$edit_data[$this->tablePrefix.'_image1'] = $image_1_upload['image_name'];
		}
		if($image_2_upload['status']){
			$edit_data[$this->tablePrefix.'_image2'] = $image_2_upload['image_name'];
		}
		if($image_3_upload['status']){
			$edit_data[$this->tablePrefix.'_image3'] = $image_3_upload['image_name'];
		}
		return $edit_data;
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
	   			
			if(!empty($data['image1'])){
				unlink($this->destinationPath.basename($data['image1']));
			}
			$image_name = time().'_'.$image->getClientOriginalName(); 
			$image->move($this->destinationPath, $image_name);		
			$result['status'] = true;
			$result['image_name'] = $image_name;
		}
		return $result;
	}
}

?>