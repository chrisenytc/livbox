<?php

class LoginController extends BaseController {

    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | The LoginController provides an interface for managing logins 
    | and logouts of the system. Some basic functions such as login, 
    | to leave the system and retrieve the password is one of its characteristics.
    |
    |   Route::get('/login', 'LoginController@form');
    |
    */

    /**
     * Display a login form.
     *
     * @return Response
     */
    public function form()
    {
        return View::make('login');
    }

    /**
     * Validate authentication
     *
     * @return Response
     */
	public function auth()
	{
		$rules = array("email" => "required|email",
            "password" => "required");
    
        $validation = Validator::make(Input::all(), $rules);
        
        if ($validation->fails()) {
            return Redirect::to('login')->withErrors($validation);
        }
        
        //Try Login
        if (Auth::attempt( array('email' => Input::get('email'), 'password' => Input::get('password')), Input::get('remind'))) {
            //Find user
            $user = User::find($id = Auth::user()->id);
            //Call user.login event
            Event::fire('user.login', $id);
            //Check if the user is an administrator and if the user is locked. 
            //If not, lock the session and exit the system.
            if($user->role == 0 && $user->locked)
            {
                //If user is logged and is locked return to home with security message
                return Redirect::to('/')->withErrors(array('msg' => Lang::get('messages.login.unlocked')));
            }
            else if($user->role != 0 && $user->locked)
            {
                //Logout this user
                Auth::logout();
                //If user is not logged and is locked return to login with error message
                return Redirect::to('login')->withErrors(array('locked' => Lang::get('messages.login.locked')));
            }
            else
            {
                //If user is logged and is not locked return to home
                return Redirect::to('/');
            }
        }
        else {
            return Redirect::to('login')->withErrors(Lang::get('messages.login.invaliddata'));
        }
    }
    
    /**
     * Display forgot view.
     *
     * @return Response
     */
    public function forgot()
    {
        return View::make('forgot');
    }

    /**
     * Remind password.
     *
     * @return Response
     */
    public function remind()
    {
        $credentials = array('email' => Input::get('email'));

        return Password::remind($credentials);
    }

    /**
     * Display reset view.
     *
     * @return Response
     */
    public function reset($token)
    {
        return View::make('reset')->with('token', $token);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return Response
     */
    public function storage()
    {
        $credentials = array('email' => Input::get('email'));

        return Password::reset($credentials, function($user, $password)
        {
            $user->password = Hash::make($password);

            $user->save();

            return Redirect::to('/');
        });
    }

    /**
     * Provide a LogoutManager.
     *
     * @return Response
     */
    public function logout()
    {
        //Call user.exit with user id
        Event::fire('user.exit', Auth::user()->id);
        //Logout action
        Auth::logout();
        return Redirect::to('login');
    }
}