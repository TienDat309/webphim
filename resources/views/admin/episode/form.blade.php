@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    {{-- <a href="{{ route('episode.index') }}" class="btn btn-success btn-md">Liệt kê danh sách tập phim</a> --}}
                    <span>Quản lý tập phim</span>
                </div>
                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    @if (!isset($episode))
                    {!! Form::open(['route' => 'episode.store','method'=>'POST', 'enctype'=>'multipart/form-data']) !!}
                    @else
                    {!! Form::open(['route' => ['episode.update',$episode->id],'method'=>'PUT',
                    'enctype'=>'multipart/form-data']) !!}
                    @endif
                    
                    <div class="form-group">
                        {!! Form::label('Movie', 'Chọn phim', []) !!}
                        {!! Form::select('movie_id', ['0'=>'Chọn phim','Phim mới nhất'=>$list_movie], isset($episode) ? $episode->movie_id : '',
                        ['class'=>'form-control select-movie']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('link', 'Link Phim', []) !!}
                        {!! Form::text('link', isset($episode) ? $episode->linkphim : '',
                        ['class'=>'form-control','placeholder'=>'Nhập vào dữ liệu...','required'=>'required']) !!}
                    </div> 
                    @if(isset($episode))
                        <div class="form-group">
                            {!! Form::label('episode', 'Tập phim', []) !!}
                            {!! Form::text('episode', isset($episode) ? $episode->episode : '', ['class'=>'form-control','placeholder'=>'Nhập vào dữ liệu...', isset($episode) ? 'readonly' : '']) !!}
                        </div>
                    @else
                        <div class="form-group">
                            {!! Form::label('episode', 'Tập phim', []) !!}
                            <select name="episode" class="form-control" id="show_movie"></select>
                        </div>
                    @endif
                    
                    
                    @if (!isset($episode))
                    {!! Form::submit('Thêm tập phim', ['class'=>'btn btn-success']) !!}
                    @else
                    {!! Form::submit('Cập nhật tập phim', ['class'=>'btn btn-success']) !!}
                    @endif
                    {!! Form::close() !!}
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection