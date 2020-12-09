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

Route::get('landing/{lpage}', function($lpage) {
    return 'hello '.$lpage ;
});

Route::get('/', function () {
    return view('welcome');
})->name('landing');

Route::group(['middleware' => 'inactive'], function(){
    Route::get('inactive', function () {
        return 'inactive';
    })->name('inactive');

    Route::get('/payment', function () {
        return view('guest.payment');
    })->name('payment');

});
	
Auth::routes(['register' => false]);

Route::group(['middleware' => ['active']], function () {
    
    Route::get('api/user', 'APIController@user');

    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/home', 'HomeController@index')->name('user.home');

   
    Route::get('/portal/welcome', 'Teacher\HomeController@welcome')->name('teacher.welcome');

    Route::get('/club/welcome', function () {
        return redirect(route('organization.home'));
    })->name('organization.welcome');

    Route::get('/welcome', function () {
        return redirect(route('home'));
    })->name('welcome');

    Route::resource('organizations', 'Admin\OrganizationController');
    Route::resource('users', 'UserController');
    Route::resource('songs', 'SongController');
    Route::resource('playlists', 'PlaylistController')->except(['index']);
    Route::resource('classrooms', 'ClassroomController');

    Route::get('club/home', 'Organization\HomeController@index')->name('organization.home');

    Route::get('portal/home', 'Teacher\HomeController@index')->name('teacher.home');

    Route::get('api/grade/{grade}/subject/{subject}', 'SongController@browse');

    Route::get('api/playlists/{userid}', 'PlaylistController@index');
    Route::get('api/teacher-playlists', 'PlaylistController@getTeacherPlaylists');

    Route::get('api/playlists/{playlist}/songs', 'PlaylistController@showSongs');
    Route::get('api/classrooms/{classroom_id}/playlists', 'ClassroomController@getPlaylists');
    Route::get('api/classrooms/{classroom_id}/students', 'ClassroomController@getStudents');

    Route::get('/playlists/{playlist}/song/{song}', 'PlaylistController@attachSongToPlaylist');
    Route::get('/classrooms/{classroom_id}/playlists/{playlist_id}', 'ClassroomController@attachPlaylist');
    Route::post('/playlists/classroom/{classroom_id}/', 'ClassroomController@createPlaylist');

    Route::get('/api/classrooms', 'ClassroomController@getClassroomsNoParams');
    Route::get('/api/classrooms/available-students', 'ClassroomController@getAvailableStudents');
    Route::post('/api/search', 'SongController@search');

});

Route::get('/process-payment', 'PaymentController@charge')->name('charge');

/*ADMIN ROUTES*/
Route::get('admin', 'Admin\Auth\LoginController@showLoginForm');
Route::post('admin', 'Admin\Auth\LoginController@login')->name('admin.login');
 Route::get('admin/home', 'Admin\HomeController@index')->name('admin.home');
    //After registration routes
    Route::get('/admin/welcome', function () {
        return redirect(route('admin.home'));
    })->name('admin.welcome');


/*ORGANIZATION ROUTES*/
Route::get('club', 'Organization\Auth\LoginController@showLoginForm');
Route::post('club', 'Organization\Auth\LoginController@login')->name('organization.login');

/*TEACHER ROUTES*/
Route::get('portal', 'Teacher\Auth\LoginController@showLoginForm');
Route::post('portal', 'Teacher\Auth\LoginController@login')->name('teacher.login');
/*TEACHER REGISTRATION*/
Route::get('portal/register','Teacher\RegisterController@showRegisterForm');
Route::post('/portal/register', 'Teacher\RegisterController@register')->name('teacher.register');



/*Access Code Routes*/
Route::post('/register/access-code', 'AccessCodeController@AccessCodeRequest')->middleware(['throttle:100,10'])->name('access-code');

Route::get('/registration/{guard}/{accesscode?}', 'AccessCodeController@showRegisterForm')->middleware(['throttle:100,10']);

Route::post('/registration/access-code', 'AccessCodeController@register')->middleware(['throttle:100,10'])->name('accesscode.register');

Route::get('/register', 'Auth\RegisterController@showRegisterForm');
Route::post('/register', 'Auth\RegisterController@register')->name('register');


Route::get('/query', 'SongController@query');

//Route::get('/{any}', 'DefaultController@index')->where('any', '.*');
Route::get('{any}', function($any){
    $guard = new \App\Repository\GuardResolver;
    return redirect($guard->getHomeUrl());
});
