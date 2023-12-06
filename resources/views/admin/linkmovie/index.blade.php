@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card" >
                <div class="card-header " style="margin-bottom:10px;font-size:20px; text-align:center; font-weight:700">QUẢN LÝ LINK PHIM</div>
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
                    <table class="table" id="tablephim" style="border: 1px solid #ddd; border-radius: 8px; background-color: #f9f9f9; padding-top: 5px;">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Tên link server</th>
                                <th scope="col">Mô tả</th>
                                <th scope="col">Hiển thị</th>
                                <th scope="col">Quản lý</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($linkmovie as $key => $movielink)
                            <tr>
                                <th scope="row">{{$key}}</th>
                                <td>{{$movielink->title}}</td>
                                <td>{{$movielink->description}}</td>
                                <td>
                                    @if($movielink->status)
                                    Có
                                    @else
                                    Không
                                    @endif
                                </td>
                                <td>
                                    {!! Form::open(['method'=>'DELETE','route'=>['linkmovie.destroy',$movielink->id],'onsubmit'=>'return confirm("Bạn có chắc chắn xóa")']) !!}
                                    {!! Form::submit('Xóa', ['class'=>'btn btn-danger']) !!}
                                    {!! Form::close() !!}
                                    <a href="{{route('linkmovie.edit', $movielink->id)}}" class="btn btn-warning"
                                        style="margin-top: 5px; width:56px">Sửa</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection