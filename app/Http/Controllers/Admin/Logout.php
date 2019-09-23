<?php 
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class Logout extends Controller{

		
	public function index(Request $request){
        $request->session()->flush();
	    $request>session()->has('admin_userid');
		return Redirect('/admin')->send();
		
	}

	
}

?>