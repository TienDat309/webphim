@extends('layouts.app')

@section('content')
<div class="table-responsive">
    <table class="table" style="border: 1px solid #ddd; border-radius: 8px; background-color: #f9f9f9; padding-top: 5px">
        <thead>
            <tr>
                <th scope="col">_id</th>
                <th scope="col">Tên phim</th>
                <th scope="col">Tên tiếng anh</th>
                <th scope="col">Mô tả</th>
                <th scope="col">Thuộc phim</th>
                <th scope="col">Trạng thái</th>
                <th scope="col">Hình ảnh</th>
                {{-- <th scope="col">Poster</th> --}}
                {{-- <th scope="col">Bản quyền</th> --}}
                <th scope="col">Trailer</th>
                <th scope="col">Thời gian</th>
                <th scope="col">Tập hiện tại</th>
                <th scope="col">Tổng số tập</th>
                <th scope="col">Chất lượng</th>
                <th scope="col">Phụ đề</th>
                {{-- <th scope="col">Thông báo</th>
                <th scope="col">Lịch chiếu</th> --}}
                <th scope="col">slug</th>
                <th scope="col">Năm</th>
                <th scope="col">Lượt xem</th>
                <th scope="col">Diễn viên</th>
                <th scope="col">Đạo diễn</th>
                <th scope="col">Thể loại</th>
                <th scope="col">Quốc gia</th>
                {{-- <th scope="col">chieurap</th> --}}
                {{-- <th scope="col">sub_docquyen</th> --}}
            </tr>
        </thead>
        <tbody>
            @foreach ($resp_movie as $key => $res)
            <tr>
                <th scope="row">{{$key}}</th>
                <td>{{$res['name']}}</td>
                <td>({{$res['origin_name']}})</td>
                <td>{!! substr($res['content'], 0, 100) !!}</td>
                <td>{{$res['type']}}</td>
                <td>{{$res['status']}}</td>
                <td><img src="{{$res['thumb_url']}}" height="80" width="80"></td>
                {{-- <td><img src="{{$res['poster_url']}}" height="80" width="80"></td> --}}
                {{-- <td>
                    @if($res['is_copyright']==true)
                        Có
                    @else
                       Không
                    @endif
                </td> --}}
                <td>{{$res['trailer_url']}}</td>
                <td>{{$res['time']}}</td>
                <td>{{$res['episode_current']}}</td>
    
                <td>{{$res['episode_total']}}</td>
                <td>{{$res['quality']}}</td>
                <td>{{$res['lang']}}</td>
                {{-- <td>{{$res['notify']}}</td>
                <td>{{$res['showtimes']}}</td> --}}
                <td>{{$res['slug']}}</td>
                <td>{{$res['year']}}</td>
                <td>{{$res['view']}}</td>
                <td>
                    @foreach ($res['actor'] as $actor)
                        <span class="badge badge-info">{{$actor}}</span>
                    @endforeach
                </td>
                <td>
                    @foreach ($res['director'] as $director)
                        <span class="badge badge-info">{{$director}}</span>
                    @endforeach
                </td>
                <td>
                    @foreach ($res['category'] as $category)
                        <span class="badge badge-info">{{$category['name']}}</span>
                    @endforeach
                </td>
                <td>
                    @foreach ($res['country'] as $country)
                        <span class="badge badge-info">{{$country['name']}}</span>
                    @endforeach
                </td>
                {{-- <td>
                    @if($res['chieurap']==true)
                        Có
                    @else
                       Không
                    @endif
                </td> --}}
                {{-- <td>
                    @if($res['sub_docquyen']==true)
                      Có
                    @else
                        Không
                    @endif
                </td> --}}
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection