<?php 
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Validator;
use App\AboutUsPage;
use DB;
use Mail;
 
class AboutUs extends Controller{
	 
	public $destinationPath = '';
	public $tablePrefix = '';

	public function __construct()
	{        
		$this->destinationPath = public_path('/images\/');
		$this->tablePrefix = \Config::get('constants.db.aboutus');

		$this->middleware(function ($request, $next) {
            if(! session()->has('admin_userid')){
				return Redirect('/admin')->send();
			}
            return $next($request);
        });
	}
	
    /**
	 * Show list of all saved plans
	 * 
	 * @params $request Request
	 * 
	 * @return view
	 */
	public function index(Request $request){
		
		$data['title_heading'] ='About Us Section';
        $data['section_heading'] ='About Us Section';
        //get all records from table
        $data['getAboutUsData'] = AboutUsPage::getAllData();
		return view('admin/aboutus',$data);
	}
	
	/**
	 * Add a new plan
	 * 
	 * @params $request Request
	 * 
	 * @return view
	 */
	public function add(Request $request){

        $data['title_heading'] ='Add New Content';
        $data['section_heading'] ='Add New Content';
        
		$assetsPath = asset('/images\/');
		$data['heading']   = ($request->old('heading') !='' ) ? $request->old('heading') : '' ;
		$data['content']   = ($request->old('content') !='' ) ? $request->old('content') : '' ;
		$data['section']   = ($request->old('section') !='' ) ? $request->old('section') : '' ;
		
		if($request->input('save')){

			//validate user input
			$this->validateAddRecord($request);
			//process image informationn and return $add_data Array
            $add_data = $this->processImages($request);
            //add data to table
			$insert_status = \App\AboutUsPage::create($add_data);
			if($insert_status)
				return Redirect('admin/aboutus');
		}
		return view('admin/aboutus',$data);
	}
	
	/**
	 * Edit record information
	 * 
	 * @params $request Request
	 * 
	 * @return view
	 */
	public function edit(Request $request){
 
		$data['title_heading'] ='Edit About Us Details';
        $data['section_heading'] ='Edit About Us Detail';
		$assetsPath = asset('/images\/');

		$id = $request->segment(4);
		$editdata = \App\AboutUsPage::where($this->tablePrefix.'_id',$id)->first(); 
		
		$data['heading']  = ($request->old('heading') !='' ) ? $request->old('heading') : $editdata->{$this->tablePrefix.'_heading'} ;
		$data['content']  = ($request->old('content') !='' ) ? $request->old('content') : $editdata->{$this->tablePrefix.'_content'} ;
		$data['section']  = ($request->old('section') !='' ) ? $request->old('section') : $editdata->{$this->tablePrefix.'_section'} ;
		$data['image']   = $editdata->{$this->tablePrefix.'_image'} ;

		if($request->input('save')){

			$heading = trim($request->input('heading'));
			$content = trim($request->input('content'));
			$section = trim($request->input('section'));
			//validate input
			$this->validateUserInput($request, $id);

			$edit_data = [
                $this->tablePrefix.'_heading' => $heading,
                $this->tablePrefix.'_content' => $content,
                $this->tablePrefix.'_section' => $section,
            ];
			
			if($section == 'top' || $section == 'bottom'){

				$image_upload = $this->checkAndUpdateImage($request->file('image'), $data);
				if($image_upload['status']){
					$edit_data[$this->tablePrefix.'_image'] = $image_upload['image_name'];
				}
			}else{
				$edit_data[$this->tablePrefix.'_image'] = '';
			}
			$edited = \App\AboutUsPage::where($this->tablePrefix.'_id',$id)->update($edit_data);
			return Redirect('admin/aboutus');	
		}
		return view('admin/aboutus',$data);
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
			
		$edited = \App\AboutUsPage::where($this->tablePrefix.'_id',$id)->update($status_data);
		return Redirect('admin/aboutus');
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
		$edited = \App\AboutUsPage::destroy($id);
		return Redirect('admin/aboutus');
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
			'heading' => 'required|max:50|regex:/^[\pL\s\-]+$/u',
            'content' => 'required|max:500|regex:/^[\pL\s\-]+$/u',
            'section' => 'required|max:6',
            'image'   => 'required|image|mimes:jpeg,png,jpg,JPEG,PNG,JPG|max:2048',		
		]);
		
		if ($validator->fails()) {
			return redirect('admin/aboutus/edit/'.$id)
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
			'heading' => 'required|max:50|regex:/^[\pL\s\-]+$/u',
			'content' => 'required|max:500|regex:/^[\pL\s\-]+$/u',
			'section' => 'required|max:6',
            'image'   => 'required|image|mimes:jpeg,png,jpg,JPEG,PNG,JPG|max:2048',		
		]);
		
		if ($validator->fails()) {
			return redirect('admin/aboutus/add')
						->withErrors($validator)
						->withInput();
		}
	}

	/**
	 * Process uploaded images
	 * 
	 * @params $request 
	 * 
	 * @return $add_data Array 
	 */
	private function processImages($request){

		$image_name = '';
		$heading = trim($request->input('heading'));
		$content = trim($request->input('content'));
		$section = trim($request->input('section'));
		if('top' == $section || 'bottom' == $section){

			$image   = $request->file('image');
			$image_name = time().'_'.$image->getClientOriginalName(); 
			$image->move($this->destinationPath, $image_name);
		}
		return $add_data = array(  
					$this->tablePrefix.'_heading' => $heading,
					$this->tablePrefix.'_content' => $content,
					$this->tablePrefix.'_section' => $section,
					$this->tablePrefix.'_image'   => $image_name,
					$this->tablePrefix.'_status'  => '1'
				);
	}
}
?>