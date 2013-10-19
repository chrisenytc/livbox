<?php

class Helpers {

    /**
     * Set default application timezone
     *
     * @param  string  $timezone
     * @return void
     */
    public static function setTimezone($timezone)
    {
        date_default_timezone_set($timezone);
    }

    /**
     * Set default application language
     *
     * @param  string  $locale
     * @return void
     */
    public static function setLocale($locale)
    {
        App::setLocale($locale);
    }

    /**
     * Fomart time in seconds
     *
     * @param  int  $timeDB
     * @return string
     */
    private static function time_format($timeBD)
    {

        $timeNow = time();
        $timeRes = $timeNow - $timeBD;
        $nar = 0;
        
        // variable
        $r = "";

        // now
        if ($timeRes == 0){
            $r = Lang::get('general.helpers.time_format.now');
        } else
        // Segundos
        if ($timeRes > 0 and $timeRes < 60){
            $r = Lang::get('general.helpers.time_format.seconds_ago', array('time' => $timeRes));
        } else
        // Minutos
        if (($timeRes > 59) and ($timeRes < 3599)){
            $timeRes = $timeRes / 60;   
            if (round($timeRes,$nar) >= 1 and round($timeRes,$nar) < 2){
                $r = Lang::choice('general.helpers.time_format.minutes_ago', 10);
            } else {
                $r = Lang::choice('general.helpers.time_format.minutes_ago', round($timeRes,$nar), array('time' => round($timeRes,$nar)));
            }
        }
         else
        // Horas
        // Usar expressao regular para fazer hora e MEIA
        if ($timeRes > 3559 and $timeRes < 85399){
            $timeRes = $timeRes / 3600;
            
            if (round($timeRes,$nar) >= 1 and round($timeRes,$nar) < 2){
                $r = Lang::choice('general.helpers.time_format.hours_ago', round($timeRes,$nar), array('time' => round($timeRes,$nar)));
            }
            else {
                $r = Lang::choice('general.helpers.time_format.hours_ago', round($timeRes,$nar), array('time' => round($timeRes,$nar)));
            }
        } else
        // Dias
        // Usar expressao regular para fazer dia e MEIO
        if ($timeRes > 86400 and $timeRes < 2591999){
            
            $timeRes = $timeRes / 86400;
            if (round($timeRes,$nar) >= 1 and round($timeRes,$nar) < 2){
                $r = Lang::choice('general.helpers.time_format.days_ago', round($timeRes,$nar), array('time' => round($timeRes,$nar)));
            } else {

                preg_match('/(\d*)\.(\d)/', $timeRes, $matches);
                
                if ($matches[2] >= 5) {
                    $ext = round($timeRes,$nar) - 1;
                    
                    // Imprime o dia
                    $r = Lang::choice('general.helpers.time_format.days_ago', $ext, array('time' => $ext));
                    
                    
                } else {
                    $r = Lang::choice('general.helpers.time_format.days_ago', round($timeRes,0), array('time' => round($timeRes,0)));
                }
                
            }       
                    
        } else
        // Meses
        if ($timeRes > 2592000 and $timeRes < 31103999){

            $timeRes = $timeRes / 2592000;
            if (round($timeRes,$nar) >= 1 and round($timeRes,$nar) < 2){
                $r = Lang::choice('general.helpers.time_format.months_ago', round($timeRes,$nar), array('time' => round($timeRes,$nar)));

            } else {

                preg_match('/(\d*)\.(\d)/', $timeRes, $matches);
                
                if ($matches[2] >= 5){
                    $ext = round($timeRes,$nar) - 1;
                    
                    // Imprime o mes
                    $r = Lang::choice('general.helpers.time_format.months_ago', $ext, array('time' => $ext));
                    
                    
                } else {
                    $r = Lang::choice('general.helpers.time_format.months_ago', round($timeRes,0), array('time' => round($timeRes,0)));
                }
                
            }
        } else
        // Anos
        if ($timeRes > 31104000 and $timeRes < 155519999){
            
            $timeRes /= 31104000;
            if (round($timeRes,$nar) >= 1 and round($timeRes,$nar) < 2){
                $r = Lang::choice('general.helpers.time_format.years_ago', round($timeRes,$nar), array('time' => round($timeRes,$nar)));
            } else {
                $r = Lang::choice('general.helpers.time_format.years_ago', round($timeRes,$nar), array('time' => round($timeRes,$nar)));
            }
        } else
        // 5 anos, mostra data
        if ($timeRes > 155520000){
            
            $localTimeRes = localtime($timeRes);
            $localTimeNow = localtime(time());
                    
            $timeRes /= 31104000;
            $gmt = array();
            $gmt['month'] = $localTimeRes[4];
            $gmt['year'] = round($localTimeNow[5] + 1900 - $timeRes,0);              
                        
            $mon = array(Lang::get('general.months.january'),Lang::get('general.months.february'),Lang::get('general.months.march'),Lang::get('general.months.april'),Lang::get('general.months.may'),Lang::get('general.months.june'),Lang::get('general.months.july'),Lang::get('general.months.'),Lang::get('general.months.september'),Lang::get('general.months.octuber'),Lang::get('general.months.november'),Lang::get('general.months.december')); 
            
            $r = $mon[$gmt['month']] . $gmt['year'];
        }
        
        return $r;

    }

    /**
     * Lit of all timezones
     *
     * @return array
     */
    public static function timezones()
    {
        return array (
            '(UTC-11:00) Midway Island' => 'Pacific/Midway',
            '(UTC-11:00) Samoa' => 'Pacific/Samoa',
            '(UTC-10:00) Hawaii' => 'Pacific/Honolulu',
            '(UTC-09:00) Alaska' => 'US/Alaska',
            '(UTC-08:00) Pacific Time (US &amp; Canada)' => 'America/Los_Angeles',
            '(UTC-08:00) Tijuana' => 'America/Tijuana',
            '(UTC-07:00) Arizona' => 'US/Arizona',
            '(UTC-07:00) Chihuahua' => 'America/Chihuahua',
            '(UTC-07:00) La Paz' => 'America/Chihuahua',
            '(UTC-07:00) Mazatlan' => 'America/Mazatlan',
            '(UTC-07:00) Mountain Time (US &amp; Canada)' => 'US/Mountain',
            '(UTC-06:00) Central America' => 'America/Managua',
            '(UTC-06:00) Central Time (US &amp; Canada)' => 'US/Central',
            '(UTC-06:00) Guadalajara' => 'America/Mexico_City',
            '(UTC-06:00) Mexico City' => 'America/Mexico_City',
            '(UTC-06:00) Monterrey' => 'America/Monterrey',
            '(UTC-06:00) Saskatchewan' => 'Canada/Saskatchewan',
            '(UTC-05:00) Bogota' => 'America/Bogota',
            '(UTC-05:00) Eastern Time (US &amp; Canada)' => 'US/Eastern',
            '(UTC-05:00) Indiana (East)' => 'US/East-Indiana',
            '(UTC-05:00) Lima' => 'America/Lima',
            '(UTC-05:00) Quito' => 'America/Bogota',
            '(UTC-04:00) Atlantic Time (Canada)' => 'Canada/Atlantic',
            '(UTC-04:30) Caracas' => 'America/Caracas',
            '(UTC-04:00) La Paz' => 'America/La_Paz',
            '(UTC-04:00) Santiago' => 'America/Santiago',
            '(UTC-03:30) Newfoundland' => 'Canada/Newfoundland',
            '(UTC-03:00) Brasilia' => 'America/Sao_Paulo',
            '(UTC-03:00) Buenos Aires' => 'America/Argentina/Buenos_Aires',
            '(UTC-03:00) Georgetown' => 'America/Argentina/Buenos_Aires',
            '(UTC-03:00) Greenland' => 'America/Godthab',
            '(UTC-02:00) Mid-Atlantic' => 'America/Noronha',
            '(UTC-01:00) Azores' => 'Atlantic/Azores',
            '(UTC-01:00) Cape Verde Is.' => 'Atlantic/Cape_Verde',
            '(UTC+00:00) Casablanca' => 'Africa/Casablanca',
            '(UTC+00:00) Edinburgh' => 'Europe/London',
            '(UTC+00:00) Greenwich Mean Time : Dublin' => 'Etc/Greenwich',
            '(UTC+00:00) Lisbon' => 'Europe/Lisbon',
            '(UTC+00:00) London' => 'Europe/London',
            '(UTC+00:00) Monrovia' => 'Africa/Monrovia',
            '(UTC+00:00) UTC' => 'UTC',
            '(UTC+01:00) Amsterdam' => 'Europe/Amsterdam',
            '(UTC+01:00) Belgrade' => 'Europe/Belgrade',
            '(UTC+01:00) Berlin' => 'Europe/Berlin',
            '(UTC+01:00) Bern' => 'Europe/Berlin',
            '(UTC+01:00) Bratislava' => 'Europe/Bratislava',
            '(UTC+01:00) Brussels' => 'Europe/Brussels',
            '(UTC+01:00) Budapest' => 'Europe/Budapest',
            '(UTC+01:00) Copenhagen' => 'Europe/Copenhagen',
            '(UTC+01:00) Ljubljana' => 'Europe/Ljubljana',
            '(UTC+01:00) Madrid' => 'Europe/Madrid',
            '(UTC+01:00) Paris' => 'Europe/Paris',
            '(UTC+01:00) Prague' => 'Europe/Prague',
            '(UTC+01:00) Rome' => 'Europe/Rome',
            '(UTC+01:00) Sarajevo' => 'Europe/Sarajevo',
            '(UTC+01:00) Skopje' => 'Europe/Skopje',
            '(UTC+01:00) Stockholm' => 'Europe/Stockholm',
            '(UTC+01:00) Vienna' => 'Europe/Vienna',
            '(UTC+01:00) Warsaw' => 'Europe/Warsaw',
            '(UTC+01:00) West Central Africa' => 'Africa/Lagos',
            '(UTC+01:00) Zagreb' => 'Europe/Zagreb',
            '(UTC+02:00) Athens' => 'Europe/Athens',
            '(UTC+02:00) Bucharest' => 'Europe/Bucharest',
            '(UTC+02:00) Cairo' => 'Africa/Cairo',
            '(UTC+02:00) Harare' => 'Africa/Harare',
            '(UTC+02:00) Helsinki' => 'Europe/Helsinki',
            '(UTC+02:00) Istanbul' => 'Europe/Istanbul',
            '(UTC+02:00) Jerusalem' => 'Asia/Jerusalem',
            '(UTC+02:00) Kyiv' => 'Europe/Helsinki',
            '(UTC+02:00) Pretoria' => 'Africa/Johannesburg',
            '(UTC+02:00) Riga' => 'Europe/Riga',
            '(UTC+02:00) Sofia' => 'Europe/Sofia',
            '(UTC+02:00) Tallinn' => 'Europe/Tallinn',
            '(UTC+02:00) Vilnius' => 'Europe/Vilnius',
            '(UTC+03:00) Baghdad' => 'Asia/Baghdad',
            '(UTC+03:00) Kuwait' => 'Asia/Kuwait',
            '(UTC+03:00) Minsk' => 'Europe/Minsk',
            '(UTC+03:00) Nairobi' => 'Africa/Nairobi',
            '(UTC+03:00) Riyadh' => 'Asia/Riyadh',
            '(UTC+03:00) Volgograd' => 'Europe/Volgograd',
            '(UTC+03:30) Tehran' => 'Asia/Tehran',
            '(UTC+04:00) Abu Dhabi' => 'Asia/Muscat',
            '(UTC+04:00) Baku' => 'Asia/Baku',
            '(UTC+04:00) Moscow' => 'Europe/Moscow',
            '(UTC+04:00) Muscat' => 'Asia/Muscat',
            '(UTC+04:00) St. Petersburg' => 'Europe/Moscow',
            '(UTC+04:00) Tbilisi' => 'Asia/Tbilisi',
            '(UTC+04:00) Yerevan' => 'Asia/Yerevan',
            '(UTC+04:30) Kabul' => 'Asia/Kabul',
            '(UTC+05:00) Islamabad' => 'Asia/Karachi',
            '(UTC+05:00) Karachi' => 'Asia/Karachi',
            '(UTC+05:00) Tashkent' => 'Asia/Tashkent',
            '(UTC+05:30) Chennai' => 'Asia/Calcutta',
            '(UTC+05:30) Kolkata' => 'Asia/Kolkata',
            '(UTC+05:30) Mumbai' => 'Asia/Calcutta',
            '(UTC+05:30) New Delhi' => 'Asia/Calcutta',
            '(UTC+05:30) Sri Jayawardenepura' => 'Asia/Calcutta',
            '(UTC+05:45) Kathmandu' => 'Asia/Katmandu',
            '(UTC+06:00) Almaty' => 'Asia/Almaty',
            '(UTC+06:00) Astana' => 'Asia/Dhaka',
            '(UTC+06:00) Dhaka' => 'Asia/Dhaka',
            '(UTC+06:00) Ekaterinburg' => 'Asia/Yekaterinburg',
            '(UTC+06:30) Rangoon' => 'Asia/Rangoon',
            '(UTC+07:00) Bangkok' => 'Asia/Bangkok',
            '(UTC+07:00) Hanoi' => 'Asia/Bangkok',
            '(UTC+07:00) Jakarta' => 'Asia/Jakarta',
            '(UTC+07:00) Novosibirsk' => 'Asia/Novosibirsk',
            '(UTC+08:00) Beijing' => 'Asia/Hong_Kong',
            '(UTC+08:00) Chongqing' => 'Asia/Chongqing',
            '(UTC+08:00) Hong Kong' => 'Asia/Hong_Kong',
            '(UTC+08:00) Krasnoyarsk' => 'Asia/Krasnoyarsk',
            '(UTC+08:00) Kuala Lumpur' => 'Asia/Kuala_Lumpur',
            '(UTC+08:00) Perth' => 'Australia/Perth',
            '(UTC+08:00) Singapore' => 'Asia/Singapore',
            '(UTC+08:00) Taipei' => 'Asia/Taipei',
            '(UTC+08:00) Ulaan Bataar' => 'Asia/Ulan_Bator',
            '(UTC+08:00) Urumqi' => 'Asia/Urumqi',
            '(UTC+09:00) Irkutsk' => 'Asia/Irkutsk',
            '(UTC+09:00) Osaka' => 'Asia/Tokyo',
            '(UTC+09:00) Sapporo' => 'Asia/Tokyo',
            '(UTC+09:00) Seoul' => 'Asia/Seoul',
            '(UTC+09:00) Tokyo' => 'Asia/Tokyo',
            '(UTC+09:30) Adelaide' => 'Australia/Adelaide',
            '(UTC+09:30) Darwin' => 'Australia/Darwin',
            '(UTC+10:00) Brisbane' => 'Australia/Brisbane',
            '(UTC+10:00) Canberra' => 'Australia/Canberra',
            '(UTC+10:00) Guam' => 'Pacific/Guam',
            '(UTC+10:00) Hobart' => 'Australia/Hobart',
            '(UTC+10:00) Melbourne' => 'Australia/Melbourne',
            '(UTC+10:00) Port Moresby' => 'Pacific/Port_Moresby',
            '(UTC+10:00) Sydney' => 'Australia/Sydney',
            '(UTC+10:00) Yakutsk' => 'Asia/Yakutsk',
            '(UTC+11:00) Vladivostok' => 'Asia/Vladivostok',
            '(UTC+12:00) Auckland' => 'Pacific/Auckland',
            '(UTC+12:00) Fiji' => 'Pacific/Fiji',
            '(UTC+12:00) International Date Line West' => 'Pacific/Kwajalein',
            '(UTC+12:00) Kamchatka' => 'Asia/Kamchatka',
            '(UTC+12:00) Magadan' => 'Asia/Magadan',
            '(UTC+12:00) Marshall Is.' => 'Pacific/Fiji',
            '(UTC+12:00) New Caledonia' => 'Asia/Magadan',
            '(UTC+12:00) Solomon Is.' => 'Asia/Magadan',
            '(UTC+12:00) Wellington' => 'Pacific/Auckland',
            '(UTC+13:00) Nuku\'alofa' => 'Pacific/Tongatapu'
        );
    }
    
    /**
     * Format file sizes
     *
     * @param  int  $bytes
     * @return string
     */
    public static function formatsize($bytes)
    {
            if ($bytes >= 1073741824)
            {
                $bytes = Lang::get('general.sizes.gigabytes', array('size' => number_format($bytes / 1073741824, 2)));
            }
            elseif ($bytes >= 1048576)
            {
                $bytes = Lang::get('general.sizes.megabytes', array('size' => number_format($bytes / 1048576, 2)));
            }
            elseif ($bytes >= 1024)
            {
                $bytes = Lang::get('general.sizes.kilobytes', array('size' => number_format($bytes / 1024, 2)));
            }
            elseif ($bytes > 1)
            {
                $bytes = Lang::choice('general.sizes.bytes', $bytes, array('size' => $bytes));
            }
            elseif ($bytes == 1)
            {
                $bytes = Lang::choice('general.sizes.bytes', $bytes, array('size' => $bytes));
            }
            else
            {
                $bytes = Lang::get('general.sizes.bytes', array('size' => 0));
            }

            return $bytes;
    }

    /**
     * Provide a file path to ArchiveController
     *
     * @param  string  $path
     * @return void
     */
    public static function file_path($path = DIRECTORY_SEPARATOR)
    {
        return base_path().DIRECTORY_SEPARATOR.'files'.DIRECTORY_SEPARATOR.Auth::user()->id.$path;
    }

    /**
     * Provide a user path to ArchiveController
     *
     * @param  string  $path
     * @return void
     */
    public static function user_path($path = DIRECTORY_SEPARATOR)
    {
        return DIRECTORY_SEPARATOR.Auth::user()->id.$path;
    }

    /**
     * Generate a formatted file path to use in ArchiveController
     *
     * @param  string  $path
     * @return void
     */
    public static function share_format($file, $name)
    {
        //Get file info
        $pathinfo = pathinfo($file);
        //Separate file path
        $ex = explode(DIRECTORY_SEPARATOR.Auth::user()->id.DIRECTORY_SEPARATOR, $pathinfo['dirname']);
        //Verify if the index exists, if exists return formatted path or name of file
        $fpath = array_key_exists(1, $ex)  ? DIRECTORY_SEPARATOR.$ex[1].DIRECTORY_SEPARATOR.$name : DIRECTORY_SEPARATOR.$name;
        //Return the share path
        return $fpath;
    }

    /**
     * Traverses the folder informed and 
     * removes all subfolders and files in that folder.
     *
     * @param  string  $dir
     * @return void
     */
    public static function remove_dir($dir) {
       if (is_dir($dir)) {
         $objects = scandir($dir);
         foreach ($objects as $object) {
           if ($object != "." && $object != "..") {
             if (filetype($dir."/".$object) == "dir") rmdir($dir."/".$object); else unlink($dir."/".$object);
           }
         }
         reset($objects);
         rmdir($dir);
       }
     }

    /**
     * Format title of page, from Settings
     *
     * @param  boolean  $only
     * @return string
     */
     public static function title($only = FALSE)
     {
        //Get Settings
        $livbox = Setting::all()->first();
        //Verify if it require a full title
        if($only === FALSE)
        {
            //If description is not empty return title + description
            if(!empty($livbox->description))
            {
                return $livbox->title.' - '.$livbox->description;
            }
            else
            {
                return $livbox->title;
            }
        }
        else
        {
            return $livbox->title;
        }
     }

    /**
     * Provide a role name of user
     *
     * @param  int  $role
     * @return string
     */
     public static function role_name($role = NULL)
     {
        $role_number = $role == NULL ? Auth::user()->role : $role;

        switch ($role_number) {
            case 0:
                return Lang::get('general.roles.admin');
                break;
            case 1:
                return Lang::get('general.roles.manager');
                break;
            case 2:
                return Lang::get('general.roles.user');
                break;
            
            default:
                return Lang::get('general.roles.unknow');
                break;
        }
     }

    /**
     * Provide the last user login
     *
     * @param  DateTime  $time
     * @return string
     */
     public static function last_login($time = NULL)
     {
        if($time == NULL)
        {
            return date('Y/m/d H:m:s', strtotime(Auth::user()->last_login));
        }
        else
        {
            return date('Y/m/d H:m:s', strtotime($time));
        }
     }

    /**
     * Provide the last user activity
     *
     * @param  int  $time
     * @return string
     */
     public static function last_activity($time = NULL)
     {
        //If time is null, use the last record activity
        if($time == NULL)
        {
            return Helpers::time_format(Auth::user()->last_activity);
        }
        else
        {
            return Helpers::time_format($time);
        }
     }

    /**
     * Provide the actived option
     *
     * @param  string  $value1
     * @param  string  $value2
     * @return string
     */
     public static function is_active($value1, $value2)
     {
        //Verify if value1 is equals to value2
        if($value1 == $value2)
            return 'selected="selected"';
     }

    /**
     * Require specific role to perform some action.
     *
     * @param  int  $role
     * @return string
     */
     public static function required($role)
     {
        //Verify if user role equals to required role
        if(Auth::user()->role == $role)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

}