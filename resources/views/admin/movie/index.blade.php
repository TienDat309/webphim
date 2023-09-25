@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <a href="{{route('movie.create')}}" class="btn btn-success m-3">Thêm phim</a>
            <table class="table" id="tablephim">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Tiêu đề</th>
                        <th scope="col">Hình ảnh</th>
                        <th scope="col">Mô tả</th>
                        <th scope="col">Đường dẫn slug</th>
                        <th scope="col">Hiển thị</th>
                        <th scope="col">Danh mục</th>
                        <th scope="col">Quốc gia</th>
                        <th scope="col">Thể loại</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($list as $key => $cate)
                    <tr>
                        <th scope="row">{{$key}}</th>
                        <td>{{$cate->title}}</td>
                        <td><img width="60%" src="{{asset('uploads/movie/'.$cate->image)}}"></td>
                        <td style="text-align: justify">{{$cate->description}}</td>
                        <td>{{$cate->slug}}</td>
                        <td>
                            @if($cate->status)
                                Có
                            @else
                                Không
                            @endif
                        </td>
                        <td>{{$cate->category->title}}</td>
                        <td>{{$cate->country->title}}</td>
                        <td>{{$cate->genre->title}}</td>
                        <td>
                            {!! Form::open(['method'=>'DELETE','route'=>['movie.destroy',$cate->id],'onsubmit'=>'return confirm("Bạn có chắc chắn xóa")']) !!}
                                {!! Form::submit('Xóa', ['class'=>'btn btn-danger']) !!}
                            {!! Form::close() !!}
                            <a href="{{route('movie.edit', $cate->id)}}" style="margin-top: 5px" class="btn btn-warning">Sửa</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection