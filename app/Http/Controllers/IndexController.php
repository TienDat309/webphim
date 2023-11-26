<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Genre;
use App\Models\Country;
use App\Models\Movie;
use App\Models\Episode;
use App\Models\Movie_Genre;
use App\Models\Rating;
use DB;

class IndexController extends Controller
{
    public function filter(){
            $sapxep = $_GET['order'];
            $genre_get = $_GET['genre'];
            $country_get = $_GET['country'];
            $year_get = $_GET['year'];
        if($sapxep==''&& $genre_get==''&& $country_get==''&& $year_get==''){
            return redirect()->back();
        }else{
            $category = Category::orderBy('position','ASC')->where('status',1)->get();
            $genre = Genre::orderBy('id','ASC')->get();   
            $country = Country::orderBy('id','ASC')->get();
            $phimhot_trailer = Movie::where('resolution',5)->where('status',1)->orderBy('updateday', 'DESC')->take(6)->get();
            //lấy dữ liệu
            $movie = Movie::withCount('episode');
            if($genre_get){
                $movie = $movie->where('genre_id','=',$genre_get);
            }elseif($country_get){
                $movie = $movie->where('country_id','=',$country_get);
            }elseif($year_get){
                $movie = $movie->where('year','=',$year_get);
            }elseif($order){
                $movie = $movie->orderBy('title','ASC');
            }
                $movie = $movie->orderBy('updateday', 'DESC')->paginate(24);
            return view('pages.filter', compact('category','genre','country','movie','phimhot_trailer'));
        }
    }
    

    public function search(){
        if(isset($_GET['search'])){
            $search = $_GET['search'];
            $category = Category::orderBy('position','ASC')->where('status',1)->get();
            $genre = Genre::orderBy('id','ASC')->get();   
            $country = Country::orderBy('id','ASC')->get();
            // $phimhot_sidebar = Movie::where('phim_hot',1)->where('status',1)->orderBy('updateday', 'DESC')->take(5)->get();
            $phimhot_trailer = Movie::where('resolution',5)->where('status',1)->orderBy('updateday', 'DESC')->take(6)->get();
            $movie = Movie::withCount('episode')->where('title','LIKE','%'.$search.'%')->orderBy('updateday', 'DESC')->paginate(24);
            return view('pages.search', compact('category','genre','country','search','movie','phimhot_trailer'));
        }else{
            return redirect()->to('/');
        }
    }
    public function home(){
        $phimhot = Movie::withCount('episode')->where('phim_hot',1)->where('status',1)->orderBy('updateday', 'DESC')->get();
        // $phimhot_sidebar = Movie::where('phim_hot',1)->where('status',1)->orderBy('updateday', 'DESC')->take(5)->get();
        $phimhot_trailer = Movie::where('resolution',5)->where('status',1)->orderBy('updateday', 'DESC')->take(6)->get();
        $category = Category::orderBy('position','ASC')->where('status',1)->get();
        $genre = Genre::orderBy('id','ASC')->get();   
        $country = Country::orderBy('id','ASC')->get();   
        $category_home = Category::with(['movie'=>function($q)
        {
            $q->withCount('episode')->where('status',1);
        }
        ])->orderBy('id','ASC')->where('status',1)->get();//nested trong laaravel
        return view('pages.home', compact('category','genre','country','category_home','phimhot','phimhot_trailer'));
    }
    public function category($slug){
        $category = Category::orderBy('position','ASC')->where('status',1)->get();
        $genre = Genre::orderBy('id','ASC')->get();   
        $country = Country::orderBy('id','ASC')->get();
        // $phimhot_sidebar = Movie::withCount('episode')->where('phim_hot',1)->where('status',1)->orderBy('updateday', 'DESC')->take(5)->get();
        $phimhot_trailer = Movie::where('resolution',5)->where('status',1)->orderBy('updateday', 'DESC')->take(6)->get();
        $cate_slug = Category::where('slug',$slug)->first();  
        $movie = Movie::withCount('episode')->where('category_id',$cate_slug->id)->orderBy('updateday', 'DESC')->paginate(24);
        return view('pages.category', compact('category','genre','country','cate_slug','movie','phimhot_trailer'));
    }
    public function year($year){
        $category = Category::orderBy('position','ASC')->where('status',1)->get();
        $genre = Genre::orderBy('id','DESC')->get();   
        $country = Country::orderBy('id','DESC')->get(); 
        // $phimhot_sidebar = Movie::where('phim_hot',1)->where('status',1)->orderBy('updateday', 'DESC')->take(5)->get();
        $phimhot_trailer = Movie::where('resolution',5)->where('status',1)->orderBy('updateday', 'DESC')->take(6)->get();
        $year = $year; 
        $movie = Movie::withCount('episode')->where('year',$year)->orderBy('updateday', 'DESC')->paginate(24);
        return view('pages.year', compact('category','genre','country','year','movie','phimhot_trailer'));
    }
    public function tag($tag){
        $category = Category::orderBy('position','ASC')->where('status',1)->get();
        $genre = Genre::orderBy('id','DESC')->get();   
        $country = Country::orderBy('id','DESC')->get();
        // $phimhot_sidebar = Movie::where('phim_hot',1)->where('status',1)->orderBy('updateday', 'DESC')->take(5)->get();
        $phimhot_trailer = Movie::where('resolution',5)->where('status',1)->orderBy('updateday', 'DESC')->take(6)->get();
        $tag = $tag; 
        $movie = Movie::withCount('episode')->where('tags','LIKE','%'.$tag.'%')->orderBy('updateday', 'DESC')->paginate(24);//LIKE lấy gần đúng
        return view('pages.tag', compact('category','genre','country','tag','movie','phimhot_trailer'));
    }
    public function genre($slug){
        $category = Category::orderBy('position','ASC')->where('status',1)->get();
        $genre = Genre::orderBy('id','ASC')->get();   
        $country = Country::orderBy('id','ASC')->get();
        // $phimhot_sidebar = Movie::withCount('episode')->where('phim_hot',1)->where('status',1)->orderBy('updateday', 'DESC')->take(5)->get();
        $phimhot_trailer = Movie::where('resolution',5)->where('status',1)->orderBy('updateday', 'DESC')->take(6)->get();
        $genre_slug = Genre::where('slug',$slug)->first();  
        //nhìu thể loại
        $movie_genre = Movie_Genre::where('genre_id',$genre_slug->id)->get();
        $many_genre = [];
        foreach($movie_genre as $key => $movi){
            $many_genre[]= $movi->movie_id;
        }
        $movie = Movie::withCount('episode')->whereIn('id',$many_genre)->orderBy('updateday', 'DESC')->paginate(24);
        return view('pages.genre', compact('category','genre','country','genre_slug','movie','phimhot_trailer'));
    }
    public function country($slug){
        $category = Category::orderBy('position','ASC')->where('status',1)->get();
        $genre = Genre::orderBy('id','ASC')->get();   
        $country = Country::orderBy('id','ASC')->get();  
        // $phimhot_sidebar = Movie::where('phim_hot',1)->where('status',1)->orderBy('updateday', 'DESC')->take(5)->get();
        $phimhot_trailer = Movie::where('resolution',5)->where('status',1)->orderBy('updateday', 'DESC')->take(6)->get();
        $country_slug = Country::where('slug',$slug)->first(); 
        $movie = Movie::withCount('episode')->where('country_id',$country_slug->id)->orderBy('updateday', 'DESC')->paginate(24);
        return view('pages.country', compact('category','genre','country','country_slug','movie','phimhot_trailer'));
    }
    public function movie($slug){
        $category = Category::orderBy('position','ASC')->where('status',1)->get();
        $genre = Genre::orderBy('id','DESC')->get();   
        $country = Country::orderBy('id','DESC')->get();
        // $phimhot_sidebar = Movie::where('phim_hot',1)->where('status',1)->orderBy('updateday', 'DESC')->take(5)->get();
        $phimhot_trailer = Movie::where('resolution',5)->where('status',1)->orderBy('updateday', 'DESC')->take(6)->get();
        $movie = Movie::with('category','genre','country','movie_genre')->where('slug',$slug)->where('status',1)->first();
        $episode_first = Episode::with('movie')->where('movie_id',$movie->id)->orderBy('episode','ASC')->take(1)->first();
        $related = Movie::withCount('category','genre','country','episode')->where('category_id',$movie->category->id)->orderby(DB::raw('RAND()'))->whereNotIn('slug',[$slug])->get();//phim liên quan 
        //lấy 3 tập gần nhất
        $episode = Episode::with('movie')->where('movie_id',$movie->id)->orderBy('episode','DESC')->take(5)->get();
        //lấy tổng tập phim đã thêm
        $episode_current_list = Episode::with('movie')->where('movie_id',$movie->id)->get();
        $episode_current_list_count = $episode_current_list->count();
        //đánh giá phim
        $rating = Rating::where('movie_id',$movie->id)->avg('rating');//average: tổng trung bình
        $rating = round($rating);//round: làm tròn số 
        $count_total = Rating::where('movie_id',$movie->id)->count();
        return view('pages.movie', compact('category','genre','country','movie','related','phimhot_trailer','episode','episode_first','episode_current_list_count','rating','count_total'));
    }
    public function add_rating(Request $request){
        $data = $request->all();
        $ip_address = $request->ip();
        $rating_count = Rating::where('movie_id',$data['movie_id'])->where('ip_address',$ip_address)->count();
        if($rating_count>0){
            echo 'exit';
        }else{
            $rating = new Rating();
            $rating->movie_id = $data['movie_id'];
            $rating->rating = $data['index'];
            $rating->ip_address = $ip_address;
            $rating->save();
            echo 'done';
        };
    }
    public function watch($slug,$tap){

        $category = Category::orderBy('position','ASC')->where('status',1)->get();
        $genre = Genre::orderBy('id','DESC')->get();   
        $country = Country::orderBy('id','DESC')->get();
        // $phimhot_sidebar = Movie::where('phim_hot',1)->where('status',1)->orderBy('updateday', 'DESC')->take(5)->get();
        $phimhot_trailer = Movie::where('resolution',5)->where('status',1)->orderBy('updateday', 'DESC')->take(6)->get();
        $movie = Movie::with('category','genre','country','movie_genre','episode')->where('slug',$slug)->where('status',1)->first();
        $related = Movie::withCount('category','genre','country','episode')->where('category_id',$movie->category->id)->orderby(DB::raw('RAND()'))->whereNotIn('slug',[$slug])->get();//phim liên quan 
        //lấy tập 1 tap-fullhd
        if(isset($tap)){
            $tapphim= $tap;
            $tapphim = substr($tap, 4 ,20);
            $episode = Episode::where('movie_id',$movie->id)->where('episode',$tapphim)->first();
        }else{

            $tapphim=1;
            $episode = Episode::where('movie_id',$movie->id)->where('episode',$tapphim)->first();

        }
        return view('pages.watch', compact('category','genre','country','movie','phimhot_trailer','episode','tapphim','related'));
    }
    public function episode(){
        return view('pages.episode');
    }
}
