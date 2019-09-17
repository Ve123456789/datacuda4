<?php 
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Validator;
use DB;
use Mail;
use App\UserProjects;
use App\Purchase;

class Finance extends Controller{
	 
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
		$project_purchase = UserProjects::where('user_id',$id = $request->segment(3))->get();
        foreach($project_purchase as $key => $project){
            $project_purchase[$key]['user_detail'] = $project->users()->first();
            // $project_purchase[$key]['purchase_details'] = $project->purchase()->count();
            $project_purchase[$key]['purchase_details'] = Purchase::where('project_id', $project->id)->count();
            $purches_datas = Purchase::where('project_id', $project->id)->get();
            $p_amount_temp = 0;
            foreach ($purches_datas as $value) {
            	$p_amount_temp  += $value->by_amount;
            }
            $project_purchase[$key]['purchase_price']    =  $p_amount_temp;

        }


        $data['listdatas'] =  $project_purchase;		
		return view('admin/finance',$data);
	}
	

	
	


	
	
	
	public function status(Request $request){
		$status = $request->segment(4);
		$id = $request->segment(5);
			$status_data = array(
							'active' => $status
						);
			
			$edited = DB::table('users')->where('id',$id)->update($status_data);
			return Redirect('admin/user');

	}



	
	
	// public function del(Request $request){
	// 	$id = $request->segment(3);
	// 	$edited = \App\AdminAdviser::destroy($id);
	// 	return Redirect('adviser');

	// }


	
}

?>