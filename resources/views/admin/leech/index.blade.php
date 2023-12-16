@extends('layouts.app')

@section('content')
<div class="table-responsive">
    <table class="table" id="tablephim" style="border: 1px solid #ddd; border-radius: 8px; background-color: #f9f9f9; padding-top: 5px">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Tên phim</th>
                <th scope="col">Tên tiếng anh</th>
                <th scope="col">Hình ảnh phim</th>
                {{-- <th scope="col">Hình ảnh poster</th> --}}
                <th scope="col">Slug</th>
                <th scope="col">_Id</th>
                <th scope="col">Năm phim</th>
                <th scope="col">Quản lý</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($resp['items'] as $key => $res)
            <tr>
                <th scope="row">{{$key}}</th>
                <td>{{$res['name']}}</td>
                <td>{{$res['origin_name']}}</td>
                <td><img src="{{$resp['pathImage'].$res['thumb_url']}}" height="80" width="80"> </td>
                {{-- <td><img src="{{$resp['pathImage'].$res['poster_url']}}" height="80" width="80"> </td> --}}
                <td>{{$res['slug']}}</td>
                <td>{{$res['_id']}}</td>
                <td>{{$res['year']}}</td>
                <td>
                    <a href="{{route('leech-detail',$res['slug'])}}" class="btn btn-primary btn-sm" style="width:123px">Chi tiết phim</a>
                    <a href="{{route('leech-episode',$res['slug'])}}" class="btn btn-info btn-sm" style="width:123px ;margin-top:5px">Tập phim</a>
                    @php
                        $movie = \App\Models\Movie::where('slug',$res['slug'])->first();
                    @endphp
                    @if(!$movie)
                    <form method="POST" action="{{route('leech-store',$res['slug'])}}"> 
                        @csrf
                        <input type="submit" class="btn btn-success btn-sm" style="width:123px ;margin-top:5px" value="Thêm phim">
                    </form>
                    @else
                    <form method="POST" action="{{route('movie.destroy',$movie->id)}}"> 
                        @csrf
                        @method('DELETE')
                        <input type="submit" class="btn btn-danger btn-sm" style="width:123px ;margin-top:5px" value="Xóa phim">
                    </form>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection