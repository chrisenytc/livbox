<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::group(array('before' => 'auth'), function()
{
    /*--------------------------------------------------------------------------
    | Home Controller
    --------------------------------------------------------------------------*/
    Route::get('/', 'HomeController@index');
    /*--------------------------------------------------------------------------
    | Users Controller
    --------------------------------------------------------------------------*/
    Route::group(array('before' => 'managerpermission'), function(){
        Route::get('users', 'UserController@index');
        Route::put('users/reset/{id}', 'UserController@reset');
    });
    Route::group(array('before' => 'permission'), function(){
        /*--------------------------------------------------------------------------
        | Users Controller
        --------------------------------------------------------------------------*/
        Route::get('users/create', 'UserController@create');
        Route::post('users', array('before' => 'csrf', 'uses' => 'UserController@store'));
        Route::get('users/{id}/edit', 'UserController@edit');
        Route::post('users/{id}', array('before' => 'csrf', 'uses' => 'UserController@update'));
        Route::delete('users/{id}', 'UserController@destroy');
        /*--------------------------------------------------------------------------
        | Setting Controller
        --------------------------------------------------------------------------*/
        Route::get('settings', 'SettingController@index');
        Route::post('settings', 'SettingController@update');
    });
    /*--------------------------------------------------------------------------
    | Users Controller
    --------------------------------------------------------------------------*/
    Route::get('me', 'UserController@show');
    Route::post('me/update/{id}', array('before' => 'csrf', 'uses' => 'UserController@update'));
    /*--------------------------------------------------------------------------
    | Archive Controller
    --------------------------------------------------------------------------*/
    Route::get('archives/{path?}', 'ArchiveController@index');
    Route::get('archives/download/{path}', 'ArchiveController@download');
    Route::post('archives/upload', array('before' => 'csrf', 'uses' => 'ArchiveController@upload'));
    Route::post('archives/create', array('before' => 'csrf', 'uses' => 'ArchiveController@create'));
    Route::put('archives/rename', 'ArchiveController@rename');
    Route::delete('archives/delete', 'ArchiveController@delete');
    Route::put('archives/share', 'ArchiveController@share');
    Route::delete('archives/unshare', 'ArchiveController@unshare');
    Route::get('archives/save/{share_id}', 'ArchiveController@save');
    /*--------------------------------------------------------------------------
    | Login Controller
    --------------------------------------------------------------------------*/
    Route::get('logout', 'LoginController@logout');

});


/*--------------------------------------------------------------------------
| Login Controller
--------------------------------------------------------------------------*/

Route::get('login', 'LoginController@form');

Route::post('login', array('before' => 'csrf', 'uses' => 'LoginController@auth'));

Route::get('forgot', 'LoginController@forgot');

Route::post('forgot/remind', array('before' => 'csrf', 'uses' => 'LoginController@remind'));

Route::get('forgot/reset/{token}', 'LoginController@reset');

Route::post('password/reset/{token}', 'LoginController@storage');

/*--------------------------------------------------------------------------
| Archive Controller
--------------------------------------------------------------------------*/

Route::get('public/{path}', 'ArchiveController@view');
Route::get('download/{path}', 'ArchiveController@publicDownload');
