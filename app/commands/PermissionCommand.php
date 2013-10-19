<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class PermissionCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'grant:permission';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Grant permission for required directories';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return void
	 */
	public function fire()
	{
		//Get storage path
		$storage = storage_path().DIRECTORY_SEPARATOR;

		//Verify if the folders exists
		if(file_exists($dir = base_path().'/files') && is_dir($dir) && file_exists($sdir = storage_path()) && is_dir($sdir))
		{

			//Grant permission for all folders
			chmod($dir, 0777);
			chmod(storage_path(), 0777);
            chmod($storage.'cache', 0777);
            chmod($storage.'logs', 0777);
            chmod($storage.'meta', 0777);
            chmod($storage.'sessions', 0777);
            chmod($storage.'views', 0777);

			$this->info('Grant permission successfully!');
		}
		else
		{
			//If files folder is not exist create it
			mkdir($dir, 0777);
			//Grant permission for all folders
			chmod($dir, 0777);
			chmod(storage_path(), 0777);
            chmod($storage.'cache', 0777);
            chmod($storage.'logs', 0777);
            chmod($storage.'meta', 0777);
            chmod($storage.'sessions', 0777);
            chmod($storage.'views', 0777);

			$this->info('Grant permission successfully!');
		}
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
			
		);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
			
		);
	}

}