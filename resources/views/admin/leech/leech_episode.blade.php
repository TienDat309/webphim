@extends('layouts.app')

@section('content')
<table class="table" style="border: 1px solid #ddd; border-radius: 8px; background-color: #f9f9f9; padding-top: 5px">
    <thead>
        <tr>
            <th scope="col">#</th> 
            <th scope="col">Link Embed</th>
            <th scope="col">Tên phim</th>
            <th scope="col">Slug phim</th>
            <th scope="col">Tổng số tập</th>
            <th scope="col">Tập phim</th>
            <th scope="col">Quản lý</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($resp['episodes'] as $key => $res)
        <tr>
            <th scope="row">{{$key}}</th>
            <td>
                @foreach ($res['server_data'] as $key => $server_1)
                    <ul>
                        <div>Tập {{$server_1['name']}}
                            <input type="text" class="form-control" value="{{$server_1['link_embed']}}">
                        </div>
                    </ul>
                @endforeach
            </td>
            <td>{{$resp['movie']['name']}}</td>
            <td>{{$resp['movie']['slug']}}</td>
            <td>{{$resp['movie']['episode_total']}}</td>

            <td>
                {{$res['server_name']}}  
            </td>

            <td>
                <form method="POST" action="{{route('leech-episode-store',[$resp['movie']['slug']])}}">
                    @csrf
                    <input type="submit" value="Thêm tập phim" class="btn btn-success btn-sm">
                </form>
            </td>
            
        </tr>
        @endforeach
    </tbody>
</table>

@endsection