<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Http\Controllers\Controller;
use DB;

use Illuminate\Http\Request;

class IndexController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function viewHome(Request $request){

        $latest = DB::table('releases')->orderBy('release_date','desc')->first();
        $this->addTemplateVariables(compact('latest'));

        return view('index.home', $this->template_vars);
    }
}

