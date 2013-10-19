<?php

class SettingController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Setting Controller
	|--------------------------------------------------------------------------
	|
	| The SettingController provides an interface for managing system settings. 
	| Some basic functions, such as changing the title and description of the system,
	| change the system language or change system time zone is one of its features.
	|
	|	Route::get('/settings', 'SettingController@index');
	|
	*/

	/**
	 * Display a listing of the settings.
	 *
	 * @return Response
	 */
	public function index()
	{
		return View::make('setting')->with('configs', Setting::all()->first());
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @return Response
	 */
	public function update()
	{
		$rules = array('title' => 'required', 'language' => 'required|alpha', 'timezone' => 'required', 'year' => 'required|integer');
    
        $validation = Validator::make(Input::all(), $rules);
        
        if ($validation->fails())
            return Redirect::to('settings')->withErrors($validation);
        
        try {
            //Update the settings
            $config = Setting::all()->first();
            $config->title = Input::get('title');
            $config->description = Input::get('description');
            $config->language = Input::get('language');
            $config->timezone = Input::get('timezone');
            $config->year = Input::get('year');
            $config->save();
            
            return Redirect::to('settings')->with('success', Lang::get('messages.settings.settingsuccess'));
        }
        catch(Exception $e) {
            return Redirect::to('settings')->withErrors(array('msg' => Lang::get('messages.settings.settingnotfound')));
        }
	}

}