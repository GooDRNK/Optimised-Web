<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use Redirect;
use Carbon;
class LoginController extends Controller
{
    public function test($req)
    {
        $v = json_decode($req,true);
        return $req;
        return $v['ID'];
    }
    function quickRandom($length = 60)
    {
        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    
        return substr(str_shuffle(str_repeat($pool, $length)), 0, $length);
    }

    public function login($user,$mail,$pass)
    {
        
        $check = DB::table('elevi')->where('statie',$user)->where('pass',$pass)->where('email',$mail)->get();
        $cont = 0;
        $token;
        foreach($check as $checked)
        {
            $cont++;
        }
        if($cont==1)
        {
            $date = DB::table('elevi')->where('statie',$user)->where('pass',$pass)->where('email',$mail)->first();
       
            if($date->last_login != null)
            {
                $date1 = time();
                $date1Timestamp = $date1;
                $date2Timestamp = strtotime($date->last_login);
                $difference = $date1Timestamp - $date2Timestamp;
                if($difference > 20)
                {
                    $token = LoginController::quickRandom(60);
                    $mytime = Carbon\Carbon::now();
                    DB::table('elevi')->where('statie',$user)->where('pass',$pass)->where('email',$mail)->update(['token' => $token,'last_login' => $mytime->toDateTimeString(),'last_online'=> $mytime->toDateTimeString()]);
                    return $token;
                }
                else
                {
                    return "Cineva este deja logat pe acest cont.";
                }
            }
            else
            {
                $token = LoginController::quickRandom(60);
                $mytime = Carbon\Carbon::now();
                DB::table('elevi')->where('statie',$user)->where('pass',$pass)->where('email',$mail)->update(['token' => $token,'last_login' => $mytime->toDateTimeString(),'last_online'=> $mytime->toDateTimeString()]);
                return $token;
            }
        }
        else
        {
            return "Acest cont nu este inregistrat.";
        }
    }
    public function CheckLogin($user,$mail,$pass,$token)
    {
        $check = DB::table('elevi')->where('statie',$user)->where('pass',$pass)->where('email',$mail)->where('token',$token)->get();
        $cont = 0;
        foreach($check as $checked)
        {
            $cont++;
        }
        if($cont==1)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    public function updateonline($user,$mail,$pass,$token)
    {
        $check = DB::table('elevi')->where('statie',$user)->where('pass',$pass)->where('email',$mail)->where('token',$token)->get();
        $cont = 0;
        foreach($check as $checked)
        {
            $cont++;
        }
        if($cont==1)
        {
            $mytime = Carbon\Carbon::now();
            DB::table('elevi')->where('statie',$user)->where('pass',$pass)->where('email',$mail)->where('token',$token)->update(['last_online' => $mytime->toDateTimeString()]);
            return 0;
        }
        else
        {
            return 0;
        }
    }
    public function getwebstart($user,$mail,$pass,$token,$id)
    {
    
            $check = DB::table('elevi')->where('statie',$user)->where('pass',$pass)->where('email',$mail)->where('token',$token)->get();
            $cont = 0;
            foreach($check as $checked)
            {
                $cont++;
            }
            if($cont==1)
            {
                $var = DB::table('elevi')->where('statie',$user)->where('pass',$pass)->where('email',$mail)->where('token',$token)->first();
                $obj = json_decode($var->openweb);
            if($id=="0")
            {
                if($obj->{'status'}==1)
                {
                    return 1;
                }
                else
                {
                    return NULL;
                }
            }
            else if($id=="1")
            {
                if($obj->{'status'}==1)
                {
                    
                    DB::table('elevi')->where('statie',$user)->where('pass',$pass)->where('email',$mail)->where('token',$token)->update(['openweb->status'=>0]);
                    return $obj->{'web'};
                }
                else
                {
                    return NULL;
                }
            }
            else
            {
                return NULL;
            }
        }
        else
        {
            $status = array('status'=>0);
            return $status;
        }
    }
    public function optsistem($user,$mail,$pass,$token,$id)
    {
        if(LoginController::CheckLogin($user,$mail,$pass,$token))
        {

            $var = DB::table('elevi')->where('statie',$user)->where('pass',$pass)->where('email',$mail)->where('token',$token)->first();
            $obj = json_decode($var->sistemopt);
            if($id=="0")
            {
                if($obj->{'status'}==1)
                {
                    return 1;
                }
                else
                {
                    return NULL;
                }
            }
            else
            {
                if($obj->{'status'}==1)
                {
                    DB::table('elevi')->where('statie',$user)->where('pass',$pass)->where('email',$mail)->where('token',$token)->update(['sistemopt->status'=>0]);
                    return $obj->{'action'};
                }
                else
                {
                    return NULL;
                }
            }
        }
        else
        {
            $status = array('status'=>0);
            return $status;
        }
    }
    public function getoptall($user,$mail,$pass,$token,$id)
    {
        if(LoginController::CheckLogin($user,$mail,$pass,$token))
        {

            $var = DB::table('elevi')->where('statie',$user)->where('pass',$pass)->where('email',$mail)->where('token',$token)->first();
            $obj = json_decode($var->tools);
            if($id=="0")
            {
                if($obj->{'status'}==1)
                {
                    return 1;
                }
                else
                {
                    return NULL;
                }
            }
            else
            {
                if($obj->{'status'}==1)
                {
                    DB::table('elevi')->where('statie',$user)->where('pass',$pass)->where('email',$mail)->where('token',$token)->update(['tools->status'=>0]);
                    return $var->tools;
                }
                else
                {
                    return NULL;
                }
            }
        }
        else
        {
            $status = array('status'=>0);
            return $status;
        }
    }
    public function getoptonly($user,$mail,$pass,$token,$id)
    {
        if(LoginController::CheckLogin($user,$mail,$pass,$token))
        {

            $var = DB::table('elevi')->where('statie',$user)->where('pass',$pass)->where('email',$mail)->where('token',$token)->first();
            $obj = json_decode($var->sistemoptonly);
            if($id=="0")
            {
                if($obj->{'status'}==1)
                {
                    return 1;
                }
                else
                {
                    return 0;
                }
            }
            else
            {
                if($obj->{'status'}==1)
                {
                    DB::table('elevi')->where('statie',$user)->where('pass',$pass)->where('email',$mail)->where('token',$token)->update(['sistemoptonly->status'=>0]);
                    return $var->sistemoptonly;
                }
                else
                {
                    return 0;
                }
            }
        }
        else
        {
            $status = array('status'=>0);
            return $status;
        }
    }
}
