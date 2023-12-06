@extends('layouts.app')

@section('content')
<div class="container" style="border: 1px solid #ddd; border-radius: 8px; background-color: #f9f9f9; padding-top: 5px">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header " style="font-size:20px; text-align:center; font-weight:700">QUẢN LÝ LINK PHIM</div>
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
                    @if (!isset($linkmovie))
                        {!! Form::open(['route' => 'linkmovie.store','method'=>'POST']) !!}
                    @else
                        {!! Form::open(['route' => ['linkmovie.update',$linkmovie->id],'method'=>'PUT']) !!}
                    @endif
                        <div class="form-group">
                            {!! Form::label('title', 'Tên Link Server', []) !!}
                            {!! Form::text('title', isset($linkmovie) ? $linkmovie->title : '', ['class'=>'form-control','placeholder'=>'Nhập vào dữ liệu...']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('description', 'Mô tả Link Server', []) !!}
                            {!! Form::textarea('description', isset($linkmovie) ? $linkmovie->description : '', ['style'=>'resize:none','class'=>'form-control','placeholder'=>'Nhập vào dữ liệu...','id'=>'description']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('Active', 'Hiển thị', []) !!}
                            {!! Form::select('status', ['1'=>'Có', '0'=>'Không'], isset($linkmovie) ? $linkmovie->status : '', ['class'=>'form-control']) !!}
                        </div>
                    @if (!isset($linkmovie))
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