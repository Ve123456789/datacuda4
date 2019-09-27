<?php

namespace App\Http\Controllers\API;

use App\ShareImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\UserProfile;
use App\UserProjects;
use App\UserFiles;
use App\UserStorage;

use Storage;
use Auth;
use Hash;
use DB;
use App\CompanyProfile;
use File;
use Image;
use App\Quotation;
use Validator;
use App\Media;

class FilesController extends Controller
{
    public function multiple_file(Request $request)
    {

        if (!empty($request->file())) {
            $amount = $request->imgamount;
            $path = [
                'id'    => Auth::user()->id,
                'email' => Auth::user()->email,
                'project_path' => 'singleimages',
                'storagepath'  => 'users/',
            ];
            create_public_dir($path,'single_images');
            foreach ($request->file()['file'] as $key => $image) {
                if (in_array($image[0]->getClientOriginalExtension(), array('3dc', '3ds', 'blend', 'dwf', 'fbx', 'kmz',
                        'las', 'lws', 'flt', 'iv', 'osg', 'osgterrain',
                        'ply', 'shp', 'stl', 'txp', 'wrl', 'wrz', 'jpeg',
                        'jfif', 'jpeg 2000', 'exif', 'tiff', 'gif', 'bmp', 'png', 'svg',
                        'pdf', 'psd', 'img', 'ai', 'vml', 'xar', 'eps', 'u3d', 'vrml', 'eps','jpg', 'png', 'jpeg', 'gif')
                )) {
                    $id = helperSaveImage($image[0], $path, $amount);
                } elseif (in_array($image[0]->getClientOriginalExtension(), array('MP4', 'AVI', 'FLV', 'WMV', 'MOV', 'MP4', '3GP', 'Quicktime', 'HDV', 'ts', 'MPEG', 'WAV', 'LXF',
                    'avi', 'flv', 'wmv', 'mov', 'mp4', '3gp', 'quicktime', 'hdv', 'ts', 'mpeg', 'wav', 'lxf', 'mp4'))) {
                    $id = processVideo($image[0], $path, $amount);
                } else {
                    $id = helperSaveFile($image[0], $path, $amount);
                }

                User::find(Auth::user()->id)->medias()->attach($id);
            }
        }
        return response()->json(['status' => 200, 'token' => request('auth_token'), 'message' => 'User file uploaded', 'success' => 'success']);
    }

    public function project_multiple_file(Request $request){   
        if($request->img_360){
            $img_360 = '1';
        }else{
            $img_360 = '0';
            
        }

        $project_id = key_encryption($request->project_id, 'd');
        if(!empty($request->file())) {
            $plan = $request->user()->subscriptions()->latest()->first();
            $plan = $plan? $plan->plan()->first(): null;
            $volume = (int) (new ProjectController)->get_user_project($request)->getData()->project_size_in_byte;
            foreach ($request->file()['file'] as $key => $image) {
                $volume += (int) (current ($image))->getSize();
            }
           
            if ($volume > memoryConverterToBytes ($plan ? $plan->storage_quantity : 0, $plan ? $plan->storage_unit : "mb")) {
                return response()->json(['code' => 102, 'token' => request('auth_token'), 'message' => 'Unsufficient Memory. Please upgrade your plan.', 'error' => 'failed']);
            }

            $amount = $request->imgamount;
            $project_data = UserProjects::where('id', $project_id)->first();
            $path  = [
                'id'         =>  $project_id,
                'email'      =>  Auth::user()->email,
                'project_path' =>  $project_data->project_path.$project_data->id,
                'storagepath'  => 'usersdata/',
            ];
            foreach ($request->file()['file'] as $key => $image) {
                if (in_array($image[0]->getClientOriginalExtension(), array('jpg', 'png', 'jpeg', 'gif'))) {
                    $id = helperSaveImage($image[0], $path, $amount,$img_360);
                }elseif (in_array($image[0]->getClientOriginalExtension(), array('MP4', 'AVI', 'FLV', 'WMV', 'MOV', 'MP4', '3GP', 'Quicktime', 'HDV', 'ts', 'MPEG', 'WAV', 'LXF',
                    'avi', 'flv', 'wmv', 'mov', 'mp4', '3gp', 'quicktime', 'hdv', 'ts', 'mpeg', 'wav', 'lxf', 'mp4'))) {
                    $id = processVideo($image[0], $path, $amount);
                }else {
                    $id = helperSaveFile($image[0], $path, $amount);
                }
                UserProjects::find($project_id)->medias()->attach($id);
            }
        }
        return response()->json(['status' => 200, 'token' => request('auth_token'), 'message' => 'project file uploaded', 'success' => 'success']);
    }


    public function storage_multiple_file(Request $request)
    {   
        if($request->img_360){
            $img_360 = '1';
        }else{
            $img_360 = '0';
            
        }

        $storage_id = key_encryption($request->storage_id, 'd');
        if(!empty($request->file())) {
            $amount = $request->imgamount;
            $storage_data = UserStorage::where('id', $storage_id)->first();
            $path  = [
                'id'         =>  $storage_id,
                'email'      =>  Auth::user()->email,
                'project_path' =>  'UserStorage/'.$storage_data->storage_path.$storage_data->id,
                'storagepath'  => 'UserStorage/',
            ];
            foreach ($request->file()['file'] as $key => $image) {
                if (in_array($image[0]->getClientOriginalExtension(), array('jpg', 'png', 'jpeg', 'gif'))) {
                    $id = helperSaveImage($image[0], $path, $amount,$img_360);
                }elseif (in_array($image[0]->getClientOriginalExtension(), array('MP4', 'AVI', 'FLV', 'WMV', 'MOV', 'MP4', '3GP', 'Quicktime', 'HDV', 'ts', 'MPEG', 'WAV', 'LXF',
                    'avi', 'flv', 'wmv', 'mov', 'mp4', '3gp', 'quicktime', 'hdv', 'ts', 'mpeg', 'wav', 'lxf', 'mp4'))) {
                    $id = processVideo($image[0], $path, $amount);
                }else {
                    $id = helperSaveFile($image[0], $path, $amount);
                }
                UserStorage::find($storage_id)->medias()->attach($id);
            }
        }
        return response()->json(['status' => 200, 'token' => request('auth_token'), 'message' => 'Storage file uploaded', 'success' => 'success']);
    }

    

    public function store(Request $request)
    {
        // validate data coming from front end.
        dd($request->file());
        $id = Auth::user()->id;

        $data = $request->file()['file'];
        $validator = Validator::make($request->all(), [
            'file' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors(), 'status' => '401'], 401);
        }
        if (!empty($data)) {
            $file_name = $data->getClientOriginalName();
            $ext = pathinfo($file_name, PATHINFO_EXTENSION);
            $ext = strtolower($ext);
            $file_name = $id . '.' . $ext;
            $file_folder = 'public/';

            Storage::put(
                $file_folder . $file_name,
                file_get_contents($data->getRealPath())
            );
            $user = User::find($id);
            if ($user) {
                $user->picture = $file_name;
                $user->save();
            }
            return response()->json(['status' => 200, 'token' => request('auth_token'), 'message' => 'User profile picture updated', 'file_name' => $file_name]);

        } else {
            return response()->json(['status' => 300, 'token' => request('auth_token'), 'message' => 'User profile updated']);
        }
    }

    public function uploadProfilePic(Request $request)
    {
        // validate data coming from front end.
        $id = Auth::user()->id;
        $data = $request->file()['file'];
        $validator = Validator::make($request->all(), [
            'file' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors(), 'status' => '401'], 401);
        }
        if (!empty($data)) {
            $file_name = $data->getClientOriginalName();
            $ext = pathinfo($file_name, PATHINFO_EXTENSION);
            $ext = strtolower($ext);
            $file_name = $id . '.' . $ext;

            $file_folder = 'public/';

            Storage::put(
                $file_folder . $file_name,
                file_get_contents($data->getRealPath())
            );
            $user = User::find($id);
            if ($user) {
                $user->picture = $file_name;
                $user->save();
            }
            return response()->json(['status' => 200, 'token' => request('auth_token'), 'message' => 'User profile picture updated', 'file_name' => $file_name]);

        } else {
            return response()->json(['status' => 300, 'token' => request('auth_token'), 'message' => 'User profile updated']);
        }

    }

    public function sendimagelink(Request $request)
    {
        $media_data = Media::where('id', $request->id)->first();
        if (!$media_data) {
            return response()->json([
                'message' => 'Some Think Wrong',
                'status' => 422
            ], 422);
        }
        $media = Media::where('id', $request->id)->get();
        $id = Auth::user()->id;
        $key = random(10);
        $sm_model = new ShareImage();
        $sm_model->user_id = $id;
        $sm_model->image_id = $media_data->id;
        $sm_model->email = $request->email;
        $sm_model->project_password = bcrypt($request->pass);
        $sm_model->recipient_id = $key;
        $sm_model->buy_amount = $media_data->amount;
        if ($sm_model->save()) {
            $link_encrypt = key_encryption($key);
            $link_encrypt2 = key_encryption($link_encrypt);
            $share_link = url('/') . '/#/shareimage/' . $link_encrypt2;
            $mail_details = [
                'email_id' => $request->email,
                'from_id' => 'info@datatcuda.com',
                'subject' => 'Share Image Link',
                'view' => 'mail_template/share_image_mail',
                'data' => $share_link,
                'project_data' => array('file_count'=>1,'medias'=> $media)
            ];
            if (!send_mail_project($mail_details)) {
                return response()->json([
                    'message' => 'Some Think Wrong',
                    'status' => 422
                ], 422);

            }
        } else {
            return response()->json([
                'message' => 'Some Think Wrong',
                'status' => 422
            ], 422);
        }
        return response()->json(['status' => 201, 'token' => request('auth_token'), 'message' => 'Share Image Link Send Mail Id Successfully!']);
    }

    public function getshareimagedata(Request $request)
    {
        $link_dencrypt = key_encryption($request->img_id, 'd');
        $key = key_encryption($link_dencrypt, 'd');
        $share_image_data = ShareImage::where('recipient_id', $key)->first();
        if ($share_image_data):
            $st_val = $share_image_data->status + 1;
            ShareImage::where('id', $share_image_data['id'])->update(['status' => $st_val]);
            $media_data = Media::where('id', $share_image_data['image_id'])->first();
            if (!$media_data) {
                return response()->json([
                    'message' => 'Some Think Wrong',
                    'status' => 422
                ], 422);
            }
            $data = [
                'media' => $media_data,
                'share' => $share_image_data
            ];
            $path = [];
            if($share_image_data->buy_status == 1)
            {
                $buystatus = 1;
                $path['image'] = 'database/'.$share_image_data->email.'/singleimages/original/';
                $path['file'] = 'database/'.$share_image_data->email.'/singleimages/file/';
            }
            else{
                $buystatus = 0;
                $path['image'] = 'uploads/';
                $path['file'] = 'uploads/';
            }
            return response()->json(['status' => 200,'message' => 'Success', 'data' => $data,'path'=>$path,'buystatus' => $buystatus]);
        else:
            return response()->json([
                'message' => 'Some Think Wrong',
                'status' => 422
            ], 422);
        endif;

    }

    public function editimagedata(Request $request)
    {
        $media = Media::where('id', $request->id)->update([$request->field => $request->value]);

        $get_project_id = DB::table('media_user_projects')->where('media_id', $request->id)->pluck('user_projects_id')->first();
        $get_medias_ids =  DB::table('media_user_projects')->where('user_projects_id', $get_project_id)->pluck('media_id');
        $total_amount = 0;
       
        foreach ($get_medias_ids as $id) {
            $amount = Media::select('amount')->where('id', $id)->where("status","1")->first();
            if(isset($amount->amount))
            $total_amount = $total_amount + $amount->amount;
        }
 
        UserProjects::where('id', $get_project_id)->update(['project_price' => $total_amount]);

        if (!$media):
            return response()->json([
                'message' => 'Some Thing Went Wrong',
                'status' => 422
            ], 422);
        endif;
        return response()->json(['status' => 201, 'token' => request('auth_token'), 'message' => 'Image Update Successfully!']);
    }



    public function soft_delete_file(Request $request)
    {
        $file_id = $request->id;
        $media_data = Media::where('id', $file_id)->update(['status' => 0]);
        return response()->json(['status' => 200, 'message' => 'File Deleted', 'success' => 'success']);
    }

    public function hard_delete_file(Request $request)
    {
        $project_id = key_encryption($request->project_id, 'd');
        $project_data = UserProjects::where('id', $project_id)->first();
        $project_data->delete();
        if (in_array($project_data->ext, array('jpg', 'png', 'jpeg', 'gif'))) {
            File::delete('storage/user_medium/' . $project_data->filename);
            File::delete('storage/user_thumb/' . $project_data->filename);
            File::delete('storage/user_watermarked/' . $project_data->filename);
            File::delete('storage/user_original/' . $project_data->filename);
        } else {
            File::delete('storage/user_files/' . $project_data->filename);
        }
        return response()->json(['status' => 200, 'message' => 'Project Deleted', 'success' => 'success']);
    }

    public function search_files(Request $request)
    {
        $error = ['error' => 'No results found, please try with different keywords.'];
        if ($request->has('keywords')) {
            // Using the Laravel Scout syntax to search the products table.
            $id = key_encryption($request->get('id'), 'd');
            $project = UserProjects::where('id', $id)->first();
            $project['medias'] = $project->medias()->where('status', 1)->where('filename', 'like', '%' . $request->get('keywords') . '%')->orderBy('id', 'DESC')->get();
            if (!$project->id) {
                return response()->json([
                    'message' => 'Some Think Wrong',
                    'status' => 422
                ], 422);
            }
            return response()->json($project['medias']);

        }
        return $error;
    }
}
