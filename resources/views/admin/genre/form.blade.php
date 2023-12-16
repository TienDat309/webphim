@extends('layouts.app')

@section('content')
<div class="container" style="border: 1px solid #ddd; border-radius: 8px; background-color: #f9f9f9; padding-top: 5px">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"style="font-size:20px; text-align:center; font-weight:700">THÊM THỂ LOẠI PHIM</div>
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
                        @if (!isset($genre))
                            {!! Form::open(['route' => 'genre.store','method'=>'POST']) !!}
                        @else
                            {!! Form::open(['route' => ['genre.update',$genre->id],'method'=>'PUT']) !!}
                        @endif
                            <div class="form-group">
                                {!! Form::label('title', 'Tên thể loại', []) !!}
                                {!! Form::text('title', isset($genre) ? mb_convert_case($genre->title, MB_CASE_TITLE, 'UTF-8') : '', ['class'=>'form-control','placeholder'=>'Nhập vào dữ liệu...',
                                'id'=>'slug','onkeyup'=>'ChangeToSlug()']) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('slug', 'Đường dẫn slug', []) !!}
                                {!! Form::text('slug', isset($genre) ? $genre->slug : '', ['class'=>'form-control','placeholder'=>'Nhập vào dữ liệu...',
                                'id'=>'convert_slug']) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('description', 'Mô tả', []) !!}
                                {!! Form::textarea('description', isset($genre) ? $genre->description : '', ['style'=>'resize:none','class'=>'form-control','placeholder'=>'Nhập vào dữ liệu...','id'=>'description']) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('Active', 'Hiển thị', []) !!}
                                {!! Form::select('status', ['1'=>'Có', '0'=>'Không'], isset($genre) ? $genre->status : '', ['class'=>'form-control']) !!}
                            </div>
                        @if (!isset($genre))
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
</div>
@endsection