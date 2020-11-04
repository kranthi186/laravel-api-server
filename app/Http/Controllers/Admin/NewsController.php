<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\News;
use Validator;

class NewsController extends Controller
{
    public function index() {

    }

    public function addNews(Request $request) {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            return redirect()->back()
                    ->with('data', $request->all())
                    ->withErrors($validator);
        }

        $status = $request->news_status;
        $category = $request->news_category;
        $title = $request->title;
        $link = $request->link ? $request->link : '';
        $date = $request->date ? $request->date: '';

        $news = new News();
        $news->status = $status;
        $news->category = $category;
        $news->title = $title;
        $news->link = $link;
        $news->date = $date;

        if($request->file('photo')) {
            // $img_photo = $request->file('photo');
            // $photo_name = 'photo-' . date("Ymd") . '-' . time() . '.' . $img_photo->getClientOriginalExtension();
            // $img_photo->move(public_path('/uploads'), $photo_name);
            // $news->photo = $photo_name;
            $photo_name = $request->file('photo')->store('uploads', 's3', 'public');
            $news->photo = env('AWS_UPLOAD_URL') . $photo_name;
        }
        $news->save();

        return redirect()->to('/news');
    }

    public function editNews($id, Request $request) {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            return redirect()->back()
                    ->with('data', $request->all())
                    ->withErrors($validator);
        }

        $status = $request->news_status;
        $category = $request->news_category;
        $title = $request->title;
        $link = $request->link ? $request->link : '';
        $date = $request->date ? $request->date: '';

        $news = News::find($id);
        $news->status = $status;
        $news->category = $category;
        $news->title = $title;
        $news->link = $link;
        $news->date = $date;

        if($request->file('photo')) {
            // $img_photo = $request->file('photo');
            // $photo_name = 'photo-' . date("Ymd") . '-' . time() . '.' . $img_photo->getClientOriginalExtension();
            // $img_photo->move(public_path('/uploads'), $photo_name);
            // $news->photo = $photo_name;
            $photo_name = $request->file('photo')->store('uploads', 's3', 'public');
            $news->photo = env('AWS_UPLOAD_URL') . $photo_name;
        }
        $news->save();

        return redirect()->to('/news');  
    }

    protected function validator(array $data)
    {
        $messages = [
            'title.required' => 'Required title',
            'news_category.min' => 'Required Article Category', 
        ];

        return Validator::make($data, [
            'news_category' => ['min:1'], 
            'title' => ['required', 'string', 'max:255'],
        ], $messages);
    }
}
