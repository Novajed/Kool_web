
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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('user.home');

/*ADMIN ROUTES*/
Route::get('admin','Admin\Auth\LoginController@showLoginForm');
Route::post('admin','Admin\Auth\LoginController@login')->name('admin.login');

Route::get('admin/home', 'Admin\HomeController@index')->name('admin.home');

Route::resource('organizations','Admin\OrganizationController');

/*ORGANIZATION ROUTES*/
Route::get('club','Organization\Auth\LoginController@showLoginForm');
Route::post('club','Organization\Auth\LoginController@login')->name('organization.login');

Route::get('club/home','Organization\HomeController@index')->name('org.home');


/*TEACHER ROUTES*/
Route::get('portal', 'Teacher\Auth\LoginController@showLoginForm');
Route::post('portal','Teacher\Auth\LoginController@login')->name('teacher.login');

Route::get('portal/home','Teacher\HomeController@index')->name('teacher.home');


Route::post('/access-code','AccessCodeController@handle')->middleware(['throttle:10,10'])->name('access-code');

Route::get('/registration/{guard}/{accesscode}', 'AccessCodeController@showRegisterForm')->middleware(['throttle:100,10']);
Route::post('/registration','AccessCodeController@register')->middleware(['throttle:100,10'])->name('accesscode.register');
