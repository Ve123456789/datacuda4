<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\UserProfile;
use App\UserStorage;
use Storage;
use Auth;
use Hash;
use DB;
use Validator;
use App\Media;
use ZanySoft\Zip\Zip;
use ZipArchive;
use File;

class StorageController extends Controller{
    
    /*
        function name : create_storage
        functionality : create storage for user
    */
    public function create_storage(Request $request){
        $user_id = Auth::user()->id;
        $validator = Validator::make($request->all(), [
            'storage_name' => 'required|unique:user_storage,storage_name,NULL,id,user_id,'.$user_id.',status,1'
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors(), 'status' => '401']);
        }
        //Save data into the table
        $storage_path = rand_string(8);
        $data_saved = UserStorage::create([
            'user_id' => Auth::user()->id,
            'storage_name' => request('storage_name'),
            'storage_logo' => request('storage_name'),
            'storage_price' => 0,
            'storage_slug' => request('storage_name'),
            'storage_path' => $storage_path,
            'created_at' => date('d-m-y h:i:s')
        ]);
        $storage_id = key_encryption($data_saved->id);
        $dir_data = [
            'id'         =>  $data_saved->id,
            'email'      =>  Auth::user()->email,
            'project_path' =>  $data_saved->storage_path,
        ];
        create_public_dir($dir_data,'us');
        return response()->json(['status' => 201, 'message' => 'Storage created successfully', 'storage_id' => $storage_id]);
    }


    /*
        function name : update_storage
        functionality : update storage for user
    */
    public function update_storage(Request $request){

        $validator = Validator::make($request->all(), [
            'id'           => 'required',
            'storage_name' => 'required|unique:user_storage,storage_name'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors(), 'status' => '401']);
        }

        $storage_id = key_encryption(request('id'),'d');

        $data_saved = UserStorage::where("id",$storage_id)->update([
            'storage_name' => request('storage_name'),
            'storage_logo' => request('storage_name')
        ]);
       
        return response()->json(['status' => 201, 'message' => 'Storage Updated successfully','storage_id' =>request('id')]);
    }



    public function get_storage($user_id = null)
    {
        $UserStorage = UserStorage::get();
        return response()->json(['status' => 201, 'message' => 'Storage created successfully', 'UserStorage' => $UserStorage]);
    }



    public function get_user_storage(Request $request){

        $UserStorage = UserStorage::where('user_id', Auth::user()->id)->where('status', 1)->orderBy($request->get('order_by'), 'DESC')->get();
        $StorageData = [];
       
        foreach ($UserStorage as $data):
            $media_ids  = DB::table('media_user_storage')->where('user_storage_id', $data->id)->get();
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
            $image_path = 'database/'.Auth::user()->email.'/UserStorage/'.$data->storage_path.$data->id.'/';
            if ($media && ($media->ext == 'jpg' || $media->ext == 'png' || $media->ext == 'jpeg')):
                $StorageData[] = [
                    'id' => key_encryption($data->id),
                    'name' => $data->storage_name,
                    'date' => date("m/d/Y",strtotime($data->created_at)),
                    'logo' => $media->filename,
                    'real_id' => $data->id,
                    'image_path' => $image_path,
                    'total_vid'=>$total_vid,
                    'total_img'=>$total_img,
                ];
            else:
                $StorageData[] = [
                    'id' => key_encryption($data->id),
                    'name' => $data->storage_name,
                    'date' => date("m/d/Y",strtotime($data->created_at)),
                    'real_id' => $data->id,
                    'image_path' => $image_path,
                    'total_vid'=>$total_vid,
                    'total_img'=>$total_img,
                ];
            endif;
        endforeach; 
        return response()->json(['status' => 201, 'message' => 'Storage created successfully', 'UserStorage' => $StorageData]);
    }



    public function search(Request $request){
        $error = ['error' => 'No results found, please try with different keywords.'];
        if ($request->has('keywords')) {
            $UserStorage = UserStorage::where('user_id', Auth::user()->id)->where('storage_name', 'like', '%' . $request->get('keywords') . '%')->where('status', 1)->get();
            $StorageData = [];

            foreach ($UserStorage as $data):
                $media_ids  = DB::table('media_user_storage')->where('user_storage_id', $data->id)->get();
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
                $image_path = 'database/'.Auth::user()->email.'/UserStorage/'.$data->storage_path.$data->id.'/';
                if ($media && ($media->ext == 'jpg' || $media->ext == 'png')):
                    $StorageData[] = [
                        'id' => key_encryption($data->id),
                        'name' => $data->storage_name,
                        'logo' => $media->filename,
                        'real_id' => $data->id,
                        'image_path' => $image_path,
                        'total_vid'=>$total_vid,
                        'total_img'=>$total_img,
                    ];
                else:
                    $StorageData[] = [
                        'id' => key_encryption($data->id),
                        'name' => $data->storage_name,
                        'real_id' => $data->id,
                        'image_path' => $image_path,
                        'total_vid'=>$total_vid,
                        'total_img'=>$total_img,
                    ];
                endif;
            endforeach;
            return response()->json(['status' => 201, 'message' => 'Success', 'UserStorage' => $StorageData]);
        }
        return $error;
    }


    public function get_storage_data(Request $request){
        $id = key_encryption($request->pro_id, 'd');
        $storage = UserStorage::where('user_id', Auth::user()->id)->where('id', $id)->first();
        $storage['storage_date'] =  date("m/d/Y h:i:a",strtotime($storage->created_at));
        $storage['medias'] = $storage->medias()->where('status', 1)->orderBy($request->order_by, 'DESC')->get();
        $storage['image_path'] = 'database/'.Auth::user()->email.'/UserStorage/'.$storage->storage_path.$storage->id.'/';
        $size_data = 0;
        $size = array();
        if(!empty($storage['medias'])) {
            foreach ($storage['medias'] as $media_data):
                $test_data = $size_data;
                $size_data = $test_data + $media_data->size;
            endforeach;

            if (!$storage->id) {
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
        return response()->json(['status' => 200, 'token' => request('auth_token'), 'message' => 'Success', 'storage_medias' => $storage['medias']
                ,'storage_data'=>$storage,'path'=>$storage['image_path'],'storage_size' => $size]
            );
    }


    public function sendstoragelink(Request $request)
    {
        $storage_data = UserStorage::where('id', $request->id)->first();
        if (!$storage_data) {
            return response()->json([
                'message' => 'Something Went Wrong',
                'status' => 422
            ], 422);
        }
        $storage_data['medias'] = $storage_data->medias()->orderBy('id', 'DESC')->ofStatus(1)->get();
        $totla_size = 0;
        foreach ($storage_data['medias'] as $value) {
            $totla_size += $value['size'];
        }
        $deleteDate = date("F d, Y", strtotime("+1 month", strtotime(date('Y-m-d'))));

        $file_count = count($storage_data['medias']);
        $id = Auth::user()->id;
        $key = random(10);
        $sm_model = new ShareImage();
        $sm_model->user_id = $id;
        $sm_model->image_id = $storage_data->id;
        $sm_model->storage_id = $storage_data->id;
        $sm_model->recipient_id = $key;
        $sm_model->email = $request->email;
        $sm_model->storage_password = bcrypt($request->storage_password);
        $sm_model->buy_amount = $storage_data->storage_price;
        
        if ($sm_model->save()) {
            $link_encrypt = key_encryption($key);
            $link_encrypt2 = key_encryption($link_encrypt);
            $share_link = url('/') . '/#/sharestorage/' . $link_encrypt2;
            $mail_details = [
                'email_id' => $request->email,
                'from_id' => 'info@datatcuda.com',
                'subject' => 'Share Project Link',
                'view' => 'mail_template/share_files_mail',
                'data' => $share_link,
                'storage_data' => array('file_count'=>$file_count,'total_size'=>number_format($totla_size/(1024*1024),1),'delete'=>$deleteDate,'medias'=> $storage_data['medias'])
            ];
            if (!send_mail_storage($mail_details)) {
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
        $storage_data = UserStorage::where('id', $request->id)->first();
        if (!$storage_data) {
            return response()->json([
                'message' => 'Something Went Wrong',
                'status' => 422
            ], 422);
        }
        $storage_data['medias'] = $storage_data->medias()->orderBy('id', 'DESC')->ofStatus(1)->get();
        $file_count = count($storage_data['medias']);
        $totla_size = 0;
        foreach ($storage_data['medias'] as $value) {
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
        $sm_model->image_id = $storage_data['id'];
        $sm_model->storage_id = $storage_data['id'];
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
        $sm_model->storage_password = bcrypt($request->set_password);
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
                $share_link = url('/') . '/#/sharestorage/' . $link_encrypt2;
                $mail_details = [
                    'email_id' => $request->email,
                    'from_id' => 'info@datatcuda.com',
                    'subject' => 'You received files',
                    'view' => 'mail_template/share_files_mail',
                    'data' => $share_link,
                    'storage_data' => array('file_count'=>$file_count,'total_size'=>number_format($totla_size/(1024*1024),1),'delete'=>$deleteDate,'medias'=> $storage_data['medias'],'company_data'=>$company_data)
                ];
                if($request->collect_payment == 1):
                $dir_data = [
                    'id'           =>  $storage_data->id,
                    'email'        =>  $request->email,
                    'storage_path' =>  $storage_data->storage_path,
                ];
                create_public_dir($dir_data,'r');
                create_public_dir($dir_data,'share_storage');

                $s_path = storage_path('app/usersdata/'.$dir_data['id'].'/');
                $d_path = public_path('database/'.$dir_data['email'].'/'.$dir_data['storage_path'].$dir_data['id'].'/');

                foreach ($storage_data['medias'] as $m_data):
                    if (in_array($m_data->ext, array('jpg', 'png', 'jpeg', 'gif'))) {
                        \File::copy($s_path.$m_data->filename,$d_path.'original/'.$m_data->filename);
                    } else {
                        \File::copy($s_path.$m_data->filename,$d_path.'file/'.$m_data->filename);
                    }
                endforeach;
                endif;
                if (!send_mail_storage($mail_details)):

                    return response()->json([
                        'message' => 'Something Went Wrong',
                        'status' => 422
                    ], 422);

                endif;

            elseif ($request->send_as == 'email'):
                if($request->collect_payment == 1):
                    $dir_data = [
                        'id'           =>  $storage_data->id,
                        'email'        =>  $request->email,
                        'storage_path' =>  $storage_data->storage_path,
                    ];
                    create_public_dir($dir_data,'r');
                    create_public_dir($dir_data,'share_storage');
                    $s_path = storage_path('app/usersdata/'.$dir_data['id'].'/');
                    $d_path = public_path('database/'.$dir_data['email'].'/'.$dir_data['storage_path'].$dir_data['id'].'/');
                    foreach ($storage_data['medias'] as $m_data):
                        if (in_array($m_data->ext, array('jpg', 'png', 'jpeg', 'gif'))) {
                            \File::copy($s_path.$m_data->filename,$d_path.'original/'.$m_data->filename);
                        } else {
                            \File::copy($s_path.$m_data->filename,$d_path.'file/'.$m_data->filename);
                        }
                    endforeach;
                    $file_name    = $d_path.'zip/'.$storage_data->storage_name.'.zip';
                    $images = [];
                    foreach ($storage_data['medias'] as $m_data):
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
                    $file_name    = $d_path.$storage_data->storage_name.'.zip';
                    $images = [];
                    foreach ($storage_data['medias'] as $m_data):
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
                    'storage_data' => array('file_count'=>$file_count,'total_size'=>number_format($totla_size/(1024*1024),1),'delete'=>$deleteDate,'medias'=> $storage_data['medias'])
                ];
                if (!send_mail_storage_attach($mail_details)):

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

    public function getsharestoragedata(Request $request)
    {
        $link_dencrypt = key_encryption($request->img_id, 'd');
        $key = key_encryption($link_dencrypt, 'd');
        $share_image_data = ShareImage::where('recipient_id', $key)->first();
        if ($share_image_data):
            $st_val = $share_image_data[0]['status'] + 1;
            ShareImage::where('id', $share_image_data['id'])->update(['status' => $st_val]);
            /*$linked_media_ids = DB::table('media_user_storage')->where('user_storage_id',$share_image_data['storage_id'])->pluck('media_id');
            $media_data    = Media::whereIn('id',$linked_media_ids)->get();*/
            $storage = UserStorage::where('id', $share_image_data['storage_id'])->ofStatus(1)->first();
            $storage['user']    = DB::table('users')->where('id',$storage['user_id'])->first(); 
            $storage['company'] = DB::table('company_profile')->where('user_id',$storage['user_id'])->first(); 

            $storage['share_data']=$share_image_data;
            if (!$storage) {
                return response()->json([
                    'message' => 'Something Went Wrong',
                    'status' => 422
                ], 422);
            }
            $storage['medias'] = $storage->medias()->orderBy('id', 'DESC')->ofStatus(1)->get();
            $path = [];
            if($share_image_data->buy_status == 1)
            {
               $buystatus = 1;
               $path['image'] = 'database/'.$share_image_data->email.'/'.$storage->storage_path.$storage->id.'/original/';
               $path['file'] = 'database/'.$share_image_data->email.'/'.$storage->storage_path.$storage->id.'/file/';
            }
            else{
                $buystatus = 0;
                $path['image'] = 'uploads/';
                $path['file'] = 'uploads/';
            }
            return response()->json(['status' => 200,'message' => 'Success', 'data' => $storage,'path'=>$path,'buystatus' => $buystatus]);
        else:
            return response()->json([
                'message' => 'Something Went Wrong',
                'status' => 422
            ], 422);
        endif;
    }



    public function checkstoragepass(Request $request)
    {
        $link_dencrypt = key_encryption($request->rep_id, 'd');
        $key = key_encryption($link_dencrypt, 'd');
        $share_image_data = ShareImage::where('recipient_id',$key)->first();
        if ($share_image_data):
            if (!Hash::check(request('rep_pass'), $share_image_data->storage_password)) {
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
                'storage_path' => 'singleimages',
            ];
            $d_path = public_path('database/'.$dir_data['email'].'/'.$dir_data['storage_path'].'/');
            $file_name    = $d_path.'zip/'.$medias->title.'.zip';
            $download_url = 'database/'.$dir_data['email'].'/'.$dir_data['storage_path'].'/zip/'.$medias->title.'.zip';
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

    public function downloadstorage(Request $request){
        $include="0";
        if($request->id_type == 'e'):
            $storage_id = key_encryption($request->id, 'd');
            $storage_email = Auth::user()->email;
        endif;
        if($request->id_type == 'share_storage'):
            $storage_id = $request->id;
            $link_dencrypt = key_encryption($request->rep_id, 'd');
            $key = key_encryption($link_dencrypt, 'd');
            $share_image_data = ShareImage::where('recipient_id',$key)->first();
            $storage_email = $share_image_data->email;
            $include = $share_image_data->include_condition;
        endif;


        $storage_data = UserStorage::where('id', $storage_id)->first();
        $user_id = $storage_data->user_id;
        $company_data = DB::table("company_profile")->where("user_id",$user_id)->first();


        $medias = $storage_data->medias()->where('status', 1)->get();
        if(!empty($medias[0])):
            $dir_data = [
                'id'         =>  $storage_id,
                'email'      =>  $storage_email,
                'project_path' => $storage_data->storage_path,
            ];
            $s_path = storage_path('app/UserStorage/'.$dir_data['id'].'/');
            $d_path = public_path('database/'.$dir_data['email'].'/UserStorage/'.$dir_data['project_path'].$dir_data['id'].'/');
            // create_public_dir($dir_data,'share_storage');
            $file_name    = $d_path.'zip/'.$storage_data->storage_name.'.zip';
            $download_url = 'database/'.$dir_data['email'].'/UserStorage/'.$dir_data['project_path'].$dir_data['id'].'/zip/'.$storage_data->storage_name.'.zip';
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
                'name' => $storage_data->storage_name,
                'url'  => $download_url
            ];
            return response()->json(['status' => 200,'message' => 'Success', 'data' => $data]);
        endif;
        return response()->json([
            'message' => 'Project is empty',
            'status' => 422
        ], 422);
    }
    public function soft_delete_storage(Request $request)
    {
        $storage_id = key_encryption($request->id, 'd');
        $storage_update = UserStorage::where('id', $storage_id)->update(['status' => 0]);
        return response()->json(['status' => 200, 'message' => 'Storage Deleted', 'success' => 'success']);
    }

    public function hard_delete_storage(Request $request)
    {
        $storage_id = key_encryption($request->id, 'd');
        $storage_data = UserStorage::where('id', $storage_id)->first();
        $storage_data->delete();
        return response()->json(['status' => 200, 'message' => 'Storage Deleted', 'success' => 'success']);
    }

    public function make_cover(Request $request) {
        $get_storage_id = DB::table('media_user_storage')->where('media_id', $request->image_id)->pluck('user_storage_id')->first();
        $get_medias_ids =  DB::table('media_user_storage')->where('user_storage_id', $get_storage_id)->pluck('media_id');
        foreach ($get_medias_ids as $id) {
            Media::where('id', $id)->update(['is_cover' => 0]);
        }
        $storage_media = Media::where('id', $request->image_id)->where('status',1)->update(['is_cover' => 1]);
        return response()->json(['status' => 200, 'message' => 'Cover Photo Changed', 'success' => 'success']);

    }

}
