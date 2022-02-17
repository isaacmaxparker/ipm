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

        $latest = DB::table('releases')->orderBy('release_date','desc')->limit(3)->get();

        $featured = DB::table('products')
        ->join('featured_products','products.id','featured_products.product_id')
        ->join('product_images','products.id','product_images.product_id')
        ->orderBy('featured_products.rank_order','asc')
        ->get();


        $this->addTemplateVariables(compact('latest','featured'));

        return view('index.home', $this->template_vars);
    }
}

