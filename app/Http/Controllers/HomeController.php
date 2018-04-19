<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use Redirect;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth','IsVerified']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = DB::table("elevi")->where('idcont', Auth::user()->id)->get();
        return view('home',['users' => $users]);
    }
    public function info()
    {
        $datelast = time()-50;
        $datetimeFormat = 'Y-m-d H:i:s';
        $datee = new \DateTime();
        $datee->setTimestamp($datelast);
        $datee->format($datetimeFormat);
        $countonline = DB::table('elevi')->where('idcont',Auth::user()->id)->where('email',Auth::user()->email)->where('last_online','>',$datee)->count();
        $count = DB::table('elevi')->where('idcont',Auth::user()->id)->where('email',Auth::user()->email)->count();
        return view('info',['count'=>$count,'counts'=>$countonline]);
    }
    public static function checkonline($date)
    {
        if((time() - ($date)) > 10)
        {
            return "Offline";
        }
        else
        {
            return "Online";
        }
    }
    public static function checklastlog($date,$id)
    {
        if((time() - ($date)) > 10)
        {
            $min = (time() - ($date));
            $datelast = time()-$min;
            $datetimeFormat = 'Y-m-d H:i:s';
            $datee = new \DateTime();
            $datee->setTimestamp($datelast);
            $datee->format($datetimeFormat);
            DB::table('elevi')->where('id',$id)->update(['last_logout' => $datee]);
            $dates = DB::table('elevi')->where('id',$id)->first();
            echo $dates->last_logout;
        }
        else
        {
 
            $dates = DB::table('elevi')->where('id',$id)->first();
            if($dates->last_logout!=NULL)
            echo $dates->last_logout;
            else
            echo "Neutilizat";
        }
    }
    public function addPC(Request $request)
    {
        $name = $request->input('nume');
        $pass = md5($request->input('pass'));
        $extract = DB::table('elevi')->where('statie',$name)->where('idcont', Auth::user()->id)->get();
        $connt=0;
        foreach($extract as $ex)
        {
           $connt++;
        }
        if($connt!=0)
        {
            return Redirect::back()->with('fail',"Numele: " .$name." este deja folosit.");
        }
        else
        {
        DB::table('elevi')->insert(array('statie' => $name, 'pass' => $pass, 'idcont' => Auth::user()->id,'email' => Auth::user()->email));
            return Redirect::back()->with('succes', "Contul: " .$name." a fost adaugat cu succes.");
        }
    }
    public function deletePC(Request $req)
    {  
        DB::table('elevi')->where('idcont', Auth::user()->id)->where('id', $req->input('delete'))->where('email',Auth::user()->email)->delete();
        $name = $req->input('nume');
        $count = DB::table('elevi')->where('idcont',Auth::user()->id)->count();
        return Redirect::back()->with('succes', "Contul: $name a fost sters cu succes.Mai aveti $count conturi.");
    }
    public function sendAction(Request $request)
    {
        $var = $request->except('_token');
        $datelast = time()-50;
        $datetimeFormat = 'Y-m-d H:i:s';
        $datee = new \DateTime();
        $datee->setTimestamp($datelast);
        $datee->format($datetimeFormat);
        $count = DB::table('elevi')->where('idcont',Auth::user()->id)->where('email',Auth::user()->email)->where('last_online','>',$datee)->count();
        if($count==0)
        {
            return Redirect::back()->with('fail',"Actiunea nu se poate trimite, utilizatorii sunt offline.");
        }
        else
        {

        DB::table('elevi')->where('idcont',Auth::user()->id)->where('email',Auth::user()->email)->where('last_online','>',$datee)->update(['sistemopt' => json_encode($var)]);
        return Redirect::back()->with('succes', "Actiunea a fost trimisa la $count utilizatori online.");
        }
    }
    public function sendActionOnly(Request $request)
    {
        $var = $request->except('_token','id','nume');
        $id = $request->input('id');
        $nume = $request->input('nume');
        $datelast = time()-50;
        $datetimeFormat = 'Y-m-d H:i:s';
        $datee = new \DateTime();
        $datee->setTimestamp($datelast);
        $datee->format($datetimeFormat);
        $count =  DB::table('elevi')->where('idcont',Auth::user()->id)->where('email',Auth::user()->email)->where('last_online','>',$datee)->where('id',$id)->count();
        if($count==0)
        {
            return Redirect::back()->with('fail',"Utilizatorul $nume nu este online.");
        }
        DB::table('elevi')->where('idcont',Auth::user()->id)->where('email',Auth::user()->email)->where('last_online','>',$datee)->where('id',$id)->update(['sistemopt' => json_encode($var)]);
        return Redirect::back()->with('succes', "Actiunea a fost trimisa utilizatorului $nume.");
    
    }
    public function openWeb(Request $request)
    {
        $var = $request->except('_token');
        $web = $request->input('web');
        if (filter_var($web, FILTER_VALIDATE_URL)) 
        {
        $datelast = time()-50;
        $datetimeFormat = 'Y-m-d H:i:s';
        $datee = new \DateTime();
        $datee->setTimestamp($datelast);
        $datee->format($datetimeFormat);
        $count = DB::table('elevi')->where('idcont',Auth::user()->id)->where('email',Auth::user()->email)->where('last_online','>',$datee)->count();
        if($count==0)
        {
            
            return Redirect::back()->with('fail',"Actiunea nu se poate trimite, utilizatorii sunt offline.");
        }
        DB::table('elevi')->where('idcont',Auth::user()->id)->where('email',Auth::user()->email)->where('last_online','>',$datee)->update(['openweb' => json_encode($var)]);
        return Redirect::back()->with('succes', "Site-ul web a fost deschis pentru $count utilizatorii online.");
        }
        else
        {
            return Redirect::back()->with('fail',"Adresa introdusa nu este valida.");
        }
        
    }
    public function openWebOnly(Request $request)
    {
        $var = $request->except('_token','id','nume');
        $web = $request->input('web');
        $id = $request->input('id');
        $nume = $request->input('nume');
        if (filter_var($web, FILTER_VALIDATE_URL)) 
        {
        $datelast = time()-50;
        $datetimeFormat = 'Y-m-d H:i:s';
        $datee = new \DateTime();
        $datee->setTimestamp($datelast);
        $datee->format($datetimeFormat);
        $count =  DB::table('elevi')->where('idcont',Auth::user()->id)->where('email',Auth::user()->email)->where('last_online','>',$datee)->where('id',$id)->count();
        if($count==0)
        {
            return Redirect::back()->with('fail',"Utilizatorul $nume nu este online.");
        }
        DB::table('elevi')->where('idcont',Auth::user()->id)->where('email',Auth::user()->email)->where('last_online','>',$datee)->where('id',$id)->update(['openweb' => json_encode($var)]);
        return Redirect::back()->with('succes', "Site-ul web a fost deschis pentru $nume.");
        }
        else
        {
            return Redirect::back()->with('fail',"Adresa introdusa nu este valida.");
        }
        
    }
    public function senddata(Request $request)
    {
        $var = $request->except('_token');
        $datelast = time()-50;
        $datetimeFormat = 'Y-m-d H:i:s';
        $datee = new \DateTime();
        $datee->setTimestamp($datelast);
        $datee->format($datetimeFormat);
        $count = DB::table('elevi')->where('idcont',Auth::user()->id)->where('email',Auth::user()->email)->where('last_online','>',$datee)->count();
        if($count==0)
        {
            
            return Redirect::back()->with('fail',"Actiunea nu se poate trimite, utilizatorii sunt offline.");
        }
        DB::table('elevi')->where('idcont',Auth::user()->id)->where('email',Auth::user()->email)->where('last_online','>',$datee)->update(['tools' => json_encode($var)]);
        return Redirect::back()->with('succes', "Actiunea a fost trimisa la $count utilizatori online.");
    }
    public function senddataonly(Request $request)
    {
        $var = $request->except(['_token','id','email','idcont','statie']);
        $id = $request->input('id');
        $email = $request->input('email');
        $idcont = $request->input('idcont');
        $statie = $request->input('statie');
        if(Auth::user()->id == $idcont && Auth::user()->email == $email)
        {
            $datelast = time()-50;
            $datetimeFormat = 'Y-m-d H:i:s';
            $datee = new \DateTime();
            $datee->setTimestamp($datelast);
            $datee->format($datetimeFormat);
            DB::table('elevi')->where('idcont',Auth::user()->id)->where('email',Auth::user()->email)->where('last_online','>',$datee)->update(['sistemoptonly' => json_encode($var)]);
            return Redirect::back()->with('succes', "Actiunea a fost trimisa la $statie!");
        }
        else
        {
            return Redirect::back()->with('fail', "Ceva este gresit la cererea de optimizare.");
        }
    }
}
