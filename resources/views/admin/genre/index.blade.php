@extends('layouts.app')

@section('content')
<!-- Button trigger modal -->
<button type="button" class="btn btn-info" data-toggle="modal" data-target="#genre"  style="margin-bottom: 15px">
    Thêm nhanh
</button>

<!-- Modal -->
<div class="modal fade" id="genre" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        {!! Form::open(['route' => 'genre.store','method'=>'POST']) !!}
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel" style="font-size: 20px; text-align:center; font-weight:700">THÊM THỂ LOẠI PHIM</h5>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-body">
                        @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                        @endif
                            <div class="form-group">
                                {!! Form::label('title', 'Tên thể loại', []) !!}
                                {!! Form::text('title', isset($genre) ? $genre->title : '', ['class'=>'form-control','placeholder'=>'Nhập vào dữ liệu...',
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
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                {!! Form::submit('Thêm mới', ['class'=>'btn btn-info']) !!}
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>
<table class="table" id="tablephim" style="border: 1px solid #ddd; border-radius: 8px; background-color: #f9f9f9; padding-top: 5px;">
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
                {!! Form::open(['method'=>'DELETE','route'=>['genre.destroy',$cate->id],'onsubmit'=>'return confirm("Bạn có chắc chắn xóa")']) !!}
                {!! Form::submit('Xóa', ['class'=>'btn btn-danger']) !!}
                {!! Form::close() !!}
                <a href="{{route('genre.edit', $cate->id)}}" class="btn btn-warning" style="margin-top: 5px; width:56px">Sửa</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection