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
        ->join('product_catalog','products.id','product_catalog.product_id')
        ->where('product_catalog.available','=','1')
        ->orderBy('products.rank_order','desc')
        ->limit(1)
        ->get();

        foreach($featured as $product){
            $product->img_link = DB::table('product_images')->where('product_id','=',$product->id)->orderBy('sort_order', 'desc')->first()->img_link;
        }


        $this->addTemplateVariables(compact('latest','featured'));

        return view('index.home', $this->template_vars);
    }
}

