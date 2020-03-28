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


Route::get('/register', 'AppController@showFarmRegisterForm')->name('register');
Route::post('/register', 'AppController@farmRegister')->name('farm.post.register');

/** Route for credentials */
Route::get('/credentials/create/{id}','AppController@createCredentials')->name('farm.credential.create');
Route::post('/admin/register','Auth\FarmManagerRegisterController@register')->name('farm.post.credential.create');
Route::get('/credentials/verify/{id}','AppController@verifyCredentialSent')->name('farm.credential.verfy');
Route::get('/credentials/resend/', 'AppController@resendCredentialLink')->name('farm.credential.resend');

/** Route for farm manager login */
Route::get('/login', 'Auth\FarmManagerLoginController@showLoginForm')->name('login');
Route::post('/login', 'Auth\FarmManagerLoginController@login')->name('farm.manager.login');

Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('farm.manager.password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');


/**
 * Register the typical email verification routes for an application.
 */
Route::get('email/verify', 'Auth\FarmAdminVerificationController@show')->name('verification.notice');
Route::get('email/verify/{id}', 'Auth\FarmAdminVerificationController@verify')->name('verification.verify');
Route::get('email/resend', 'Auth\FarmAdminVerificationController@resend')->name('verification.resend');

Route::group(['prefix'=>'dashboard'],function(){
    Route::post('/logout','Auth\FarmManagerLoginController@logout')->name('admin.logout');
    Route::get('/','FarmAdminController@dashboard')->name('admin.dashboard');
    Route::get('/profile','FarmAdminController@profile')->name('admin.profile');
    Route::get('{type}','FarmAdminController@index')->name('admin.home');
    Route::get('{type}/population','FarmAdminController@population')->name('admin.bird.population');
    Route::post('birds/{type}/add','FarmAdminController@addBird')->name('admin.add.bird');
    Route::get('{type}/mortality','FarmAdminController@mortality')->name('admin.bird.mortality');
    Route::post('bird/{type}/mortality/add','FarmAdminController@addMortality')->name('admin.add.mortality');
    Route::get('{type}/egg/production','FarmAdminController@eggProduction')->name('admin.egg.production');
    Route::post('/bird/{type}/egg/production','FarmAdminController@addEggProduction')->name('admin.add.production');
    Route::get('{type}/feed/stock','FarmAdminController@feed')->name('admin.feed.stock');
    Route::post('/feed/stock','FarmAdminController@addFeed')->name('admin.add.feed');
    Route::get('/{type}/feeding/record','FarmAdminController@feeding')->name('admin.feeding.record');
    Route::post('/feeding/record','FarmAdminController@addFeeding')->name('admin.add.feeding');
    Route::get('/{type}/medicine','FarmAdminController@medicine')->name('admin.medicine');
    Route::post('/medicine','FarmAdminController@addMedicine')->name('admin.add.medicine');
    Route::get('/{type}/vaccine','FarmAdminController@vaccine')->name('admin.vaccine');
    Route::post('/vaccine','FarmAdminController@addVaccine')->name('admin.add.vaccine');
    Route::post('/pen/add','FarmAdminController@addPen')->name('admin.add.pen');
    Route::get('/setup/bird','FarmAdminController@setupBird')->name('setup.bird');
    Route::get('/setup/finish','FarmAdminController@setupFinish')->name('setup.finish');
});

Route::get('/birds/{type}','FarmAdminController@birdType')->name('admin.bird_type');
Route::get('/birds/{type}/population','ApiController@population')->name('datatables.population');
Route::get('/birds/{type}/export/exel','ApiController@exportPopulation')->name('export.birds');
Route::get('/birds/{type}/mortality','ApiController@mortality')->name('datatables.mortality');
Route::get('/mortality/{type}/export/exel','ApiController@exportMortality')->name('export.mortality');
Route::get('/pen','ApiController@pen')->name('datatables.pen');
Route::get('/birds/{type}/eggs','ApiController@eggs')->name('datatables.eggs');
Route::get('/eggs/{type}/export/exel','ApiController@exportEggs')->name('export.eggs');

Route::get('/feed','ApiController@feed')->name('datatables.feed');
Route::get('/feed/export/exel','ApiController@exportFeed')->name('export.feed');
Route::get('/feeding','ApiController@feeding')->name('datatables.feeding');
Route::get('/feeding/export/exel','ApiController@exportFeeding')->name('export.feeding');
Route::get('/medicine','ApiController@medicine')->name('datatables.medicine');
Route::get('/medicine/export/exel','ApiController@exportMedicine')->name('export.medicine');
Route::get('/vaccine','ApiController@vaccine')->name('datatables.vaccine');
Route::get('/vacine/export/exel','ApiController@exportVaccine')->name('export.vaccine');

