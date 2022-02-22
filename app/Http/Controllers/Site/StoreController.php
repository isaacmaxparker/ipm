<?php

namespace App\Http\Controllers\Site;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Http\Controllers\Controller;
use DB;
use stdClass;

use Illuminate\Http\Request;

class StoreController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function viewCatalog(Request $request){

        //TAKE OUT LATER THIS IS JUST FOR VERSION 1.0 SINCE THERE IS ONLY ONE PRODUCT

        return redirect('/store/product/1');

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
       
        $product = DB::table('products')->where('id','=',$id)->first();

        $catalog_item = DB::table('product_catalog')
        ->selectRaw('product_catalog.*, product_sizes.*, quantity_left - quantity_held as amount_left')
        ->join('product_sizes','product_catalog.id','product_sizes.product_catalog_id')
        ->where('product_catalog.id','=',$id)
        ->first();
        ;

        $images = DB::table('product_images')
        ->where('product_id','=',$id)
        ->orderBy('sort_order','desc')
        ->get();

        $test_alert = new StdClass();

        $test_alert->type = 'sale';
        $test_alert->title = 'Limited Time Offer:';
        $test_alert->message = 'Recieve a FREE signed poster with purchase!';

        $alerts = [$test_alert];

        $this->addTemplateVariables(compact('product', 'images', 'alerts','catalog_item'));

        return view('store.product', $this->template_vars);
    }

    public function viewCart(Request $request){
        $cart = session('cart');
        if(count($cart) < 1){
            $cart = [];
        }
        $cart_items = [];
        foreach ($cart as $item){
            $product = DB::table('product_catalog')
            ->join('products','products.id','product_catalog.product_id')
            ->where('product_catalog.id','=',$item[0])->first();

             $img = DB::table('product_images')->where('product_id','=',$item[0])->orderBy('sort_order','desc')->first();

            $new_item = new StdClass;
            $new_item->cart_item_id = $item[2];
            $new_item->name = $product->name;
            $new_item->price = $product->price;
            $new_item->total = $product->price * $item[1];
            $new_item->quantity = $item[1];
            $new_item->img_link = $img->img_link;

            array_push($cart_items,$new_item);
        }
        return $cart_items;
        $this->addTemplateVariables(compact('cart_items'));
        return view('store.cart', $this->template_vars);
    }

    public function addToCart(Request $request, $id){
        $quant = $request->input('quantity');
        $cart = session('cart');
        if(!$cart){
            session(['cart' => []]);
            $cart = session('cart');
        }

        $cart_item = array($id, $quant, $this->generateRandomString());

        $request->session()->push('cart', $cart_item);
        return redirect('/store/cart');
    }

    public function deleteCart(Request $request){
        $request->session()->pull('cart');
        return redirect::back();
    }

    public function generateRandomString($length = 5) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString . time();
    }
}

