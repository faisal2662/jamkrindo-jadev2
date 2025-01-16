<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use DateTime;
use DateTimeZone;
use Validator;

class UtilController extends Controller
{
    public static function sha1Hash($string, $rawOutput = false)
    {
        return strtoupper(bin2hex(sha1($string, $rawOutput)));
    }
    
    public static function sha1GetHash($message, $salt = null, $iterator = 7)
    {
        if ($iterator == 0) {
            $stringMessage = self::sha1Hash($message, true);
            return implode('', [
                strrev(substr($stringMessage, 0, 4)),
                strrev(substr($stringMessage, 4, strlen($stringMessage) - 8)),
                strrev(substr($stringMessage, strlen($stringMessage) - 4, 4))
            ]);
        }

        if (is_null($salt)) {
            $salt = $message;
        } else if (count(explode(':', $salt)) > 0) {
            $salt = explode(':', $salt)[0];
        }

        $salt = strrev("5unf15h".$salt."D4740N");
        
        $stringMessage = self::sha1Hash($message.$salt, true);
        for ($i = 1; $i < $iterator; $i++) {
            $stringMessage = self::sha1Hash($stringMessage.$salt, true);
        }

        return $stringMessage;
    }

    public static function generateDateTime($timezone = 'Asia/Jakarta') {
        $dateTime = new DateTime('now', new DateTimeZone($timezone));
        return $dateTime->format('Y-m-d H:i:s P');
    }  
}
