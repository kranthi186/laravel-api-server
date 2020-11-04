<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Retailer;
use App\Models\Brand;
use App\Models\RetailerReview;
use App\Models\Product;
use App\Models\ProductConnection;
use App\Models\ProductReview;
use App\Models\Puff;
use App\Models\News;
use DB;

class UserApiController extends Controller
{
    public function featuredRetailers() {
        $users = DB::table('retailer_reviews')
            ->join('users', 'users.id', '=', 'retailer_reviews.user_id')
             ->where('status', 1)
             ->where('user_type', 1)
             ->orderBy('retailer_reviews.rate','desc')
             ->groupBy('user_id')
             ->take(10)
             ->get();

        foreach($users as $user) {
            $retailer = Retailer::where('user_id', $user->user_id)->first();
            $address = (isset($retailer->address) ? $retailer->address : '') . ' ' 
                . (isset($user->city) ? $user->city : '') . ', ' . (isset($user->state) ? $user->state : '') . ' ' 
                . (isset($retailer->zip) ? $retailer->zip : '') . ' ' . (isset($user->state) ? $user->country : '');
            // $user->address = env('GOOGLE_MAP_API_KEY');
            $user->location = $this->getLatLong($address);
            if(isset($retailer->hours)){
                $user->interval = json_decode($retailer->hours, true)[strtolower(substr(date("l"), 0, 3))];
            } else {
                $user->interval = ['closed' => '0', 'open_time' => null, 'closed_time' => null];
            }
            $user->image = isset($retailer->featured_image) ? $retailer->featured_image : '';
            $user->name = isset($retailer->name) ? $retailer->name : '';
            $user->address = isset($retailer->address) ?  $retailer->address : '';
        }
        $arr = json_decode(json_encode($users), true);
        shuffle($arr);

        return response()->json($arr, 200);
    }

    public function retailers() {
        $users = User::where('user_type', '=', 1)->where('status', '=', '1')->get();

        foreach($users as $user) {
            $retailer = Retailer::where('user_id', '=', $user->id)->first();
            if(isset($retailer->hours)){
                $user->interval = json_decode($retailer->hours, true)[strtolower(substr(date("l"), 0, 3))];
            } else {
                $user->interval = ['closed' => '0', 'open_time' => null, 'closed_time' => null];
            }
            $address = (isset($retailer->address) ? $retailer->address : '') . ' ' 
                . (isset($user->city) ? $user->city : '') . ', ' . (isset($user->state) ? $user->state : '') . ' ' 
                . (isset($retailer->zip) ? $retailer->zip : '') . ' ' . (isset($user->state) ? $user->country : '');
            $user->location = $this->getLatLong($address);
            $user->logo = isset($retailer->logo) ? $retailer->logo : '';
            $user->cover_photo = isset($retailer->cover_photo) ? $retailer->cover_photo : '';
            $user->featured_image = isset($retailer->featured_image) ? $retailer->featured_image : '';
            $user->name = isset($retailer->name) ? $retailer->name : '';
            $user->zip = isset($retailer->zip) ? $retailer->zip : '';
            $user->address = isset($retailer->address) ?  $retailer->address : '';
            $reviews = RetailerReview::where('user_id', '=', $user->id)->orderBy('created_at')->take(10)->get();
            $rate = 0;
            if(count($reviews)) {
                foreach($reviews as $review) {
                    $rate += $review->rate;
                }
                $rate /= count($reviews);
            }
            $user->rate = $rate;
            $user->review_count = count($reviews);
        }

        return response()->json($users, 200);
    }

    public function retailer($user_id) {
        $user = User::find($user_id);
        $retailer = Retailer::where('user_id', $user_id)->first();
        $user->hours = isset($retailer->hours) ? json_decode($retailer->hours, true) : [
            'sun' => [
                'closed' => 0,
                'open_time' => null,
                'closed_time' => null,
            ],
            'mon' => [
                'closed' => 0,
                'open_time' => null,
                'closed_time' => null,
            ],
            'tue' => [
                'closed' => 0,
                'open_time' => null,
                'closed_time' => null,
            ],
            'wed' => [
                'closed' => 0,
                'open_time' => null,
                'closed_time' => null,
            ],
            'thu' => [
                'closed' => 0,
                'open_time' => null,
                'closed_time' => null,
            ],
            'fri' => [
                'closed' => 0,
                'open_time' => null,
                'closed_time' => null,
            ],
            'sat' => [
                'closed' => 0,
                'open_time' => null,
                'closed_time' => null,
            ],
        ];
        $address = (isset($retailer->address) ? $retailer->address : '') . ' ' 
            . (isset($user->city) ? $user->city : '') . ', ' . (isset($user->state) ? $user->state : '') . ' ' 
            . (isset($retailer->zip) ? $retailer->zip : '') . ' ' . (isset($user->state) ? $user->country : '');
        $user->location = $this->getLatLong($address);
        $user->logo = isset($retailer->logo) ? $retailer->logo : '';
        $user->cover_photo = isset($retailer->cover_photo) ? $retailer->cover_photo : '';
        $user->featured_image = isset($retailer->featured_image) ? $retailer->featured_image : '';
        $user->name = isset($retailer->name) ? $retailer->name : '';
        $user->address = isset($retailer->address) ?  $retailer->address : '';
        $user->zip = isset($retailer->zip) ?  $retailer->zip : '';
        $reviews = RetailerReview::where('user_id', '=', $user->id)->orderBy('created_at')->take(10)->get();
        $rate = 0;
        if(count($reviews)) {
            foreach($reviews as $review) {
                $rate += $review->rate;
            }
            $rate /= count($reviews);
        }
        $user->rate = $rate;
        $user->review_count = count($reviews);
        return response()->json($user, 200);
    }

    public function brands() {
        $users = User::where('user_type', '=', 2)->where('status', '=', '1')->get();
        foreach($users as $user) {
            $brand = Brand::where('user_id', '=', $user->id)->first();
            $user->logo = isset($brand->logo) ? $brand->logo : '';
            $user->cover_photo = isset($brand->cover_photo) ? $brand->cover_photo : '';
            $user->featured_image = isset($brand->featured_image) ? $brand->featured_image : '';
            $user->name = isset($brand->name) ? $brand->name : '';
            $user->tagline = isset($brand->tagline) ? $brand->tagline : '';
        }
        $arr = json_decode(json_encode($users), true);
        shuffle($arr);
        return response()->json($arr, 200);
    }

    public function brand($user_id) {
        $user = User::find($user_id);
        $brand = Brand::where('user_id', $user_id)->first();
        $user->logo = isset($brand->logo) ? $brand->logo : '';
        $user->cover_photo = isset($brand->cover_photo) ? $brand->cover_photo : '';
        $user->featured_image = isset($brand->featured_image) ? $brand->featured_image : '';
        $user->name = isset($brand->name) ? $brand->name : '';
        $user->tagline = isset($brand->tagline) ?  $brand->tagline : '';
        return response()->json($user, 200);
    }


    public function addRetailerReview(Request $request) {
        $review = new RetailerReview();
        $review->user_id = $request->userId;
        $review->rate = $request->rate;
        $review->content = $request->content;
        $review->provider_id = $request->providerId;
        $review->save();

        return response()->json([
            'userId' => $request->userId, 
            'rate' => $request->rate, 
            'content' => $request->content
        ], 200);
    }

    public function fetchProducts($user_id) {
        $connections = ProductConnection::where('user_id', $user_id)->where('status', '=', 1)->get();
        $products = array();
        
        foreach($connections as $connection) {
            $product = Product::find($connection->product_id);
            $product->attributes = json_decode($product->attributes);
            $product->prices = json_decode($connection->prices);
            $product->status = $connection->status;
            $product->description = $connection->description;
            $product->types = json_decode($product->types);
            $product->connection_id = $connection->id;
            $reviews = ProductReview::where('product_id', '=', $product->id)->orderBy('created_at')->take(10)->get();
            $rate = 0;
            if(count($reviews)) {
                foreach($reviews as $review) {
                    $rate += $review->rate;
                }
                $rate /= count($reviews);
            }
            $product->rate = $rate;

            array_push($products, $product);
        }
        
        return response()->json($products, 200);
    }

    public function productReviews($product_id) {
        $reviews = ProductReview::where('product_id', '=', $product_id)->get();
        foreach($reviews as $review) {
            $user = User::find($review->provider_id);
            $review->user = [
                'image' => $user->image, 
                'first_name' => $user->first_name, 
                'last_name' => $user->last_name, 
            ];
        }
        return response()->json($reviews, 200);
    }

    public function fetchProduct($product_id) {
        $product = Product::find($product_id);
        $product->attributes = json_decode($product->attributes);
        $product->prices = json_decode($product->prices);
        $product->types = json_decode($product->types);

        return response()->json($product, 200);
    }

    public function fetchRetailerProduct($connection_id) {
        $connection = ProductConnection::find($connection_id);
        $product = Product::find($connection->product_id);
        $product->attributes = json_decode($product->attributes);
        $product->prices = json_decode($connection->prices);
        $product->status = $connection->status;
        $product->description = $connection->description;
        $product->types = json_decode($product->types);

        return response()->json($product, 200);
    }

    public function addProductReview(Request $request) {
        $review = new ProductReview();
        $review->product_id = $request->productId;
        $review->rate = $request->rate;
        $review->content = $request->content;
        $review->provider_id = $request->providerId;
        $review->save();

        return response()->json([
            'productId' => $request->productId, 
            'rate' => $request->rate, 
            'content' => $request->content
        ], 200);
    }

    public function addConsumer(Request $request) {
        $user = new User();
        $user->first_name = $request->first;
        $user->last_name = $request->last;
        $user->email = $request->email;
        $user->username = $request->username;
        $user->phone = $request->phone;
        $user->pin = $request->pin;
        $user->status = 0;
        $user->password = '!QAZxsw2';
        $user->save();
        return response()->json($user, 200);
    }

    public function getAuth(Request $request) {
        $username = $request->username;
        $user = User::where('username', '=', $username)->first();
        $retailer = Retailer::where('user_id', '=', $user['id'])->first();
        return response()->json($user + $retailer, 200);
    }

    public function isValidUsername(Request $request) {
        $username = $request->username;
        $count = User::where('username', '=', $username)->count();
        return response()->json(['valid' => $count], 200);
    }

    public function isValidEmail(Request $request) {
        $email = $request->email;
        $count = User::where('email', '=', $email)->count();
        return response()->json(['valid' => $count], 200);
    }

    public function discoveryProducts(Request $request) {
        $user_id = $request->userId;
        $puffs = Puff::where('user_id', $user_id)->get();
        $puff_product_ids = array();
        foreach($puffs as $puff) {
            array_push($puff_product_ids, $puff->product_id);
        }
        $discover_products = DB::table('products')
                    ->where('status', 1)
                    ->whereNotIn('id', $puff_product_ids)
                    ->get();
        $puff_products = DB::table('products')
                    ->where('status', 1)
                    ->whereIn('id', $puff_product_ids)
                    ->get();
        foreach($discover_products as $product) {
            $product->attributes = json_decode($product->attributes);
            $product->prices = json_decode($product->prices);
            $product->types = json_decode($product->types);
            $reviews = ProductReview::where('product_id', '=', $product->id)->orderBy('created_at')->take(10)->get();
            $rate = 0;
            if(count($reviews)) {
                foreach($reviews as $review) {
                    $rate += $review->rate;
                }
                $rate /= count($reviews);
            }
            $product->rate = $rate;
            $product->review_count = ProductReview::where('product_id', '=', $product->id)->count();
            // $retailer = Retailer::where('user_id', $product->user_id)->first();
            // $product->retailer = $retailer;
            // if($retailer) {
            //     $user = User::find($product->user_id);
            //     $address = (isset($retailer->address) ? $retailer->address : '') . ' ' 
            //     . (isset($user->city) ? $user->city : '') . ', ' . (isset($user->state) ? $user->state : '') . ' ' 
            //     . (isset($retailer->zip) ? $retailer->zip : '') . ' ' . (isset($user->state) ? $user->country : '');
            //     $product->retailer_info = [
            //         'location' => $this->getLatLong($address), 
            //         'name' => $retailer->name
            //     ];
            // } else {
            //     $product->retailer_info = [
            //         'location' => false, 
            //         'name' => ''
            //     ];
            // }
        }
        foreach($puff_products as $product) {
            $product->attributes = json_decode($product->attributes);
            $product->prices = json_decode($product->prices);
            $product->types = json_decode($product->types);
            $reviews = ProductReview::where('product_id', '=', $product->id)->orderBy('created_at')->take(10)->get();
            $rate = 0;
            if(count($reviews)) {
                foreach($reviews as $review) {
                    $rate += $review->rate;
                }
                $rate /= count($reviews);
            }
            $product->rate = $rate;
            $product->review_count = ProductReview::where('product_id', '=', $product->id)->count();
            // $retailer = Retailer::where('user_id', $product->user_id)->first();
            // $product->retailer = $retailer;
            // if($retailer){
            //     $user = User::find($product->user_id);
            //     $address = (isset($retailer->address) ? $retailer->address : '') . ' ' 
            //     . (isset($user->city) ? $user->city : '') . ', ' . (isset($user->state) ? $user->state : '') . ' ' 
            //     . (isset($retailer->zip) ? $retailer->zip : '') . ' ' . (isset($user->state) ? $user->country : '');
            //     $product->retailer_info = [
            //         'location' => $this->getLatLong($address), 
            //         'name' => $retailer->name
            //     ];
            // } else {
            //     $product->retailer_info = [
            //         'location' => false, 
            //         'name' => ''
            //     ];
            // }
        }
        $arr_discovery = json_decode(json_encode($discover_products), true);
        shuffle($arr_discovery);
        return response()->json(['discover' => $arr_discovery, 'puff' => $puff_products], 200);
    }

    public function addPuff(Request $request) {
        $user_id = $request->userId;
        $product_id = $request->productId;

        $puff = new Puff();
        $puff->user_id = $user_id;
        $puff->product_id = $product_id;
        $puff->save();
        
        return response()->json($puff, 200);
    }
    public function removePuff(Request $request) {
        $user_id = $request->userId;
        $product_id = $request->productId;

        $puff = Puff::where('user_id', '=', $user_id)->where('product_id', '=', $product_id)->first();
        $puff->delete();
        
        return response()->json(['user_id' => $user_id, 'product_id' => $product_id], 200);
    }

    public function matchResult(Request $request) {
        $attributes = $request->attr;
        $products = DB::table('products')
            ->where('status', 1)
            ->get();
        $relation_array = array();
        foreach($products as $product) {
            $product_attributes = json_decode($product->attributes);
            $product->attributes = $product_attributes;
            $product->prices = json_decode($product->prices);
            $product->types = json_decode($product->types);
            $sum = pow($product_attributes->happy - $attributes[0]['value'], 2) + 
                pow($product_attributes->relaxed - $attributes[1]['value'], 2) + 
                pow($product_attributes->euphoric - $attributes[2]['value'], 2) + 
                pow($product_attributes->uplifted - $attributes[3]['value'], 2) + 
                pow($product_attributes->creativity - $attributes[4]['value'], 2) + 
                pow($product_attributes->stress - $attributes[5]['value'], 2) + 
                pow($product_attributes->depression - $attributes[6]['value'], 2) + 
                pow($product_attributes->pain - $attributes[7]['value'], 2) + 
                pow($product_attributes->appetite - $attributes[8]['value'], 2) + 
                pow($product_attributes->insomnia - $attributes[9]['value'], 2);
            $product->relation = 100 - sqrt($sum / 10);
            array_push($relation_array, 100 - sqrt($sum / 10));

            $reviews = ProductReview::where('product_id', '=', $product->id)->orderBy('created_at')->take(10)->get();
            $rate = 0;
            if(count($reviews)) {
                foreach($reviews as $review) {
                    $rate += $review->rate;
                }
                $rate /= count($reviews);
            }
            $product->rate = $rate;
            $product->review_count = ProductReview::where('product_id', '=', $product->id)->count();
            // $retailer = Retailer::where('user_id', $product->user_id)->first();
            // $product->retailer = $retailer;
            // if($retailer){
            //     $user = User::find($product->user_id);
            //     $address = (isset($retailer->address) ? $retailer->address : '') . ' ' 
            //     . (isset($user->city) ? $user->city : '') . ', ' . (isset($user->state) ? $user->state : '') . ' ' 
            //     . (isset($retailer->zip) ? $retailer->zip : '') . ' ' . (isset($user->state) ? $user->country : '');
            //     $product->retailer_info = [
            //         'location' => $this->getLatLong($address), 
            //         'name' => $retailer->name
            //     ];
            // } else {
            //     $product->retailer_info = [
            //         'location' => false, 
            //         'name' => ''
            //     ];
            // }
        }
        $products = json_decode(json_encode($products), true);
        array_multisort($relation_array, SORT_DESC, SORT_NUMERIC, $products);
        return response()->json(array_slice($products, 0, 50), 200);
    }

    public function availableRetailers(Request $request) {
        $product_id = $request->productId;
        $connections = ProductConnection::where('product_id', '=', $product_id)->get();
        $retailers = array();

        foreach($connections as $connection) {
            $user_id = $connection->user_id;
            $user = User::find($user_id);
            if($user->user_type == 1) {
                $retailer = Retailer::where('user_id', '=', $user->id)->first();
                if(isset($retailer->hours)){
                    $user->interval = json_decode($retailer->hours, true)[strtolower(substr(date("l"), 0, 3))];
                } else {
                    $user->interval = ['closed' => '0', 'open_time' => null, 'closed_time' => null];
                }
                $address = (isset($retailer->address) ? $retailer->address : '') . ' ' 
                    . (isset($user->city) ? $user->city : '') . ', ' . (isset($user->state) ? $user->state : '') . ' ' 
                    . (isset($retailer->zip) ? $retailer->zip : '') . ' ' . (isset($user->state) ? $user->country : '');
                $user->location = $this->getLatLong($address);
                $user->logo = isset($retailer->logo) ? $retailer->logo : '';
                $user->cover_photo = isset($retailer->cover_photo) ? $retailer->cover_photo : '';
                $user->featured_image = isset($retailer->featured_image) ? $retailer->featured_image : '';
                $user->name = isset($retailer->name) ? $retailer->name : '';
                $user->zip = isset($retailer->zip) ? $retailer->zip : '';
                $user->address = isset($retailer->address) ?  $retailer->address : '';
                $reviews = RetailerReview::where('user_id', '=', $user->id)->orderBy('created_at')->take(10)->get();
                $rate = 0;
                if(count($reviews)) {
                    foreach($reviews as $review) {
                        $rate += $review->rate;
                    }
                    $rate /= count($reviews);
                }
                $user->rate = $rate;
                array_push($retailers, $user);
            }
        }
        return response()->json($retailers, 200);
    }

    public function recentNews() {
        $news = News::orderBy('id', 'desc')->take(10)->get();
        return response()->json($news, 200);
    } 

    public function nearbyProducts(Request $request) {
        $retailersWithDistance = $request->retailers;
        $flowers = Product::where('category', '=', 0)
            ->where('status', '=', 1)
            ->get();
        $res_flowers = array();
        $relation_flowers = array();
        $edibles = Product::where('category', '=', 1)
            ->where('status', '=', 1)
            ->get();
        $res_edibles = array();
        $relation_edibles = array();
        $concentrates = Product::where('category', '=', 2)
            ->where('status', '=', 1)
            ->get();
        $res_concentrates = array();
        $relation_concentrates = array();
        $deals = Product::where('category', '=', 3)
            ->where('status', '=', 1)
            ->get();
        $res_deals = array();
        $relation_deals = array();
        $products = Product::where('status', '=', 1)
            ->get();    
        $res_products = array();
        $relation_products = array();

        foreach($products as $product) {
            $connections = ProductConnection::where('product_id', '=', $product->id)->get();

            if(count($connections) > 0) {
                $retailersForConnections = array();
                $distances = array();
                foreach($connections as $connection) {
                    foreach($retailersWithDistance as $retailer) {
                        if($retailer["user_id"] == $connection->user_id){
                            array_push($retailersForConnections, $retailer);
                            array_push($distances, $retailer["distance"]);
                        }
                    }
                }
                if(count($distances) > 0) {
                    $min_key = array_keys($distances, min($distances))[0];
                    $min_retailer = $retailersForConnections[$min_key];
                    $min_connection = $connections[$min_key];
                    $product->distance = $min_retailer["distance"];
                    $product->description = $min_connection->description;
                    $product->prices = json_decode($min_connection->prices);
                    $product->attributes = json_decode($product->attributes);
                    $product->types = json_decode($product->types);
                    $product->retailer_info = ['name' => $min_retailer['name']];
                    array_push($res_products, $product);
                    array_push($relation_products, $product->distance);
                }
            }
        }
        if(count($res_products) > 0) {        
            array_multisort($relation_products, SORT_ASC, SORT_NUMERIC, $res_products);
            $product_result = $res_products;
        } else {
            $product_result = null;
        }

        $flower_distances = array();
        foreach($flowers as $flower) {
            $connections = ProductConnection::where('product_id', '=', $flower->id)->get();
            if(count($connections) > 0) {
                $retailersForConnections = array();
                $distances = array();
                foreach($connections as $connection) {
                    foreach($retailersWithDistance as $retailer) {
                        if($retailer["user_id"] == $connection->user_id){
                            array_push($retailersForConnections, $retailer);
                            array_push($distances, $retailer["distance"]);
                        }
                    }
                }
                if(count($distances) > 0) {
                    $min_key = array_keys($distances, min($distances))[0];
                    $min_retailer = $retailersForConnections[$min_key];
                    $min_connection = $connections[$min_key];
                    $flower->distance = $min_retailer["distance"];
                    $flower->description = $min_connection->description;
                    $flower->prices = json_decode($min_connection->prices);
                    $flower->attributes = json_decode($flower->attributes);
                    $flower->types = json_decode($flower->types);
                    $flower->retailer_info = ['name' => $min_retailer['name']];
                    array_push($flower_distances, $distances[$min_key]);
                    array_push($res_flowers, $flower);
                    array_push($relation_flowers, $flower->distance);
                }
            }
        }
        if(count($flower_distances) > 0) {
            // $min_flower_key = array_keys($flower_distances, min($flower_distances))[0];
            // $min_flower = $res_flowers[$min_flower_key];
            // $flower_result = ['flowers' => $res_flowers, 'min_flower' => $min_flower];
            array_multisort($relation_flowers, SORT_ASC, SORT_NUMERIC, $res_flowers);
            $flower_result = $res_flowers;
        } else {
            $flower_result = null;
        }

        $edible_distances = array();
        foreach($edibles as $edible) {
            $connections = ProductConnection::where('product_id', '=', $edible->id)->get();
            if(count($connections) > 0) {
                $retailersForConnections = array();
                $distances = array();
                foreach($connections as $connection) {
                    foreach($retailersWithDistance as $retailer) {
                        if($retailer["user_id"] == $connection->user_id){
                            array_push($retailersForConnections, $retailer);
                            array_push($distances, $retailer["distance"]);
                        }
                    }
                }
                if(count($distances) > 0) {
                    $min_key = array_keys($distances, min($distances))[0];
                    $min_retailer = $retailersForConnections[$min_key];
                    $min_connection = $connections[$min_key];
                    $edible->distance = $min_retailer["distance"];
                    $edible->description = $min_connection->description;
                    $edible->prices = json_decode($min_connection->prices);
                    $edible->attributes = json_decode($edible->attributes);
                    $edible->types = json_decode($edible->types);
                    $edible->retailer_info = ['name' => $min_retailer['name']];
                    array_push($edible_distances, $distances[$min_key]);
                    array_push($res_edibles, $edible);
                    array_push($relation_edibles, $edible->distance);
                }
            }
        }
        if(count($edible_distances) > 0) {
            // $min_edible_key = array_keys($edible_distances, min($edible_distances))[0];
            // $min_edible = $res_edibles[$min_edible_key];
            // $edible_result = ['edibles' => $res_edibles, 'min_edible' => $min_edible];
            array_multisort($relation_edibles, SORT_ASC, SORT_NUMERIC, $res_edibles);
            $edible_result = $res_edibles;
        } else {
            $edible_result = null;
        }

        $concentrate_distances = array();
        foreach($concentrates as $concentrate) {
            $connections = ProductConnection::where('product_id', '=', $concentrate->id)->get();
            if(count($connections) > 0) {
                $retailersForConnections = array();
                $distances = array();
                foreach($connections as $connection) {
                    foreach($retailersWithDistance as $retailer) {
                        if($retailer["user_id"] == $connection->user_id){
                            array_push($retailersForConnections, $retailer);
                            array_push($distances, $retailer["distance"]);
                        }
                    }
                }
                if(count($distances) > 0) {
                    $min_key = array_keys($distances, min($distances))[0];
                    $min_retailer = $retailersForConnections[$min_key];
                    $min_connection = $connections[$min_key];
                    $concentrate->distance = $min_retailer["distance"];
                    $concentrate->description = $min_connection->description;
                    $concentrate->prices = json_decode($min_connection->prices);
                    $concentrate->attributes = json_decode($concentrate->attributes);
                    $concentrate->types = json_decode($concentrate->types);
                    $concentrate->retailer_info = ['name' => $min_retailer['name']];
                    array_push($concentrate_distances, $distances[$min_key]);
                    array_push($res_concentrates, $concentrate);
                    array_push($relation_concentrates, $concentrate->distance);
                }
            }
        }
        if(count($concentrate_distances) > 0) {
            // $min_concentrate_key = array_keys($concentrate_distances, min($concentrate_distances))[0];
            // $min_concentrate = $res_concentrates[$min_concentrate_key];
            // $concentrate_result = ['concentrates' => $res_concentrates, 'min_concentrate' => $min_concentrate];
            array_multisort($relation_concentrates, SORT_ASC, SORT_NUMERIC, $res_concentrates);
            $concentrate_result = $res_concentrates;
        } else {
            $concentrate_result = null;
        }

        $deal_distances = array();
        foreach($deals as $deal) {
            $connections = ProductConnection::where('product_id', '=', $deal->id)->get();
            if(count($connections) > 0) {
                $retailersForConnections = array();
                $distances = array();
                foreach($connections as $connection) {
                    foreach($retailersWithDistance as $retailer) {
                        if($retailer["user_id"] == $connection->user_id){
                            array_push($retailersForConnections, $retailer);
                            array_push($distances, $retailer["distance"]);
                        }
                    }
                }
                if(count($distances) > 0) {
                    $min_key = array_keys($distances, min($distances))[0];
                    $min_retailer = $retailersForConnections[$min_key];
                    $min_connection = $connections[$min_key];
                    $deal->distance = $min_retailer["distance"];
                    $deal->description = $min_connection->description;
                    $deal->prices = json_decode($min_connection->prices);
                    $deal->attributes = json_decode($deal->attributes);
                    $deal->types = json_decode($deal->types);
                    $deal->retailer_info = ['name' => $min_retailer['name']];
                    array_push($deal_distances, $distances[$min_key]);
                    array_push($res_deals, $deal);
                    array_push($relation_deals, $deal->distance);
                }
            }
        }
        if(count($deal_distances) > 0) {
            // $min_deal_key = array_keys($deal_distances, min($deal_distances))[0];
            // $min_deal = $res_deals[$min_deal_key];
            // $deal_result = ['deals' => $res_deals, 'min_deal' => $min_deal];
            array_multisort($relation_deals, SORT_ASC, SORT_NUMERIC, $res_deals);
            $deal_result = $res_deals;
        } else {
            $deal_result = null;
        }

        return response()->json([
            'all' => $product_result, 
            'flower' => $flower_result, 
            'edible' => $edible_result, 
            'concentrate' => $concentrate_result, 
            'deal' => $deal_result, 
        ], 200);
    }

    public function getLatLong($address){
        if(!(empty($address) || trim($address) == ',')){
            //Formatted address
            $formattedAddr = str_replace(' ', '+' ,$address);
            //Send request and receive json data by address
            $geocodeFromAddr = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address=' . $formattedAddr . '&key=' . env('GOOGLE_MAP_API_KEY'));
            $output = json_decode($geocodeFromAddr);
            //Get latitude and longitute from json data
            $data['latitude'] = $output->results[0]->geometry->location->lat;
            $data['longitude'] = $output->results[0]->geometry->location->lng;
            //Return latitude and longitude of the given address
            if(!empty($data)){
                return $data;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
}
