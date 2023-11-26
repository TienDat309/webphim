<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Movie_Genre;
use App\Models\Category;
use App\Models\Country;
use App\Models\Genre;
use App\Models\Episode;
use Carbon\Carbon; // xử lý thời gian (ngày tạo, cập nhật phim)
use Strogare;
use File;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function category_choose(Request $request){
        $data = $request->all();
        $movie = Movie::find($data['movie_id']);
        $movie->category_id = $data['category_id'];
        $movie->save();
    }

    public function country_choose(Request $request){
        $data = $request->all();
        $movie = Movie::find($data['movie_id']);
        $movie->country_id = $data['country_id'];
        $movie->save();
    }

    public function subtitle_choose(Request $request){
        $data = $request->all();
        $movie = Movie::find($data['movie_id']);
        $movie->subtitle = $data['subtitle_val'];
        $movie->save();
    }

    public function phim_hot_choose(Request $request){
        $data = $request->all();
        $movie = Movie::find($data['movie_id']);
        $movie->phim_hot = $data['phim_hot_val'];
        $movie->save();
    }

    public function status_choose(Request $request){
        $data = $request->all();
        $movie = Movie::find($data['movie_id']);
        $movie->status = $data['status_val'];
        $movie->save();
    }

    public function belongmovie_choose(Request $request){
        $data = $request->all();
        $movie = Movie::find($data['movie_id']);
        $movie->belongmovie = $data['belongmovie_val'];
        $movie->save();
    }

    public function resolution_choose(Request $request){
        $data = $request->all();
        $movie = Movie::find($data['movie_id']);
        $movie->resolution = $data['resolution_val'];
        $movie->save();
    }

    public function index()
    {
        $list = Movie::with('category','country','movie_genre','genre')->withCount('episode')->orderBy('id', 'DESC')->get();
        $category = Category::pluck('title','id');
        $country = Country::pluck('title','id');
        //tìm kiếm phim - đếm số tập
        $path = public_path()."/json/";
        if(!is_dir($path)) //is_dir rỗng -> path không tồn tại
        { 
            mkdir($path,0777,true); //mkdir tạo folder trong path/ 0777->toàn quyền thêm sửa xóa
        }
        File::put($path.'movie.json',json_encode($list));//lấy tất cả film trong data

        return view('admin.movie.index',compact('list','category','country'));
    }
    public function update_year(Request $request)
    {
        $data = $request->all();
        $movie = Movie::find($data['id_phim']);
        $movie->year = $data['year'];
        $movie->save();
    }

    public function update_season(Request $request)
    {
        $data = $request->all();
        $movie = Movie::find($data['id_phim']);
        $movie->season = $data['season'];
        $movie->save();
    }

    public function update_topview(Request $request)
    {
        $data = $request->all();
        $movie = Movie::find($data['id_phim']);
        $movie->topview = $data['topview'];
        $movie->save();
    }

    public function filter_topview(Request $request)
    {
        $data = $request->all();
        $movie = Movie::where('topview',$data['value'])->orderBy('updateday','DESC')->take(15)->get();
        $output = '';
        foreach($movie as $key => $mov){
            if($mov->resolution==0){
                $text = 'HD';
            }elseif($mov->resolution==1){
                $text = 'SD';
            }elseif($mov->resolution==2){
                $text = 'HDCam';
            }elseif($mov->resolution==3){
                $text = 'Cam';
            }elseif($mov->resolution==4){
                $text = 'FullHD';
            }else{
                $text = 'Trailer';
            }
            $output.='<div class="item">
                        <a href="'.url('phim/'.$mov->slug).'" title="'.$mov->title.'">
                            <div class="item-link">
                                <img src="'.url('uploads/movie/'.$mov->image).'" class="lazy post-thumb" alt="'.$mov->title.'" title="'.$mov->title.'" />
                                <span class="is_trailer">'.$text.'</span>
                            </div>
                            <p class="title">'.$mov->title.'</p>
                            </a>
                            <div class="viewsCount" style="color: #9d9d9d;">3.2K lượt xem</div>
                            <div style="float: left;">
                            <span class="user-rate-image post-large-rate stars-large-vang" style="display: block;/* width: 100%; */">
                            <span style="width: 0%"></span>
                            </span>
                        </div>
                    </div>';
        }
        echo $output;
    }

    public function filter_default(Request $request)
    {
        $data = $request->all();
        $movie = Movie::where('topview',0)->orderBy('updateday','DESC')->take(15)->get();
        $output = '';
        foreach($movie as $key => $mov){
            if($mov->resolution==0){
                $text = 'HD';
            }elseif($mov->resolution==1){
                $text = 'SD';
            }elseif($mov->resolution==2){
                $text = 'HDCam';
            }elseif($mov->resolution==3){
                $text = 'Cam';
            }elseif($mov->resolution==4){
                $text = 'FullHD';
            }else{
                $text = 'Trailer';
            }
            $output.='<div class="item">
                        <a href="'.url('phim/'.$mov->slug).'" title="'.$mov->title.'">
                            <div class="item-link">
                                <img src="'.url('uploads/movie/'.$mov->image).'" class="lazy post-thumb" alt="'.$mov->title.'" title="'.$mov->title.'" />
                                <span class="is_trailer">'.$text.'</span>
                            </div>
                            <p class="title">'.$mov->title.'</p>
                            </a>
                            <div class="viewsCount" style="color: #9d9d9d;">3.2K lượt xem</div>
                            <div style="float: left;">
                            <span class="user-rate-image post-large-rate stars-large-vang" style="display: block;/* width: 100%; */">
                            <span style="width: 0%"></span>
                            </span>
                        </div>
                    </div>';
        }
        echo $output;
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
        $list_genre = Genre::all();
        $country = Country::pluck('title','id');
        return view('admin.movie.form',compact('genre','country','category','list_genre'));
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
        $movie->trailer = $data['trailer'];
        $movie->episode_movie = $data['episode_movie'];
        $movie->tags = $data['tags'];
        $movie->time_movie = $data['time_movie'];
        $movie->resolution = $data['resolution'];
        $movie->subtitle = $data['subtitle'];
        $movie->name_eng = $data['name_eng'];
        $movie->phim_hot = $data['phim_hot'];
        $movie->slug = $data['slug'];
        $movie->description = $data['description'];
        $movie->status = $data['status'];
        $movie->category_id = $data['category_id'];
        $movie->belongmovie = $data['belongmovie'];
        $movie->country_id = $data['country_id'];
        $movie->datecreated = Carbon::now('Asia/Ho_Chi_Minh');
        $movie->updateday = Carbon::now('Asia/Ho_Chi_Minh');
        //thêm nhìu thể loại phim
        foreach ($data['genre'] as $key => $gen)
            $movie->genre_id = $gen[0];
            
        

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
        //thêm nhiều thể loại cho phim
        $movie->movie_genre()->sync($data['genre']);

        return redirect()->route('movie.index');
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
        $list_genre = Genre::all();
        $movie = Movie::find($id);
        $movie_genre = $movie->movie_genre;
        return view('admin.movie.form',compact('genre','country','category','movie','list_genre','movie_genre'));
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
        $movie->trailer = $data['trailer'];
        $movie->episode_movie = $data['episode_movie'];
        $movie->tags = $data['tags'];
        $movie->time_movie = $data['time_movie'];
        $movie->subtitle = $data['subtitle'];
        $movie->resolution = $data['resolution'];
        $movie->name_eng = $data['name_eng'];
        $movie->phim_hot = $data['phim_hot'];
        $movie->slug = $data['slug'];
        $movie->description = $data['description'];
        $movie->status = $data['status'];
        $movie->category_id = $data['category_id'];
        $movie->belongmovie = $data['belongmovie'];
        $movie->country_id = $data['country_id'];
        $movie->updateday = Carbon::now('Asia/Ho_Chi_Minh');
        foreach ($data['genre'] as $key => $gen)
            $movie->genre_id = $gen[0];

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

        $movie->movie_genre()->sync($data['genre']);

        return redirect()->route('movie.index');

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
       //xóa ảnh
       if(file_exists('uploads/movie/'.$movie->image)){
        unlink('uploads/movie/'.$movie->image);
       } 
       //xóa thể loại
       Movie_Genre::whereIn('movie_id',[$movie->id])->delete();

       //xóa tập phim
       Episode::whereIn('movie_id',[$movie->id])->delete();
       $movie->delete();

       return redirect()->back();
    }
}