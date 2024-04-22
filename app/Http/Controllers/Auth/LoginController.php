<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    //
    public function showLoginForm(){
        return view('login');
    }
    public function authenticate(Request $request){
       $credtionals =  $request->validate([
            "username"=>"required|max:255",
            "password"=>"required|max:32"
        ]);
        // var_dump($credtionals);
        $userpass = $credtionals['password'];
        try{    
            $user = DB::table('vicidial_users')
            ->select("*")
            ->where("user",$credtionals['username'])
            ->whereRaw("pass = BINARY ?",["$userpass"])
            ->first();
            if($user)
            {
                return redirect('agent.dashboard');
            }
            return back()->withErrors(["errors"=>"Invalid Credtionals"]);
        }
        catch(\Exception $e){
            $errMessage = $e->getMessage();
            Log::error("Error => $errMessage");
        }
    }
}
