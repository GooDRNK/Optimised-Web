<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use Redirect;
use Pusher;
use Response;
use App\PC;
use App\Logs;
use App\Reports;
class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','IsVerified']);
    }
    public function logs()
    {
        $logs=Logs::where('idcont',Auth::user()->id)->where('email',Auth::user()->email)->get();
        return Response::json($logs);
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
    public function DeleteLogs(Request $req)
    {
        $id=$req->input('id');
        if(Logs::where("iduser",$id)->where("email",Auth::user()->email)->where("idcont",Auth::user()->id)->exists())
        {
            Logs::where("iduser",$id)->where("email",Auth::user()->email)->where("idcont",Auth::user()->id)->delete();
            return json_encode(['status' => 'success', 'msg' => "The logs was deleted."]);
        }
        return json_encode(['status' => 'fail', 'msg' => "The logs wasn't deleted."]);
    }
    public function fixedreports(Request $req)
    {
        $id=$req->input('id');
        if(Reports::where("id",$id)->where("email",Auth::user()->email)->where("idcont",Auth::user()->id)->exists())
        {
            Reports::where("id",$id)->where("email",Auth::user()->email)->where("idcont",Auth::user()->id)->delete();
            return json_encode(['status' => 'success', 'msg' => "The report was fixed."]);
        }
        return json_encode(['status' => 'fail', 'msg' => "The report wasn't fixed."]);
    }  
    public function closeproc(Request $req)
    {
        $nume=$req->input('statie');
        $pid=$req->input('PID');
        $id=$req->input('id');
        $key=$req->input('key');  
        $time=HomeController::GetLastDate();
        if(PC::where('idcont',Auth::user()->id)->where('email',Auth::user()->email)->where('last_online','>',$time)->where('id',$id)->doesntExist())
        {
            return json_encode(['status' => 'fail', 'msg' => "User $nume is not online."]);
        }
        $data["pid"]=$pid;   
        HomeController::Pushers($data,strval($key),strval($key."closeproc"));
        return json_encode(['status' => 'success', 'msg' => "Action will sent to user $nume."]);
       
    }
    public function index()
    {
        return view('home',['idcont'=>Auth::user()->id,'email'=>Auth::user()->email]);
    }
    static function quickRandom($length = 60)
    {
        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    
        return substr(str_shuffle(str_repeat($pool, $length)), 0, $length);
    }
    public function GetLastDate()
    {
        $datelast = time()-30;
        $datetimeFormat = 'Y-m-d H:i:s';
        $datee = new \DateTime();
        $datee->setTimestamp($datelast);
        $datee->format($datetimeFormat);
        return $datee;
    }
    public function GetUsers()
    {
        $time=HomeController::GetLastDate();
        $users=PC::where('idcont',Auth::user()->id)->where('email',Auth::user()->email)->orderBy('last_online','desc')->get();
        foreach($users as $index=>$user)
        {
            $logs=Logs::where('idcont',Auth::user()->id)->where('email',Auth::user()->email)->where('iduser',$user["id"])->get();
            $reports=Reports::where('idcont',Auth::user()->id)->where('email',Auth::user()->email)->where('key',$user["key"])->get();
            
            $user['logs']=$logs;
            $user['reports']=$reports;
            $users[$index]=$user;
        }
        $data["users"]=$users;
        $data["online"]=PC::where('idcont',Auth::user()->id)->where('email',Auth::user()->email)->where('last_online','>',$time)->count();
        $data["count"]=PC::where('idcont',Auth::user()->id)->where('email',Auth::user()->email)->count();
        return Response::json($data);
    }
    public function addPC(Request $request)
    {
        $name = $request->input('nume');
        $key = HomeController::quickRandom(30);
        if(PC::where('statie',$name)->where('idcont', Auth::user()->id)->exists())
        {
         return json_encode(['status' => 'fail', 'msg' => "The name: " .$name." is already used."]);
        }
        else
        {  
        PC::insert(array('statie' => $name, 'key' => $key, 'idcont' => Auth::user()->id,'email' => Auth::user()->email));
        return json_encode(['status' => 'success', 'msg' => "The account: " .$name." has been successfully added."]);
        }
    }
    public function deletePC(Request $req)
    {  
        if(PC::where('idcont', Auth::user()->id)->where('id', $req->input('id'))->where('email',Auth::user()->email)->where('key',$req->input('key'))->exists())
        {
            PC::where('idcont', Auth::user()->id)->where('id', $req->input('id'))->where('email',Auth::user()->email)->where('key',$req->input('key'))->delete();
            Logs::where('idcont', Auth::user()->id)->where('iduser', $req->input('id'))->where('email',Auth::user()->email)->delete();
            $name = $req->input('nume');
            $count = PC::where('idcont',Auth::user()->id)->count();
            return json_encode(['status' => 'success', 'msg' => "The account: $name has been successfully deleted. Now you have $count account/s."]);
        }
        else
        { 
            $name = $req->input('nume');
            return json_encode(['status' => 'fail', 'msg' => "The user: $name is not in your account."]);
        }
       
    
    }
    public function sendAction(Request $request)
    {
       
        $time=HomeController::GetLastDate();
        $count = PC::where('idcont',Auth::user()->id)->where('email',Auth::user()->email)->where('last_online','>',$time)->count();
        if($count==0)
        {
            return json_encode(['status' => 'fail', 'msg' => "Action can not be sent, users are offline."]);
        }
        else
        {
            $data["action"]=$request->input("action");
            HomeController::Pushers($data,strval(Auth::user()->id.Auth::user()->email),"ActionWindows");
            return json_encode(['status' => 'succes', 'msg' => "The action will sent to $count online users."]);
        }
    }
    public function sendActionOnly(Request $request)
    {
        $key = $request->input('key');
        $id = $request->input('id');
        $nume = $request->input('nume');
        $time=HomeController::GetLastDate();
        if(PC::where('idcont',Auth::user()->id)->where('email',Auth::user()->email)->where('last_online','>',$time)->where('id',$id)->doesntExist())
        {
            return json_encode(['status' => 'fail', 'msg' => "User $nume is not online."]);
          
        }
        $data["action"]=$request->input("action");
        HomeController::Pushers($data,strval($key),strval($key."ActionWindows"));
        return json_encode(['status' => 'succes', 'msg' => "Action will sent to user $nume."]);
    
    }
    public function openWeb(Request $request)
    {
        $web = $request->input('url');
        if (filter_var($web, FILTER_VALIDATE_URL)) 
        {
            $time=HomeController::GetLastDate();
            $count = PC::where('idcont',Auth::user()->id)->where('email',Auth::user()->email)->where('last_online','>',$time)->count();
            if($count==0)
            {   
                return json_encode(['status' => 'fail', 'msg' => "Action can not be sent, users are offline."]);  
            }
            $data["url"]=$web;
            HomeController::Pushers($data,strval(Auth::user()->id.Auth::user()->email),strval("OpenURL"));
            return json_encode(['status' => 'succes', 'msg' => "The website will open for $count online users."]);
        }
        else
        {
            return json_encode(['status' => 'fail', 'msg' => "Address entered is invalid."]);
        }
        
    }
    public function openWebOnly(Request $request)
    {
        $web = $request->input('url');
        $id = $request->input('id');
        $nume = $request->input('nume');
        $key = $request->input('key');
        if (filter_var($web, FILTER_VALIDATE_URL)) 
        {
        $time=HomeController::GetLastDate();
        if(PC::where('idcont',Auth::user()->id)->where('email',Auth::user()->email)->where('last_online','>',$time)->where('id',$id)->doesntExist())
        {
            return json_encode(['status' => 'fail', 'msg' => "Username $nume is not online."]);
        }
        $data["url"]=$web;
        HomeController::Pushers($data,strval($key),strval($key."OpenURL"));
        return json_encode(['status' => 'succes', 'msg' => "The website will open for $nume."]);
        }
        else
        {
            return json_encode(['status' => 'fail', 'msg' => "Address entered is invalid."]);
        }
        
    }
    public function senddata(Request $request)
    {
        $data = $request->input('data');
        $datelast = time()-30;
        $datetimeFormat = 'Y-m-d H:i:s';
        $datee = new \DateTime();
        $datee->setTimestamp($datelast);
        $datee->format($datetimeFormat);
        $count = PC::where('idcont',Auth::user()->id)->where('email',Auth::user()->email)->where('last_online','>',$datee)->count();
        if($count==0)
        {
            return json_encode(['status' => 'fail', 'msg' => "Action can not be sent, users are offline."]);
        }
        HomeController::Pushers($data,strval(Auth::user()->id.Auth::user()->email),strval("CleanSystem"));
        return json_encode(['status' => 'succes', 'msg' => "Action will sent to $count online users."]);
    }
    public function senddataonly(Request $request)
    {
        $data = $request->input('data');
        $id = $request->input('id');
        $key = $request->input('key');
        $statie = $request->input('nume');
        $time = HomeController::GetLastDate();
        if(PC::where('key',$key)->where('idcont',Auth::user()->id)->where('id',$id)->where('email',Auth::user()->email)->where('last_online','>',$time)->doesntExist())
        {
            return json_encode(['status' => 'fail', 'msg' => "Username $statie is not online."]);
        }
        HomeController::Pushers($data,strval($key),strval($key."CleanSystem"));
        return json_encode(['status' => 'succes', 'msg' => "Action will sent to $statie!"]);
    }
}
