<?php

/*
 * Authentication Routes Laravel Defaults... replaces //Auth::routes();
 */
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');
/*
 * Signup Routes
 */
Route::redirect('/', '/login', 301);
Route::get('signup', 'SignupController@signup')->name('signup');
Route::post('process_signup', 'SignupController@processSignup')->name('signup.submit');
Route::get('contact/login', 'Auth\ContactLoginController@showLoginForm')->name('contact.login');
Route::post('contact/login', 'Auth\ContactLoginController@login')->name('contact.login.submit');
/*
 *  Password Reset Routes...
 */
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');
/*
 * Social authentication
 */
Route::get('auth/{provider}', 'Auth\LoginController@redirectToProvider');
Route::get('auth/{provider}/callback', 'Auth\LoginController@handleProviderCallback');
/*
 * Authenticated User Routes
 */
Route::group(['middleware' => ['auth:user', 'db']], function () {

	Route::get('dashboard', 'HomeController@user')->name('user.dashboard');
	Route::get('logout', 'Auth\LoginController@logout')->name('user.logout');
    Route::resource('invoices', 'InvoiceController'); // name = (invoices. index / create / show / update / destroy / edit
    Route::get('settings', 'SettingsController@index')->name('user.settings');

});
/*
 * Inbound routes requiring DB Lookup
 */

/*
Authenticated Contact Routes
 */
Route::group(['prefix' => 'contact',  'middleware' => 'auth:contact'], function () {

   Route::get('/', 'ContactController@index')->name('contact.dashboard');
   Route::get('logout', 'Auth\ContactLoginController@logout')->name('contact.logout');
   
}); 