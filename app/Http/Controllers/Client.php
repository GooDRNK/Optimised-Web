<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use Redirect;
use Carbon;
use Pusher;
use App\PC;
use App\Logs;
use App\Reports;
class Client extends Controller
{
    function quickRandom($length = 60)
    {
        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    
        return substr(str_shuffle(str_repeat($pool, $length)), 0, $length);
    }
    public function setmainproc($key,$token,$pid,$hwnd,$proc)
    {
        if(Client::CheckLogin($key,$token))
        {
            $obj=['PID'=>$pid,'HWND'=>$hwnd,'PROC'=>$proc];
            $info = json_encode($obj);
              
            DB::table('elevi')->where('key',$key)->where('token',$token)->update(['proces'=>$info]);
            return "done";
        }
        return "log";
    }
    public function login($key)
    {
        
   
        if(DB::table('elevi')->where('key',$key)->exists())
        {
            $date = DB::table('elevi')->where('key',$key)->first();
       
            if($date->last_login != null)
            {
                $date1 = time();
                $date1Timestamp = $date1;
                $date2Timestamp = strtotime($date->last_login);
                $difference = $date1Timestamp - $date2Timestamp;
                if($difference > 20)
                {
                    $token = Client::quickRandom(60);
                    $mytime = Carbon\Carbon::now("Europe/Bucharest");
                    DB::table('elevi')->where('key',$key)->update(['token' => $token,'last_login' => $mytime->toDateTimeString(),'last_online'=> $mytime->toDateTimeString()]);
                    $data['token']=$token;
                    $data['id']=(PC::select('idcont')->where('key',$key)->first())->idcont;
                    $data['email']=(PC::select('email')->where('key',$key)->first())->email;
                    $data['statie']=(PC::select('statie')->where('key',$key)->first())->statie;
                    
                    return json_encode($data);
                }
                else
                {
                    $data['token']=null;
                    $data['error']="Cineva este deja logat pe acest cont.";
                    return json_encode($data);
                }
            }
            else
            {
                $token = Client::quickRandom(60);
                $mytime = Carbon\Carbon::now("Europe/Bucharest");
                DB::table('elevi')->where('key',$key)->update(['token' => $token,'last_login' => $mytime->toDateTimeString(),'last_online'=> $mytime->toDateTimeString()]);
                $data['token']=$token;
                $data['id']=PC::select('idcont')->where('key',$key)->first();
                $data['email']=PC::select('email')->where('key',$key)->first();
                $data['statie']=(PC::select('statie')->where('key',$key)->first())->statie;    
                return json_encode($data);
            }
        }
        else
        {
            $data['token']=null;
            $data['error']="Acest cont nu este inregistrat.";
            return json_encode($data);
       
        }
    }
    public function CheckLogin($key,$token)
    {
        
        return DB::table('elevi')->where('key',$key)->where('token',$token)->exists();
      
    }
    public function updateonline($key,$token)
    {
        if(Client::CheckLogin($key,$token))
        {
            $mytime = Carbon\Carbon::now("Europe/Bucharest");
            DB::table('elevi')->where('key',$key)->where('token',$token)->update(['last_online' => $mytime->toDateTimeString()]);
            return "Ai reusit!";
        }
    }
    public function setinfo($key,$token,$ip,$mac,$win,$localip)
    {
        
        if(Client::CheckLogin($key,$token))
        {
            if (filter_var($ip, FILTER_VALIDATE_IP) && filter_var($localip, FILTER_VALIDATE_IP)) 
            {
               $obj=['ip'=>$ip,'mac'=>$mac,'win'=>$win,'localip'=>$localip];
               
                $info = json_encode($obj);
              
                DB::table('elevi')->where('key',$key)->where('token',$token)->update(['info'=>$info]);
                return "Ai resusit!";
            }
            return "IP-ul nu este valid.";
        }   
        return "Nu esti logat.";
    }
    public function Notify($key,$token,$notify,$other=null)
    {
       
        if(Client::CheckLogin($key,$token))
        { 
            $msg["notify"]=null;
            $data = DB::table('elevi')->select("id","idcont","email","statie")->where('key',$key)->where('token',$token)->first();
            $msg["url"]=null;
            $msg["pid"]=null;
            switch($notify)
            {
                case "close":
                {
                    $msg["notify"]="The process was closed for ".$data->statie;
                    $msg["status"]="success";
                    $msg["key"]=$key;
                    $msg["id"]=$data->id;
                    $msg["pid"]=$other;
                    $msg["idcont"]=$data->idcont;
                    
                    break;
                }
                case "only":
                {
                    $msg["notify"]="Optimised was done for ".$data->statie;
                    $msg["status"]="success";
                    $msg["key"]=$key;
                    $msg["id"]=$data->id;
                    $msg["idcont"]=$data->idcont;
                    break;
                }
                case "all":
                {
                    $msg["notify"]="Optimised was done for ".$data->statie;
                    $msg["status"]="success";
                    $msg["key"]=$key;
                    $msg["id"]=$data->id;
                    $msg["idcont"]=$data->idcont;
                    break;
                }
                case "site":
                {
                    $msg["notify"]="The website was open for ".$data->statie;
                    $msg["status"]="success";
                    $msg["key"]=$key;
                    $msg["id"]=$data->id;
                    $msg["url"]=base64_decode($other);
                    $msg["idcont"]=$data->idcont;
                    break;
                }
                case "shutdown":
                {
                    $msg["notify"]="The ".$data->statie." was Shutdown";
                    $msg["status"]="success";
                    $msg["key"]=$key;
                    $msg["id"]=$data->id;
                    $msg["idcont"]=$data->idcont;
                    break;
                }
                case "restart":
                {
                    $msg["notify"]="The ".$data->statie." was Restart";
                    $msg["status"]="success";
                    $msg["key"]=$key;
                    $msg["id"]=$data->id;
                    $msg["idcont"]=$data->idcont;
                    break;
                }
            }
            Client::Pushers($msg,$data->idcont.$data->email,"Notify");
            $log = new Logs;
            $log->idcont=$data->idcont;
            $log->iduser=$data->id;
            $log->log=$msg["notify"];
            $log->email=$data->email;
            if($msg["url"]!=null){$log->url=$msg["url"];}
            if($msg["pid"]!=null){$log->pid=$msg["pid"];}
            $log->save();
            return "Success";
        }
        return "Fail";

    }
    private function Pushers($data,$channel,$event)
    {
        $options = array(
            'cluster' => 'eu',
            'encrypted' => true
          );
          $pusher = new Pusher\Pusher(
            'c322190b05b7b2265d64',
            'aff06d27814da72b7007',
            '385684',
            $options
          );
          $pusher->trigger($channel, $event, $data);
    }
    public function Report($key,$token,$id,$email,$nume,$mesaj)
    {
        if(Client::CheckLogin($key,$token))
        {
            $report = new Reports;
            $report->idcont=$id;
            $report->email=$email;
            $report->nume=$nume;
            $report->mesaj=$mesaj;
            $report->key=$key;
            $report->save();
        }
    }
}
