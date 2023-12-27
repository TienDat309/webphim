@extends('layouts.app')

@section('content')
<div class="container-fluid" style="border: 1px solid #ddd; border-radius: 8px; background-color: #f9f9f9; padding-top: 5px">
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
                            width:158px;
                            margin: 0 37px;
                            justify-content: center;
                            text-align: center;
                            align-items: center;
                            margin-bottom:5px;
                        }
                        @media only screen and (max-width:600px)
                        {
                        #sortable_nav li
                            {
                                width:auto;
                            }
                        }
                        .box_phim{
                            height: 190px;
                            border: 1px solid #d1d1d1;
                            /* margin: 5px; */
                            font-size: 12px;
                            font-weight: bold;
                            padding: 0px;
                            text-align: center;
                            background-color: #5bc0de;
                        }
                    </style>
                    <nav class="navbar navbar-inverse">

                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                        </div>
                        
                        <div class="collapse navbar-collapse" id="navbar-collapse">
                            <ul class="nav navbar-nav category_position" id="sortable_nav">
                                @foreach ($category->sortBy('position') as $key => $cate)
                                    <li id="{{$cate->id}}" class="ui-state-default" style="background-color:#ffb22b;">
                                        <a title="{{$cate->title}}" href="{{route('category',$cate->slug)}}">{{$cate->title}}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </nav>
                </div>
                    @foreach ($category_home as $key => $cate_home)
                        <p class="title_movie" style="margin-bottom: 5px ">{{$cate_home->title}}</p>
                        <div class="row movie_position sortable_movie">
                            @foreach ($cate_home->movie->sortBy('position')->take(22) as $key => $mov)
                                    <div style="width:95px; margin-right:4px; margin-bottom:5px" class="col-lg-1 col-md-2 col-sm-4 col-xs-6 box_phim" id="{{$mov->id}}">
                                        <figure>
                                            <img class="img-responsive" style="width:100%; height:135px; margin-bottom:3px; text-align:center" src="{{strpos($mov->image, 'https') !== false ? $mov->image : asset('uploads/movie/' . $mov->image)}}" title="{{$mov->title}}" alt="{{$mov->title}}">
                                        </figure>
                                        <p class="entry-title">{{$mov->title}}</p>
                                    </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
        {{-- </div> --}}
    </div>
</div>
@endsection