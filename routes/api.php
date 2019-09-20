<?php
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/homebannersection', 'API\Dynamic@homeBannerSection');
Route::get('/homesecondsection', 'API\Dynamic@homeSecondSection');
Route::get('/homethirdsection', 'API\Dynamic@homeThirdSection');
Route::get('/homereview', 'API\Dynamic@homeReview');
Route::get('/homeplan', 'API\Dynamic@homePlan');
Route::get('/aboutustop', 'API\Dynamic@aboutusTop');
Route::get('/aboutusbottom', 'API\Dynamic@aboutusBottom');
Route::get('/aboutusright', 'API\Dynamic@aboutusRight');
Route::get('/aboutusleft', 'API\Dynamic@aboutusLeft');


Route::get('/countries', 'API\AuthController@countries');
Route::post('/state', 'API\AuthController@state');

Route::post('/register', 'API\AuthController@register');
Route::post('/new_register', 'Auth\AuthController@new_register');

Route::post('/login', 'API\AuthController@login');
Route::post('/google_login', 'API\AuthController@google_login');


Route::post('/forgetpassword', 'API\AuthController@forget_password');
Route::post('/resetPassword', 'API\AuthController@reset_password');
Route::get('/redirect', 'SocialAuthFacebookController@redirect');
Route::get('/callback', 'SocialAuthFacebookController@callback');
Route::post('/get_share_image_data', 'API\FilesController@getshareimagedata');
Route::get('/search_files','API\FilesController@search_files');
//anchal
Route::get('/get_notice', 'API\NoticealertController@index');
Route::get('/get_notice_by_id/{id}', 'API\NoticealertController@show');
Route::get('/del_notice/{id}', 'API\NoticealertController@delete');
//Route::get('/count_notice', 'API\NoticealertController@countNotice');
//Route::get('/notice_list', 'API\NoticealertController@getListOfNotice');
Route::get('/checkProjectBuy/{id}', 'API\AuthController@CheckIfProjectBuy');
Route::post('/get_share_project_data', 'API\ProjectController@getshareprojectdata');
Route::post('/project_view_notification', 'API\ProjectController@viewNotification');
Route::post('/project_download_notification', 'API\ProjectController@downloadNotification');
Route::post('/project_paid_notification', 'API\ProjectController@paidNotification');



Route::post('/project_pass_check', 'API\ProjectController@checkprojectpass');
Route::post('/share_project_buy', 'API\AuthController@shareprojectbuy');
Route::post('/share_image_buy', 'API\AuthController@shareimagebuy');
Route::post('/download_project', 'API\ProjectController@downloadproject');
Route::post('/download_single_image', 'API\ProjectController@downloadsingleimage');
Route::post('/contact','API\UserController@contact');

Route::middleware('auth:api')->group(function (){
    Route::post('/logout', 'API\AuthController@logout');
    Route::get('/get_user_detail', 'API\UserController@getUserDetail');
    Route::get('/get_payplans_detail', 'API\UserController@getPatplans');
    Route::post('/getplandetails', 'API\UserController@getplandetails');
    Route::post('/store', 'API\UserController@store');
    Route::post('/multiple-files', 'API\FilesController@multiple_file');
    Route::post('/single-file', 'API\UserController@uploadProfilePic');
    Route::post('/company-file-upload/{id}', 'API\UserController@company_file_upload');
    Route::post('/user_profile', 'API\UserController@user_profile');
    Route::post('/company_profile', 'API\UserController@company_profile');
	Route::post('/banking_profile', 'API\UserController@banking_profile');
    Route::post('/paymentWithdraw','API\UserController@paymentWithdraw');
    Route::post('/create_project', 'API\ProjectController@create_project');
    Route::post('/update_project', 'API\ProjectController@update_project');
    Route::get('/get_user_files', 'API\UserController@getuserfiles');
    Route::get('/get_project', 'API\ProjectController@get_project');
    Route::get('/get_user_project', 'API\ProjectController@get_user_project');
    Route::get('/get_buy_project', 'API\ProjectController@getbuyproject');
    Route::post('/Project_Send_By_Mail', 'API\ProjectController@ProjectSendByMail');
    Route::post('/Change_Project_According_Type', 'API\ProjectController@ChangeProjectAccordingType');
    Route::post('/Change_Project_According_Amount', 'API\ProjectController@ChangeProjectAccordingAmount');
    Route::post('/user_download_project', 'API\ProjectController@downloadproject');
    Route::post('/planpay', 'API\AuthController@planpay');
    Route::post('/send_image_link', 'API\FilesController@sendimagelink');
    Route::post('/send_project_link', 'API\ProjectController@sendprojectlink');
    Route::post('/soft_delete_project', 'API\ProjectController@soft_delete_project');
    Route::post('/soft_delete_project', 'API\ProjectController@soft_delete_project');
    Route::post('/soft_delete_file', 'API\FilesController@soft_delete_file');
    Route::post('/imagebuy', 'API\AuthController@image_buy');
    Route::post('/getprojectdata', 'API\ProjectController@get_project_data');
    Route::post('/getbuyprojectdata', 'API\ProjectController@get_buy_project_data');
    Route::get('/search','API\ProjectController@search');
    Route::post('/project-multiple-files', 'API\FilesController@project_multiple_file');
    Route::post('/edit_image_data', 'API\FilesController@editimagedata');
    Route::post('/make_cover', 'API\ProjectController@make_cover');
    Route::get('/get_user_subscription','API\UserController@getUserSubscriptionDetails');
    Route::get('/get_user_project_buy_details','API\UserController@getUserProjectBuyDetails');
    Route::get('/count_notice', 'API\NoticealertController@countNotice');
    Route::get('/notice_list', 'API\NoticealertController@getListOfNotice');
    Route::get('/de_notice', 'API\NoticealertController@delListOfNotice');

    Route::post('/create_storage', 'API\StorageController@create_storage');
    Route::get('/get_user_storage', 'API\StorageController@get_user_storage');
    Route::post('/update_storage', 'API\StorageController@update_storage');
    Route::post('/soft_delete_storage', 'API\StorageController@soft_delete_storage');
    Route::post('/getstoragedata', 'API\StorageController@get_storage_data');
    Route::post('/storage-multiple-files', 'API\FilesController@storage_multiple_file');
    Route::post('/user_download_storage', 'API\StorageController@downloadstorage');
    Route::get('/storage-search','API\StorageController@search');
    Route::post('/current-subscription-plan', 'API\SubscriptionController@getCurrentSubscriptionPlan');
});


Route::namespace('Admin')->group(function ($route) {
    $route->get('subscription-plans', 'PlanController@getActive');
});