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
use App\Models\Info;
use App\Models\LinkMovie;

use DB;

class IndexController extends Controller
{
    public function filter() {
        $order = isset($_GET['order']) ? $_GET['order'] : null;
        $genres_get = isset($_GET['genre']) ? $_GET['genre'] : [];
        $country_get = isset($_GET['country']) ? $_GET['country'] : null;
        $year_get = isset($_GET['year']) ? $_GET['year'] : null;
    
        if ($order === null && empty($genres_get) && $country_get === null && $year_get === null) {
            return redirect()->back();
        } else {
            // Lấy dữ liệu
            $movie_array = Movie::withCount('episode');
    
            if ($country_get) {
                $movie_array = $movie_array->where('country_id', $country_get);
            }
    
            if (!empty($genres_get)) {
                if (!is_array($genres_get)) {
                    $genres_get = [$genres_get];
                }
    
                foreach ($genres_get as $genre) {
                    $movie_array = $movie_array->whereHas('movie_genre', function ($query) use ($genre) {
                        $query->where('genre_id', $genre);
                    });
                }
            }
    
            if ($year_get) {
                $movie_array = $movie_array->where('year', $year_get);
            }
    
            if ($order) {
                $movie_array = $movie_array->orderBy($order, 'DESC');
            }
    
            $movie = $movie_array->paginate(24)->withQueryString();
    
            return view('pages.filter', compact('movie'));
        }
    }

    public function search(){
        if(isset($_GET['search'])){
            $search = $_GET['search'];
            $movie = Movie::withCount('episode')->where('title','LIKE','%'.$search.'%')->orderBy('updateday', 'DESC')->paginate(24);
            return view('pages.search', compact('search','movie'));
        }else{
            return redirect()->to('/');
        }
    }

    public function home(){
        $phimhot = Movie::withCount('episode')->where('phim_hot',1)->where('status',1)->orderBy('updateday', 'DESC')->get();
        $category_home = Category::with(['movie'=>function($q)
        {
            $q->withCount('episode')->where('status',1);
        }
        ])->orderBy('position','ASC')->where('status',1)->get();//nested trong laaravel
        return view('pages.home', compact('category_home','phimhot'));
    }

    public function category($slug){
        $cate_slug = Category::where('slug',$slug)->first();  
        $movie = Movie::withCount('episode')->where('category_id',$cate_slug->id)->orderBy('position', 'ASC')->paginate(24);
        return view('pages.category', compact('cate_slug','movie'));
    }

    public function year($year){
        $year = $year; 
        $movie = Movie::withCount('episode')->where('year',$year)->orderBy('updateday', 'DESC')->paginate(24);
        return view('pages.year', compact('year','movie'));
    }

    public function tag($tag){
        $tag = $tag; 
        $movie = Movie::withCount('episode')->where('tags','LIKE','%'.$tag.'%')->orderBy('updateday', 'DESC')->paginate(24);//LIKE lấy gần đúng
        return view('pages.tag', compact('tag','movie'));
    }

    public function genre($slug){
        $genre_slug = Genre::where('slug',$slug)->first();  
        //nhìu thể loại
        $movie_genre = Movie_Genre::where('genre_id',$genre_slug->id)->get();
        $many_genre = [];
        foreach($movie_genre as $key => $movi){
            $many_genre[]= $movi->movie_id;
        }
        $movie = Movie::withCount('episode')->whereIn('id',$many_genre)->orderBy('updateday', 'DESC')->paginate(24);
        return view('pages.genre', compact('genre_slug','movie'));
    }

    public function country($slug){
        $country_slug = Country::where('slug',$slug)->first(); 
        $movie = Movie::withCount('episode')->where('country_id',$country_slug->id)->orderBy('updateday', 'DESC')->paginate(24);
        return view('pages.country', compact('country_slug','movie'));
    }

    public function movie($slug){
        $movie = Movie::with('category','genre','country','movie_genre')->where('slug',$slug)->where('status',1)->first();
        $episode_first = Episode::with('movie')->where('movie_id',$movie->id)->orderBy('episode','ASC')->take(1)->first();
        $related = Movie::withCount('category','genre','country','episode')->where('category_id',$movie->category->id)->orderby(DB::raw('RAND()'))->whereNotIn('slug',[$slug])->get();//phim liên quan 
        //lấy 5 tập gần nhất
        $episode = Episode::with('movie')->where('movie_id', $movie->id)->orderByRaw('CAST(episode AS SIGNED) DESC')->take(5)->get();
        //lấy tổng tập phim đã thêm
        $episode_current_list = Episode::with('movie')->where('movie_id',$movie->id)->get();
        $episode_current_list_count = $episode_current_list->count();
        //đánh giá phim
        $rating = Rating::where('movie_id',$movie->id)->avg('rating');//average: tổng trung bình
        $rating = round($rating);//round: làm tròn số 
        $count_total = Rating::where('movie_id',$movie->id)->count();
        //tăng lượt view
        $count_views = $movie->count_views;
        $count_views = $count_views + 1;
        $movie->count_views = $count_views;
        $movie->save();

        return view('pages.movie', compact('movie','related','episode','episode_first','episode_current_list_count','rating','count_total'));
    }

    public function add_rating(Request $request){
        $data = $request->all();
        $ip_address = $request->ip();
        $rating_count = Rating::where('movie_id',$data['movie_id'])->where('ip_address',$ip_address)->count();
        if($rating_count>0){
            echo 'exist';
        }else{
            $rating = new Rating();
            $rating->movie_id = $data['movie_id'];
            $rating->rating = $data['index'];
            $rating->ip_address = $ip_address;
            $rating->save();
            echo 'done';
        };
    }

    public function watch($slug,$tap,$server_active){
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
        $server = LinkMovie::orderBy('id','DESC')->get();
        $episode_movie = Episode::where('movie_id',$movie->id)->get()->unique('server');
        $episode_list = Episode::where('movie_id', $movie->id)->orderByRaw('CAST(episode AS SIGNED) ASC')->get();

        $count_views = $movie->count_views;
        $count_views = $count_views + 1;
        $movie->count_views = $count_views;
        $movie->save();
        
        return view('pages.watch', compact('movie','episode','tapphim','related','server','episode_movie','episode_list','server_active'));
    }
    
    public function episode(){
        return view('pages.episode');
    }
}
