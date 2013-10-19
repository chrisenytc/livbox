<?php

class Share extends Eloquent {
	
	/**
     * Verify if share file exists
     * @param string $share_id
     * @return string
     */
	public static function shareExists($share_id)
	{
		$count = Share::where('share_id', $share_id)->where('user_id', Auth::user()->id)->count();

		if($count > 0)
		{ 
			return TRUE;
		} 
		else 
		{ 
			return FALSE; 
		}
	}
} 