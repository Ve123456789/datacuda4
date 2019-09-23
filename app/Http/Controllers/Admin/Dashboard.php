<?php 
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use DB;

class Dashboard extends Controller{

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

		//echo $request->session()->get('admin_userid');
		$user_table = \Config::get('constants.db.prefix').\Config::get('constants.db.user'); 
		$data['photographers'] = DB::table('users')
        ->orderBy('id','desc')
        ->paginate(6);

        $data['share_images'] = DB::table('share_images')
        ->select('*')
        ->paginate(30);

        $latest_transction = [];
        $latest_tr_count = [];

        $i=0;
        foreach ($data['share_images'] as $key => $value) {
           array_push($latest_transction,$value->buy_amount);
           array_push($latest_tr_count,$i);
           $i++;
        }

        $data['latest_transction'] = $latest_transction; 
        $data['latest_tr_count'] = $latest_tr_count; 
        
       // print_r($data);
		return view('admin/dashboard',$data);
	}
	
}

?>