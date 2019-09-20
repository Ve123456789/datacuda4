<?php
namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class Dynamic extends Controller{

    public function homeSecondSection(Request $request){
    	$data  = DB::table('admin_homesecond')->first();
    	return response()->json(['response'=>$data,'success'=>true]);
    }

    public function homeThirdSection(){
    	$data = DB::table('admin_homethird')->first();
    	return response()->json(['response'=>$data,'success'=>true]);
    }

    public function homeReview(){
    	$data = DB::table('admin_homereviews')->get();
    	return response()->json(['response'=>$data,'success'=>true]);
    	
    }

    public function homePlan(){
    	$data = DB::table('admin_homeplans')->get();
    	return response()->json(['response'=>$data,'success'=>true]);
    	
    }
}