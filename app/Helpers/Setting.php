<?php

namespace App\Helpers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class Setting
{
    private $url;
    private $username;
    private $password;
    public $act;

    public function getToken()
    {
        // contoh URL
        // $this->url = 'http://36.89.57.228/ws/live2.php?=&=';
        $this->url = 'http://localhost:3003/ws/sandbox2.php';
        // $this->url = 'https://neo.tipdiaknpky.com/ws/live2.php';

        // dapatkan token
        try {
            $response = Http::withoutVerifying()->timeout(10)->retry(1, 100)->post(
                $this->url,
                [
                    'act' => 'GetToken',
                    'username' => 'upttipdiaknpky@gmail.com',
                    'password' => '177K@limantan'
                ]
            );
            return $response->json();
        } catch (\Exception $e) {
            // jika koneksi gagal, token gagal
            $error_message = ([
                'error_message' => "Connection Refused - Kemungkinan Neo Feeder Tidak Menyala atau Salah Port atau Koneksi Internet Anda Terputus",
                'error_code' => substr($e, 0, 300),
                'ringkasan' => $e->getLine()
            ]);
            session('error_feeder', $error_message['error_message']);
            return $error_message;
        }
    }

    // fungsi untuk import data
    public function postData($act, $record)
    {
        $getToken = $this->getToken();
        // return json_encode($getToken);
        $getToken = $getToken['data']['token'];
        $datapost = [
            'act' => $act,
            'token' => $getToken,
            'record' => $record
        ];
        $response = Http::withoutVerifying()->timeout(10)->retry(3, 100)->post($this->url, $datapost);
        return $response->json();
    }

    public function updateData($act, $key, $record)
    {
        $getToken = $this->getToken();
        // return json_encode($getToken);
        $getToken = $getToken['data']['token'];
        $datapost = [
            'act' => $act,
            'key' => $key,
            'token' => $getToken,
            'record' => $record
        ];
        $response = Http::withoutVerifying()->timeout(10)->retry(3, 100)->post($this->url, $datapost);
        return $response->json();
    }

    public function deleteData($act, $key)
    {
        $getToken = $this->getToken();
        // return json_encode($getToken);
        $getToken = $getToken['data']['token'];
        $datapost = [
            'act' => $act,
            'key' => $key,
            'token' => $getToken
        ];
        $response = Http::withoutVerifying()->timeout(10)->retry(3, 100)->post($this->url, $datapost);
        return $response->json();
    }


    // fungsi untuk dapatkan data dari neoFeeder
    public function getData($act, $limit = null, $filter = null)
    {
        $getToken = $this->getToken();
        if ($getToken['error_code'] != 0) {
            return $getToken;
        } else {
            $token = $getToken['data']['token'];
            $this->act['act'] = $act;
            $this->act['token'] = $token;
            $this->act['limit'] = $limit;
            $this->act['filter'] = $filter;
            $response = Http::withoutVerifying()->timeout(10)->retry(3, 100)->post($this->url, $this->act);
            return $response->json();
        }
    }

    public function getTokenUser($url, $username, $password)
    {
        try {
            $response = Http::withoutVerifying()->timeout(10)->retry(3, 100)->post(
                $url,
                [
                    'act' => 'GetToken',
                    'username' => $username,
                    'password' => $password
                ]
            );
            return $response->json();
        } catch (\Exception $e) {
            $error_message = ([
                'error_message' => "Connection Refused - Kemungkinan Neo Feeder Tidak Menyala atau Salah Port atau Koneksi Internet Anda Terputus",
                'error_code' => substr($e, 0, 300),
                'ringkasan' => $e
            ]);
            return $error_message;
        }
    }

    public function getDataUser($email)
    {
        $user = User::where('email', $email)->first();
        $password = Crypt::decryptString($user->feederpass);
        $token = $this->getTokenUser($user->feederurl, $user->kodept, $password);
        // return $token;
        if ($token['error_code'] == 0) {
            $token =  $token['data']['token'];
            $response = Http::withoutVerifying()->timeout(10)->retry(3, 100)->post(
                $user->feederurl,
                [
                    'act' => 'GetProfilPT',
                    'token' => $token,
                    'limit' => 5
                ]
            );
            return $response->json();
        } else {
            $response = $token;
            return $response;
        }
    }
}
