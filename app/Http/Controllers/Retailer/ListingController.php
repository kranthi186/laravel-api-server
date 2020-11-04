<?php

namespace App\Http\Controllers\Retailer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

use App\Models\Retailer;
use App\Models\Brand;
use BlackBits\LaravelCognitoAuth\CognitoClient;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class ListingController extends Controller
{
    public function index() {
        $user = Auth::user();
        $user->license_type = json_decode($user->license_type);
        if($user->user_type == 1) {
            $retailer = Retailer::where('user_id', $user->id)->first();
            $retailer->hours = json_decode($retailer->hours);
        } else if($user->user_type == 2) {
            $retailer = Brand::where('user_id', $user->id)->first();
        }
        if(!$retailer){
            $retailer = (object)['name' => '', 'address' => '', 'website' => '', 'logo' => '', 'cover_photo' => '', 'featured_image' => ''];
        }
        return view('retailer.listing', [
            'page' => 'listing', 
            'kind' => 'app', 
            'user' => $user, 
            'retailer' => $retailer
        ]);
    }

    public function updateListing(Request $request, CognitoClient $cognitoClient) {
        $user = Auth::user();
        $oldEmail = $user->email;

        $email = $request->email;
        $name = $request->name;
        $address = $request->address1;
        $city = $request->city;
        $state = $request->state;
        $phone = $request->phone;
        $website = $request->website;
        $license_number = $request->license_number;
        $license_type = [
            'medical' => $request->license_medical, 
            'recreational' => $request->license_recreational
        ];

        if($user->user_type == 1) {
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
        }

        $attributes = [];

        if($email != $oldEmail) {
            $cognitoClient->setUserAttributes($oldEmail, [
                'email' => $email,
                'email_verified' => 'true',
            ]);
        }

        $user->username = $email;
        $user->email = $email;
        if ($city) {
            $user->city = $city;
        }
        if ($state) {
            $user->state = $state;
        }
        if ($phone) {
            $user->phone = $phone;
        }
        if($license_number) {
            $user->license_number = $license_number;
        }
        $user->license_type = json_encode($license_type);
        $user->save();

        if($user->user_type == 1){
            $retailer = Retailer::where('user_id', $user->id)->first();
            if(!$retailer) {
                $retailer = new Retailer();
                $retailer->user_id = $user->id;
            }
            if($address) {
                $retailer->address = $address;
            }
            if($website) {
                $retailer->website = $website;
            }
            $retailer->hours = json_encode($hours);
        } else if($user->user_type == 2) {
            $retailer = Brand::where('user_id', $user->id)->first();
            if(!$retailer) {
                $retailer = new Brand();
                $retailer->user_id = $user->id;
            }
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


        $retailer->save();

        return redirect()->to('/listing');
    }
}
