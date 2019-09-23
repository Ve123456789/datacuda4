<?php 
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Validator;
use App\AdminHomePlans;
use DB;
use Mail;
 
class HomePlans extends Controller{
	 
	public $destinationPath = '';
	public $dbAndTableName = '';
	public $tablePrefix = '';

	public function __construct()
	{        
		$this->destinationPath = public_path('/images/');
		$this->dbAndTableName = \Config::get('constants.db.prefix').\Config::get('constants.db.homeplans'); 
		$this->tablePrefix = \Config::get('constants.db.homeplans');

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
		
		$data['title_heading'] ='Home Plans Section';
        $data['section_heading'] ='Home Plans Section';

		$data['search_heading'] ='';
		if($request->input('search_heading')){
			$data['search_heading'] = $search_heading = $request->input('search_heading');
			$validator = Validator::make($request->all(), [
					'search_heading' => 'max:150|alpha_dash',
				]);
			if ($validator->fails()) {
				return redirect('admin/homeplans')->withErrors($validator)->withInput();
			}
			//search heading in Table
			$data['getSectionData'] = AdminHomePlans::searchPlans($search_heading); 
		}else{
			//get all records from table
			$data['getSectionData'] = AdminHomePlans::getAllData();
		}
		return view('admin/homeplans',$data);
	}
	
	/**
	 * Add a new plan
	 * 
	 * @params $request Request
	 * 
	 * @return view
	 */
	public function add(Request $request){

        $data['title_heading'] ='Add New Plan';
        $data['section_heading'] ='Add A Plan';
        
		$assetsPath = asset('/images\/');
		$data['plan_name']          = ($request->old('plan_name') !='' ) ? $request->old('plan_name') : '' ;
		$data['plan_description']   = ($request->old('plan_description') !='' ) ? $request->old('plan_description') : '' ;
		$data['plan_amount']        = ($request->old('plan_amount') !='' ) ? $request->old('plan_amount') : '' ;
		$data['plan_duration']      = ($request->old('plan_duration') !='' ) ? $request->old('plan_duration') : '' ;
		
		if($request->input('save')){
			//validate user input
			$this->validateAddRecord($request);
			//process image informationn and return $add_data Array
            $add_data = $this->processImages($request);
            //add data to table
			$insert_status = \App\AdminHomePlans::create($add_data);
			if($insert_status)
				return Redirect('admin/homeplans');
		}
		return view('admin/homeplans',$data);
	}
	
	/**
	 * Edit record information
	 * 
	 * @params $request Request
	 * 
	 * @return view
	 */
	public function edit(Request $request){
 
		$data['title_heading'] ='Edit Plan Details';
        $data['section_heading'] ='Edit Plan Detail';
		$assetsPath = asset('/images\/');

		$id = $request->segment(4);
		$editdata = \App\AdminHomePlans::where($this->tablePrefix.'_id',$id)->first(); 
		
		$data['plan_name']  = ($request->old('plan_name') !='' ) ? $request->old('plan_name') : $editdata->{$this->tablePrefix.'_heading'} ;
		$data['plan_description']  = ($request->old('plan_description') !='' ) ? $request->old('plan_description') : $editdata->{$this->tablePrefix.'_content'} ;
		$data['plan_amount']  = ($request->old('plan_amount') !='' ) ? $request->old('plan_amount') : $editdata->{$this->tablePrefix.'_price'} ;
		$data['plan_duration']  = ($request->old('plan_duration') !='' ) ? $request->old('plan_duration') : $editdata->{$this->tablePrefix.'_duration'} ;
		$data['image']   = $editdata->{$this->tablePrefix.'_image'} ;

		if($request->input('save')){

			$plan_name = trim($request->input('plan_name'));
			$plan_description = trim($request->input('plan_description'));
			$plan_amount = trim($request->input('plan_amount'));
			$plan_duration = trim($request->input('plan_duration'));
			//validate input
			$this->validateUserInput($request, $id);

			$edit_data = [
                $this->tablePrefix.'_heading' => $plan_name,
                $this->tablePrefix.'_content' => $plan_description,
                $this->tablePrefix.'_price' => $plan_amount,
                $this->tablePrefix.'_duration' => $plan_duration
            ];
			
			$image_upload = $this->checkAndUpdateImage($request->file('image'), $data);
			if($image_upload['status']){
				$edit_data[$this->tablePrefix.'_image'] = $image_upload['image_name'];
			}
			$edited = \App\AdminHomePlans::where($this->tablePrefix.'_id',$id)->update($edit_data);
			return Redirect('admin/homeplans');	
		}
		return view('admin/homeplans',$data);
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
			
		$edited = \App\AdminHomePlans::where($this->tablePrefix.'_id',$id)->update($status_data);
		return Redirect('admin/homeplans');
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
		$edited = \App\AdminHomePlans::destroy($id);
		return Redirect('admin/homeplans');
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
			'plan_name' => 'required|max:50|regex:/^[\pL\s\-]+$/u',
			'plan_description' => 'required|max:100|regex:/^[\pL\s\-]+$/u',
            'plan_duration' => 'required|max:10|regex:/^[\pL\s\-]+$/u',
            'plan_amount'   => 'required|between:0,99999.99',
            'image'  => 'required|image|mimes:jpeg,png,jpg,JPEG,PNG,JPG|max:2048',		
		]);
		
		if ($validator->fails()) {
			return redirect('admin/homeplans/edit/'.$id)
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
			'plan_name' => 'required|max:50|regex:/^[\pL\s\-]+$/u',
			'plan_description' => 'required|max:100|regex:/^[\pL\s\-]+$/u',
            'plan_duration' => 'required|max:10|regex:/^[\pL\s\-]+$/u',
            'plan_amount'   => 'required|between:0,99999.99',
            'image'  => 'required|image|mimes:jpeg,png,jpg,JPEG,PNG,JPG|max:2048',		
		]);
		
		if ($validator->fails()) {
			return redirect('admin/homeplans/add')
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

		$plan_name = trim($request->input('plan_name'));
		$plan_description = trim($request->input('plan_description'));
		$plan_amount = trim($request->input('plan_amount'));
		$plan_duration = trim($request->input('plan_duration'));
		$image     = $request->file('image');

		$image_name        = time().'_'.$image->getClientOriginalName(); 
		$image->move($this->destinationPath, $image_name);

		return $add_data = array(  
					$this->tablePrefix.'_heading' => $plan_name,
					$this->tablePrefix.'_content' => $plan_description,
					$this->tablePrefix.'_price'   => $plan_amount,
					$this->tablePrefix.'_duration'=> $plan_duration,
					$this->tablePrefix.'_image'   => $image_name,
					$this->tablePrefix.'_status'  => '1'
				);
	}
}

?>