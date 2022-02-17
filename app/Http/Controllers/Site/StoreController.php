<?php

namespace App\Http\Controllers\Site;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Http\Controllers\Controller;
use DB;

use Illuminate\Http\Request;

class StoreController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function viewCatalog(Request $request){

        $products = DB::table('releases')->orderBy('release_date','desc')->get();
        $this->addTemplateVariables(compact('releases'));

        return view('store.catalog', $this->template_vars);
    }

    public function viewProduct(Request $request, $id){
       
        $this->addTemplateVariables(compact('release','songs','other_releases'));

        return view('store.product', $this->template_vars);
    }

}

