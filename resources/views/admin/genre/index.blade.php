@extends('layouts.app')

@section('content')
<table class="table" id="tablephim">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Tên thể loại</th>
            <th scope="col">Mô tả</th>
            <th scope="col">Đường dẫn slug</th>
            <th scope="col">Hiển thị</th>
            <th scope="col">Quản lý</th>
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
                {!! Form::open(['method'=>'DELETE','route'=>['genre.destroy',$cate->id],'onsubmit'=>'return confirm("Bạn
                có chắc chắn xóa")']) !!}
                {!! Form::submit('Xóa', ['class'=>'btn btn-danger']) !!}
                {!! Form::close() !!}
                <a href="{{route('genre.edit', $cate->id)}}" class="btn btn-warning" style="margin-top: 5px">Sửa</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection