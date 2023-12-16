@extends('layouts.app')

@section('content')
<div class="container" style="border: 1px solid #ddd; border-radius: 8px; background-color: #f9f9f9; padding-top: 5px">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header" style="margin-bottom: 15px; font-size:20px; text-align:center; font-weight:700">THÊM PHIM</div>
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
                    @if (!isset($movie))
                    {!! Form::open(['route' => 'movie.store','method'=>'POST', 'enctype'=>'multipart/form-data']) !!}
                    @else
                    {!! Form::open(['route' => ['movie.update',$movie->id],'method'=>'PUT',
                    'enctype'=>'multipart/form-data']) !!}
                    @endif
                    <div class="form-group">
                        {!! Form::label('title', 'Tên phim', []) !!}
                        {!! Form::text('title', isset($movie) ? mb_convert_case($movie->title, MB_CASE_TITLE, 'UTF-8') : '',
                        ['class' => 'form-control', 'placeholder' => 'Nhập vào dữ liệu...', 'id' => 'slug', 'onkeyup' => 'ChangeToSlug()']) !!}
                    <div class="form-group" style="margin-top:15px">
                        {!! Form::label('episode_movie', 'Số tập phim', []) !!}
                        {!! Form::text('episode_movie', isset($movie) ? $movie->episode_movie : '',
                        ['class'=>'form-control','placeholder'=>'Nhập vào dữ liệu...'
                        ]) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('time_movie', 'Thời lượng', []) !!}
                        {!! Form::text('time_movie', isset($movie) ? $movie->time_movie : '',
                        ['class'=>'form-control','placeholder'=>'Nhập vào dữ liệu...',
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
                        {!! Form::label('director', 'Đạo diễn', []) !!}
                        {!! Form::text('director', isset($movie) ? $movie->director : '',
                        ['class'=>'form-control','placeholder'=>'Nhập vào dữ liệu...','id'=>'director'
                        ]) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('actor', 'Diễn viên', []) !!}
                        {!! Form::text('actor', isset($movie) ? $movie->actor : '',
                        ['class'=>'form-control','placeholder'=>'Nhập vào dữ liệu...','id'=>'actor'
                        ]) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('description', 'Mô tả', []) !!}
                        {!! Form::textarea('description', isset($movie) ? strip_tags($movie->description) : '',
                            ['style'=>'resize:none','class'=>'form-control','placeholder'=>'Nhập vào dữ liệu...',
                            'id'=>'description' ,'style'=>'text-align:justify']) !!}
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
                        {!! Form::label('resolution', 'Độ phân giải', []) !!}
                        {!! Form::select('resolution', ['0'=>'HD', '1'=>'SD', '2'=>'HDCam', '3'=>'Cam', '4'=>'FullHD', '5'=>'Trailer'],
                        isset($movie) ? $movie->resolution : '',
                        ['class'=>'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('subtitle', 'Phụ đề', []) !!}
                        {!! Form::select('subtitle', ['0'=>'Vietsub', '1'=>'Thuyết minh'], isset($movie) ?
                        $movie->subtitle : '',
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
                        {!! Form::label('Category', 'Danh mục', []) !!}
                        {!! Form::select('category_id',$category, isset($movie) ? $movie->category_id : '',['class'=>'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('Genre', 'Thể loại', []) !!}<br>
                        @php $count = 0; @endphp
                        @foreach ($list_genre as $key => $gen)
                            @if ($count % 6 == 0)
                                <div class="row">
                            @endif

                            <div class="col-md-2 col-sm-4 col-xs-6">
                                @if (isset($movie))
                                    {!! Form::checkbox('genre[]', $gen->id, isset($movie_genre) && $movie_genre->contains($gen->id) ? true : false) !!}
                                @else
                                    {!! Form::checkbox('genre[]', $gen->id, '') !!}
                                @endif
                                {!! Form::label('genre', $gen->title) !!}
                            </div>

                            @php $count++; @endphp

                            @if ($count % 6 == 0)
                                </div>
                            @endif
                        @endforeach

                        {{-- Close the last row if the total number of genres is not a multiple of 6 --}}
                        @if ($count % 6 !== 0)
                            </div>
                        @endif
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
                        <img width="15%" style="margin-top: 10px" src="{{ strpos($movie->image, 'https') !== false ? $movie->image : asset('uploads/movie/' . $movie->image) }}" alt="Movie Image">
                        @endif
                    </div>
                    @if (!isset($movie))
                    {!! Form::submit('Thêm mới', ['class'=>'btn btn-info']) !!}
                    @else
                    {!! Form::submit('Cập nhật', ['class'=>'btn btn-info']) !!}
                    @endif
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection