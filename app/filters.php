<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function($request)
{
	//Set default timezone fom model Setting
	Helpers::setTimezone(Setting::timezone());
	//Set default language from model Setting 
	Helpers::setLocale(Setting::language());
	//Verify if user is logged and update the last activity
	if (Auth::check()) {
        $user = Auth::user();
        $now = time();
        $user->last_activity = $now;
        $user->save();
    }
});


App::after(function($request, $response)
{
	//Find all users that are no more than 30 minutes without using the system. 
	//If the user is no more than 30 minutes without activity, unlock security session.
	$users = User::where('last_activity', '<=', time() - 1800)->get();
	//Unlock
	foreach ($users as $u) {
		$u->locked = FALSE;
		$u->save();
	}
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

Route::filter('auth', function()
{
	if (Auth::guest()) return Redirect::guest('login');
});


Route::filter('auth.basic', function()
{
	return Auth::basic();
});

/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function()
{
	if (Auth::check()) return Redirect::to('/');
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function()
{
	if (Session::token() != Input::get('_token'))
	{
		throw new Illuminate\Session\TokenMismatchException;
	}
});

/*
|--------------------------------------------------------------------------
| Permission Protection Filter
|--------------------------------------------------------------------------
|
| The filter Permission is responsible for protecting your application 
| from unauthorized users. It checks whether the users permission
| equals permission required.
|
*/

Route::filter('permission', function()
{
	//If user is not administrator make error 404
	if (Auth::user()->role != 0)
	{
		return View::make('errors.403');
	}
});

Route::filter('managerpermission', function()
{
	//If user is normal user make error 403
	if (Auth::user()->role == 2)
	{
		return View::make('errors.403');
	}
});
