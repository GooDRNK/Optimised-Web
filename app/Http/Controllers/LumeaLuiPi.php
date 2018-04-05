<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Storage;
class LumeaLuiPi extends Controller
{
    //
    public function login($pass,$user)
    {

        $log = DB::table('piuser')->where('pass',$pass)->where('user',$user)->count();
        if($log==1)
        {
            return 'Succes';
        }
        else
        {
            return 'Datele introduse nu se regasesc in baza de date!';
        }
    }
    public function register($email,$pass,$user)
    {
       
        $exist = DB::table('piuser')->where('user',$user)->count();
       
        if($exist==0)
        {
            DB::table('piuser')->insert(['user'=>$user,'pass'=>$pass,'mail'=>$email]);
            return "Contul a fost realizat cu succes.";
           
        }
        else
        {
            return "Exista deja un utilizator cu acest nume.";
        }
       
    }
    public function pil($len)
    {

        $contents = Storage::get('public/pi.txt');
        $rest = substr($contents, 0, $len+2);
        return $rest;
    }
    public function pi($nr)
    {

        $contents = Storage::get('public/pi.txt');
        $pos = strpos($contents, $nr);
        if($pos==null)
        {
            return "Nu am gasit";
        }
        return $pos;
    }
    public function GetIntr($pass,$user,$intr,$check)
    {
        $log = DB::table('piuser')->where('pass',$pass)->where('user',$user)->count();
        if($log==1)
        {
            if($check==0)
            {
            $intr = DB::table('quiz')->select('Intrebare')->where('ID',$intr)->first();
            return $intr->Intrebare;
            }
            else
            {
                $raspuns="Raspuns".$check;
                $rs = DB::table('quiz')->select($raspuns)->where(['ID'=>$intr])->first();
                if($check==1)
                {
                    return $rs->Raspuns1;
                }
                else if($check==2)
                {
                    return $rs->Raspuns2;
                }
                else
                {
                    return $rs->Raspuns3;
                }
                
            }
        }
        else
        {
            return 'Datele introduse nu se regasesc in baza de date!';
        }
        
    }
    public function Score($pass,$user,$rs1,$rs2,$rs3,$rs4,$rs5,$rs6,$rs7,$rs8,$rs9,$rs10)
    {
        $log = DB::table('piuser')->where('pass',$pass)->where('user',$user)->count();
        if($log==1)
        {
            $rs = array("nimic",$rs1, $rs2, $rs3,$rs4,$rs5,$rs6,$rs7,$rs8,$rs9,$rs10);
            $score=0;
            for($i=1;$i<=10;$i++)
            {
                $raspuns=DB::table('quiz')->select('Corect')->where('Corect',$rs[$i])->where('ID',$i)->count();
                if($raspuns==1)
                {
                    $score+=10;
                }
            }
            DB::table('piuser')->where('user',$user)->update(['score'=>$score]);
            return 'Ai acumulat un scor de '.$score.'/100';
        }
        else
        {
            return 'Datele introduse nu se regasesc in baza de date!';
        }
    }
    public function clasament()
    {
        $clas = DB::table('piuser')->select('user','score')->orderBy('score','DESC')->get();
        return json_encode($clas);
    }
}
