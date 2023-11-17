<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Genre;
use App\Models\Country;
use App\Models\Movie;
use App\Models\Episode;
use App\Models\Movie_Genre;

use DB;

class IndexController extends Controller
{
    public function search(){
        if(isset($_GET['search'])){
            $search = $_GET['search'];
            $category = Category::orderBy('position','ASC')->where('status',1)->get();
            $genre = Genre::orderBy('id','ASC')->get();   
            $country = Country::orderBy('id','ASC')->get();
            $phimhot_sidebar = Movie::where('phim_hot',1)->where('status',1)->orderBy('updateday', 'DESC')->take(10)->get();
            $phimhot_trailer = Movie::where('resolution',5)->where('status',1)->orderBy('updateday', 'DESC')->take(10)->get();
            $movie = Movie::where('title','LIKE','%'.$search.'%')->orderBy('updateday', 'DESC')->paginate(24);
            return view('pages.search', compact('category','genre','country','search','movie','phimhot_sidebar','phimhot_trailer'));
        }else{
            return redirect()->to('/');
        }
    }
    public function home(){
        $phimhot = Movie::where('phim_hot',1)->where('status',1)->orderBy('updateday', 'DESC')->get();
        $phimhot_sidebar = Movie::where('phim_hot',1)->where('status',1)->orderBy('updateday', 'DESC')->take(10)->get();
        $phimhot_trailer = Movie::where('resolution',5)->where('status',1)->orderBy('updateday', 'DESC')->take(10)->get();
        $category = Category::orderBy('position','ASC')->where('status',1)->get();
        $genre = Genre::orderBy('id','ASC')->get();   
        $country = Country::orderBy('id','ASC')->get();   
        $category_home = Category::with('movie')->orderBy('id','ASC')->where('status',1)->get();
        return view('pages.home', compact('category','genre','country','category_home','phimhot','phimhot_sidebar','phimhot_trailer'));
    }
    public function category($slug){
        $category = Category::orderBy('position','ASC')->where('status',1)->get();
        $genre = Genre::orderBy('id','ASC')->get();   
        $country = Country::orderBy('id','ASC')->get();
        $phimhot_sidebar = Movie::where('phim_hot',1)->where('status',1)->orderBy('updateday', 'DESC')->take(10)->get();
        $phimhot_trailer = Movie::where('resolution',5)->where('status',1)->orderBy('updateday', 'DESC')->take(10)->get();
        $cate_slug = Category::where('slug',$slug)->first();  
        $movie = Movie::where('category_id',$cate_slug->id)->orderBy('updateday', 'DESC')->paginate(24);
        return view('pages.category', compact('category','genre','country','cate_slug','movie','phimhot_sidebar','phimhot_trailer'));
    }
    public function year($year){
        $category = Category::orderBy('position','ASC')->where('status',1)->get();
        $genre = Genre::orderBy('id','DESC')->get();   
        $country = Country::orderBy('id','DESC')->get(); 
        $phimhot_sidebar = Movie::where('phim_hot',1)->where('status',1)->orderBy('updateday', 'DESC')->take(10)->get();
        $phimhot_trailer = Movie::where('resolution',5)->where('status',1)->orderBy('updateday', 'DESC')->take(10)->get();
        $year = $year; 
        $movie = Movie::where('year',$year)->orderBy('updateday', 'DESC')->paginate(24);
        return view('pages.year', compact('category','genre','country','year','movie','phimhot_sidebar','phimhot_trailer'));
    }
    public function tag($tag){
        $category = Category::orderBy('position','ASC')->where('status',1)->get();
        $genre = Genre::orderBy('id','DESC')->get();   
        $country = Country::orderBy('id','DESC')->get();
        $phimhot_sidebar = Movie::where('phim_hot',1)->where('status',1)->orderBy('updateday', 'DESC')->take(10)->get();
        $phimhot_trailer = Movie::where('resolution',5)->where('status',1)->orderBy('updateday', 'DESC')->take(10)->get();
        $tag = $tag; 
        $movie = Movie::where('tags','LIKE','%'.$tag.'%')->orderBy('updateday', 'DESC')->paginate(24);//LIKE lấy gần đúng
        return view('pages.tag', compact('category','genre','country','tag','movie','phimhot_sidebar','phimhot_trailer'));
    }
    public function genre($slug){
        $category = Category::orderBy('position','ASC')->where('status',1)->get();
        $genre = Genre::orderBy('id','ASC')->get();   
        $country = Country::orderBy('id','ASC')->get();
        $phimhot_sidebar = Movie::where('phim_hot',1)->where('status',1)->orderBy('updateday', 'DESC')->take(10)->get();
        $phimhot_trailer = Movie::where('resolution',5)->where('status',1)->orderBy('updateday', 'DESC')->take(10)->get();
        $genre_slug = Genre::where('slug',$slug)->first();  
        //nhìu thể loại
        $movie_genre = Movie_Genre::where('genre_id',$genre_slug->id)->get();
        $many_genre = [];
        foreach($movie_genre as $key => $movi){
            $many_genre[]= $movi->movie_id;
        }
        $movie = Movie::whereIn('id',$many_genre)->orderBy('updateday', 'DESC')->paginate(24);
        return view('pages.genre', compact('category','genre','country','genre_slug','movie','phimhot_sidebar','phimhot_trailer'));
    }
    public function country($slug){
        $category = Category::orderBy('position','ASC')->where('status',1)->get();
        $genre = Genre::orderBy('id','ASC')->get();   
        $country = Country::orderBy('id','ASC')->get();  
        $phimhot_sidebar = Movie::where('phim_hot',1)->where('status',1)->orderBy('updateday', 'DESC')->take(10)->get();
        $phimhot_trailer = Movie::where('resolution',5)->where('status',1)->orderBy('updateday', 'DESC')->take(10)->get();
        $country_slug = Country::where('slug',$slug)->first(); 
        $movie = Movie::where('country_id',$country_slug->id)->orderBy('updateday', 'DESC')->paginate(24);
        return view('pages.country', compact('category','genre','country','country_slug','movie','phimhot_sidebar','phimhot_trailer'));
    }
    public function movie($slug){
        $category = Category::orderBy('position','ASC')->where('status',1)->get();
        $genre = Genre::orderBy('id','DESC')->get();   
        $country = Country::orderBy('id','DESC')->get();
        $phimhot_sidebar = Movie::where('phim_hot',1)->where('status',1)->orderBy('updateday', 'DESC')->take(10)->get();
        $phimhot_trailer = Movie::where('resolution',5)->where('status',1)->orderBy('updateday', 'DESC')->take(10)->get();
        $movie = Movie::with('category','genre','country','movie_genre')->where('slug',$slug)->where('status',1)->first();
        $related = Movie::with('category','genre','country')->where('category_id',$movie->category->id)->orderby(DB::raw('RAND()'))->whereNotIn('slug',[$slug])->get();//phim liên quan 
        return view('pages.movie', compact('category','genre','country','movie','related','phimhot_sidebar','phimhot_trailer'));
    }
    public function watch(){
        return view('pages.watch');
    }
    public function episode(){
        return view('pages.episode');
    }
}
?>