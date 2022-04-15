<?php

namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App;
use Storage;
use Auth;
use App\Noticealert;
use App\User;
use App\UserNoticealert;
use DB;
class NoticealertController extends Controller
{

    private $config_slugs;

    public function __construct()
    {
        ///$this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();
       
        // $user = User::where('id', 1)->first();
        // print_r($user);die('iyui');
        $notices = $user->noticealerts->where('id', 12)->first();
        return response()->json(['status' => 200, 'token' => request('auth_token'), 'message' => 'Success', 'data' => $notices]);
    }
    public function countNotice()
    {
        $user = Auth::user();
        $noticesCnt = UserNoticealert::where('user_id', Auth::user()->id)->where('status',1)->count();
        return response()->json(['status' => 200, 'token' => request('auth_token'), 'message' => 'Success', 'data' => ['count'=>$noticesCnt]]);
    }

    public function getListOfNotice()
    {
        $user = Auth::user();
        $noticesList = UserNoticealert::with('noticealerts')->where('user_id',Auth::user()->id)->where('status',1)->orderBy('id','DESC')->get();
        return response()->json(['status' => 200, 'token' => request('auth_token'), 'message' => 'Success', 'data' => $noticesList]);
    }

    public function delListOfNotice(){
        $user = Auth::user();
        $noticesList = DB::table('user_noticealerts')->where('user_id',Auth::user()->id)->update(['status'=>0]);
        if ($noticesList) {
            return response()->json(['status' => 200,'token' => request('auth_token'),'message' => 'Success']); 
        }else{
            return response()->json(['status' => 401, 'token' => request('auth_token'),'message' => 'Failed']); 
        }
    }

    public function show($id)
    {
        $user = Auth::user();
        // $user = User::where('id', 1)->first();
        $message = $user->noticealerts->where('id', $id)->first();
        $message->pivot->status = 1;
        $message->pivot->save();
        return response()->json(['status' => 200, 'token' => request('auth_token'), 'message' => 'Success', 'data' => $message]);
    }

    public function delete($id)
    {
        $user = Auth::user();
        // $user = User::where('id', 1)->first();
        $message = $user->noticealerts->where('id', $id)->first();
        $message->pivot->status = 2;
        $message->pivot->save();

        return response()->json(['status' => 200, 'token' => request('auth_token'), 'message' => 'Deleted Successfully']);
    }

}
