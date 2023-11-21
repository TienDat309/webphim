@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Quản lý phim</span>
                    <a href="{{ route('movie.index') }}" class="btn btn-success btn-md">Liệt kê phim</a>
                </div>
                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    @if (!isset($movie))
                    {!! Form::open(['route' => 'movie.store','method'=>'POST', 'enctype'=>'multipart/form-data']) !!}
                    @else
                    {!! Form::open(['route' => ['movie.update',$movie->id],'method'=>'PUT',
                    'enctype'=>'multipart/form-data']) !!}
                    @endif
                    <div class="form-group">
                        {!! Form::label('title', 'Tên phim', []) !!}
                        {!! Form::text('title', isset($movie) ? $movie->title : '',
                        ['class'=>'form-control','placeholder'=>'Nhập vào dữ liệu...',
                        'id'=>'slug','onkeyup'=>'ChangeToSlug()']) !!}
                    </div> 
                    <div class="form-group">
                        {!! Form::label('episode_movie', 'Số tập phim', []) !!}
                        {!! Form::text('episode_movie', isset($movie) ? $movie->episode_movie : '',
                        ['class'=>'form-control','placeholder'=>'Nhập vào dữ liệu...'
                        ]) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('time_movie', 'Thời lượng', []) !!}
                        {!! Form::text('time_movie', isset($movie) ? $movie->time_movie : '',
                        ['class'=>'form-control','placeholder'=>'Nhập vào dữ liệu...'
                        ]) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('Tên tiếng anh', 'Tên tiếng anh', []) !!}
                        {!! Form::text('name_eng', isset($movie) ? $movie->name_eng : '',
                        ['class'=>'form-control','placeholder'=>'Nhập vào dữ liệu...']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('trailer', 'Trailer', []) !!}
                        {!! Form::text('trailer', isset($movie) ? $movie->trailer : '',
                        ['class'=>'form-control','placeholder'=>'Nhập vào dữ liệu...']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('slug', 'Đường dẫn slug', []) !!}
                        {!! Form::text('slug', isset($movie) ? $movie->slug: '',
                        ['class'=>'form-control','placeholder'=>'Nhập vào dữ liệu...',
                        'id'=>'convert_slug']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('description', 'Mô tả', []) !!}
                        {!! Form::textarea('description', isset($movie) ? $movie->description :
                        '',['style'=>'resize:none','class'=>'form-control','placeholder'=>'Nhập vào dữ liệu...',
                        'id'=>'description']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('tags', 'Tags phim', []) !!}
                        {!! Form::textarea('tags', isset($movie) ? $movie->tags :
                        '',['style'=>'resize:none','class'=>'form-control','placeholder'=>'Nhập vào dữ liệu...']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('Active', 'Hiển thị', []) !!}
                        {!! Form::select('status', ['1'=>'Có', '0'=>'Không'], isset($movie) ? $movie->status : '',
                        ['class'=>'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('resolution', 'Định dạng', []) !!}
                        {!! Form::select('resolution', ['0'=>'HD', '1'=>'SD', '2'=>'HDCam', '3'=>'Cam', '4'=>'FullHD', '5'=>'Trailer'],
                        isset($movie) ? $movie->resolution : '',
                        ['class'=>'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('subtitle', 'Phụ đề', []) !!}
                        {!! Form::select('subtitle', ['0'=>'Phụ đề', '1'=>'Thuyết minh'], isset($movie) ?
                        $movie->subtitle : '',
                        ['class'=>'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('Category', 'Danh mục', []) !!}
                        {!! Form::select('category_id', $category , isset($movie) ? $movie->category_id: '',
                        ['class'=>'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('belongmovie', 'Thuộc phim', []) !!}
                        {!! Form::select('belongmovie', ['phimle'=>'Phim lẻ', 'phimbo'=>'Phim bộ'] , isset($movie) ? $movie->belongmovie: '',
                        ['class'=>'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('Country', 'Quốc gia', []) !!}
                        {!! Form::select('country_id', $country, isset($movie) ? $movie->country_id : '',
                        ['class'=>'form-control']) !!}
                    </div>
                    <div class="form-group">
                        @foreach ($list_genre as $key => $gen)
                            @if (isset($movie))
                                {!! Form::checkbox('genre[]', $gen->id, isset($movie_genre) && $movie_genre->contains($gen->id) ? true : false) !!}
                            @else
                                {!! Form::checkbox('genre[]', $gen->id, '') !!}
                            @endif
                                {!! Form::label('genre', $gen->title) !!}
                        @endforeach
                    </div>
                    <div class="form-group">
                        {!! Form::label('Hot', 'Phim hot', []) !!}
                        {!! Form::select('phim_hot', ['1'=>'Có', '0'=>'Không'], isset($movie) ? $movie->phim_hot : '',
                        ['class'=>'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('Image', 'Hình ảnh', []) !!}
                        {!! Form::file('image', ['class'=>'form-control-file']) !!}
                        @if(isset($movie))
                        <img width="15%" src="{{asset('uploads/movie/'.$movie->image)}}">
                        @endif
                    </div>
                    @if (!isset($movie))
                    {!! Form::submit('Thêm mới', ['class'=>'btn btn-success']) !!}
                    @else
                    {!! Form::submit('Cập nhật', ['class'=>'btn btn-success']) !!}
                    @endif
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection