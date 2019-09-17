<?php 
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Validator;
use App\contact;
use DB;
use Mail;
 
class AdminContactUs extends Controller{
	 
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
		
		$data['title_heading'] ='Admin Contact Us Section';
        $data['section_heading'] ='Admin Contact Us Section';

		$data['search_heading'] ='';
		if($request->input('search_heading')){
			$data['search_heading'] = $search_heading = $request->input('search_heading');
			$validator = Validator::make($request->all(), [
					'search_heading' => 'max:150|alpha_dash',
				]);
			if ($validator->fails()) {
				return redirect('admin/contact_us')->withErrors($validator)->withInput();
			}
			//search heading in Table
			$data['getSectionData'] = contact::searchHeading($search_heading); 
		}else{
			//get all records from table
			$data['getSectionData'] = contact::getAllData();
		}
		return view('admin/admin_contactus',$data);
	}

}