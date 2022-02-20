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

        $products = DB::select(DB::raw("SELECT products.*, img.img_link, img.product_id as prod_id
         FROM products
        INNER JOIN (SELECT * FROM product_images ORDER BY sort_order DESC) AS img
        ON products.id = img.product_id"));

        // $products = DB::select(DB::raw("SELECT * FROM products
        // INNER JOIN (SELECT * FROM product_images ORDER BY sort_order DESC) AS img
        // ON products.id = img.product_id
        // GROUP BY product_id"));
        
        $this->addTemplateVariables(compact('products'));

        return view('store.catalog', $this->template_vars);
    }

    public function viewProduct(Request $request, $id){
       
        $product = DB::table('product_catalog')
        ->selectRaw('products.*, product_catalog.*, product_colors.name as color_name, pc2.name as design_name')
        ->where('product_catalog.id','=',$id)
        ->join('products','products.id','product_catalog.product_id')
        ->join('product_colors','product_colors.id','product_catalog.product_color_id')
        ->join('product_colors as pc2','product_catalog.secondary_color_id','pc2.id')
        ->orderBy('sort_order','desc')
        ->first();

        $product_sizes = DB::table('product_catalog')
        ->selectRaw('product_sizes.name as size')
        ->where('product_color_id','=',$product->product_color_id)
        ->where('secondary_color_id','=',$product->secondary_color_id)
        ->join('products','products.id','product_catalog.product_id')
        ->join('product_sizes','product_sizes.id','product_catalog.product_size_id')
        ->where('product_catalog.product_id','=',$product->product_id)
        ->get();

        $product_variants = DB::table('product_catalog')
        ->selectRaw('products.*, product_catalog.*, product_colors.name as color_name, pc2.name as design_name')
        ->where('product_color_id','=',$product->product_color_id)
        ->where('product_size_id','=',$product->product_size_id)
        ->join('products','products.id','product_catalog.product_id')
        ->join('product_colors','product_colors.id','product_catalog.product_color_id')
        ->join('product_colors as pc2','product_catalog.secondary_color_id','pc2.id')
        ->leftjoin('product_images','product_images.product_id','product_catalog.id')
        ->where('product_catalog.product_id','=',$product->product_id)
        ->get();

        $product_colors = DB::table('product_catalog')
        ->selectRaw('products.*, product_catalog.*, product_colors.name as color_name, pc2.name as design_name')
        ->where('secondary_color_id','=',$product->secondary_color_id)
        ->where('product_size_id','=',$product->product_size_id)
        ->join('products','products.id','product_catalog.product_id')
        ->join('product_colors','product_colors.id','product_catalog.product_color_id')
        ->join('product_colors as pc2','product_catalog.secondary_color_id','pc2.id')
        ->leftjoin('product_images','product_images.product_id','product_catalog.id')
        ->where('product_catalog.product_id','=',$product->product_id)
        ->get();

        $images = DB::table('product_images')
        ->where('product_id','=',$id)
        ->orderBy('sort_order','desc')
        ->get();

        $this->addTemplateVariables(compact('product','product_variants','product_colors','product_sizes', 'images'));

        return view('store.product', $this->template_vars);
    }

}

