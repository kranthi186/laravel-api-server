<?php

namespace App\Http\Controllers\Retailer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

use App\Models\Retailer;
use App\Models\Brand;
use App\Models\Product;
use App\Models\ProductConnection;

class ProductController extends Controller
{
    public function index() {
        $user = Auth::user();
        $user_id = $user->id;
        $product_connections = ProductConnection::where('user_id', $user_id)->get();
        $products = array();
        
        foreach($product_connections as $connection) {
            $prod = Product::find($connection->product_id);
            $prod->status = $connection->status;
            $prod->prices = $connection->prices;
            $prod->description = $connection->description;
            $prod->connection_id = $connection->id;
            array_push($products, $prod);
        }
        return view('retailer.product.products', ['page' => 'products', 'kind' => 'app', 'products' => json_encode($products)]);
    }

    public function postAddProduct(Request $request){
        $user = Auth::user();
        $user_id = $user->id;
        $status = $request->product_status;
        $description = $request->description;
        $prices = [$request->price_product, $request->price_half, $request->price_one, $request->price_ounce];
        $name = $request->name;
        
        $product = Product::where('name', '=', $name)->first();

        if(!$product) {
            $popular = $request->popular;
            $types = [];
            if($request->type_indica == "on") {
                array_push($types, 0);
            }
            if($request->type_sativa == "on") {
                array_push($types, 1);
            }
            if($request->type_hybrid == "on") {
                array_push($types, 2);
            }
            if($request->type_cbd == "on") {
                array_push($types, 3);
            }
            $category = $request->category;
            $attributes = [
                'happy' => $request->attr_happy,
                'relaxed' => $request->attr_relaxed,
                'euphoric' => $request->attr_euphoric,
                'uplifted' => $request->attr_uplifted,
                'creativity' => $request->attr_creativity,
                'stress' => $request->attr_stress,
                'depression' => $request->attr_depression,
                'pain' => $request->attr_pain,
                'appetite' => $request->attr_appetite,
                'insomnia' => $request->attr_insomnia,
            ];

            $product = new Product();
            
            if ($request->file('product')) {
                // $img_product = $request->file('product');
                // $product_name = 'product-' . date("Ymd") . '-' . time() . '.' . $img_product->getClientOriginalExtension();
                // $img_product->move(public_path('/uploads'), $product_name);
                // $product->image = $product_name;
                $product_name = $request->file('product')->store('uploads', 's3', 'public');
                $product->image = env('AWS_UPLOAD_URL') . $product_name;
            } else {
                if($request->product_hidden) {
                    $product->image = $request->product_hidden;
                }
            }
            
            $product->user_id = $user_id;
            $product->status = $status;
            $product->popular = $popular;
            $product->name = $name;
            if($description) {
                $product->description = $description;
            }
            $product->types = json_encode($types);
            $product->category = $category;
            $product->prices = json_encode($prices);
            $product->attributes = json_encode($attributes);
            $product->save();
        }

        $connection = new ProductConnection();
        $connection->user_id = $user_id;
        $connection->product_id = $product->id;
        if($description) {
            $connection->description = $description;
        }
        $connection->prices = json_encode($prices);
        $connection->status = $status;
        $connection->save();
        
        return redirect()->to('/retailer_products');
    }

    public function postEditProduct(Request $request, $connection_id){
        $status = $request->product_status;
        $popular = $request->popular;
        $name = $request->name;
        $description = $request->description;
        $types = [];
        if($request->type_indica == "on") {
            array_push($types, 0);
        }
        if($request->type_sativa == "on") {
            array_push($types, 1);
        }
        if($request->type_hybrid == "on") {
            array_push($types, 2);
        }
        if($request->type_cbd == "on") {
            array_push($types, 3);
        }
        $category = $request->category;
        $prices = [$request->price_product, $request->price_half, $request->price_one, $request->price_ounce];
        $attributes = [
            'happy' => $request->attr_happy,
            'relaxed' => $request->attr_relaxed,
            'euphoric' => $request->attr_euphoric,
            'uplifted' => $request->attr_uplifted,
            'creativity' => $request->attr_creativity,
            'stress' => $request->attr_stress,
            'depression' => $request->attr_depression,
            'pain' => $request->attr_pain,
            'appetite' => $request->attr_appetite,
            'insomnia' => $request->attr_insomnia,
        ];

        $connection = ProductConnection::find($connection_id);
        $product_id = $connection->product_id;
        $connection->prices = json_encode($prices);
        if($description) {
            $connection->description = $description;
        }
        $connection->status = $status;
        $connection->save();

        $product = Product::find($product_id);
        
        if ($request->file('product')) {
            // $img_product = $request->file('product');
            // $product_name = 'product-' . date("Ymd") . '-' . time() . '.' . $img_product->getClientOriginalExtension();
            // $img_product->move(public_path('/uploads'), $product_name);
            // $product->image = $product_name;
            $product_name = $request->file('product')->store('uploads', 's3', 'public');
            $product->image = env('AWS_UPLOAD_URL') . $product_name;
        }
        
        $product->status = $status;
        $product->popular = $popular;
        $product->name = $name;
        if($description) {
            $product->description = $description;
        }
        $product->types = json_encode($types);
        $product->category = $category;
        $product->prices = json_encode($prices);
        $product->attributes = json_encode($attributes);
        $product->save();
        
        return redirect()->to('/retailer_products');
    }
}
