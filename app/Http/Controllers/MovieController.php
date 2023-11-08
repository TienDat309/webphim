<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Category;
use App\Models\Country;
use App\Models\Genre;
use Carbon\Carbon; // xử lý thời gian (ngày tạo, cập nhật phim)

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $list = Movie::with('category','country','genre')->orderBy('id', 'DESC')->get();
        return view('admin.movie.index',compact('list'));
    }
    public function update_year(Request $request)
    {
        $data = $request->all();
        $movie = Movie::find($data['id_phim']);
        $movie->year = $data['year'];
        $movie->save();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = Category::pluck('title','id');
        $genre = Genre::pluck('title','id');
        $country = Country::pluck('title','id');
        return view('admin.movie.form',compact('genre','country','category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $movie = new Movie();
        $movie->title = $data['title'];
        $movie->time_movie = $data['time_movie'];
        $movie->resolution = $data['resolution'];
        $movie->subtitle = $data['subtitle'];
        $movie->name_eng = $data['name_eng'];
        $movie->phim_hot = $data['phim_hot'];
        $movie->slug = $data['slug'];
        $movie->description = $data['description'];
        $movie->status = $data['status'];
        $movie->category_id = $data['category_id'];
        $movie->genre_id = $data['genre_id'];
        $movie->country_id = $data['country_id'];
        $movie->datecreated = Carbon::now('Asia/Ho_Chi_Minh');
        $movie->updateday = Carbon::now('Asia/Ho_Chi_Minh');

        //them hinh ảnh
        $get_image = $request->file('image');
        if($get_image){
            $get_name_image = $get_image->getClientOriginalName();//hinhanh1.jpg
            $name_image = current(explode('.', $get_name_image));//[0]=> hinhanh123 . [1]=>jpg
            $new_image = $name_image.rand(0, 9999).'.'.$get_image->getClientOriginalExtension();//hinhanh123.jpg
            $get_image->move('uploads/movie/', $new_image);
            $movie->image = $new_image;
        }
        $movie->save();
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::pluck('title','id');
        $genre = Genre::pluck('title','id');
        $country = Country::pluck('title','id');
        $movie = Movie::find($id);
        return view('admin.movie.form',compact('genre','country','category','movie'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        $movie = Movie::find($id);
        $movie->title = $data['title'];
        $movie->time_movie = $data['time_movie'];
        $movie->subtitle = $data['subtitle'];
        $movie->resolution = $data['resolution'];
        $movie->name_eng = $data['name_eng'];
        $movie->phim_hot = $data['phim_hot'];
        $movie->slug = $data['slug'];
        $movie->description = $data['description'];
        $movie->status = $data['status'];
        $movie->category_id = $data['category_id'];
        $movie->genre_id = $data['genre_id'];
        $movie->country_id = $data['country_id'];
        $movie->updateday = Carbon::now('Asia/Ho_Chi_Minh');

        //them hinh ảnh
        $get_image = $request->file('image');
        if($get_image){
            if(file_exists('uploads/movie/'.$movie->image))
            {
                unlink('uploads/movie/'.$movie->image);
            } 
            $get_name_image = $get_image->getClientOriginalName();//hinhanh1.jpg
            $name_image = current(explode('.', $get_name_image));//[0]=> hinhanh123 . [1]=>jpg
            $new_image = $name_image.rand(0, 9999).'.'.$get_image->getClientOriginalExtension();//hinhanh123.jpg
            $get_image->move('uploads/movie/', $new_image);
            $movie->image = $new_image;
        }
        $movie->save();
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       $movie = Movie::find($id);
       if(file_exists('uploads/movie/'.$movie->image)){
        unlink('uploads/movie/'.$movie->image);
       } 
       $movie->delete();
    return redirect()->back();
    }
}
