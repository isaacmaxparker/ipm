<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function viewAdminDashboard(Request $request){

        return view('admin.dashboard', $this->template_vars);
    }    

    public function viewLogin(Request $request){
        return view('admin.login', $this->template_vars);
    }

    public function login(Request $request){

        $username =  $request->input('username');
        $password = $request->input('password');
        $password_hash = crypt($password, $username);
        $remember = false;

        if (Auth::attempt(['email' => $username, 'password' => $password_hash])) {
            $request->session()->regenerate();
            return redirect()->route('admin::dashboard');
        }else{
            return $password_hash; 
            return redirect()->back();
        }
    }

    public function logout(Request $request)
{
    Auth::logout();
 
    $request->session()->invalidate();
 
    $request->session()->regenerateToken();
 
    return redirect('/');
}
}

