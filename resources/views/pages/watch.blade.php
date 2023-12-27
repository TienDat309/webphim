@extends('layout')
@section('content')
<div class="row container" id="wrapper">
   <div class="halim-panel-filter">
      <div class="panel-heading">
         <div class="row">
            <div class="col-xs-6">
               <div class="yoast_breadcrumb hidden-xs"><span><span><a href="">{{$movie->title}}</a> » <span><a
                              href="{{route('country',[$movie->country->slug])}}">{{$movie->country->title}}</a> » <span
                              class="breadcrumb_last" aria-current="page">{{$movie->title}}</span></span></span></span>
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
            <style type="text/css">
               .iframe_phim iframe {
                  width: 100%;
                  height: 500px;
               }
            </style>
            <div class="iframe_phim">
               {!!$episode->linkphim!!}
            </div>
            @foreach ($server as $key => $ser)
            @foreach ($episode_movie as $key => $ser_mov)
            @if($ser_mov->server==$ser->id)
            @php
            $currentEpisodeIndex = $episode_list->search(function ($epi) use ($tapphim,
            $server_active, $ser) {
            return $tapphim == $epi->episode && $server_active == 'server-' . $ser->id;
            });

            $prevEpisodeIndex = $currentEpisodeIndex - 1;
            $nextEpisodeIndex = $currentEpisodeIndex + 1;

            $prevEpisode = $prevEpisodeIndex >= 0 ? $episode_list[$prevEpisodeIndex] : null;
            $nextEpisode = $nextEpisodeIndex < count($episode_list) ? $episode_list[$nextEpisodeIndex] : null; @endphp
               <div class="halim-episode mx-auto mb-3 text-center res" style="float:right; margin-right:25.5%; margin-top:5px">
                  @if ($prevEpisode)
                     <a href="{{ url('xem-phim/'.$movie->slug.'/tap-'.$prevEpisode->episode.'/server-'.$prevEpisode->server) }}" class="box-shadow custom-link mr-3">Tập trước</a>
                  @endif
               
                  @if ($nextEpisode)
                     <a href="{{ url('xem-phim/'.$movie->slug.'/tap-'.$nextEpisode->episode.'/server-'.$nextEpisode->server) }}" class="custom-link box-shadow mr-3">Tập tiếp theo</a>
                  @endif
               
                  <span id="viewCountButton" class="d-inline-block mr-3" style="background-color: #171f27; color: #fff; padding: 2px 16px 2px 5px;">
                     <img src="/imgs/eye.svg" style="filter: invert(1);">
                     <span class="viewsCount" style="color: #9d9d9d;">
                        @if($movie->count_views > 0)
                           {{$movie->count_views}}
                        @else
                           @php
                              echo rand(1,7000);
                           @endphp
                        @endif
                     </span>
                  </span>
               
                  <!-- Chia sẻ fb -->
                  <button class="custom-s" onclick="shareMovieOnFacebook()">Chia sẻ</button>
               </div>
               
         @endif
         @endforeach
         @endforeach
         <div class="clearfix"></div>
         <div class="clearfix"></div>
         <div class="title-block" style="margin-top:8px">
            <div class="title-wrapper-xem full">
               <h4 class="entry-title"><a href="#" title="{{$movie->title}}" class="tl">{{$movie->title}}</a></h4>
            </div>
         </div>
         <div class="entry-content htmlwrap clearfix collapse" id="expand-post-content">
            <article id="post-37976" class="item-content post-37976"></article>
         </div>
         <div class="clearfix"></div>
         <div class="text-center">
            <div id="halim-ajax-list-server"></div>
         </div>
         <div id="halim-list-server">
            <ul class="nav nav-tabs" role="tablist">

               @if($movie->resolution==0)
               <li role="presentation" class="active server-1"><a href="#server-0" aria-controls="server-0" role="tab"
                     data-toggle="tab">HD</a></li>
               @elseif($movie->resolution==1)
               <li role="presentation" class="active server-1"><a href="#server-0" aria-controls="server-0" role="tab"
                     data-toggle="tab">SD</a></li>
               @elseif($movie->resolution==2)
               <li role="presentation" class="active server-1"><a href="#server-0" aria-controls="server-0" role="tab"
                     data-toggle="tab">HDCam</a></li>
               @elseif($movie->resolution==3)
               <li role="presentation" class="active server-1"><a href="#server-0" aria-controls="server-0" role="tab"
                     data-toggle="tab">Cam</a></li>
               @elseif($movie->resolution==4)
               <li role="presentation" class="active server-1"><a href="#server-0" aria-controls="server-0" role="tab"
                     data-toggle="tab">FullHD</a></li>
               @else
               <li role="presentation" class="active server-1"><a href="#server-0" aria-controls="server-0" role="tab"
                     data-toggle="tab">Trailer</a></li>
               @endif

               @if($movie->subtitle==0)
               <li role="presentation" class="active server-1"><a href="#server-0" aria-controls="server-0" role="tab"
                     data-toggle="tab">Vietsub</a></li>
               @else
               <li role="presentation" class="active server-1"><a href="#server-0" aria-controls="server-0" role="tab"
                     data-toggle="tab">Thuyết minh</a></li>
               @endif

            </ul>
            <div class="tab-content">
               <div role="tabpanel" class="tab-pane active server-1" id="server-0">
                  <div class="halim-server">
                     <ul class="halim-list-eps">

                        @foreach ($server as $key => $ser)
                        @foreach ($episode_movie as $key => $ser_mov)
                        @if($ser_mov->server==$ser->id)
                        <!--Server phim-->
                        <li class="halim-episode">
                           <span class="halim-btn halim-btn-2 halim-info-1-1 box-shadow">{{$ser->title}}
                           </span>
                        </li>
                        <!--Tập phim-->
                        <style>
                           .halim-list-eps {
                              list-style: none;
                              padding: 0;
                              white-space: nowrap;
                              /* Prevent line breaks */
                              overflow-x: auto;
                              /* Enable horizontal scrolling if needed */
                           }

                           .halim-episode {
                              display: inline-block;
                              /* Display episodes in a horizontal row */
                              margin-right: 10px;
                              /* Adjust the right margin as needed */
                           }

                           /* Optional: Style for the active episode */
                           .halim-btn.active {
                              background-color: #e83e8c;
                              /* Example background color for the active episode */
                           }
                        </style>
                        <ul class="halim-list-eps" style="text-align: justify;">

                           @foreach ($episode_list->sortBy('episode') as $epi)
                           <a href="{{ url('xem-phim/'.$movie->slug.'/tap-'.$epi->episode.'/server-'.$epi->server) }}">
                              <li class="halim-episode">
                                 <span style="padding: 10px 20px; font-size:14px"
                                    class="halim-btn halim-btn-2 {{$tapphim==$epi->episode && $server_active=='server-'.$ser->id ? 'active' : ''}} halim-info-1-1 box-shadow"
                                    title="Xem phim {{$movie->title}} - Tập {{$epi->episode}} - {{$movie->name_eng}} - Vietsub + Thuyết Minh"
                                    data-h1="{{$movie->title}} - tập {{$epi->episode}}">{{$epi->episode}}
                                 </span>
                              </li>
                           </a>
                           @endforeach
                        </ul>
                        @endif
                        @endforeach
                        @endforeach

                     </ul>

                     <div class="clearfix"></div>
                  </div>
               </div>
            </div>
         </div>
         <div class="clearfix"></div>
         <!--Nội dung phim-->

         <div class="entry-content htmlwrap clearfix">
            <div class="video-item halim-entry-box">
               <article id="post-38424" class="item-content" style="text-align: justify">
                  {{$movie->description}}
               </article>
            </div>
         </div>
         <!--Bình luận phim-->
         <div class="section-bar clearfix">
            <h2 class="section-title"><span style="color:#ffed4d">Bình luận</span></h2>
         </div>
         <div class="entry-content htmlwrap clearfix">
            <div class="video-item halim-entry-box">
               @php
               $current_url = Request::url();
               @endphp
               <article id="post-38424" class="item-content"
                  style="text-align: justify; background-color:rgba(255, 255, 255, 0.955)">
                  <div class="fb-comments" data-colorscheme="light" data-href="{{$current_url}}" data-width="100%"
                     data-numposts="10"></div>
               </article>
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
                        <figure><img class="lazy img-responsive"
                              src="{{strpos($hot->image, 'https') !== false ? $hot->image : asset('uploads/movie/' . $hot->image)}}"
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
               // JavaScript
               function shareMovieOnFacebook() {
                   // URL của trang hiện tại hoặc URL của phim
                   const currentUrl = window.location.href;
           
                   // Tạo URL chia sẻ trên Facebook với thông tin của phim
                   const facebookShareUrl = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(currentUrl)}`;
           
                   // Mở cửa sổ chia sẻ của Facebook
                   window.open(facebookShareUrl, 'Chia sẻ phim', 'width=600,height=400');
               }
           </script>

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