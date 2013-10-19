<?php

class UserController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| User Controller
	|--------------------------------------------------------------------------
	|
	| The UserController provides an interface for user management. 
	| Some basic functions such as create, edit, delete, 
	| reset security session, change the user's role or view login information 
	| and activity is one of its characteristics.
	|
	|	Route::get('/users', 'UserController@index');
	|
	*/

	/**
	 * Display a listing of the all files.
	 *
	 * @return Response
	 */
	public function index()
	{
		return View::make('users')->with('users', User::all());
	}

	/**
	 * Show user profile
	 *
	 * @return Response
	 */
	public function show()
	{
		//Try show user profile
		try
		{
			//If user exists return the user profile page
			return View::make('me')->with('user', User::findOrFail(Auth::user()->id));
		}
		catch(Exeception $e)
		{
			return Redirect::to('users')->withErrors(array('notfound' => Lang::get('messages.users.notfound')));
		}
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
        $rules = array('email' => 'required|email|unique:users,email','password' => 'required','password_confirmation' => 'required|same:password', 'role' => 'required|integer');
        
        $validation = Validator::make(Input::all(), $rules);
        
        if ($validation->fails())
            return Redirect::to('users/create')->withErrors($validation);
        
        //Adding a new User
        $user = new User;
        $user->email = Input::get('email');
        $user->password = Hash::make( Input::get('password') );
        $user->role = Input::get('role', 2);
        $user->last_login = new DateTime();
        $user->last_activity = time();
        $user->save();
        
        return Redirect::to('users')->with('success', Lang::get('messages.users.usersuccess', array('action' => Lang::get('messages.users.create'))));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//Try edit
		try
		{
			//Return the edit view with the user infos
			return View::make('edit')->with('user', User::findOrFail($id));
		}
		catch(Exeception $e)
		{
			return Redirect::to('users')->withErrors(array('notfound' => Lang::get('messages.users.notfound')));
		}
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
    {   
    	//Try update this user
        try {
        	//Find this user
        	$user = User::findOrFail($id);
        	//If the user's email address is the same as the email database
        	//and password and confirmation password are different from empty.
        	//Perform the following rule.
        	if(Input::get('email') == $user->email && Input::get('password') != '' || Input::get('password_confirmation') != '')
        	{
        		$rules = array('email' => 'required|email','password' => 'required','password_confirmation' => 'required|same:password');
        	}
        	else if(Input::get('email') == $user->email && Input::get('password') == '' || Input::get('password_confirmation') == '')
        	{
        		$rules = array('email' => 'required|email');
        	}
        	else
        	{
        		$rules = array('email' => 'required|email|unique:users,email','password' => 'required','password_confirmation' => 'required|same:password');
        	}
    
	        $validation = Validator::make(Input::all(), $rules);
	        
	        if ($validation->fails())
	        {
	            return Redirect::back()->withErrors($validation);
	        }

            //Adding a new User
            $user->email = Input::get('email');
            $user->password = Hash::make(Input::get('password'));
            //Check if this user have a permission to change user role
            if(Auth::user()->role == 0)
            {
            	$user->role = Input::get('role', $user->role);
            }
            //Save updates
            $user->save();
            
            return Redirect::back()->with('success', Lang::get('messages.users.usersuccess', array('action' => Lang::get('messages.users.update'))));
        }
        catch(Exception $e) {
            return Redirect::back()->withErrors(array('notfound' => Lang::get('messages.users.usernotfound', array('action', Lang::get('messages.users.update')))));
        }
	}

	/**
	 * Reset user session.
	 *
	 * @param int id
	 * @return Response
	 */
	public function reset($id)
	{
		//Check if the Request is ajax
		if(Request::ajax())
		{
			//Try reset the user security session
			try 
			{
				//Find user
	            $user = User::findOrFail($id);
	            //Unlocked session
	            $user->locked = FALSE;
	            //Save updates
	            $user->save();
	            //Return json response
	            return Response::json(array('status' => 'success', 'msg' => Lang::get('messages.users.sessionrestarted')));
	        }
	        catch(Exception $e) {
	        	//If throw exception return json error message
	            return Response::json(array('status' => 'danger', 'msg' => Lang::get('messages.users.notrestarted')));
	        }
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//Check if the Request is ajax
		if(Request::ajax())
		{
			//Check if the user is equals to database user 
		    if(Auth::user()->id == $id)
            {
            	//If the current user is the same has selected, return error message.
                return Response::json(array('status' => 'warning', 'msg' => Lang::get('messages.users.notdeleteyou')));
            }
            else
            {
            	//Try Delete this user
                try {
                	//Find this user
                    $user = User::findOrFail($id);
                    //Check if the user is not administrator
                    if($user->role != 0)
                    {
                    	//Call user.delete event with user id
                    	Event::fire('user.delete', $id);
                    	//Delete all user shared files
                    	$user->shares()->delete();
                    	//Delete user
                    	$user->delete();
                    }
                    else
                    {
                    	//If user is a administrator return a error
                    	return Response::json(array('status' => 'danger', 'msg' => Lang::get('messages.users.notdeleteadmin')));
                    }
                    //If user deleted return successfully message
                    return Response::json(array('status' => 'success', 'msg' => Lang::get('messages.users.usersuccess', array('action' => Lang::get('messages.users.delete')))));
                }
                catch(Exception $e) {
                	//If throw exception return json message error
                    return Response::json(array('status' => 'danger', 'msg' => Lang::get('messages.users.usernotfound', Lang::get('messages.users.delete'))));
                }
            }
		}
	}

}