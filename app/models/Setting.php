<?php

class Setting extends Eloquent {
	
	/**
     * Provide default language
     *
     * @return string
     */
	public static function language()
	{
		$config = Setting::all()->first();
		return $config->language;
	}

	/**
     * Provide default timezone
     *
     * @return string
     */
	public static function timezone()
	{
		$config = Setting::all()->first();
		return $config->timezone;
	}
}