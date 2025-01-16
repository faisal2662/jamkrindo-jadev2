<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Exception;
use Log;

class SunfishController extends Controller
{   
    public static function loginUser($username, $password, $url = 'https://sf7dev-pro.dataon.com/sfpro')
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $url.'/?ofid=sfSystem.loginUser&originapp=helpdesk_jamkrindo',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode([
                'USERPWD' => UtilController::sha1GetHash($password, $username),
                'USERNAME' => $username,
                'ACCNAME' => 'jamkrindo',
                'TIMESTAMP' => UtilController::generateDateTime(),
            ]),
            CURLOPT_HTTPHEADER => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ]
        ]);

        $response = curl_exec($curl);
        
        $data = json_decode($response);
        
        $errorMessage = null;
        if (curl_errno($curl)) {
            $errorMessage = curl_error($curl);
        }

        curl_close($curl);
        
        if (!is_null($errorMessage)) {
            Log::error($errorMessage);
            throw new Exception($errorMessage);
        }
        
        if (is_null($data)) {
            throw new Exception('NPP atau Password Salah.');
        }

        if ($data->STATUS == false) {
            throw new Exception($data->MESSAGE);
        }
        
        return $data;
    }
}
