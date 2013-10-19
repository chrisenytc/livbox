<?php

class ArchiveController extends BaseController {

    /*
    |--------------------------------------------------------------------------
    | Archive Controller
    |--------------------------------------------------------------------------
    |
    | The ArchiveController provides an interface for managing files and folders.
    | Some basic functions like create, rename, delete, and share 
    | files or folder are one of its features.
    |
    |	Route::get('/archives/{path?}', 'ArchiveController@index');
    |
    */


    /**
     * Provide a manager for download files.
     *
     * @param string $path
     * @return Response
     */
    private function downloadManager($path)
    {
        try
        {
            //Decrypt file path
            $rpath = Crypt::decrypt($path);
            //Check if file exists and Download this file
            if(file_exists($filepath = $rpath))
            {
                return Response::download($filepath);
            }
            else
            {
                return Redirect::back()->withErrors(array('msg' => Lang::get('messages.archives.filenotpermission', array('filepath' => $filepath))));
            }
        }
        catch(Exception $e)
        {
            return Redirect::back()->withErrors(array('msg' => Lang::get('messages.archives.servererror')));
        }
    }

    /**
     * Display a listing of the archives and directories.
     *
     * @param string $epath
     * @return Response
     */
    public function index($epath = '')
    {
        //Try execute this block
        try
        {
            //Check if $path is not empty and set decrypted path or DIRECTORY_SEPARATOR
            $path = !empty($epath) ? Crypt::decrypt($epath) : DIRECTORY_SEPARATOR;
            //Check if directory exists and is a directory
            if(file_exists($filepath = Helpers::file_path($path)) && is_dir($filepath))
            {
                //Scan directory and return all directories and file names
                $files = scandir($filepath, 1);
                //Update the session path
                //If the session exists
                //clear this session and generate new path
                if(Session::has('path'))
                {
                    //Clear session path
                    Session::forget('path');
                    //Generate new session path with the current path
                    Session::put('path', $path);
                }
                {
                    //If session is not exists create this session
                    // with the current path
                    Session::put('path', $path);
                }
                //Return the file manager view with file infos
                return View::make('archives', array('files' => $files, 'username' => Auth::user()->id, 'path' => $path));
            }
            else
            {
                return Redirect::back()->withErrors(array('msg' => Lang::get('messages.archives.foldernotfound')));
            }
        }
        catch(Exception $e)
        {
            return Redirect::back()->withErrors(array('msg' => Lang::get('messages.archives.servererror')));
        } 
    }

    /**
     * Privide a UploadManager.
     *
     * @return Response
     */
    public function upload()
    {
        try
        {
            //Check if has input files
            if (Input::hasFile('files'))
            {
                //Check if session path exists
                if(Session::has('path'))
                {
                    $path = Session::get('path');
                }
                // Move input file to the user folder
                $result = Input::file('files')->move(Helpers::file_path($path), Input::file('files')->getClientOriginalName());
                //If file moves successfully return message
                if($result)
                {
                    return Redirect::back()->with('success', Lang::get('messages.archives.uploadsuccess'));
                }
            }
            return Redirect::back()->withErrors(array('msg' => Lang::get('messages.archives.servererror')));
        }
        catch(Exception $e)
        {
            return Redirect::back()->withErrors(array('msg' => Lang::get('messages.archives.servererror')));
        } 
    }

    /**
     * Provide Download for the private archives
     * with the DownloadManager
     * 
     * @param string $path
     * @return Response
     */
    public function download($path)
    {
        $dpath = Crypt::decrypt($path);
        return $this->downloadManager(Crypt::encrypt(Helpers::file_path($dpath)));
    }


    /**
     * Provide a directory creatorManager.
     *
     * @return Response
     */
    public function create()
    {
        //Check if the input name exists
        if(Input::has('name'))
        {
            //Try create folder
            try
            {
                //Get folder name
                $name = Input::get('name');
                //Check if the path session exista to use in create folder
                if(Session::has('path'))
                {
                    //If exists, $path receive a current path
                    $path = Session::get('path');
                }
                else
                {
                    //If is not exists receive start path
                    $path = '';
                }
                //Get absolute file path
                $dir = Helpers::file_path($path);
                //Check if the file name is not exists and is not a directory
                if(!file_exists($d = $dir.DIRECTORY_SEPARATOR.$name) && !is_dir($d))
                {
                    //Create directory
                    mkdir($dir.DIRECTORY_SEPARATOR.$name, 0777);
                    //Return message
                    return Redirect::back()->with('success', Lang::get('messages.archives.foldersuccess', array('name' => $name)));
                }
                else
                {
                    //If is not exists return error message
                    return Redirect::back()->withErrors(array('msg' => Lang::get('messages.archives.foldernotpermission', array('name' => $name))));
                }
            }
            catch(Exception $e)
            {
                return Redirect::back()->withErrors(array('msg' => Lang::get('messages.archives.servererror')));
            }
        }
        else
        {
            return Redirect::back()->withErrors(array('msg' => Lang::get('messages.archives.requiredfields')));
        }
    }

    /**
     * Provide a archive renameManager.
     *
     * @return Response
     */
    public function rename()
    {
        //Check if the Request is ajax
        if(Request::ajax())
        {
            //check if the input name, share_id and path exists
            if(Input::has('name') && Input::has('share_id') && Input::has('path'))
            {
                try
                {
                    //Get Name
                    $name = Input::get('name');
                    //Get Share ID
                    $share_id = Input::get('share_id');
                    //Decrypt path
                    $path = Crypt::decrypt(Input::get('path'));
                    //Use helper file_path to get absolute user file path
                    $file = Helpers::file_path($path);
                    //If file path exists rename file or directory
                    if(file_exists($file))
                    {
                        //Fomart share path
                        $fpath = Crypt::encrypt(Helpers::share_format($file, $name));
                        //Try rename this file or directory
                        rename($file, dirname($file).DIRECTORY_SEPARATOR.$name);
                        //Get infos to the share.rename event in listeners.php
                        $infos = array('share_id' => $share_id, 'path' => $fpath);
                        //Call share.rename event with share file infos
                        Event::fire('share.rename', array($infos));
                        //Return json format response
                        return Response::json(array('status' => 'success', 'msg' => Lang::get('messages.archives.archivesuccess', array('action' => Lang::get('messages.archives.renamed')))));
                    }
                    else
                    {
                        return Response::json(array('status' => 'danger', 'msg' => Lang::get('messages.archives.filenotfound')));
                    }
                }
                catch(Exception $e)
                {
                    return Response::json(array('status' => 'danger', 'msg' => Lang::get('messages.archives.servererror')));
                }
            }
            else
            {
                return Response::json(array('status' => 'danger', 'msg' => Lang::get('messages.archives.requiredfields')));
            }
        }
    }

    /**
     * Provide a archive deleteManager.
     *
     * @return Response
     */
    public function delete()
    {
        //Check if the Request is ajax
        if(Request::ajax())
        {
            //Check if the input action and path exists
            if(Input::has('action') && Input::has('path'))
            {
                //Get input action
                $action = Input::get('action');
                //Decrypt file path
                $path = Crypt::decrypt(Input::get('path'));
                //Use helper file_path to get the absolute file path
                $file = Helpers::file_path($path);

                //Check if this action is file and has share_id to delete this file
                if($action == 'file' && Input::has('share_id'))
                {
                    //Try delete this file or throw a exception 
                    try
                    {
                        //If the file exists delete it
                        if(file_exists($file))
                        {
                            //Delete this file
                            unlink($file);
                            //Call share.remove event with the share_id
                            Event::fire('share.remove', Input::get('share_id'));
                            //Return josn response
                            return Response::json(array('status' => 'success', 'msg' => Lang::get('messages.archives.archivesuccess', array('action' => Lang::get('messages.archives.deleted')))));
                        }
                        else
                        {
                            return Response::json(array('status' => 'danger', 'msg' => Lang::get('messages.archives.filenotfound')));
                        }
                    }
                    catch(Exception $e)
                    {
                        return Response::json(array('status' => 'danger', 'msg' => Lang::get('messages.archives.servererror')));
                    }
                }
                else if ($action == 'dir')
                {
                    //Try delete this directory or throw a exception 
                    try
                    {
                        //Check if the directory exists
                        if(file_exists($file) && is_dir($file))
                        {
                            //Remove this irectory
                            rmdir($file);
                            //Return json response
                            return Response::json(array('status' => 'success', 'msg' => Lang::get('messages.archives.archivesuccess', array('action' => Lang::get('messages.archives.deleted')))));
                        }
                        else
                        {
                            return Response::json(array('status' => 'danger', 'msg' => Lang::get('messages.archives.filenotfound')));
                        }
                    }
                    catch(Exception $e)
                    {
                        return Response::json(array('status' => 'danger', 'msg' => Lang::get('messages.archives.servererror')));
                    }
                }
                else
                {
                    return Response::json(array('status' => 'danger', 'msg' => Lang::get('messages.archives.requiredfields')));
                }
            }
            else
            {
                return Response::json(array('status' => 'danger', 'msg' => Lang::get('messages.archives.requiredfields')));
            }
        }
    }

    /**
     * Provide a archive shareManager.
     *
     * @return Response
     */
    public function share()
    {
        ////Check if the Request is ajax
        if(Request::ajax())
        {
                $rules = array('share_id' => 'required|unique:shares', 'path' => 'required');
        
                $validation = Validator::make(Input::all(), $rules);
                
                if ($validation->fails())
                {
                    return Response::json(array('status' => 'warning', 'error' => 'true', 'msg' => Lang::get('messages.archives.sharefailed')));
                }
                else
                {
                    //Share this file and provide a share link to use
                    //Decrypt the input file path
                    $path = Crypt::decrypt(Input::get('path'));
                    //Use helper file_path to get absolute file path and 
                    //Encrypt the absolute file path
                    $epath = Crypt::encrypt(Helpers::file_path($path));
                    //Create new Share file object
                    $file = new Share;
                    $file->share_id = Input::get('share_id');
                    $file->user_id = Auth::user()->id;
                    $file->path = $epath;
                    //Create new share file
                    $file->save();

                    return Response::json(array('status' => 'success', 'msg' => Lang::get('messages.archives.sharesuccess'), 'url' => URL::to('public').DIRECTORY_SEPARATOR.Input::get('share_id')));
                }
        }
    }

    /**
     * Provide a archive unshareManager.
     *
     * @return Response
     */
    public function unshare()
    {
        //Check if the Request is ajax
        if(Request::ajax())
        {
            //Check if the input share_id exists
            if(Input::has('share_id'))
            {
                //Try unshare this file
                try
                {
                    //Find shared file where share_id is equals to input share_id
                    $file = Share::where('share_id', Input::get('share_id'))->firstOrFail();
                    //Delete this shared file
                    $file->delete();
                    //Return json response
                    return Response::json(array('status' => 'success', 'msg' => Lang::get('messages.archives.unsharesuccess')));
                }
                catch(Exception $e)
                {
                    return Response::json(array('status' => 'danger', 'msg' => Lang::get('messages.archives.unsharedfailed')));
                }
            }
            else
            {
                return Response::json(array('status' => 'danger', 'msg' => Lang::get('messages.archives.requiredfields')));
            }


        }
    }

    /**
     * Provide a Public Shared Files View.
     *
     * @param string $share_id
     * @return Response
     */
    public function view($share_id)
    {
        //Try get the shared file
        try
        {
            //Find the shared file or throw a exception
            $share = Share::where('share_id', $share_id)->firstOrFail();
            //Decrypt share path to use in file object
            $path = Crypt::decrypt($share->path);
            //Check if the shared file exists
            if(file_exists($path))
            {
                //Create new file object
                $file = new stdClass();
                //Get name of file
                $file->name = basename($path);
                //Get file size and format this size
                $file->size = Helpers::formatsize(filesize($path));
                //Provide a share_id
                $file->share_id = $share_id;
                //Provide a file path to use in download
                $file->path = $share->path;
                //Return the share view to use save and download options
                return View::make('view')->with('file', $file);
            }
            //If this file not found abort this action and show error 404 with message
            return App::abort(404, Lang::get('messages.archives.filenotfound'));
        }
        catch(Exception $e)
        {
            //If throw a exception abort this action and show error 404 with message
            return App::abort(404, Lang::get('messages.archives.filenotfound'));
        }
    }

    /**
     * Provide a shared files to save in user folder with SaveManager.
     *
     * @param string $share_id
     * @return Response
     */
    public function save($share_id)
    {
        //Try copy this file to the new user folder
        try
        {
            //Check this shared file exists in database
            $share = Share::where('share_id', $share_id)->firstOrFail();
            //Decrypt this path to use in copy
            $path = Crypt::decrypt($share->path);

            //Check if this shared file exists in file system
            if(file_exists($path))
            {
                //Check if this file was copied successfully
                if(copy($path, Helpers::file_path(DIRECTORY_SEPARATOR.basename($path))))
                {
                    //Return json response with message if successfully
                    return Redirect::to('archives')->with('success', Lang::get('messages.archives.saved', array('name' => basename($path))));   
                }
                else
                {
                    return Redirect::to('archives')->withErrors(array('msg' => Lang::get('messages.archives.filenotfound')));
                }
            }
        }
        catch(Exception $e)
        {
            //If this file not found abort this action and show error 404 with message
            return App::abort(404, Lang::get('messages.archives.filenotfound'));
        }
    }

    /**
     * Provide a public share files 
     * with DownloadManager.
     *
     * @return Response
     */
    public function publicDownload($path)
    {
        //Return downloadManager instance
        return $this->downloadManager($path);
    }

}