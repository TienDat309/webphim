@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card-header d-flex justify-content-between align-items-center"
                style="font-size:20px; text-align:center; font-weight:700; margin-bottom:20px">DANH SÁCH TẬP PHIM</span>
            </div>
            <table class="table table-responsive" id="tablephim" style="border: 1px solid #ddd; border-radius: 8px; background-color: #f9f9f9; padding-top: 5px">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Tên phim</th>
                        <th scope="col">Hình ảnh</th>
                        <th scope="col">Tập phim</th>
                        <th scope="col">Link phim</th>
                        {{-- <th scope="col">Hiển thị</th> --}}
                        <th scope="col">Quản lý</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($list_episode as $key => $episode)
                            
                    <tr>
                        <th scope="row">{{$key}}</th>
                        <td>{{$episode->movie->title}}</td>
                        <td><img width="100" src="{{ strpos($episode->movie->image, 'https') !== false ? $episode->movie->image : asset('uploads/movie/' . $episode->movie->image) }}"></td>
                        <td>{{$episode->episode}}</td>
                        <td style="width:5%">{{$episode->linkphim}}</td>
                        {{-- <td>
                            @if($episode->status)
                                Có
                            @else
                                Không
                            @endif
                        </td> --}}
                        <td>
                            {!! Form::open(['method'=>'DELETE','route'=>['episode.destroy',$episode->id],'onsubmit'=>'return confirm("Bạn có chắc chắn xóa")']) !!}
                                {!! Form::submit('Xóa', ['class'=>'btn btn-danger']) !!}
                            {!! Form::close() !!}
                            <a href="{{route('episode.edit', $episode->id)}}" class="btn btn-warning" style="margin-top: 5px; width:56px">Sửa</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection