@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Quản lý danh mục</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    @if (!isset($category))
                        {!! Form::open(['route' => 'category.store','method'=>'POST']) !!}
                    @else
                        {!! Form::open(['route' => ['category.update',$category->id],'method'=>'PUT']) !!}
                    @endif
                        <div class="form-group">
                            {!! Form::label('title', 'Tên danh mục', []) !!}
                            {!! Form::text('title', isset($category) ? $category->title : '', ['class'=>'form-control','placeholder'=>'Nhập vào dữ liệu...',
                            'id'=>'slug','onkeyup'=>'ChangeToSlug()']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('slug', 'Đường dẫn slug', []) !!}
                            {!! Form::text('slug', isset($category) ? $category->slug : '', ['class'=>'form-control','placeholder'=>'Nhập vào dữ liệu...',
                            'id'=>'convert_slug']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('description', 'Mô tả', []) !!}
                            {!! Form::textarea('description', isset($category) ? $category->description : '', ['style'=>'resize:none','class'=>'form-control','placeholder'=>'Nhập vào dữ liệu...','id'=>'description']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('Active', 'Hiển thị', []) !!}
                            {!! Form::select('status', ['1'=>'Có', '0'=>'Không'], isset($category) ? $category->status : '', ['class'=>'form-control']) !!}
                        </div>
                    @if (!isset($category))
                        {!! Form::submit('Thêm mới', ['class'=>'btn btn-success']) !!}
                    @else
                        {!! Form::submit('Cập nhật', ['class'=>'btn btn-success']) !!}
                    @endif
                        {!! Form::close() !!}
                </div>
            </div>
            <table class="table" id="tablephim">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Tên danh mục</th>
                        <th scope="col">Mô tả</th>
                        <th scope="col">Đường dẫn slug</th>
                        <th scope="col">Hiển thị</th>
                        <th scope="col">Quản lý</th>
                    </tr>
                </thead>
                <tbody class="order_position">
                    @foreach ($list as $key => $cate)
                    <tr id="{{$cate->id}}">
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
                            {!! Form::open(['method'=>'DELETE','route'=>['category.destroy',$cate->id],'onsubmit'=>'return confirm("Bạn có chắc chắn xóa")']) !!}
                                {!! Form::submit('Xóa', ['class'=>'btn btn-danger']) !!}
                            {!! Form::close() !!}
                            <a href="{{route('category.edit', $cate->id)}}" class="btn btn-warning" style="margin-top: 5px">Sửa</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection