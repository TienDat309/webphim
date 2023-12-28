<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Category;
use App\Models\Country;
use App\Models\Genre;
use App\Models\Episode;
use App\Models\LinkMovie;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;

class LeechMovieController extends Controller
{
    public function leech_movie(){
        $resp = Http::get("https://ophim1.com/danh-sach/phim-moi-cap-nhat?page=26")->json();
        return view('admin/leech.index', compact('resp'));
    }

    public function leech_episode($slug){
        $resp = Http::get("https://ophim1.com/phim/".$slug)->json();
        return view('admin/leech.leech_episode', compact('resp'));

    }

    public function leech_detail($slug){
        $resp = Http::get("https://ophim1.com/phim/".$slug)->json();
        $resp_movie[] = $resp['movie']; 
        return view('admin/leech.leech_detail', compact('resp_movie'));
    }

    public function leech_episode_store(Request $request, $slug){
        $movie = Movie::where('slug',$slug)->first();
        $resp = Http::get("https://ophim1.com/phim/".$slug)->json();
        foreach ($resp['episodes'] as $key => $res){
            foreach($res['server_data'] as $key_data => $res_data)
            {
                $ep = new Episode();
                $ep->movie_id = $movie->id;
                $ep->linkphim = '<p><iframe allowfullscreen framborder="0" height="360" scrolling="0" src="'.$res_data['link_embed'].'" width="100%"></iframe></p>';
                $ep->episode = $res_data['name'];
                if($key_data==0){
                    $linkmovie = LinkMovie::orderBy('id','ASC')->first();
                    $ep->server = $linkmovie->id;
                }
                else{
                    $linkmovie = LinkMovie::orderBy('id','ASC')->first();
                    $ep->server = $linkmovie->id;
                }
                $ep->created_at = Carbon::now('Asia/Ho_Chi_Minh');
                $ep->updated_at = Carbon::now('Asia/Ho_Chi_Minh');
                $ep->save();
            }
        }
        toastr()->success('Thêm tập phim thành công.');
        return redirect()->route('leech-movie');
    }

    public function leech_store(Request $request, $slug){
        $resp = Http::get("https://ophim1.com/phim/".$slug)->json();
        $resp_movie[] = $resp['movie']; 
        $movie = new Movie();
        foreach ($resp_movie as $key => $res){
            $movie->title = $res['name'];
            $movie->trailer = $res['trailer_url'];
            $movie->episode_movie = $res['episode_total'];
            $movie->tags = $res['name'].', '.$res['slug'].', '.$res['origin_name'];
            $movie->time_movie = $res['time'];
            $movie->resolution = 0;
            $movie->subtitle = 0;
            $movie->name_eng = $res['origin_name'];
            $movie->phim_hot = 1;
            $movie->slug = $res['slug'];
            $movie->description = $res['content'];
            $movie->director = join(', ', $res['director']);
            $movie->actor = join(', ', $res['actor']);
            $movie->status = 1;
            $movie->belongmovie = 'phimle';

            $category = Category::orderBy('id','DESC')->first();
            $movie->category_id = $category->id;
            
            $country = Country::orderBy('id','DESC')->first();
            $movie->country_id = $country->id;

            $genre = Genre::orderBy('id','DESC')->first();
            $movie->genre_id = $genre->id;

            $movie->count_views = rand(1,7000);
            $movie->datecreated = Carbon::now('Asia/Ho_Chi_Minh');
            $movie->updateday = Carbon::now('Asia/Ho_Chi_Minh');
            $movie->image = $res['thumb_url'];

            $movie->save();
            $movie->movie_genre()->attach($genre);
        }
        toastr()->success('Thêm phim thành công.');

        return redirect()->back();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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
        $resp = Http::get("https://ophim1.com/phim/".$slug)->json();
        $resp_movie[] = $resp['movie']; 
        $movie = new Movie();
        foreach ($resp_movie as $key => $res){
            $movie->title = $res['name'];
            $movie->trailer = $res['trailer_url'];
            $movie->episode_movie = $res['episode_total'];
            $movie->tags = $res['name'].', '.$res['slug'];
            $movie->time_movie = $res['time'];
            $movie->resolution = 0;
            $movie->subtitle = 0;
            $movie->name_eng = $res['origin_name'];
            $movie->phim_hot = 1;
            $movie->slug = $res['slug'];
            $movie->description = $res['content'];
            $movie->director = join(', ', $res['director']);
            $movie->actor = join(', ', $res['actor']);
            $movie->status = 1;
            $movie->belongmovie = 'phimle';

            $category = Category::orderBy('id','DESC')->first();
            $movie->category_id = $category->id;
            
            $country = Country::orderBy('id','DESC')->first();
            $movie->country_id = $country->id;

            $genre = Genre::orderBy('id','DESC')->first();
            $movie->genre_id = $genre->id;

            $movie->count_views = rand(1,7000);
            $movie->datecreated = Carbon::now('Asia/Ho_Chi_Minh');
            $movie->updateday = Carbon::now('Asia/Ho_Chi_Minh');
            $movie->image = $res['thumb_url'];

            $movie->save();
            $movie->movie_genre()->attach($genre);
        }
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
        //
    }
}
