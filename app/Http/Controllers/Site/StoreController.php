<?php

namespace App\Http\Controllers\Site;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Http\Controllers\Controller;
use DB;
use stdClass;
use App\Http\Models\Customer;
use DateTime;

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

    public function viewCheckout(Request $request){

        if(session('promo')){
            $this->validatePromo($request);
        }else{
            session(['shipping'=>10]);
        }

        $shipping = session('shipping');
        $cart_items = $this->createCartItems()[0];
        $cart_total = $this->createCartItems()[1];
        $total_discount = $this->createCartItems()[2];
        $promo = session('promo');
        $this->addTemplateVariables(compact('cart_items','cart_total','promo','total_discount', 'shipping'));
        return view('store.checkout', $this->template_vars);
    }

    public function addToCart(Request $request, $id){
        $quant = $request->input('quantity');
        $cart = session('cart');
        if(!$cart){
            session(['cart' => []]);
            $cart = session('cart');
        }

        $cart_item = new StdClass;
        $cart_item->cart_item_id = $this->generateRandomString();
        $cart_item->product_id = $id;
        $cart_item->quantity = $quant;
        $cart_item->discount = 0;

        $request->session()->push('cart', $cart_item);
        return redirect('/store/checkout');
    }

    public function viewOrder(Request $request, $order_id){
        $order = DB::table('orders')->join('customers','customers.id','orders.customer_id')->where('order_id','=',$order_id)->first();
        $order_items = DB::table('orders_items')->where('order_id','=','orders.id');
        
        $this->addTemplateVariables(compact('order','order_items'));
        return view('store.order', $this->template_vars);
    }

    //AJAX FUNCTIONS
    public function deleteFromCart(Request $request){
        $cart_obj_id = $request->input('id');
        $new_array = [];
        $cart = session('cart');

        foreach( $cart as $item){
            if($item->cart_item_id != $cart_obj_id){
                array_push($new_array, $item);
            }
        }

        session(['cart'=>$new_array]);

        $response = new StdClass();
        $response->type = 'Success';
        return [$response, $new_array, session('shipping')];
    }

    public function deleteCart(Request $request){
        $request->session()->pull('cart');
        $request->session()->pull('promo');
        return redirect::back();
    }

    public function getOrderTotal(Request $request){
        if(session('promo')){
            $this->validatePromo($request);
        }else{
            session(['shipping'=>10]);
        }

        $shipping = session('shipping');
        $cart_items = $this->createCartItems()[0];
        $cart_total = $this->createCartItems()[1];
        $total_discount = $this->createCartItems()[2];

        return [$cart_total + $shipping];
    }

    public function validatePromo(Request $request){
        $promocode = strtolower($request->input('code'));
        $response = new StdClass();

        if($promocode == 'inpersonpickup'){
            session(['shipping'=>0]);
            $response->message = 'Code: ' . strtoupper($promocode) . ' Applied';
            $response->type = 'Success';
            session(['promo'=>strtoupper($promocode)]);
            return [$response, $this->createCartItems()[0], session('shipping')];
        }else{
            if(!$promocode){
                $promocode = session('promo');
            }
    
            $code = DB::table('promos')
            ->where('code','=',$promocode)
            ->first();
    

            if(count($code) < 1){
                $response->message = 'Promo Code is not valid';
                $response->type = 'Error';
                return [$response];
            }
    
            $date_now = new DateTime();
            $start_date = new DateTime($code->start_date);
            $end_date = new DateTime($code->end_date);
    
            
            if($date_now < $start_date ){
                $response->message = 'Promo has not begun yet';
                $response->type = 'Error';
                return [$response];
            }
            if($date_now > $end_date){
                $response->message = 'Promo has expired';
                $response->type = 'Error';
                return [$response];
            }
    
            $cart_items = session('cart');
            foreach($cart_items as $item){
                $item->price = DB::table('products')->join('product_catalog','products.id','product_catalog.product_id')->where('product_catalog.id',$item->product_id)->first()->price;
                
                if($code->dollar_discount){
                    $item->discount = $code->dollar_discount;
                }
                else if($code->percentage_discount){
                    $item->discount = $item->price * $code->percentage_discount;
                }
                $item->price = $item->price - $item->discount;
                $item->total = $item->price * $item->quantity;
            }

            session(['cart'=>$cart_items]);
            session(['promo'=>strtoupper($promocode)]);
    
            $response->message = 'Code: ' . strtoupper($promocode) . ' Applied';
            $response->type = 'Success';
            return [$response, $cart_items, session('shipping')];
        }

        


    }

    public function removePromo(Request $request){
        $response = new StdClass();

        session(['shipping'=>10]);

        $request->session()->pull('promo');

        $cart_items = session('cart');

        foreach($cart_items as $item){
            $item->price = DB::table('products')->join('product_catalog','products.id','product_catalog.product_id')->where('product_catalog.id',$item->product_id)->first()->price;
            $item->discount = 0;
        }

        session(['cart'=>$cart_items]);
        $response->type = 'Success';

        return [$response, $cart_items, session('shipping')];
    }

    public function saveOrder(Request $request){

        $data = json_decode($_POST['data']);
        
        $purchase_data = $data->purchase_units[0];
        $payment_data = $data->purchase_units[0]->payments->captures[0];

        // return array($data);
        $customer = Customer::updateOrCreate(
            ['first_name'=>$data->payer->name->given_name,
             'last_name'=>$data->payer->name->surname,
             'email'=>$data->payer->email_address],
            [
                'first_name'=>$data->payer->name->given_name,
                'last_name'=>$data->payer->name->surname,
                'email'=>$data->payer->email_address,
                'address_1'=>$purchase_data->shipping->address->address_line_1,
                'address_2'=>property_exists($purchase_data->shipping->address,'address_line_2') ? $purchase_data->shipping->address->address_line_2 : null,
                'city'=>$purchase_data->shipping->address->admin_area_2,
                'state'=>$purchase_data->shipping->address->admin_area_1,
                'zip'=>$purchase_data->shipping->address->postal_code,
                'country'=>$purchase_data->shipping->address->country_code,
                'updated_at'=>now()
            ]
        );

        DB::table('orders')->insert(
            [
                'order_id'=>$this->generateRandomString(),
                'paypal_order_id'=>$data->id,
                'transaction_id'=>$payment_data->id,
                'amount'=>$purchase_data->amount->value,
                'customer_id'=>$customer->id,
                'ship_address_1'=>$purchase_data->shipping->address->address_line_1,
                'ship_address_2'=>property_exists($purchase_data->shipping->address,'address_line_2') ? $purchase_data->shipping->address->address_line_2 : null,
                'ship_city'=>$purchase_data->shipping->address->admin_area_2,
                'ship_state'=>$purchase_data->shipping->address->admin_area_1,
                'ship_zip'=>$purchase_data->shipping->address->postal_code,
                'ship_country'=>$purchase_data->shipping->address->country_code,    
                'status'=>'P',
                'created_at'=>now(),
                'updated_at'=>now()   
            ]
        );
        $order = DB::table('orders')->where('paypal_order_id','=',$data->id)->where('transaction_id','=',$payment_data->id)->first();
        $cart = session('cart');

        foreach ($cart as $item){
            DB::table('order_items')->insert(
                [
                    'order_id'=>$order->id,
                    'product_catalog_id'=>$item->product_id,
                    'product_details'=>null,
                    'quantity'=>$item->quantity,
                    'created_at'=>now(),
                    'updated_at'=>now()   
                ]
                );
        }

        $request->session()->pull('cart');
        $request->session()->pull('promo');
        $request->session()->pull('shipping');

        return ['Success', $order->order_id];
    }

    // HELPER FUNCTIONS 
    public function createCartItems(){
        $cart = session('cart');
        $cart_total = 0;
        $discount_total = 0;
        if(count($cart) < 1){
            $cart = [];
        }
        $cart_items = [];
        foreach ($cart as $item){
            $product = DB::table('product_catalog')
            ->join('products','products.id','product_catalog.product_id')
            ->where('product_catalog.id','=',$item->product_id)->first();

             $img = DB::table('product_images')->where('product_id','=',$item->product_id)->orderBy('sort_order','desc')->first();

            $new_item = new StdClass;
            $new_item->cart_item_id = $item->cart_item_id;
            $new_item->product_id = $item->product_id;
            $new_item->name = $product->name;
            $new_item->price = $product->price;
            $new_item->product_price = $product->price;
            $new_item->discount = ($item->discount * $item->quantity);
            $new_item->total = ($product->price * $item->quantity);
            $new_item->quantity = $item->quantity;
            $new_item->img_link = $product->type . "/" . $img->img_link;

            $cart_total = $cart_total + $new_item->total - $new_item->discount;
            $discount_total = $discount_total + $new_item->discount;

            array_push($cart_items,$new_item);
        }

        return [$cart_items,$cart_total,$discount_total];
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

