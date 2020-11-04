<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Product;
use Auth;

class ProductController extends Controller
{
    public function index() {
        $products = Product::all();

        return view('admin.product.admin_products', ['page' => 'products', 'products' => $products]);
    }

    public function addProduct(Request $request){
        $user = Auth::user();
        $user_id = $user->id;
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
        
        return redirect()->to('/admin_products');
    }

    public function editProduct(Request $request, $product_id){
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
        
        return redirect()->to('/admin_products');
    }
}
