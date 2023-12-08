@extends('layouts.app')

@section('content')
<div class="container" style="border: 1px solid #ddd; border-radius: 8px; background-color: #f9f9f9; padding-top: 5px">
    <div class="row justify-content-center">
        {{-- <div class="col-md-12"> --}}
            <div class="card">
                <div class="card-header " style="margin-bottom:10px; font-size:20px; text-align:center; font-weight:700">SẮP XẾP PHIM</div>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    <style>
                        .ui-state-highlight { height: 1.5em; line-height: 1.2em; }
                        .title_movie{
                            font-weight: bold;
                            color: rgb(0, 102, 255);
                            font-size: 16px;
                            text-transform: uppercase;
                        }
                        #sortable_nav li{
                            margin: 0 37px;
                        }
                        .box_phim{
                            height: 200px;
                            border: 1px solid #d1d1d1;
                            margin: 5px;
                            font-size: 12px;
                            font-weight: bold;
                            padding: 0px;
                            text-align: center;
                            background-color: #5bc0de;
                        }
                    </style>
                    <nav class="navbar navbar-inverse">
                        <div class="container-fluid" >
                          <ul class="nav navbar-nav category_position" id="sortable_nav">
                            @foreach ($category->sortBy('position') as $key => $cate)
                                <li id="{{$cate->id}}" class="ui-state-default" style="background-color:#ffb22b;"><a title="{{$cate->title}}" href="{{route('category',$cate->slug)}}">{{$cate->title}}</a></li>
                            @endforeach
                          </ul>
                        </div>
                    </nav>
                    @foreach ($category_home as $key => $cate_home)
                        <p class="title_movie" style="margin-bottom: 5px ">{{$cate_home->title}}</p>
                        <div class="row movie_position sortable_movie">
                            @foreach ($cate_home->movie->sortBy('position')->take(16) as $key => $mov)
                            <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12 box_phim" id="{{$mov->id}}">
                                <figure><img class="img-responsive" width="100%" style="height:135px; margin-bottom:3px" src="{{asset('uploads/movie/'.$mov->image)}}" title="{{$mov->title}}"></figure>
                                <p class="entry-title">{{$mov->title}}</p>
                            </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection