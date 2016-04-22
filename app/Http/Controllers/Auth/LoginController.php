<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    public function index() {    
        if(!Session::has("auth")) return view('welcome');

        $url = env('API_SERVER')."users/0&1000";
        // $url = "http://188.166.44.121/api/users/0&1000";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // curl_setopt($ch, CURLOPT_HEADER, 1);
        $output = curl_exec($ch);
        $result = curl_getinfo($ch);
        curl_close($ch);

        $jsonUsers = json_decode($output);
        $username=""; 
        $firstName=""; 
        $secondName="";

        foreach ($jsonUsers as $key => $value) {
            if( Session::get('username') == $value->email ) {
                $username = $value->username;
                $firstName = $value->firstName;
                $secondName = $value->secondName;
            }
        }

        return view('main')
        ->with("users",$jsonUsers)
        ->with("username",$username)
        ->with("firstName",$firstName)
        ->with("secondName",$secondName)
        ;
    }


    public function login() {    
        $login = Input::get("login");
        $pass = Input::get("pass");

        $url = env('API_SERVER')."auth/".$login."&".$pass;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        $output = curl_exec($ch);
        $result = curl_getinfo($ch);
        curl_close($ch);

        $response = new Response($result['http_code']);

        if($result['http_code'] == 200) {

            Session::put('username',$login);

            preg_match_all('/^Set-Cookie:\s*([^;]*)/mi', $output, $matches);
            $cookie = explode("=", $matches[0][0]);
            $response->withCookie(cookie("connect.sid", $cookie[1], 60));
            Session::put("auth",$cookie[1]);
            return $response;
        }

        return $result['http_code'];
    }

    public function logout() {
        Session::forget('auth');
        Session::forget('username');
        return redirect('/');
    }

    public function register() {

        $sponsor = Input::get("sponsor");
        $fname = Input::get("fname");
        $sname = Input::get("sname");
        $email = Input::get("email");
        $username = Input::get("username");
        $phone = Input::get("phone");
        $skype = Input::get("skype");
        $country = Input::get("country");
        $password = Input::get("password");
        $finPassword = Input::get("finPassword");

        $url = env('API_SERVER')."user/";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        




        curl_setopt($ch, CURLOPT_POSTFIELDS,
            "sponsor=".$sponsor."&".
            "fname=".$fname."&".
            "sname=".$sname."&".
            "email=".$email."&".
            "username=".$username."&".
            "phone=".$phone."&".
            "skype=".$skype."&".
            "country=".$country."&".
            "password=".$password."&".
            "finPassword=".$finPassword);

        curl_setopt($ch, CURLOPT_NOBODY, 1);

        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_POST, true);
        $output = curl_exec($ch);
        $result = curl_getinfo($ch);
        curl_close($ch);

        // var_dump($result);
        // var_dump($output);

        if( $result['http_code'] == 200 ) {
            Session::put('auth', 1);
            Session::put('username', $email);
        }

        return $result['http_code'];
    }

}
