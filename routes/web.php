<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\HomeController;
//admin controller
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\EpisodeController;
use App\Http\Controllers\LinkMovieController;
use App\Http\Controllers\LeechMovieController;
use App\Http\Controllers\LoginGoogleController;
use App\Http\Controllers\Auth\LoginController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [IndexController::class, 'home'])->name('homepage');
Route::get('/danh-muc/{slug}', [IndexController::class, 'category'])->name('category');
Route::get('/the-loai/{slug}', [IndexController::class, 'genre'])->name('genre');
Route::get('/quoc-gia/{slug}', [IndexController::class, 'country'])->name('country');
Route::get('/phim/{slug}', [IndexController::class, 'movie'])->name('movie');
Route::get('/xem-phim/{slug}/{tap}/{serveractive}', [IndexController::class, 'watch']);
Route::get('/episode_movie', [IndexController::class, 'episode'])->name('episode_movie');
Route::get('/nam/{year}', [IndexController::class, 'year']);
Route::get('/tag/{tag}', [IndexController::class, 'tag']);
Route::get('/search', [IndexController::class, 'search'])->name('search');
Route::get('/filter', [IndexController::class, 'filter'])->name('filter');
Route::post('/add-rating', [IndexController::class,'add_rating'])->name('add-rating');


Auth::routes();
Route::get('/home', [HomeController::class, 'index'])->name('home');

//route admin
Route::post('resorting', [CategoryController::class, 'resorting'])->name('resorting');
Route::resource('category', CategoryController::class);
Route::resource('genre', GenreController::class);
Route::resource('country', CountryController::class);
Route::resource('movie', MovieController::class);
Route::resource('linkmovie', LinkMovieController::class);

//thêm tập phim
Route::get('add-episode/{id}', [EpisodeController::class,'add_episode'])->name('add-episode');
Route::resource('episode', EpisodeController::class);
Route::get('select-movie', [EpisodeController::class,'select_movie'])->name('select-movie');
Route::get('/update-year-phim', [MovieController::class, 'update_year']);
Route::get('/update-topview-phim', [MovieController::class, 'update_topview']);
Route::post('/filter-topview-phim', [MovieController::class, 'filter_topview']);
Route::get('/filter-topview-default', [MovieController::class, 'filter_default']);
Route::get('/update-season-phim', [MovieController::class, 'update_season']);
Route::get('/sort_movie', [MovieController::class, 'sort_movie'])->name('sort_movie');
Route::post('/resorting_nav', [MovieController::class, 'resorting_nav'])->name('resorting_nav');
Route::post('/resorting_moive', [MovieController::class, 'resorting_moive'])->name('resorting_moive');

//thay đổi dữ liệu movie bằng ajax
Route::get('/category-choose', [MovieController::class, 'category_choose'])->name('category-choose');
Route::get('/country-choose', [MovieController::class, 'country_choose'])->name('country-choose');
Route::get('/subtitle-choose', [MovieController::class, 'subtitle_choose'])->name('subtitle-choose');
Route::get('/phim_hot-choose', [MovieController::class, 'phim_hot_choose'])->name('phim_hot-choose');
Route::get('/status-choose', [MovieController::class, 'status_choose'])->name('status-choose');
Route::get('/belongmovie-choose', [MovieController::class, 'belongmovie_choose'])->name('belongmovie-choose');
Route::get('/resolution-choose', [MovieController::class, 'resolution_choose'])->name('resolution-choose');
Route::post('/watch-video', [MovieController::class, 'watch_video'])->name('watch-video');


//rotue leech movie
Route::get('leech-movie', [LeechMovieController::class, 'leech_movie'])->name('leech-movie');
Route::get('leech-detail/{slug}', [LeechMovieController::class, 'leech_detail'])->name('leech-detail');
Route::get('leech-episode/{slug}', [LeechMovieController::class, 'leech_episode'])->name('leech-episode');
Route::post('leech-store/{slug}', [LeechMovieController::class, 'leech_store'])->name('leech-store');
Route::post('leech-episode-store/{slug}', [LeechMovieController::class, 'leech_episode_store'])->name('leech-episode-store');


//đăng nhập
Route::get('auth/google', [LoginGoogleController::class, 'redirectToGoogle'])->name('login-by-google');
Route::get('auth/google/callback', [LoginGoogleController::class, 'handleGoogleCallback']);