@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <a href="{{route('movie.create')}}" class="btn btn-success m-3">Thêm phim</a>
            <table class="table table-responsive" id="tablephim">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Tên phim (English)</th>
                        <th scope="col">Số tập phim</th>
                        <th scope="col">Tập phim</th>
                        <th scope="col">Từ khóa</th>
                        <th scope="col">Định dạng</th>
                        <th scope="col">Phụ đề</th>
                        <th scope="col">Hình ảnh</th>
                        <th scope="col">Phim hot</th>
                        <th scope="col">Thời lượng</th>
                        <th scope="col">Slug</th>
                        <th scope="col">Mô tả</th>
                        <th scope="col">Hiển thị</th>
                        <th scope="col">Danh mục</th>
                        <th scope="col">Thuộc phim</th>
                        <th scope="col">Thể loại</th>
                        <th scope="col">Quốc gia</th>
                        <th scope="col">Ngày tạo</th>
                        <th scope="col">Ngày cập nhật</th>
                        <th scope="col">View theo</th>
                        <th scope="col">Năm phim</th>
                        <th scope="col">Season</th>
                        <th scope="col">Quản lý</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($list as $key => $cate)
                    <tr>
                        <th scope="row">{{$key}}</th>

                        <td>{{$cate->title}} - ({{$cate->name_eng}})</td>
                        
                        <td>{{$cate->episode_count}}/{{$cate->episode_movie}} tập</td>

                        <td>
                            <a href="{{route('add-episode',[$cate->id])}}" class="btn btn-info btn-sm">Thêm tập mới</a>
                        </td>

                        
                        <td>
                            @if($cate->tags!=NULL)
                            {{substr($cate->tags,0,50)}}...
                            @else
                            Chưa có từ khóa cho phim
                            @endif    
                        </td>
                        
                        <td>
                            @if($cate->resolution==0)
                            HD
                            @elseif($cate->resolution==1)
                            SD
                            @elseif($cate->resolution==2)
                            HDCam
                            @elseif($cate->resolution==3)
                            Cam
                            @elseif($cate->resolution==4)
                            FullHD
                            @else
                            Trailer
                            @endif
                        </td>

                        <td>
                            @if($cate->subtitle==0)
                            Phụ đề
                            @else
                            Thuyết minh
                            @endif
                        </td>

                        <td><img width="100" src="{{asset('uploads/movie/'.$cate->image)}}"></td>

                        <td>
                            @if($cate->phim_hot==0)
                            Không
                            @else
                            Có
                            @endif
                        </td>

                        <td>{{$cate->time_movie}}</td>

                        <td>{{$cate->slug}}</td>

                        <td style="text-align: justify">
                            @if($cate->description!=NULL)
                                {{substr($cate->description,0,150)}}...
                            @else
                                Chưa có mô tả cho phim
                            @endif
                        </td>

                        <td>
                            @if($cate->status)
                            Có
                            @else
                            Không
                            @endif
                        </td>

                        <td>{{$cate->category->title}}</td>
                        
                        <td>
                            @if($cate->belongmovie=='phimle')
                            Phim lẻ
                            @else
                            Phim bộ
                            @endif
                        </td>
                        
                        <td>
                            @foreach ($cate->movie_genre as $gen)
                            <span class="badge badge-info">{{$gen->title}}</span>   
                            @endforeach
                        </td>
                        
                        <td>{{$cate->country->title}}</td>
                        
                        <td>{{$cate->datecreated}}</td>
                        <td>{{$cate->updateday}}</td>
                        <td>
                            {!! Form::select('topview', ['0'=>'Ngày', '1'=>'Tuần','2'=>'Tháng'], isset($cate->topview) ? $cate->topview :
                            '',['class'=>'select-topview','id'=>$cate->id]) !!}
                        </td>
                        <td>
                            {!! Form::selectYear('year', 2000, 2023, isset($cate->year) ? $cate->year :
                            '',['class'=>'select-year','id'=>$cate->id])!!}
                        </td>
                        <td>
                            {!! Form::selectRange('season', 0, 20, isset($cate->season) ? $cate->season :
                            '',['class'=>'select-season','id'=>$cate->id])!!}
                        </td>
                        <td>
                            {!! Form::open(['method'=>'DELETE','route'=>['movie.destroy',$cate->id],'onsubmit'=>'return confirm("Bạn có chắc chắn xóa")']) !!}
                                {!! Form::submit('Xóa', ['class'=>'btn btn-danger']) !!}
                            {!! Form::close() !!}
                            <a href="{{route('movie.edit', $cate->id)}}" style="margin-top: 5px"
                                class="btn btn-warning">Sửa</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection