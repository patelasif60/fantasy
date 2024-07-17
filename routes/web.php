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

// Route::view('/', 'welcome')->name('landing');

Route::view('/', 'public-website.pages.index')->name('frontend');
Route::view('/about', 'public-website.pages.about')->name('frontend/about');
Route::view('/rules', 'public-website.pages.rules')->name('frontend/rules');
Route::view('/terms', 'public-website.pages.terms')->name('frontend/terms');
Route::view('/privacy', 'public-website.pages.privacy')->name('frontend/privacy');
Route::view('/contact', 'public-website.pages.contact')->name('frontend/contact');

Route::view('/home', 'welcome')->name('landing');

Route::view('/login/selection', 'auth.login_selection')->name('login.selection');

Route::view('/register/selection', 'auth.register_selection')->name('register.selection');

Route::get('/gameguide', 'GameGuideController@show')->name('frontend.gameguide');
Route::get('/autologin', 'HomeController@autologin')->name('frontend.autologin');

Route::get('/fixtures/check', 'Script\FixturesController@check')->name('fixture.check');

// Route::get('apple-app-site-association', 'HomeController@iosJson')->name('frontend.mobile.ios');

// Route::get('/super-sub', function(){
//     return view('pages.super-sub');
// });
//Route::get('/apple-app-site-association', 'Manager\HomeController@iosDeepLinking')->name('home.ios.deep.linking');

Auth::routes(['verify' => true]);

// Social Account Auth Section
Route::get('auth/{provider}', 'Auth\SocialLoginController@redirectToProvider')->where('provider', 'facebook|google')->name('social.login');
Route::get('auth/{provider}/callback', 'Auth\SocialLoginController@handleProviderCallback')->where('provider', 'facebook|google')->name('social.login.callback');

// Admin users invitation section
Route::get('/users/invitation/{token}', 'Auth\AdminUsersInvitationController@show')->name('auth.users.admin.invitation.show');
Route::post('/users/invitation/{token}', 'Auth\AdminUsersInvitationController@accept')->name('auth.users.admin.invitation.accept');

//User Route to Register
Route::get('/users/{next}/register', 'Auth\RegisterController@redirect')->name('auth.register.select');

// Contact us route
Route::get('/contactus', 'ContactUsController@create')->name('manage.contactus');
Route::post('/contactus/store', 'ContactUsController@store')->name('manage.contactus.store');
