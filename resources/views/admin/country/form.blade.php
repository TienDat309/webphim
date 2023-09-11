@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Quản lý quốc gia</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    @if (!isset($country))
                        {!! Form::open(['route' => 'country.store','method'=>'POST']) !!}
                    @else
                        {!! Form::open(['route' => ['country.update',$country->id],'method'=>'PUT']) !!}
                    @endif
                        <div class="form-group">
                            {!! Form::label('title', 'Tiêu đề', []) !!}
                            {!! Form::text('title', isset($country) ? $country->title : '', ['class'=>'form-control','placeholder'=>'Nhập vào dữ liệu...',
                            'id'=>'slug','onkeyup'=>'ChangeToSlug()']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('slug', 'Đường dẫn slug', []) !!}
                            {!! Form::text('slug', isset($category) ? $category->slug : '', ['class'=>'form-control','placeholder'=>'Nhập vào dữ liệu...',
                            'id'=>'convert_slug']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('description', 'Mô tả', []) !!}
                            {!! Form::textarea('description', isset($country) ? $country->description : '', ['style'=>'resize:none','class'=>'form-control','placeholder'=>'Nhập vào dữ liệu...','id'=>'description']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('Active', 'Hiển thị', []) !!}
                            {!! Form::select('status', ['1'=>'Có', '0'=>'Không'], isset($country) ? $country->status : '', ['class'=>'form-control']) !!}
                        </div>
                    @if (!isset($country))
                        {!! Form::submit('Thêm mới', ['class'=>'btn btn-success']) !!}
                    @else
                        {!! Form::submit('Cập nhật', ['class'=>'btn btn-success']) !!}
                    @endif
                        {!! Form::close() !!}
                </div>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Tiêu đề</th>
                        <th scope="col">Mô tả</th>
                        <th scope="col">Đường dẫn slug</th>
                        <th scope="col">Hiển thị</th>
                        {{-- <th scope="col">Manage</th> --}}
                    </tr>
                </thead>
                <tbody>
                    @foreach ($list as $key => $cate)
                    <tr>
                        <th scope="row">{{$key}}</th>
                        <td>{{$cate->title}}</td>
                        <td>{{$cate->description}}</td>
                        <td>{{$cate->slug}}</td>
                        <td>
                            @if($cate->status)
                                Có
                            @else
                                Không
                            @endif
                        </td>
                        <td>
                            {!! Form::open(['method'=>'DELETE','route'=>['country.destroy',$cate->id],'onsubmit'=>'return confirm("Bạn có chắc chắn xóa")']) !!}
                                {!! Form::submit('Xóa', ['class'=>'btn btn-danger']) !!}
                            {!! Form::close() !!}
                            <a href="{{route('country.edit', $cate->id)}}" class="btn btn-warning">Sửa</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection