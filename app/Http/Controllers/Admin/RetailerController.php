<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Retailer;
use App\Models\Product;
use App\Models\ProductConnection;
use BlackBits\LaravelCognitoAuth\CognitoClient;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Validator;

class RetailerController extends Controller
{
    public function index()
    {
        $users = User::where('user_type', 1)->get();
        foreach ($users as $user) {
            $user_id = $user->id;
            $retailer = Retailer::where('user_id', $user_id)->first();
            $user->products = ProductConnection::where('user_id', $user_id)->count();

            if ($retailer) {
                $user->logo = $retailer->logo;
                $user->name = $retailer->name;
                $user->address = $retailer->address;
                $user->cover_photo = $retailer->cover_photo;
                $user->website = $retailer->website;
                $user->featured_image = $retailer->featured_image;
                $user->hours = $retailer->hours;
            } else {
                $user->logo = '';
                $user->name = '';
                $user->address = '';
                $user->cover_photo = '';
                $user->website = '';
                $user->featured_image = '';
                $user->hours = json_encode([]);
            }
        }
        return view('admin.retailer.retailers', ['page' => 'retailers', 'users' => $users]);
    }

    public function addRetailer(Request $request, CognitoClient $cognitoClient)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            return redirect()->back()
                    ->with('data', $request->all())
                    ->withErrors($validator);
        }

        $status = $request->retailer_status;
        $email = $request->email;
        $password = '!QAZxsw2';
        $name = $request->name;
        $address = $request->address1;
        $city = $request->city;
        $state = $request->state;
        $zip = $request->zip;
        $country = $request->country;
        $phone = $request->phone;
        $website = $request->website;

        $hours = [
            'sun' => [
                'closed' => $request->sunday_closed == "on" ? 1 : 0,
                'open_time' => $request->hours_sunday_open,
                'closed_time' => $request->hours_sunday_closed,
            ],
            'mon' => [
                'closed' => $request->monday_closed == "on" ? 1 : 0,
                'open_time' => $request->hours_monday_open,
                'closed_time' => $request->hours_monday_closed,
            ],
            'tue' => [
                'closed' => $request->tuesday_closed == "on" ? 1 : 0,
                'open_time' => $request->hours_tuesday_open,
                'closed_time' => $request->hours_tuesday_closed,
            ],
            'wed' => [
                'closed' => $request->wednesday_closed == "on" ? 1 : 0,
                'open_time' => $request->hours_wednesday_open,
                'closed_time' => $request->hours_wednesday_closed,
            ],
            'thu' => [
                'closed' => $request->thursday_closed == "on" ? 1 : 0,
                'open_time' => $request->hours_thursday_open,
                'closed_time' => $request->hours_thursday_closed,
            ],
            'fri' => [
                'closed' => $request->friday_closed == "on" ? 1 : 0,
                'open_time' => $request->hours_friday_open,
                'closed_time' => $request->hours_friday_closed,
            ],
            'sat' => [
                'closed' => $request->saturday_closed == "on" ? 1 : 0,
                'open_time' => $request->hours_saturday_open,
                'closed_time' => $request->hours_saturday_closed,
            ],
        ];

        $attributes = [
            'phone_number' => ''
        ];

        app()->make(CognitoClient::class)->register($email, $password, $attributes);

        $cognitoClient->setUserAttributes($email, [
            'email_verified' => 'true',
        ]);
        $cognitoClient->confirmSignUp($email);

        $user = new User();
        $user->username = $email;
        $user->status = $status;
        $user->email = $email;
        $user->password = Hash::make($password);
        if ($city) {
            $user->city = $city;
        }
        if ($state) {
            $user->state = $state;
        }
        if ($country) {
            $user->country = $country;
        }
        if ($phone) {
            $user->phone = $phone;
        }
        $user->user_type = 1;
        $user->save();

        $retailer = new Retailer();
        $retailer->user_id = $user->id;
        if($name) {
            $retailer->name = $name;
        }

        if($request->file('logo')) {
            // $img_logo = $request->file('logo');
            // $logo_name = 'logo-' . date("Ymd") . '-' . time() . '.' . $img_logo->getClientOriginalExtension();
            // $img_logo->move(public_path('/uploads'), $logo_name);
            // $retailer->logo = $logo_name;
            $logo_name = $request->file('logo')->store('uploads', 's3', 'public');
            $retailer->logo = env('AWS_UPLOAD_URL') . $logo_name;
        }

        if($request->file('cover')) {
            // $img_cover = $request->file('cover');
            // $cover_name = 'cover-' . date("Ymd") . '-' . time() . '.' . $img_cover->getClientOriginalExtension();
            // $img_cover->move(public_path('/uploads'), $cover_name);
            // $retailer->cover_photo = $cover_name;
            $cover_name = $request->file('cover')->store('uploads', 's3', 'public');
            $retailer->cover_photo = env('AWS_UPLOAD_URL') . $cover_name;
        }

        if($request->file('featured')) {
            // $img_featured = $request->file('featured');
            // $featured_name = 'featured-' . date("Ymd") . '-' . time() . '.' . $img_featured->getClientOriginalExtension();
            // $img_featured->move(public_path('/uploads'), $featured_name);
            // $retailer->featured_image = $featured_name;
            $featured_name = $request->file('featured')->store('uploads', 's3', 'public');
            $retailer->featured_image = env('AWS_UPLOAD_URL') . $featured_name;
        }

        if($address) {
            $retailer->address = $address;
        }
        if($zip) {
            $retailer->zip = $zip;
        }
        if($website) {
            $retailer->website = $website;
        }
        $retailer->hours = json_encode($hours);
        $retailer->save();

        return redirect()->to('/retailers');
    }

    public function getEditRetailer($id)
    {
        $user = User::find($id);
        $user_id = $user->id;
        $retailer = Retailer::where('user_id', $user_id)->first();

        if ($retailer) {
            $user->logo = $retailer->logo;
            $user->name = $retailer->name;
            $user->address = $retailer->address;
            $user->zip = $retailer->zip;
            $user->cover_photo = $retailer->cover_photo;
            $user->website = $retailer->website;
            $user->featured_image = $retailer->featured_image;
            $user->hours = json_decode($retailer->hours);
        } else {
            $user->logo = '';
            $user->name = '';
            $user->address = '';
            $user->zip = '';
            $user->cover_photo = '';
            $user->website = '';
            $user->featured_image = '';
            $user->hours = json_decode(json_encode([
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
            ]), false);
        }
        return view('admin.retailer.edit_retailer', ['page' => 'retailers', 'user' => $user]);
    }

    public function postEditRetailer($id, Request $request, CognitoClient $cognitoClient)
    {
        // echo $request->address; exit;
        $validator = $this->updateValidator($request->all());

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $user = User::find($id);
        $oldEmail = $user->email;

        $status = $request->retailer_status;
        $email = $request->email;
        $password = $request->password;
        $name = $request->name;
        $address = $request->address1;
        $city = $request->city;
        $state = $request->state;
        $zip = $request->zip;
        $country = $request->country;
        $phone = $request->phone;
        $website = $request->website;

        $hours = [
            'sun' => [
                'closed' => $request->sunday_closed == "on" ? 1 : 0,
                'open_time' => $request->hours_sunday_open,
                'closed_time' => $request->hours_sunday_closed,
            ],
            'mon' => [
                'closed' => $request->monday_closed == "on" ? 1 : 0,
                'open_time' => $request->hours_monday_open,
                'closed_time' => $request->hours_monday_closed,
            ],
            'tue' => [
                'closed' => $request->tuesday_closed == "on" ? 1 : 0,
                'open_time' => $request->hours_tuesday_open,
                'closed_time' => $request->hours_tuesday_closed,
            ],
            'wed' => [
                'closed' => $request->wednesday_closed == "on" ? 1 : 0,
                'open_time' => $request->hours_wednesday_open,
                'closed_time' => $request->hours_wednesday_closed,
            ],
            'thu' => [
                'closed' => $request->thursday_closed == "on" ? 1 : 0,
                'open_time' => $request->hours_thursday_open,
                'closed_time' => $request->hours_thursday_closed,
            ],
            'fri' => [
                'closed' => $request->friday_closed == "on" ? 1 : 0,
                'open_time' => $request->hours_friday_open,
                'closed_time' => $request->hours_friday_closed,
            ],
            'sat' => [
                'closed' => $request->saturday_closed == "on" ? 1 : 0,
                'open_time' => $request->hours_saturday_open,
                'closed_time' => $request->hours_saturday_closed,
            ],
        ];

        $attributes = [
            'phone_number' => ''
        ];

        if ($password) {
            if($password != '') {
                $cognitoClient->setUserPassword($oldEmail, $password);
            }
        }
        $cognitoClient->setUserAttributes($oldEmail, [
            'email' => $email,
            'email_verified' => 'true',
        ]);

        $user->username = $email;
        $user->status = $status;
        $user->email = $email;
        if ($password) {
            if($password != '') {
                $user->password = Hash::make($password);
            }
        }
        if ($city) {
            $user->city = $city;
        }
        if ($state) {
            $user->state = $state;
        }
        if ($country) {
            $user->country = $country;
        }
        if ($phone) {
            $user->phone = $phone;
        }
        $user->save();

        $retailer = Retailer::where('user_id', $user->id)->first();
        if(!$retailer) {
            $retailer = new Retailer();
            $retailer->user_id = $user->id;
        }
        if ($name) {
            $retailer->name = $name;
        }

        if ($request->file('logo')) {
            // $img_logo = $request->file('logo');
            // $logo_name = 'logo-' . date("Ymd") . '-' . time() . '.' . $img_logo->getClientOriginalExtension();
            // $img_logo->move(public_path('/uploads'), $logo_name);
            // $retailer->logo = $logo_name;
            $logo_name = $request->file('logo')->store('uploads', 's3', 'public');
            $retailer->logo = env('AWS_UPLOAD_URL') . $logo_name;
        }

        if ($request->file('cover')) {
            // $img_cover = $request->file('cover');
            // $cover_name = 'cover-' . date("Ymd") . '-' . time() . '.' . $img_cover->getClientOriginalExtension();
            // $img_cover->move(public_path('/uploads'), $cover_name);
            // $retailer->cover_photo = $cover_name;
            $cover_name = $request->file('cover')->store('uploads', 's3', 'public');
            $retailer->cover_photo = env('AWS_UPLOAD_URL') . $cover_name;
        }

        if ($request->file('featured')) {
            // $img_featured = $request->file('featured');
            // $featured_name = 'featured-' . date("Ymd") . '-' . time() . '.' . $img_featured->getClientOriginalExtension();
            // $img_featured->move(public_path('/uploads'), $featured_name);
            // $retailer->featured_image = $featured_name;
            $featured_name = $request->file('featured')->store('uploads', 's3', 'public');
            $retailer->featured_image = env('AWS_UPLOAD_URL') . $featured_name;
        }

        if($address) {
            $retailer->address = $address;
        }
        if($zip) {
            $retailer->zip = $zip;
        }
        if($website) {
            $retailer->website = $website;
        }
        $retailer->hours = json_encode($hours);
        $retailer->save();

        return redirect()->to('/retailers');
    }

    protected function validator(array $data)
    {
        $messages = [
            'email.required' => 'Required email',
            'email.email' => 'Email is incorrect',
            'email.unique' => 'Existed email',
            // 'password.required' => 'Required password',
            // 'password.regex' => 'Password should be contain uppercase and lowercase character, at least 1 number and at least 1 symbol.',
            // 'password.min' => 'Password minimum length is 8',
        ];

        return Validator::make($data, [
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            // 'password' => ['required', 'string', 'min:8', 'regex:/^(?=.*[!@#$%^&*-])(?=.*[0-9])(?=.*[A-Z]).{8,20}$/'],
        ], $messages);
    }

    protected function updateValidator(array $data)
    {
        $messages = [
            'email.required' => 'Required email',
            'email.email' => 'Email is incorrect',
            // 'password.required' => 'Required password',
            // 'password.regex' => 'Password should be contain uppercase and lowercase character, at least 1 number and at least 1 symbol.',
            // 'password.min' => 'Password minimum length is 8',
        ];

        return Validator::make($data, [
            'email' => ['required', 'string', 'email', 'max:255'],
            // 'password' => ['required', 'string', 'min:8', 'regex:/^(?=.*[!@#$%^&*-])(?=.*[0-9])(?=.*[A-Z]).{8,20}$/'],
        ], $messages);
    }

    public function manageRetailerProducts($id)
    {
        $user = User::find($id);
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

        return view('admin.retailer.manage_retailer_products', ['page' => 'retailers', 'user' => $user, 'products' => json_encode($products)]);
    }

    public function postAddRetailerProduct(Request $request, $user_id)
    {
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
        
        return redirect()->to('/manage_retailer_products/' . $user_id);
    }

    public function postEditRetailerProduct(Request $request, $connection_id)
    {
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
        
        $product->popular = $popular;
        $product->name = $name;
        $product->types = json_encode($types);
        $product->category = $category;
        $product->attributes = json_encode($attributes);
        $product->save();
        
        return redirect()->to('/manage_retailer_products/' . $product->user_id);
    }
}
