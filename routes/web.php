<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function () {
    return view('home');
});
Route::get('/reset-password-confirm/{id}','Auth\ForgotPasswordController@reset_password');
Route::get('/signup-verification/{id}','Auth\ForgotPasswordController@signup_verification');
Route::get('/redirect', 'SocialAuthFacebookController@redirect');
Route::get('/callback', 'SocialAuthFacebookController@callback');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

/*Route::get('/{a}',             function () {  return redirect('/'); });
Route::get('/{a}/{b}',         function () {  return redirect('/'); });
Route::get('/{a}/{b}/{c}',     function () {  return redirect('/'); });
Route::get('/{a}/{b}/{c}/{d}', function () {  return redirect('/'); });*/


//Admin Route 
Route::get('/admin','Admin\Login@index');
Route::post('/admin','Admin\Login@login');
Route::get('admin/logout','Admin\Logout@index');
Route::get('admin/dashboard','Admin\Dashboard@index');
Route::get('admin/changepassword','Admin\Changepassword@index');
Route::post('admin/changepassword','Admin\Changepassword@changepassword');

//User List
Route::get('admin/user','Admin\User@index'); 
Route::post('admin/user','Admin\User@index'); 
Route::get('admin/user/edit/{id}','Admin\User@edit'); 
Route::post('admin/user/edit/{id}','Admin\User@edit'); 
Route::get('admin/user/delete/{id}','Admin\User@del'); 
Route::get('admin/user/status/{val}/{id}','Admin\User@status'); 

//User List
Route::get('admin/finance/{id}','Admin\Finance@index'); 
Route::post('admin/finance/{id}','Admin\Finance@ndex'); 

//Homepage Banner
Route::get('admin/homebanner','Admin\Homebanner@index'); 
Route::post('admin/homebanner','Admin\Homebanner@index'); 
Route::post('admin/homebanner/add','Admin\Homebanner@add'); 
Route::get('admin/homebanner/add','Admin\Homebanner@add'); 
Route::get('admin/homebanner/edit/{id}','Admin\Homebanner@edit'); 
Route::post('admin/homebanner/edit/{id}','Admin\Homebanner@edit'); 
Route::get('admin/homebanner/status/{val}/{id}','Admin\Homebanner@status'); 
Route::get('admin/homebanner/adminstatus/{val}/{id}','Admin\Homebanner@Adminstatus'); 
Route::get('admin/homebanner/delete/{id}','Admin\Homebanner@del');
Route::get('admin/homebanner/view/{id}','Admin\Homebanner@view');

//Homepage Second Section
Route::get('admin/homesecond','Admin\HomeSecond@index'); 
Route::post('admin/homesecond','Admin\HomeSecond@index'); 
Route::post('admin/homesecond/add','Admin\HomeSecond@add'); 
Route::get('admin/homesecond/add','Admin\HomeSecond@add'); 
Route::get('admin/homesecond/edit/{id}','Admin\HomeSecond@edit'); 
Route::post('admin/homesecond/edit/{id}','Admin\HomeSecond@edit'); 
Route::get('admin/homesecond/status/{val}/{id}','Admin\HomeSecond@status'); 
Route::get('admin/homesecond/adminstatus/{val}/{id}','Admin\HomeSecond@Adminstatus'); 
Route::get('admin/homesecond/delete/{id}','Admin\HomeSecond@del');
Route::get('admin/homesecond/view/{id}','Admin\HomeSecond@view');

//Homepage Third Section
Route::get('admin/homethird','Admin\HomeThird@index'); 
Route::post('admin/homethird','Admin\HomeThird@index'); 
Route::post('admin/homethird/add','Admin\HomeThird@add'); 
Route::get('admin/homethird/add','Admin\HomeThird@add'); 
Route::get('admin/homethird/edit/{id}','Admin\HomeThird@edit'); 
Route::post('admin/homethird/edit/{id}','Admin\HomeThird@edit'); 
Route::get('admin/homethird/status/{val}/{id}','Admin\HomeThird@status'); 
Route::get('admin/homethird/adminstatus/{val}/{id}','Admin\HomeThird@Adminstatus'); 
Route::get('admin/homethird/delete/{id}','Admin\HomeThird@del');
Route::get('admin/homethird/view/{id}','Admin\HomeThird@view');

//Homepage Reviews Section
Route::get('admin/homereviews','Admin\HomeReviews@index'); 
Route::post('admin/homereviews','Admin\HomeReviews@index'); 
Route::post('admin/homereviews/add','Admin\HomeReviews@add'); 
Route::get('admin/homereviews/add','Admin\HomeReviews@add'); 
Route::get('admin/homereviews/edit/{id}','Admin\HomeReviews@edit'); 
Route::post('admin/homereviews/edit/{id}','Admin\HomeReviews@edit'); 
Route::get('admin/homereviews/status/{val}/{id}','Admin\HomeReviews@status'); 
Route::get('admin/homereviews/adminstatus/{val}/{id}','Admin\HomeReviews@Adminstatus'); 
Route::get('admin/homereviews/delete/{id}','Admin\HomeReviews@del');
Route::get('admin/homereviews/view/{id}','Admin\HomeReviews@view');

//Homepage Plans Section
Route::get('admin/homeplans','Admin\HomePlans@index'); 
Route::post('admin/homeplans','Admin\HomePlans@index'); 
Route::post('admin/homeplans/add','Admin\HomePlans@add'); 
Route::get('admin/homeplans/add','Admin\HomePlans@add'); 
Route::get('admin/homeplans/edit/{id}','Admin\HomePlans@edit'); 
Route::post('admin/homeplans/edit/{id}','Admin\HomePlans@edit'); 
Route::get('admin/homeplans/status/{val}/{id}','Admin\HomePlans@status'); 
Route::get('admin/homeplans/adminstatus/{val}/{id}','Admin\HomePlans@Adminstatus'); 
Route::get('admin/homeplans/delete/{id}','Admin\HomePlans@del');
Route::get('admin/homeplans/view/{id}','Admin\HomePlans@view');



//Homepage Second Section
Route::get('admin/aboutus','Admin\AboutUs@index'); 
Route::post('admin/aboutus','Admin\AboutUs@index'); 
Route::post('admin/aboutus/add','Admin\AboutUs@add'); 
Route::get('admin/aboutus/add','Admin\AboutUs@add'); 
Route::get('admin/aboutus/edit/{id}','Admin\AboutUs@edit'); 
Route::post('admin/aboutus/edit/{id}','Admin\AboutUs@edit'); 
Route::get('admin/aboutus/status/{val}/{id}','Admin\AboutUs@status'); 
Route::get('admin/aboutus/adminstatus/{val}/{id}','Admin\AboutUs@Adminstatus'); 
Route::get('admin/aboutus/delete/{id}','Admin\AboutUs@del');
Route::get('admin/aboutus/view/{id}','Admin\AboutUs@view');

//Admin Contact Us Section
Route::get('admin/contact_us','Admin\AdminContactUs@index'); 
Route::post('admin/contact_us','Admin\AdminContactUs@index'); 

Route::namespace('Admin')->prefix('admin/subscription-plans')->group(function ($route) {
    $route->get('/', 'PlanController@index')->name('subscriptionPlanList');
    $route->post('/', 'PlanController@store')->name('subscriptionPlanStore');
    $route->get('/create', 'PlanController@create')->name('subscriptionPlanCreate');
    $route->get('/{planId}', 'PlanController@view')->name('subscriptionPlanView');
    $route->put('/{planId}', 'PlanController@update')->name('subscriptionPlanUpdate');
});