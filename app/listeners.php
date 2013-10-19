<?php

/*
|--------------------------------------------------------------------------
| Event user.login
|--------------------------------------------------------------------------
|
| The user.login event is called when a user enters the system,
| it stores user information and lock the security session. 
| If this is the first time the user accesses the system,
| the folder will be created for that user's files.
|
*/

Event::listen('user.login', function($id)
{
    //Search User
	$user = User::find($id);
    $user->last_login = new DateTime();
    $user->last_activity = time();
    $user->locked = TRUE;
    //Save Updates
    $user->save();

    // Try delete folder
    try
    {
        //Verify if the user folder exists
    	if(!file_exists($filepath = Helpers::file_path()) && !is_dir($filepath)) 
    	{
            //if not exists, create the folder with permission 0777.
    		mkdir(Helpers::file_path(), 0777);
    	}
    }
    catch(Exception $e)
    {
        Log::error($e);
    }
});

/*
|--------------------------------------------------------------------------
| Event user.exit
|--------------------------------------------------------------------------
|
| The user.exit event is called when a user leaves the system,
| it unlocks the security session and saves the changes.
|
*/

Event::listen('user.exit', function($id)
{
    //Search user
	$user = User::find($id);
    $user->locked = FALSE;
    //Save Updates
    $user->save();

});

/*
|--------------------------------------------------------------------------
| Event user.delete
|--------------------------------------------------------------------------
|
| The user.delete event is called when a user is deleted,
| it delete all user folders and files.
|
*/

Event::listen('user.delete', function($id)
{
    //Try delete folder
    try
    {
        //If folders exist, it remove all user folders and files.
        if(file_exists($dir = base_path().DIRECTORY_SEPARATOR.'files'.DIRECTORY_SEPARATOR.$id) && is_dir($dir))
        {
            // Remove all folders and files.
            Helpers::remove_dir($dir);
        }
    }
    catch(Exception $e)
    {
        return FALSE;
    }
});

/*
|--------------------------------------------------------------------------
| Event share.rename
|--------------------------------------------------------------------------
|
| The share.rename event is called when a user changes the name of a folder or file,
| the event receives a share_id and path of the file or folder.
| If the file or folder exists, 
| will be changed in the database for using the new name.
|
*/

Event::listen('share.rename', function($data)
{
    //Decrypt file path
    $dpath = Crypt::decrypt($data['path']);
    //Encrypt file path and use file_path helpers for get absolute file path
    $epath = Crypt::encrypt(Helpers::file_path($dpath));
    //Count all share files
    $count = Share::where('share_id', $data['share_id'])->count();
    //If share files is greater than 0 update share file info
    if ($count > 0) {
        //Find share file
        $file = Share::where('share_id', $data['share_id'])->first();
        //Generate a new share_id and update share_id
        $file->share_id = md5(Helpers::user_path($dpath));
        //Update path
        $file->path = $epath;
        //Save updates
        $file->save();
    }
});

/*
|--------------------------------------------------------------------------
| Event share.remove
|--------------------------------------------------------------------------
|
| The share.remove event is called when a user deletes a file that is shared.
|
*/

Event::listen('share.remove', function($share_id)
{
    //Find and count share files
    $count = Share::where('share_id', $share_id)->count();
    //If share files is greater than 0 delete share file
    if ($count > 0) {
        //Find share file
        $file = Share::where('share_id', $share_id)->first();
        //Delete
        $file->delete();
    }
});