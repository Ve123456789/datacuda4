<?php

namespace App\Http\Controllers\API;

use App\Purchase;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\UserProfile;
use App\UserProjects;
use App\ShareImage;
use Storage;
use Auth;
use Hash;
use DB;
use App\CompanyProfile;
use App\Models\Payplan;


use App\Quotation;
use Validator;
use App\Media;
use ZanySoft\Zip\Zip;
use ZipArchive;
use File;


class ProjectController extends Controller{
    
    /*
        function name : create_project
        functionality : create project for user
    */
    public function create_project(Request $request){

        $validator = Validator::make($request->all(), [
            'project_name' => 'required|unique:user_projects,project_name'
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors(), 'status' => '401']);
        }
        //Save data into the table
        $project_path = rand_string(8);
        $data_saved = UserProjects::create([
            'user_id' => Auth::user()->id,
            'project_name' => request('project_name'),
            'project_logo' => request('project_name'),
            'project_price' => 0,
            'project_slug' => request('project_name'),
            'project_path' => $project_path,
            'created_at' => date('d-m-y h:i:s')
        ]);
        $project_id = key_encryption($data_saved->id);
        $dir_data = [
            'id'         =>  $data_saved->id,
            'email'      =>  Auth::user()->email,
            'project_path' =>  $data_saved->project_path,
        ];
        create_public_dir($dir_data,'p');
        return response()->json(['status' => 201, 'message' => 'Project created successfully', 'project_id' => $project_id]);
    }


    /*
        function name : update_project
        functionality : update project for user
    */
    public function update_project(Request $request){

        $validator = Validator::make($request->all(), [
            'id'           => 'required',
            'project_name' => 'required'
        ]);

        //'project_name' => 'required|unique:user_projects,project_name'
        
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors(), 'status' => '401']);
        }

        $project_id = key_encryption(request('id'),'d');

        //Save data into the table
        // DB::table()->where("id",$project_id)->update([
        //     'project_name' => request('project_name'),
        //     'project_logo' => request('project_name')
        // ]);

        $data_saved = UserProjects::where("id",$project_id)->update([
            'project_name' => request('project_name'),
            'project_logo' => request('project_name')
        ]);
       
        return response()->json(['status' => 201, 'message' => 'Project Updated successfully','project_id' =>request('id')]);
    }



    public function get_project($user_id = null)
    {
        $UserProjects = UserProjects::get();
        return response()->json(['status' => 201, 'message' => 'Project created successfully', 'UserProjects' => $UserProjects]);
    }



    public function get_user_project(Request $request){
        $UserProjects = UserProjects::where('user_id', Auth::user()->id)->where('status', 1)->orderBy($request->input('order_by', 'id'), 'DESC')->get();
        $ProjectData = [];
        $project_size = 0;
       
        foreach ($UserProjects as $data):

            $project_purchase = Purchase::where('project_id', $data->id)->get();

            $project_ShareImage = ShareImage::where('project_id', $data->id)->where('buy_status','0')->get();

            $media_ids  = DB::table('media_user_projects')->where('user_projects_id', $data->id)->get();

            $total_img = 0;
            $total_vid = 0;
            
            foreach ($media_ids as $key => $value) {
                $media_count = DB::table('medias')->select('ext')->where('status', 1)->where('id', $value->media_id)->first();
                if($media_count){
                    if($media_count->ext == 'jpg' || $media_count->ext == 'png'){
                        $total_img++;
                    }else{
                        $total_vid++;
                    }
                }
                
            }

            $media = $data->medias()->where('is_cover', 1)->first();
            if(empty($media)) {
                $media = $data->medias()->where('status', 1)->orderBy("id","desc")->first();
            }
            $media_price_get = $data->medias()->where('status', 1)->get();



            $price = 0;
            foreach ($media_price_get as $p_data):
                $old_p = $price;
                $price = $old_p + $p_data->amount;
            endforeach;
            $size_data = 0;
            foreach ($media_price_get as $media_data):
                $test_data = $size_data;
                $size_data  = $test_data + $media_data->size;
            endforeach;
            $test_size_data = $project_size;
            $project_size = $test_size_data + $size_data;
            $image_path = 'database/'.Auth::user()->email.'/'.$data->project_path.$data->id.'/';

            if ($media && ($media->ext == 'jpg' || $media->ext == 'png' || $media->ext == 'jpeg')):
                $ProjectData[] = [
                    'id' => key_encryption($data->id),
                    'name' => $data->project_name,
                    'date' => date("m/d/Y",strtotime($data->created_at)),
                    'logo' => $media->filename,
                    'price' => $price,
                    'real_id' => $data->id,
                    'image_path' => $image_path,
                    'project_purchase'=>$project_purchase,
                    'project_ShareImage'=>$project_ShareImage,
                    'total_vid'=>$total_vid,
                    'total_img'=>$total_img,
                ];
            else:
                $ProjectData[] = [
                    'id' => key_encryption($data->id),
                    'name' => $data->project_name,
                    'date' => date("m/d/Y",strtotime($data->created_at)),
                    'price' => $price,
                    'real_id' => $data->id,
                    'image_path' => $image_path,
                    'project_purchase'=>$project_purchase,
                    'project_ShareImage'=>$project_ShareImage,
                    'total_vid'=>$total_vid,
                    'total_img'=>$total_img,
                ];
            endif;
        endforeach;
        
        $plan = $request->user()->subscriptions()->latest()->first()->plan()->first();

        $size = [
            'usag' => convertToReadableSize($project_size),
            'plan'  => $plan->storage_quantity,
            'plan_unit'  => $plan->storage_unit,
        ];
        return response()->json(['status' => 201, 'message' => 'Project created successfully', 'UserProjects' => $ProjectData,'usagedata'=>$size, 'project_size_in_byte' => $project_size]);
    }



    public function search(Request $request){
        $error = ['error' => 'No results found, please try with different keywords.'];
        if ($request->has('keywords')) {
            $UserProjects = UserProjects::where('user_id', Auth::user()->id)->where('project_name', 'like', '%' . $request->get('keywords') . '%')->where('status', 1)->get();
            $ProjectData = [];

            foreach ($UserProjects as $data):

                $project_purchase = Purchase::where('project_id', $data->id)->get();

                $project_ShareImage = ShareImage::where('project_id', $data->id)->where('buy_status','0')->get();

                $media_ids  = DB::table('media_user_projects')->where('user_projects_id', $data->id)->get();

                $total_img = 0;
                $total_vid = 0;
                
                foreach ($media_ids as $key => $value) {
                    $media_count = DB::table('medias')->select('ext')->where('status', 1)->where('id', $value->media_id)->first();
                    if($media_count){
                        if($media_count->ext == 'jpg' || $media_count->ext == 'png'){
                            $total_img++;
                        }else{
                            $total_vid++;
                        }
                    }
                    
                }

                $media = $data->medias()->where('is_cover', 1)->first();
                    if(empty($media)) {
                        $media = $data->medias()->where('status', 1)->first();
                    }
                $image_path = 'database/'.Auth::user()->email.'/'.$data->project_path.$data->id.'/';
                if ($media && ($media->ext == 'jpg' || $media->ext == 'png')):
                    $ProjectData[] = [
                        'id' => key_encryption($data->id),
                        'name' => $data->project_name,
                        'logo' => $media->filename,
                        'price' => '',
                        'real_id' => $data->id,
                        'image_path' => $image_path,
                        'project_purchase'=>$project_purchase,
                        'project_ShareImage'=>$project_ShareImage,
                        'total_vid'=>$total_vid,
                        'total_img'=>$total_img,
                    ];
                else:
                    $ProjectData[] = [
                        'id' => key_encryption($data->id),
                        'name' => $data->project_name,
                        'price' => '',
                        'real_id' => $data->id,
                        'image_path' => $image_path,
                        'project_purchase'=>$project_purchase,
                        'project_ShareImage'=>$project_ShareImage,
                        'total_vid'=>$total_vid,
                        'total_img'=>$total_img,
                    ];
                endif;
            endforeach;
            //return response()->json($ProjectData);
            $plan = $request->user()->subscriptions()->latest()->first()->plan()->first();
            dd ($plan);
             $size = [
                'usag' => 3,
                'plan'  => $plan->storage_quantity,
                'plan_unit'  => $plan->storage_unit,
             ];
            return response()->json(['status' => 201, 'message' => 'Success', 'UserProjects' => $ProjectData,'usagedata'=>$size]);

        }
        return $error;
    }

    public function getbuyproject(Request $request){
        $project_ids = Purchase::select('project_id')->where('user_id', Auth::user()->id)->where('status', 1)->get();
        $p_ids =[];
        foreach ($project_ids as $p_id_data): $p_ids[] = $p_id_data->project_id; endforeach;
        $UserProjects = UserProjects::whereIn('id',$p_ids)->get();
        $ProjectData = [];
        foreach ($UserProjects as $data):
            $media = $data->medias()->first();
            $image_path = 'database/'.Auth::user()->email.'/'.$data->project_path.$data->id.'/';
            if ($media && ($media->ext == 'jpg' || $media->ext == 'png')):
                $ProjectData[] = [
                    'id' => key_encryption($data->id),
                    'name' => $data->project_name,
                    'logo' => $media->filename,
                    'real_id' => $data->id,
                    'image_path' => $image_path
                ];
            else:
                $ProjectData[] = [
                    'id' => key_encryption($data->id),
                    'name' => $data->project_name,
                    'real_id' => $data->id,
                    'image_path' => $image_path
                ];
            endif;
        endforeach;
        return response()->json(['status' => 201, 'message' => 'Success', 'UserProjects' => $ProjectData]);
    }
    public function get_project_data(Request $request){

        $id = key_encryption($request->pro_id, 'd');

        $project = UserProjects::where('user_id', Auth::user()->id)->where('id', $id)->first();
        $project['project_date'] =  date("m/d/Y h:i:a",strtotime($project->created_at));
        $project['project_last_share'] =  ShareImage::orderBy('id', 'desc')->where('user_id', Auth::user()->id)->where('project_id', $id)->first();

       // echo $project->created_at;
        //echo $project->created_at = date("m/d/Y h:i:a",strtotime($project->created_at));
        //print_r($project); die();
        $project['medias'] = $project->medias()->where('status', 1)->orderBy($request->order_by, 'DESC')->get();
        $project['image_path'] = 'database/'.Auth::user()->email.'/'.$project->project_path.$project->id.'/';
        $size_data = 0;
        $size = array();
        if(!empty($project['medias'])) {
            foreach ($project['medias'] as $media_data):
                $test_data = $size_data;
                $size_data = $test_data + $media_data->size;
            endforeach;

            if (!$project->id) {
                return response()->json([
                    'message' => 'Some Think Wrong',
                    'status' => 422
                ], 422);
            }
        }
        $mail_size = 0;
        if($size_data <= 20000000): $mail_size = 1; endif;
        $size = convertToReadableSize($size_data);
        $size['mail_size'] = $mail_size;
        return response()->json(['status' => 200, 'token' => request('auth_token'), 'message' => 'Success', 'project_medias' => $project['medias']
                ,'project_data'=>$project,'path'=>$project['image_path'],'project_last_share'=>$project['project_last_share'],'project_size' => $size]
            );
    }


    public function ChangeProjectAccordingType(Request $request)
    {

        $run = UserProjects::where('id', $request->id)->update(['project_according'=>$request->project_according]);
        if($run): return response()->json(['status' => 200, 'message' => 'Success']);
        else:     return response()->json(['message' => 'Some Think Wrong', 'status' => 422], 422); endif;
    }
    public function ChangeProjectAccordingAmount(Request $request)
    {
        $project = UserProjects::where('id',$request->id)->first();
        $project_amount = $request->amount;
        $count = $project->medias()->where('status', 1)->count();
        $imagevalue = $project_amount / $count;
        $media_get = $project->medias()->where('status', 1)->get();
        foreach ($media_get as $media_data):
            $run = Media::where('id',$media_data->id)->update(['amount'=>$imagevalue]);
        endforeach;
        if($run): return response()->json(['status' => 200, 'message' => 'Success']);
        else:     return response()->json(['message' => 'Some Think Wrong', 'status' => 422], 422); endif;
    }
    public function get_buy_project_data(Request $request)
    {
        $id = key_encryption($request->pro_id, 'd');
        $project = UserProjects::where('id', $id)->first();
        $project['medias'] = $project->medias()->orderBy($request->order_by, 'DESC')->get();
        $project['image_path'] = 'database/'.Auth::user()->email.'/'.$project->project_path.$project->id.'/';
        if (!$project->id) {
            return response()->json([
                'message' => 'Some Think Wrong',
                'status' => 422
            ], 422);
        }
        if(empty($project['medias'])) {
                return response()->json([
                    'message' => 'Some Think Wrong',
                    'status' => 422
                ], 422);
        }
        return response()->json(['status' => 200, 'token' => request('auth_token'), 'message' => 'Success','project_medias' => $project['medias'],'path'=>$project['image_path']]);
    }

    public function sendprojectlink(Request $request)
    {
        $project_data = UserProjects::where('id', $request->id)->first();
        if (!$project_data) {
            return response()->json([
                'message' => 'Something Went Wrong',
                'status' => 422
            ], 422);
        }


        $project_data['medias'] = $project_data->medias()->orderBy('id', 'DESC')->ofStatus(1)->get();

        $totla_size = 0;
        foreach ($project_data['medias'] as $value) {
            $totla_size += $value['size'];
        }
        $deleteDate = date("F d, Y", strtotime("+1 month", strtotime(date('Y-m-d'))));

        $file_count = count($project_data['medias']);
        $id = Auth::user()->id;
        $key = random(10);
        $sm_model = new ShareImage();
        $sm_model->user_id = $id;
        $sm_model->image_id = $project_data->id;
        $sm_model->project_id = $project_data->id;
        $sm_model->recipient_id = $key;
        $sm_model->email = $request->email;
        $sm_model->project_password = bcrypt($request->project_password);
        $sm_model->buy_amount = $project_data->project_price;
        
        // if($project_data->project_price == 0){
        //     $sm_model->buy_status = '1';
        // }

        if ($sm_model->save()) {
            $link_encrypt = key_encryption($key);
            $link_encrypt2 = key_encryption($link_encrypt);
            $share_link = url('/') . '/#/shareproject/' . $link_encrypt2;
            $mail_details = [
                'email_id' => $request->email,
                'from_id' => 'info@datatcuda.com',
                'subject' => 'Share Project Link',
                'view' => 'mail_template/share_files_mail',
                'data' => $share_link,
                'project_data' => array('file_count'=>$file_count,'total_size'=>number_format($totla_size/(1024*1024),1),'delete'=>$deleteDate,'medias'=> $project_data['medias'])
            ];
            if (!send_mail_project($mail_details)) {
                return response()->json([
                    'message' => 'Something Went Wrong',
                    'status' => 422
                ], 422);

            }
        } else {
            return response()->json([
                'message' => 'Something Went Wrong',
                'status' => 422
            ], 422);
        }
        return response()->json(['status' => 201, 'token' => request('auth_token'), 'message' => 'Share Project Link Send Mail Id Successfully!']);
    }




    public function ProjectSendByMail(Request $request){
        
        
        $project_data = UserProjects::where('id', $request->id)->first();
        if (!$project_data) {
            return response()->json([
                'message' => 'Something Went Wrong',
                'status' => 422
            ], 422);
        }
        $project_data['medias'] = $project_data->medias()->orderBy('id', 'DESC')->ofStatus(1)->get();
        $file_count = count($project_data['medias']);
        $totla_size = 0;
        foreach ($project_data['medias'] as $value) {
            $totla_size += $value['size'];
        }

        $deleteDate = date("F d, Y", strtotime("+1 month", strtotime(date('Y-m-d')))); 

        $id = Auth::user()->id;

        if ($request->include_condition == 1){
            $company_data = DB::table('company_profile')->where("user_id",$id)->first();      
        }else{
            $company_data='';
        }


        $key = random(10);
        $sm_model = new ShareImage();
        $sm_model->user_id = $id;
        $sm_model->image_id = $project_data['id'];
        $sm_model->project_id = $project_data['id'];
        $sm_model->recipient_id = $key;
        $sm_model->fist_name = $request->fist_name;
        $sm_model->last_name = $request->last_name;
        $sm_model->email = $request->email;
        $sm_model->address = $request->address;
        $sm_model->city = $request->city;
        $sm_model->state = $request->state;
        $sm_model->zip = $request->zip;
        $sm_model->invoice_no = $request->invoice_no;
        $sm_model->invoice_date = $request->invoice_date;
        $sm_model->description = json_encode(!empty($request->description)?$request->description:$request->description1);
        $sm_model->amount = json_encode(!empty($request->amount)?$request->amount:$request->amount1);
        $sm_model->amount_type = json_encode(!empty($request->amount_type)?$request->amount_type:$request->amount_type1);
        $sm_model->massage = $request->massage;
        $sm_model->buy_status = $request->collect_payment;
        $sm_model->delete_after = $request->delete_after;
        $sm_model->project_password = bcrypt($request->set_password);
        $sm_model->include_condition = $request->include_condition;
        $sm_model->send_as = $request->send_as;
        $sm_model->password_protect  = $request->password_protect;
        $sm_model->watermark_preview = $request->watermark_preview;
        
        $loopamount = 0;
        if(!empty($request->amount)){
            $user_amount = $request->amount;
        }else{
            $user_amount = $request->amount1;
        }
        foreach($user_amount as $m_amount): $run_amount = $loopamount; $loopamount  = $run_amount + $m_amount; endforeach;
        $buy_amount = $loopamount;
        $sm_model->buy_amount = $buy_amount;
        if ($sm_model->save()) {

            if($request->send_as == 'link'):

                
                $link_encrypt = key_encryption($key);
                $link_encrypt2 = key_encryption($link_encrypt);
                $share_link = url('/') . '/#/shareproject/' . $link_encrypt2;
                $mail_details = [
                    'email_id' => $request->email,
                    'from_id' => 'info@datatcuda.com',
                    'subject' => 'You received files',
                    'view' => 'mail_template/share_files_mail',
                    'data' => $share_link,
                    'project_data' => array('file_count'=>$file_count,'total_size'=>number_format($totla_size/(1024*1024),1),'delete'=>$deleteDate,'medias'=> $project_data['medias'],'company_data'=>$company_data)
                ];
                if($request->collect_payment == 1):
                $dir_data = [
                    'id'           =>  $project_data->id,
                    'email'        =>  $request->email,
                    'project_path' =>  $project_data->project_path,
                ];
                create_public_dir($dir_data,'r');
                create_public_dir($dir_data,'share_project');

                $s_path = storage_path('app/usersdata/'.$dir_data['id'].'/');
                $d_path = public_path('database/'.$dir_data['email'].'/'.$dir_data['project_path'].$dir_data['id'].'/');

                foreach ($project_data['medias'] as $m_data):
                    if (in_array($m_data->ext, array('jpg', 'png', 'jpeg', 'gif'))) {
                        \File::copy($s_path.$m_data->filename,$d_path.'original/'.$m_data->filename);
                    } else {
                        \File::copy($s_path.$m_data->filename,$d_path.'file/'.$m_data->filename);
                    }
                endforeach;
                endif;
                if (!send_mail_project($mail_details)):

                    return response()->json([
                        'message' => 'Something Went Wrong',
                        'status' => 422
                    ], 422);

                endif;

            elseif ($request->send_as == 'email'):
                if($request->collect_payment == 1):
                    $dir_data = [
                        'id'           =>  $project_data->id,
                        'email'        =>  $request->email,
                        'project_path' =>  $project_data->project_path,
                    ];
                    create_public_dir($dir_data,'r');
                    create_public_dir($dir_data,'share_project');
                    $s_path = storage_path('app/usersdata/'.$dir_data['id'].'/');
                    $d_path = public_path('database/'.$dir_data['email'].'/'.$dir_data['project_path'].$dir_data['id'].'/');
                    foreach ($project_data['medias'] as $m_data):
                        if (in_array($m_data->ext, array('jpg', 'png', 'jpeg', 'gif'))) {
                            \File::copy($s_path.$m_data->filename,$d_path.'original/'.$m_data->filename);
                        } else {
                            \File::copy($s_path.$m_data->filename,$d_path.'file/'.$m_data->filename);
                        }
                    endforeach;
                    $file_name    = $d_path.'zip/'.$project_data->project_name.'.zip';
                    $images = [];
                    foreach ($project_data['medias'] as $m_data):
                        if (in_array($m_data->ext, array('jpg', 'png', 'jpeg', 'gif'))) {
                            $images[] = $d_path.'original/'.$m_data->filename;
                        } else {
                            $images[] = $d_path.'file/'.$m_data->filename;
                        }
                    endforeach;
                    $is_valid = file_exists($file_name);
                    if($is_valid): unlink($file_name); endif;
                    $zip = Zip::create($file_name);
                    $zip->add($images);
                    $zip->close();
                else:
                    $d_path = public_path('uploads/');
                    $file_name    = $d_path.$project_data->project_name.'.zip';
                    $images = [];
                    foreach ($project_data['medias'] as $m_data):
                        $images[] = $d_path.$m_data->filename;
                    endforeach;
                    $is_valid = file_exists($file_name);
                    if($is_valid): unlink($file_name); endif;
                    $zip = Zip::create($file_name);
                    $zip->add($images);
                    $zip->close();
                endif;       
                        
                $mail_details = [
                    'email_id' => $request->email,
                    'from_id' => 'info@datatcuda.com',
                    'subject' => 'You received files',
                    'view' => 'mail_template/share_files_mail',
                    'file_link' => $file_name,
                    'data' => 'hello',
                    'project_data' => array('file_count'=>$file_count,'total_size'=>number_format($totla_size/(1024*1024),1),'delete'=>$deleteDate,'medias'=> $project_data['medias'])
                ];
                if (!send_mail_project_attach($mail_details)):

                    return response()->json([
                        'message' => 'Something Went Wrong',
                        'status' => 422
                    ], 422);

                endif;
            endif;
        } else {
            return response()->json([
                'message' => 'Something Went Wrong',
                'status' => 422
            ], 422);
        }


        $notoclear_data = array(
            "title"=>" Your files sent",
            "message"=>"Your file sent to ".$request->email,
            "created_at"=>date("Y-m-d H:i:s"),
        );

        $noticealerts_id = DB::table('noticealerts')->insertGetId($notoclear_data);

        $notoclear_relation = array(
            "user_id"=>$id,
            "noticealert_id"=>$noticealerts_id,
            "status"=>'1',
        );
        DB::table('user_noticealerts')->insert($notoclear_relation);

        return response()->json(['status' => 201, 'token' => request('auth_token'), 'message' => 'Share Project Link Send Mail Id Successfully!','share_link'=>isset($share_link)?urlencode($share_link):'']);
    }


    public function viewNotification(Request $request){

        $link_dencrypt = key_encryption($request->img_id, 'd');
        $key = key_encryption($link_dencrypt, 'd');
        $share_image_data = ShareImage::where('recipient_id', $key)->where('view_status','0')->first();
        $user_id = $share_image_data['user_id'];

        $project_data = UserProjects::where('id',$share_image_data['project_id'])->first();
        if (!$project_data) {
            return response()->json([
                'message' => 'Something Went Wrong',
                'status' => 422
            ], 422);
        }
        $project_data['medias'] = $project_data->medias()->orderBy('id', 'DESC')->ofStatus(1)->get();
        $file_count = count($project_data['medias']);
        $totla_size = 0;
        foreach ($project_data['medias'] as $value) {
            $totla_size += $value['size'];
        }

        $link_encrypt = key_encryption($share_image_data['recipient_id']);
        $link_encrypt2 = key_encryption($link_encrypt);
        $share_link = url('/') . '/#/shareproject/' . $link_encrypt2;

        $deleteDate = date("F d, Y", strtotime("+1 month", strtotime($share_image_data['created_at']))); 
         
        if($share_image_data){
            ShareImage::where('id', $share_image_data['id'])->update(['view_status' => '1']);
            $user_data  = User::where('id', $user_id)->first();
            $notoclear_data = array(
                "title"=>$share_image_data['email']." has viewed your files",
                "message"=>$share_image_data['email']." has viewed your DataCuda files",
                "created_at"=>date("Y-m-d H:i:s"),
            );

            $noticealerts_id = DB::table('noticealerts')->insertGetId($notoclear_data);

            $notoclear_relation = array(
                "user_id"=>$user_id,
                "noticealert_id"=>$noticealerts_id,
                "status"=>'1',
            );
            DB::table('user_noticealerts')->insert($notoclear_relation);

            $mail_details = [
                    'email_id' => $user_data['email'],
                    'from_id' => 'info@datatcuda.com',
                    'subject' => '('.$share_image_data['email'].')  has viewed your files',
                    'view' => 'mail_template/view_notification',
                    'data' => $share_link,
                    'project_data' => array('file_count'=>$file_count,'total_size'=>number_format($totla_size/(1024*1024),1),'delete'=>$deleteDate,'medias'=> $project_data['medias'],'client_mail'=>$share_image_data['email'])
                ];

            if (!send_mail_project($mail_details)) {

                return response()->json([
                    'message' => 'Some Think Wrong',
                    'status' => 422
                ]);

            }

        }else{
            return response()->json([
                'message' => 'Status already changend ',
                'status' => 422
            ]);
        }

        
    }

  

    public function paidNotification(Request $request){

        $link_dencrypt = key_encryption($request->img_id, 'd');
        $key = key_encryption($link_dencrypt, 'd');
        $share_image_data = ShareImage::where('recipient_id', $key)->where('paid_status','0')->first();
        $user_id = $share_image_data['user_id'];

        $project_data = UserProjects::where('id',$share_image_data['project_id'])->first();
        if (!$project_data) {
            return response()->json([
                'message' => 'Something Went Wrong',
                'status' => 422
            ], 422);
        }
        $project_data['medias'] = $project_data->medias()->orderBy('id', 'DESC')->ofStatus(1)->get();
        $file_count = count($project_data['medias']);
        $totla_size = 0;
        foreach ($project_data['medias'] as $value) {
            $totla_size += $value['size'];
        }

        $link_encrypt = key_encryption($share_image_data['recipient_id']);
        $link_encrypt2 = key_encryption($link_encrypt);
        $share_link = url('/') . '/#/shareproject/' . $link_encrypt2;

        $deleteDate = date("F d, Y", strtotime("+1 month", strtotime($share_image_data['created_at']))); 
         
        if($share_image_data){
            ShareImage::where('id', $share_image_data['id'])->update(['paid_status' => '1']);
            $user_data  = User::where('id', $user_id)->first();

            $notoclear_data = array(
                "title"=>"Great News! You’ve been paid!",
                "message"=>$share_image_data['email']." has paid you for their files. You received ".number_format($share_image_data['buy_amount'],2),
                "created_at"=>date("Y-m-d H:i:s"),
            );

            $noticealerts_id = DB::table('noticealerts')->insertGetId($notoclear_data);

            $notoclear_relation = array(
                "user_id"=>$user_id,
                "noticealert_id"=>$noticealerts_id,
                "status"=>'1',
            );

            DB::table('user_noticealerts')->insert($notoclear_relation);

            $mail_details = [
                    'email_id' => $user_data['email'],
                    'from_id' => 'info@datatcuda.com',
                    'subject' => 'Great News! You’ve been paid!',
                    'view' => 'mail_template/paid_notification',
                    'data' => $share_link,
                    'project_data' => array('file_count'=>$file_count,'total_size'=>number_format($totla_size/(1024*1024),1),'delete'=>$deleteDate,'medias'=> $project_data['medias'],'client_mail'=>$share_image_data['email'],'total_amount'=>number_format($share_image_data['buy_amount'],2))
                ];

            if (!send_mail_project($mail_details)) {

                return response()->json([
                    'message' => 'Some Think Wrong',
                    'status' => 422
                ]);

            }

        }else{
            return response()->json([
                'message' => 'Status already changend ',
                'status' => 422
            ]);
        }

        
    }

    public function downloadNotification(Request $request){

        $link_dencrypt = key_encryption($request->img_id, 'd');
        $key = key_encryption($link_dencrypt, 'd');
        $share_image_data = ShareImage::where('recipient_id', $key)->where('download_status','0')->first();
        $user_id = $share_image_data['user_id'];

        $project_data = UserProjects::where('id',$share_image_data['project_id'])->first();
        if (!$project_data) {
            return response()->json([
                'message' => 'Something Went Wrong',
                'status' => 422
            ], 422);
        }
        $project_data['medias'] = $project_data->medias()->orderBy('id', 'DESC')->ofStatus(1)->get();
        $file_count = count($project_data['medias']);
        $totla_size = 0;
        foreach ($project_data['medias'] as $value) {
            $totla_size += $value['size'];
        }

        $link_encrypt = key_encryption($share_image_data['recipient_id']);
        $link_encrypt2 = key_encryption($link_encrypt);
        $share_link = url('/') . '/#/shareproject/' . $link_encrypt2;

        $deleteDate = date("F d, Y", strtotime("+1 month", strtotime($share_image_data['created_at']))); 
         
        if($share_image_data){
            ShareImage::where('id', $share_image_data['id'])->update(['download_status' => '1']);
            $user_data  = User::where('id', $user_id)->first();
            $notoclear_data = array(
                "title"=>$share_image_data['email']." has downloaded your DataCuda files",
                "message"=>$share_image_data['email']." has downloaded your DataCuda files",
                "created_at"=>date("Y-m-d H:i:s"),
            );

            $noticealerts_id = DB::table('noticealerts')->insertGetId($notoclear_data);

            $notoclear_relation = array(
                "user_id"=>$user_id,
                "noticealert_id"=>$noticealerts_id,
                "status"=>'1',
            );
            DB::table('user_noticealerts')->insert($notoclear_relation);
            
            
            $mail_details = [
                    'email_id' => $user_data['email'],
                    'from_id' => 'info@datatcuda.com',
                    'subject' => '('.$share_image_data['email'].') has downloaded your DataCuda files',
                    'view' => 'mail_template/download_notification',
                    'data' => $share_link,
                    'project_data' => array('file_count'=>$file_count,'total_size'=>number_format($totla_size/(1024*1024),1),'delete'=>$deleteDate,'medias'=> $project_data['medias'],'client_mail'=>$share_image_data['email'])
                ];

            if (!send_mail_project($mail_details)) {

                return response()->json([
                    'message' => 'Some Think Wrong',
                    'status' => 422
                ]);

            }

        }else{
            return response()->json([
                'message' => 'Status already changend ',
                'status' => 422
            ]);
        }

        
    }


    public function getshareprojectdata(Request $request)
    {
        $link_dencrypt = key_encryption($request->img_id, 'd');
        $key = key_encryption($link_dencrypt, 'd');
        $share_image_data = ShareImage::where('recipient_id', $key)->first();
        if ($share_image_data):
            $st_val = $share_image_data[0]['status'] + 1;
            ShareImage::where('id', $share_image_data['id'])->update(['status' => $st_val]);
            /*$linked_media_ids = DB::table('media_user_projects')->where('user_projects_id',$share_image_data['project_id'])->pluck('media_id');
            $media_data    = Media::whereIn('id',$linked_media_ids)->get();*/
            $project = UserProjects::where('id', $share_image_data['project_id'])->ofStatus(1)->first();
            $project['user']    = DB::table('users')->where('id',$project['user_id'])->first(); 
            $project['company'] = DB::table('company_profile')->where('user_id',$project['user_id'])->first(); 

            $project['share_data']=$share_image_data;
            if (!$project) {
                return response()->json([
                    'message' => 'Something Went Wrong',
                    'status' => 422
                ], 422);
            }
            $project['medias'] = $project->medias()->orderBy('id', 'DESC')->ofStatus(1)->get();
            $path = [];
            if($share_image_data->buy_status == 1)
            {
               $buystatus = 1;
               $path['image'] = 'database/'.$share_image_data->email.'/'.$project->project_path.$project->id.'/original/';
               $path['file'] = 'database/'.$share_image_data->email.'/'.$project->project_path.$project->id.'/file/';
            }
            else{
                $buystatus = 0;
                $path['image'] = 'uploads/';
                $path['file'] = 'uploads/';
            }
            return response()->json(['status' => 200,'message' => 'Success', 'data' => $project,'path'=>$path,'buystatus' => $buystatus]);
        else:
            return response()->json([
                'message' => 'Something Went Wrong',
                'status' => 422
            ], 422);
        endif;
    }



    public function checkprojectpass(Request $request)
    {
        $link_dencrypt = key_encryption($request->rep_id, 'd');
        $key = key_encryption($link_dencrypt, 'd');
        $share_image_data = ShareImage::where('recipient_id',$key)->first();
        if ($share_image_data):
            if (!Hash::check(request('rep_pass'), $share_image_data->project_password)) {
                return response()->json([
                    'message' => 'Wrong password',
                    'status' => 422
                ], 422);
            }
            $st_val = $share_image_data[0]['status'] + 1;
            ShareImage::where('id', $share_image_data['id'])->update(['status' => $st_val]);
            return response()->json(['status' => 200,'message' => 'Success', 'status' => 'Have']);
        else:
            return response()->json([
                'message' => 'Something Went Wrong',
                'status' => 422
            ], 422);
        endif;
    }
    public function downloadsingleimage(Request $request)
    {

        $share_data = ShareImage::where('id', $request->id)->first();
        $medias       = Media::where('id',$share_data->image_id)->where('status', 1)->first();
        if(!empty($medias)):
            $dir_data = [
                'email'      =>  $share_data->email,
                'project_path' => 'singleimages',
            ];
            $d_path = public_path('database/'.$dir_data['email'].'/'.$dir_data['project_path'].'/');
            $file_name    = $d_path.'zip/'.$medias->title.'.zip';
            $download_url = 'database/'.$dir_data['email'].'/'.$dir_data['project_path'].'/zip/'.$medias->title.'.zip';
            $images = '';
            if (in_array($medias->ext, array('jpg', 'png', 'jpeg', 'gif'))) {
                $images = $d_path.'original/'.$medias->filename;
            } else {
                $images = $d_path.'file/'.$medias->filename;
            }
            $is_valid = file_exists($file_name);
            if($is_valid): unlink($file_name); endif;
            $zip = Zip::create($file_name);
            $zip->add($images);
            $zip->close();
            $data = [
                'name' => $medias->title,
                'url'  => $download_url
            ];
            return response()->json(['status' => 200,'message' => 'Success', 'data' => $data]);
        endif;
        return response()->json([
            'message' => 'Something Went Wrong',
            'status' => 422
        ], 422);
    }
    public function downloadproject(Request $request){

        $include="0";
        if($request->id_type == 'e'):
            $project_id = key_encryption($request->id, 'd');
            $project_email = Auth::user()->email;
        endif;
        if($request->id_type == 'share_project'):
            $project_id = $request->id;
            $link_dencrypt = key_encryption($request->rep_id, 'd');
            $key = key_encryption($link_dencrypt, 'd');
            $share_image_data = ShareImage::where('recipient_id',$key)->first();
            $project_email = $share_image_data->email;
            $include = $share_image_data->include_condition;
        endif;


        $project_data = UserProjects::where('id', $project_id)->first();
        $user_id = $project_data->user_id;
        $company_data = DB::table("company_profile")->where("user_id",$user_id)->first();


        $medias       = $project_data->medias()->where('status', 1)->get();
        if(!empty($medias[0])):
            $dir_data = [
                'id'         =>  $project_id,
                'email'      =>  $project_email,
                'project_path' =>  $project_data->project_path,
            ];
            $s_path = storage_path('app/usersdata/'.$dir_data['id'].'/');
            $d_path = public_path('database/'.$dir_data['email'].'/'.$dir_data['project_path'].$dir_data['id'].'/');
            // create_public_dir($dir_data,'share_project');
            $file_name    = $d_path.'zip/'.$project_data->project_name.'.zip';
            $download_url = 'database/'.$dir_data['email'].'/'.$dir_data['project_path'].$dir_data['id'].'/zip/'.$project_data->project_name.'.zip';
            $images = [];
            foreach ($medias as $m_data):
                if (in_array($m_data->ext, array('jpg', 'png', 'jpeg', 'gif'))) {
                    $images[] = $d_path.'original/'.$m_data->filename;
                } else {
                    $images[] = $d_path.'file/'.$m_data->filename;
                }
            endforeach;

            if ($include == "1") {
                
                if ($company_data->company_logo !='') {
                    $images[] = $d_path.'original/'.$company_data->company_logo;
                }
                if ($company_data->other_image !='') {
                    $images[] = $d_path.'original/'.$company_data->other_image;
                }
                 
            }

            $is_valid = file_exists($file_name);
            if($is_valid): unlink($file_name); endif;
            $zip = Zip::create($file_name);
            $zip->add($images);
            $zip->close();
            $data = [
                'name' => $project_data->project_name,
                'url'  => $download_url
            ];
            return response()->json(['status' => 200,'message' => 'Success', 'data' => $data]);
        endif;
        return response()->json([
            'message' => 'Project is empty',
            'status' => 422
        ], 422);
    }
    public function soft_delete_project(Request $request)
    {
        $project_id = key_encryption($request->id, 'd');
        $project_update = UserProjects::where('id', $project_id)->update(['status' => 0]);
        return response()->json(['status' => 200, 'message' => 'Project Deleted', 'success' => 'success']);
    }

    public function hard_delete_project(Request $request)
    {
        $project_id = key_encryption($request->id, 'd');
        $project_data = UserProjects::where('id', $project_id)->first();
        $project_data->delete();
        return response()->json(['status' => 200, 'message' => 'Project Deleted', 'success' => 'success']);
    }

   

    public function make_cover(Request $request) {
        $get_project_id = DB::table('media_user_projects')->where('media_id', $request->image_id)->pluck('user_projects_id')->first();
        $get_medias_ids =  DB::table('media_user_projects')->where('user_projects_id', $get_project_id)->pluck('media_id');
        foreach ($get_medias_ids as $id) {
            Media::where('id', $id)->update(['is_cover' => 0]);
        }
        $project_media = Media::where('id', $request->image_id)->where('status',1)->update(['is_cover' => 1]);
        return response()->json(['status' => 200, 'message' => 'Cover Photo Changed', 'success' => 'success']);

    }

    


}
