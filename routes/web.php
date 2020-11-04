<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Models\Brand;
use App\Models\Retailer;
use App\Models\Product;
use App\Models\News;
use App\Models\ProductConnection;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


// Route::get('/', 'HomeController@welcome')->name('welcome');

// Route::get('/verifycation/{token}', 'Auth\VerificationController@verifyEmail')->name('verification.email');
// Route::post('/register', 'Auth\RegisterController@register')->name('register');
// Route::post('/login', 'Auth\LoginController@login')->name('login');
// Route::post('/forgot-password', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('forgot.password');
// Route::post('/logout', 'Auth\LoginController@logout')->name('logout');
// Route::post('/password_reset','Auth\ResetPasswordController@reset')->name('password.request');
// //Auth::routes();
// Route::get('/destroy/{email}', 'UserController@destroy');


Route::get('/login', function () {
    return view('auth.login', ['page' => 'login']);
})->name('login');

Route::post('/login', 'Auth\LoginController@login');
Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

Route::middleware(['auth', 'check.admin'])->group(function () {
    Route::get('/', function () {
        return view('admin.dashboard', ['page' => 'dashboard']);
    });

    Route::get('/users', 'Admin\UserController@index');
    Route::get('/add_user', function () {
        return view('admin.user.add_user', ['page' => 'users']);
    });
    Route::post('/add_user', 'Admin\UserController@addUser');
    Route::get('/edit_user/{id}', 'Admin\UserController@editUser');
    Route::post('/edit_user/{id}', 'Admin\UserController@postEditUser');

    Route::get('/brands', 'Admin\BrandController@index');
    Route::get('/add_brand', function () {
        return view('admin.brand.add_brand', ['page' => 'brands']);
    });
    Route::post('/add_brand', 'Admin\BrandController@addBrand');
    Route::get('/edit_brand/{id}', 'Admin\BrandController@getEditBrand');
    Route::post('/edit_brand/{id}', 'Admin\BrandController@postEditBrand');
    Route::get('/manage_brand_products/{id}', 'Admin\BrandController@manageBrandProducts');
    Route::get('/add_brand_product/{user_id}', function ($user_id) {
        $products = DB::table('products')->get();
        $brand = Brand::where('user_id', $user_id)->first();
        $brand_name = isset($brand->name) ? $brand->name : '';
        return view('admin.brand.add_brand_product', [
            'page' => 'brands',
            'user_id' => $user_id, 
            'brand_name' => $brand_name, 
            'products' => $products, 
        ]);
    });
    Route::post('/add_brand_product/{user_id}', 'Admin\BrandController@postAddBrandProduct');
    Route::get('/edit_brand_product/{connection_id}', function ($connection_id) {
        $connection = ProductConnection::find($connection_id);
        $product = Product::find($connection->product_id);
        $product->attributes = json_decode($product->attributes);
        $product->prices = json_decode($connection->prices);
        $product->types = json_decode($product->types);
        $product->description = $connection->description;
        $product->status = $connection->status;
        $product->connection_id = $connection->id;
        $brand_name = Brand::where('user_id', $connection->user_id)->first()->name;
        return view('admin.brand.edit_brand_product', [
            'page' => 'brands', 
            'product' => $product, 
            'brand_name' => $brand_name
        ]);
    });
    Route::post('/edit_brand_product/{product_id}', 'Admin\BrandController@postEditBrandProduct');

    Route::get('/retailers', 'Admin\RetailerController@index');
    Route::get('/add_retailer', function () {
        return view('admin.retailer.add_retailer', ['page' => 'retailers']);
    });
    Route::post('/add_retailer', 'Admin\RetailerController@addRetailer');
    Route::get('/edit_retailer/{id}', 'Admin\RetailerController@getEditRetailer');
    Route::post('/edit_retailer/{id}', 'Admin\RetailerController@postEditRetailer');
    Route::get('/manage_retailer_products/{id}', 'Admin\RetailerController@manageRetailerProducts');
    Route::get('/add_retailer_product/{user_id}', function ($user_id) {
        $products = DB::table('products')->get();
        $retailer = Retailer::where('user_id', $user_id)->first();
        $retailer_name = isset($retailer->name) ? $retailer->name : '';
        return view('admin.retailer.add_retailer_product', [
            'page' => 'retailers',
            'user_id' => $user_id, 
            'retailer_name' => $retailer_name, 
            'products' => $products, 
        ]);
    });
    Route::post('/add_retailer_product/{user_id}', 'Admin\RetailerController@postAddRetailerProduct');
    Route::get('/edit_retailer_product/{connection_id}', function ($connection_id) {
        $connection = ProductConnection::find($connection_id);
        $product = Product::find($connection->product_id);
        $product->attributes = json_decode($product->attributes);
        $product->prices = json_decode($connection->prices);
        $product->types = json_decode($product->types);
        $product->description = $connection->description;
        $product->status = $connection->status;
        $product->connection_id = $connection->id;
        $retailer_name = Retailer::where('user_id', $connection->user_id)->first()->name;
        return view('admin.retailer.edit_retailer_product', [
            'page' => 'retailers', 
            'product' => $product, 
            'retailer_name' => $retailer_name
        ]);
    });
    Route::post('/edit_retailer_product/{connection_id}', 'Admin\RetailerController@postEditRetailerProduct');

    Route::get('/news', function () {
        $news = News::all();
        return view('admin.news.news', ['page' => 'news', 'news' => $news]);
    });
    Route::get('/add_news', function () {
        return view('admin.news.add_news', ['page' => 'news']);
    });
    Route::post('/add_news', 'Admin\NewsController@addNews');
    Route::get('/edit_news/{news_id}', function ($id) {
        $news = News::find($id);
        return view('admin.news.edit_news', ['page' => 'news', 'news' => $news]);
    });
    Route::post('/edit_news/{news_id}', 'Admin\NewsController@editNews');
    
    Route::get('/admin_products', 'Admin\ProductController@index');
    Route::get('/admin_add_product', function () {
        $products = DB::table('products')
            ->groupBy('name')
            ->get();
        return view('admin.product.admin_add_product', ['page' => 'products', 'products' => $products]);
    });
    Route::post('/admin_add_product', 'Admin\ProductController@addProduct');
    Route::get('/admin_edit_product/{product_id}', function ($product_id) {
        $product = Product::find($product_id);
        $product->types = json_decode($product->types);
        $product->attributes = json_decode($product->attributes);
        $product->prices = json_decode($product->prices);
        return view('admin.product.admin_edit_product', [
            'page' => 'products', 
            'product' => $product, 
        ]);
    });
    Route::post('/admin_edit_product/{product_id}', 'Admin\ProductController@editProduct');

    Route::get('/reviews', function () {
        return view('admin.reviews', ['page' => 'reviews']);
    });
    Route::get('/notifications', function () {
        return view('admin.notifications', ['page' => 'notifications']);
    });
});

Route::get('/delete_product/{product_id}', function($product_id) {
    $product = Product::find($product_id);
    $product->delete();
    return back();
});

Route::get('/delete_product_connection/{connection_id}', function($connection_id) {
    $connection = ProductConnection::find($connection_id);
    $connection->delete();
    return back();
});

Route::middleware(['auth', 'check.retailer'])->group(function () {
    Route::get('/dashboard', function () {
        return view('retailer.dashboard', ['page' => 'dashboard', 'kind' => 'app']);
    })->middleware('auth');
    Route::get('/listing', 'Retailer\ListingController@index');
    Route::post('/update_listing', 'Retailer\ListingController@updateListing');
    Route::get('/retailer_products', 'Retailer\ProductController@index');
    Route::get('/retailer_add_product', function () {
        $products = DB::table('products')->get();
        return view('retailer.product.add_product', ['page' => 'products', 'kind' => 'app', 'products' => $products]);
    });
    Route::post('/retailer_add_product', 'Retailer\ProductController@postAddProduct');
    Route::get('/retailer_edit_product/{connection_id}', function ($connection_id) {
        $connection = ProductConnection::find($connection_id);
        $product = Product::find($connection->product_id);
        $product->attributes = json_decode($product->attributes);
        $product->prices = json_decode($connection->prices);
        $product->types = json_decode($product->types);
        $product->description = $connection->description;
        $product->status = $connection->status;
        $product->connection_id = $connection->id;
        return view('retailer.product.edit_product', [
            'page' => 'products', 
            'kind' => 'app', 
            'product' => $product, 
        ]);
    });
    Route::post('/retailer_edit_product/{product_id}', 'Retailer\ProductController@postEditProduct');
});

