@extends('layout')
@section('content')
<div class="row container" id="wrapper">
   <div class="halim-panel-filter">
      <div class="panel-heading">
         <div class="row">
            <div class="col-xs-6">
               <div class="yoast_breadcrumb hidden-xs">
                  <span>
                     <span>
                        <a href="{{route('category',$movie->category->slug)}}">{{$movie->category->title}}</a> »
                        <span>
                           <a href="{{route('country',$movie->country->slug)}}">{{$movie->country->title}}</a> »

                           <span class="breadcrumb_last"
                              aria-current="page">{{$movie->title}}</span></span></span></span>
               </div>
            </div>
         </div>
      </div>
      <div id="ajax-filter" class="panel-collapse collapse" aria-expanded="true" role="menu">
         <div class="ajax"></div>
      </div>
   </div>
   <main id="main-contents" class="col-xs-12 col-sm-12 col-md-8">
      <section id="content" class="test">
         <div class="clearfix wrap-content">

            <div class="halim-movie-wrapper">
               {{-- <div class="title-block">
                  <div id="bookmark" class="bookmark-img-animation primary_ribbon" data-id="38424">
                     <div class="halim-pulse-ring"></div>
                  </div>
                  <div class="title-wrapper" style="font-weight: bold;">
                     Bookmark
                  </div>
               </div> --}}
               <div class="movie_info col-xs-12">
                  <div class="movie-poster col-md-9"> 
                     <img src="{{strpos($movie->image, 'https') !== false ? $movie->image : asset('uploads/movie/' . $movie->image)}}" alt="{{$movie->tilte}}">
                     @if ($movie->resolution!=5)
                        @if($episode_current_list_count>0)
                        <a href="{{url('xem-phim/'.$movie->slug.'/tap-'.$episode_first->episode.'/server-'.$episode_first->server)}}" style="width:100%; height:35px; font-size:15px"
                           class="btn btn-danger">Xem Phim</a>
                        @else
                        <a style="width:100%; height:35px; font-size:15px" class="btn btn-success">Đang Cập Nhật</a>
                        @endif
                     @else
                        <a href="#watch_trailer" style="display:block" class="btn btn-primary watch_trailer">Xem Trailer</a>
                     @endif
                  </div>
                  <div class="film-poster col-md-9">
                     <h1 class="movie-title title-1"
                        style="display:block;line-height:35px;margin-bottom: -14px;color: #ffed4d;text-transform: uppercase;font-size: 18px;">
                        {{$movie->title}}</h1>
                     <h2 class="movie-title title-2" style="font-size: 12px;">{{$movie->name_eng}}</h2>
                     <div class="custom-scrollbar" style="height:283px; overflow: auto;">
                        <ul class="list-info-group">
                           <li class="list-info-group-item"><span>Trạng Thái</span> : <span class="quality">
                                 @if($movie->resolution==0)
                                 HD
                                 @elseif($movie->resolution==1)
                                 SD
                                 @elseif($movie->resolution==2)
                                 HDCam
                                 @elseif($movie->resolution==3)
                                 Cam
                                 @elseif($movie->resolution==4)
                                 FullHD
                                 @else
                                 Trailer
                                 @endif
                              </span>
                              @if ($movie->resolution!=5)
                              <span class="episode">
                                 @if($movie->subtitle==0)
                                 Vietsub
                                 @else
                                 Thuyết Minh
                                 @endif
                              </span>
                              @endif
                           </li>
                           {{-- <li class="list-info-group-item"><span>Thời lượng</span> : {{$movie->time_movie}}</li> --}}

                           <?php
                              function displayTime_movie($time_movie) {
                                  if ($time_movie) {
                                      echo "<li class='list-info-group-item'><span>Thời lượng</span>: $time_movie</li>";
                                  } else {
                                      echo "<li class='list-info-group-item'><span>Thời lượng</span>: Đang cập nhật</li>";
                                  }
                              }
                              
                              // Sử dụng hàm
                              displayTime_movie($movie->time_movie);
                           ?> 

                           <li class="list-info-group-item"><span>Tập phim</span> : 
                              @if($movie->belongmovie=='phimbo')
                                 {{$episode_current_list_count}}/{{$movie->episode_movie}} - 
                                 @if($episode_current_list_count==$movie->episode_movie)
                                       Hoàn thành
                                 @else
                                       Đang cập nhật
                                 @endif
                              @else
                              Phim lẻ
                              @endif

                           </li>

                           @if ($movie->season!=0)
                           <li class="list-info-group-item"><span>Season</span> : {{$movie->season}}</li>
                           @endif

                           <li class="list-info-group-item"><span>Thể loại</span> :
                              @foreach ($movie->movie_genre as $gen)
                              <a href="{{route('genre',[$gen->slug])}}" rel="category tag" style="border-radius: 10px; padding: 2px 11px;background-color:#224361; color:#ffffff">{{$gen->title}}</a>
                              @endforeach
                           </li>

                           <li class="list-info-group-item"><span>Danh mục</span> :
                              <a href="{{route('category',[$movie->category->slug])}}" 
                                 rel="category tag" style="border-radius: 10px; padding: 2px 11px;background-color:#224361; color:#ffffff">{{$movie->category->title}}</a>
                           </li>
                              
                           <li class="list-info-group-item"><span>Quốc gia</span> :
                              <a href="{{route('country',$movie->country->slug)}}"
                                 rel="tag" style="border-radius: 10px; padding: 2px 11px;background-color:#224361; color:#ffffff">{{$movie->country->title}}</a>
                           </li>

                           <li class="list-info-group-item"><span>Năm phim</span> :
                              {{$movie->year}}
                     
                              <?php
                              function displayDirector($director) {
                                  if ($director) {
                                      echo "<li class='list-info-group-item'><span>Đạo diễn</span>: $director</li>";
                                  } else {
                                      echo "<li class='list-info-group-item'><span>Đạo diễn</span>: Đang cập nhật</li>";
                                  }
                              }
                              // Sử dụng hàm
                              displayDirector($movie->director);
                              ?>
                     
                              <?php
                              function displayActor($actor) {
                                 if ($actor) {
                                    echo "<li class='list-info-group-item'><span>Diễn viên</span>: $actor</li>";
                                 } else {
                                    echo "<li class='list-info-group-item'><span>Diễn viên</span>: Đang cập nhật</li>";
                                 }
                              }
                              
                              // Sử dụng hàm
                              displayActor($movie->actor);
                              ?>
                     
                           </li>   
                           <li class="list-info-group-item"><span>Tập phim mới nhất</span> :
                              @if($episode_current_list_count>0)
                                 @if($movie->belongmovie=='phimbo')
                                    @foreach ($episode as $key => $ep)
                                       <a href="{{url('xem-phim/'.$ep->movie->slug.'/tap-'.$ep->episode.'/server-'.$ep->server)}}"
                                          rel="tag">Tập {{$ep->episode}}</a>
                                    @endforeach
                                 @elseif($movie->belongmovie=='phimle')
                                    @foreach ($episode as $key => $ep_le)
                                       <a href="{{url('xem-phim/'.$movie->slug.'/tap-'.$ep_le->episode.'/server-'.$ep_le->server)}}" rel="tag">{{$ep_le->episode}} Tập</a>
                                    @endforeach
                                 @endif
                              @else
                                 Đang cập nhật
                              @endif
                           </li>
                        </ul>
                           <!--đánh giá-->
                        </div>
                        <div class="entry-content htmlwrap clearfix" style="height: 38px; padding-top:1px; background-color:#11171f">
                           <ul class="list-inline rating " title="Average Rating" style="font-size: 18px;">
                              @for($count=1; $count<=5; $count++)
                              @php
                                       if($count<=$rating){ 
                                          $color = 'color:#ffcc00;';
                                       }
                                       else {
                                          $color = 'color:#ccc;';
                                       }
                                       @endphp
                                 <li title="star_rating" 
                                 id="{{$movie->id}}-{{$count}}" 
                                 data-index="{{$count}}"  
                                 data-movie_id="{{$movie->id}}" 
                                 data-rating="{{$rating}}" 
                                 class="rating" 
                                 style="cursor:pointer;{{$color}} font-size:23px;">&#9733;</li>
                                 @endfor
                           </ul>
                        
                           <div class="total_rating" style="float:left; padding-top:7px; padding-left:15px; font-weight:700; font-size:14px;"> ({{$rating}} / {{$count_total}} lượt)</div>
                       </div>
                  </div>
               </div>
            </div>
            <div class="clearfix"></div>
            <div id="halim_trailer"></div>
            <div class="clearfix"></div>
            <div class="section-bar clearfix">
               <h2 class="section-title"><span style="color:#ffed4d">Nội dung phim</span></h2>
            </div>
            <div class="entry-content htmlwrap clearfix">
               <div class="video-item halim-entry-box">
                  <article id="post-38424" class="item-content" style="text-align: justify">
                     {{$movie->description}}
                  </article>
               </div>
            </div>
            <!--Tags phim-->
            <div class="section-bar clearfix">
               <h2 class="section-title"><span style="color:#ffed4d">Tags phim</span></h2>
            </div>
            <div class="entry-content htmlwrap clearfix">
               <div class="video-item halim-entry-box">
                  <article id="post-38424" class="item-content" style="text-align: justify">
                     @if ($movie->tags!=NULL)
                     @php
                     $tags = array();
                     $tags = explode(',', $movie->tags);
                     @endphp
                     @foreach ($tags as $key => $tag)
                     <a href="{{url('tag/'.$tag)}}">{{$tag}}</a>
                     @endforeach
                     @else
                     {{$movie->title}}
                     @endif
                  </article>
               </div>
            </div>
            {{-- <!--Bình luận phim-->
            <div class="section-bar clearfix">
               <h2 class="section-title"><span style="color:#ffed4d">Bình luận</span></h2>
            </div>
            <div class="entry-content htmlwrap clearfix">
               <div class="video-item halim-entry-box">
                  @php
                  $current_url = Request::url();
                  @endphp
                  <article id="post-38424" class="item-content" style="text-align: justify; background-color:rgba(255, 255, 255, 0.955)">
                     <div class="fb-comments" data-colorscheme="light" data-href="{{$current_url}}" data-width="100%"
                        data-numposts="10"></div>
                  </article>
               </div>
            </div> --}}
            <!--Trailer phim-->
            <div class="section-bar clearfix">
               <h2 class="section-title"><span style="color:#ffed4d">Trailer phim</span></h2>
            </div>
            <div class="entry-content htmlwrap clearfix">
               <div class="video-item halim-entry-box">
                  <article id="watch_trailer" class="item-content" style="text-align: justify">
                     <iframe width="100%" height="400" src="https://www.youtube.com/embed/{{$movie->trailer}}"
                        title="YouTube video player" frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        allowfullscreen></iframe>
                  </article>
               </div>
            </div>
         </div>
      </section>
      <section class="related-movies">
         <div id="halim_related_movies-2xx" class="wrap-slider">
            <div class="section-bar clearfix">
               <h3 class="section-title"><span>CÓ THỂ BẠN MUỐN XEM</span></h3>
            </div>
            <div id="halim_related_movies-2" class="owl-carousel owl-theme related-film">
               @foreach ($related as $key => $hot)
               <article class="thumb grid-item post-38498">
                  <div class="halim-item">
                     <a class="halim-thumb" href="{{route('movie',$hot->slug)}}" title="{{$hot->title}}">
                        <figure><img class="lazy img-responsive" src="{{strpos($hot->image, 'https') !== false ? $hot->image : asset('uploads/movie/' . $hot->image)}}"
                              title="{{$hot->title}}"></figure>
                        <span class="status">
                           @if($hot->resolution==0)
                           HD
                           @elseif($hot->resolution==1)
                           SD
                           @elseif($hot->resolution==2)
                           HDCam
                           @elseif($hot->resolution==3)
                           Cam
                           @elseif($hot->resolution==4)
                           FullHD
                           @else
                           Trailer
                           @endif
                        </span>
                        <span class="episode"></i>
                           {{$hot->episode_count}}/{{$hot->episode_movie}} -
                           @if($hot->subtitle==0)
                           Vietsub
                           @else
                           Thuyết Minh
                           @endif
                        </span>
                        <div class="icon_overlay"></div>
                        <div class="halim-post-title-box">
                           <div class="halim-post-title ">
                              <p class="entry-title">{{$hot->title}}</p>
                              <p class="original_title">{{$hot->name_eng}}</p>
                           </div>
                        </div>
                     </a>
                  </div>
               </article>
               @endforeach

            </div>
            <script>
               $(document).ready(function($) {				
                var owl = $('#halim_related_movies-2');
                owl.owlCarousel({loop: true,margin: 4,autoplay: true,autoplayTimeout: 4000,autoplayHoverPause: true,nav: true,navText: ['<i class="hl-down-open rotate-left"></i>', '<i class="hl-down-open rotate-right"></i>'],responsiveClass: true,responsive: {0: {items:2},480: {items:3}, 600: {items:4},1000: {items: 4}}})});
            </script>
         </div>
      </section>
   </main>
   @include('pages.include.sidebar')

</div>
@endsection