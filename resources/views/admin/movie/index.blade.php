@extends('layouts.app')

@section('content')
<div class="modal" id="videoModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><span id="video_title" style="font-size: 20px; color:black ;font-weight:600"></span></h5>
            </div>
            <div class="modal-body">
                <p id="video_desc" style="text-align:justify"></p>
                <p id="video_link"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>

    <div class="row justify-content-center">
        {{-- <div class="col-md-12"> --}}
            <a href="{{route('movie.create')}}" class="btn btn-info" style="margin-bottom: 15px">Thêm phim</a>
            <div class="table-responsive">
                <table class="table" id="tablephim" style=" border: 1px solid #ddd; border-radius: 8px; background-color: #f9f9f9; padding: 5px 10px 0 10px; ">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Tên phim (English)</th>
                            {{-- <th scope="col">Số tập</th> --}}
                            <th scope="col">Tập phim</th>
                            {{-- <th scope="col">Từ khóa</th> --}}
                            {{-- <th scope="col">Độ phân giải</th> --}}
                            {{-- <th scope="col">Phụ đề</th> --}}
                            <th scope="col">Hình ảnh</th>
                            {{-- <th scope="col">Phim hot</th> --}}
                            <th scope="col">Thời lượng</th>
                            {{-- <th scope="col">Slug</th> --}}
                            {{-- <th scope="col">Mô tả</th> --}}
                            {{-- <th scope="col">Hiển thị</th> --}}

                            <th scope="col">Thể loại</th>
                            <th scope="col">Danh mục</th>
                            <th scope="col">Quốc gia</th>

                            {{-- <th scope="col">Thuộc phim</th> --}}
                            <th scope="col">Ngày tạo</th>
                            <th scope="col">Ngày cập nhật</th>
                            <th scope="col">Tùy chỉnh</th>
                            {{-- <th scope="col">TopView</th>
                            <th scope="col">Năm</th>
                            <th scope="col">Season</th> --}}
                            <th scope="col">Quản lý</th>
                        </tr>
                </thead>
                    <tbody>
                        @foreach ($list as $key => $cate)
                            <tr>
                                <th scope="row">{{$key}}</th>

                                <td style="width: 60px">{{$cate->title}} - ({{$cate->name_eng}})</td>

                                
                                {{-- <td>{{$cate->episode_count}}/{{$cate->episode_movie}} Tập</td> --}}
                                <td>
                                    <a href="{{route('add-episode',[$cate->id])}}" class="btn btn-info btn-sm" style="padding:5px 25px">Thêm tập phim</a>
                                    <span style="display: flex;
                                    align-items: center;
                                    justify-content: center;
                                    height: 100%;">{{$cate->episode_count}}/{{$cate->episode_movie}} tập</span>
                                    {{-- @foreach ($cate->episode as $key => $epi)
                                        @if($key < 15)
                                            <a 
                                                class="show_video" 
                                                data-movie_video_id="{{$epi->movie_id}}" 
                                                data-video_episode="{{$epi->episode}}" 
                                                style="color:#fff; cursor:pointer">
                                                <span class="badge badge-dark" style="color:#ffffff">{{$epi->episode}}</span>
                                            </a>
                                        @endif 
                                    @endforeach --}}
                                </td>


                                {{-- <td>
                                    @if($cate->tags!=NULL)
                                    {{substr($cate->tags,0,50)}}...
                                    @else
                                    Chưa có từ khóa cho phim
                                    @endif
                                </td> --}}

                                {{-- <td> --}}
                                    {{-- @if($cate->resolution==0)
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
                                    @endif --}}
                                    {{-- @php
                                        $option = array('0'=>'HD','1'=>'SD','2'=>'HDCam','3'=>'Cam','4'=>'FullHD','5'=>'Trailer')
                                    @endphp
                                    <select id="{{$cate->id}}" class="resolution_choose">
                                        @foreach ($option as $key => $resolution)
                                            <option {{$cate->resolution==$key ? 'selected' : ''}} value="{{$key}}">{{$resolution}}</option>
                                        @endforeach
                                    </select> --}}
                                {{-- </td> --}}

                                {{-- <td> --}}
                                    {{-- @if($cate->subtitle==0)
                                    Vietsub
                                    @else
                                    Thuyết minh
                                    @endif --}}
                                    {{-- <select id="{{$cate->id}}" class="subtitle_choose">
                                        @if($cate->subtitle==0)
                                        <option value="1">Thuyết minh</option>
                                        <option selected value="0">Vietsub</option>
                                        @else
                                        <option selected value="1">Thuyết minh</option>
                                        <option value="0">Vietsub</option>
                                        @endif
                                    </select> --}}
                                {{-- </td> --}}

                                <td>
                                    <img width="100" src="{{ strpos($cate->image, 'https') !== false ? $cate->image : asset('uploads/movie/' . $cate->image) }}" alt="Movie Image">
                                </td>

                                {{-- <td> --}}
                                    {{-- @if($cate->phim_hot==0)
                                    Không
                                    @else
                                    Có
                                    @endif --}}
                                    {{-- <select id="{{$cate->id}}" class="phim_hot_choose">
                                        @if($cate->phim_hot==0)
                                        <option value="1">Có</option>
                                        <option selected value="0">Không</option>
                                        @else
                                        <option selected value="1">Có</option>
                                        <option value="0">Không</option>
                                        @endif
                                    </select>
                                </td> --}}

                                <td style="width:90px">{{$cate->time_movie}}</td>

                                {{-- <td>{{$cate->slug}}</td> --}}

                                {{-- <td>
                                    @if($cate->description!=NULL)
                                    {!! substr($cate->description,0,100) !!}...
                                    @else
                                    Chưa có mô tả cho phim
                                    @endif
                                </td> --}}

                                {{-- <td> --}}
                                    {{-- @if($cate->status)
                                    Có
                                    @else
                                    Không
                                    @endif --}}
                                    {{-- <select id="{{$cate->id}}" class="status_choose">
                                        @if($cate->status==0)
                                        <option value="1">Có</option>
                                        <option selected value="0">Không</option>
                                        @else
                                        <option selected value="1">Có</option>
                                        <option value="0">Không</option>
                                        @endif
                                    </select>
                                </td> --}}

                                {{-- <td>{{$cate->category->title}}</td> --}}
                                {{-- <td>
                                    {!! Form::select('category_id', $category , isset($cate) ? $cate->category->id : '',
                                    ['class'=>'category_choose','id'=>$cate->id,'style'=>'width:150px']) !!}
                                </td> --}}

                                <td>
                                    @foreach ($cate->movie_genre as $gen)
                                    <span class="badge badge-secondary">{{$gen->title}}</span>
                                    @endforeach
                                </td>
                                <td>
                                    <span  class="badge badge-secondary">{{$cate->category->title}}</span>
                                </td>

                                <td> 
                                    <span class="badge badge-secondary">{{$cate->country->title}}</span>        
                                </td>

                                {{-- <td> --}}
                                    {{-- @if($cate->belongmovie=='phimle')
                                    Phim lẻ
                                    @else
                                    Phim bộ
                                    @endif --}}
                                    {{-- <select id="{{$cate->id}}" class="belongmovie_choose">
                                        @if($cate->belongmovie=='phimle')
                                        <option value="phimbo">Phim bộ</option>
                                        <option selected value="phimle">Phim lẻ</option>
                                        @else
                                        <option selected value="phimbo">Phim bộ</option>
                                        <option value="phimle">Phim lẻ</option>
                                        @endif
                                    </select>
                                </td> --}}

                                <td>{{$cate->datecreated}}</td>
                                <td>{{$cate->updateday}}</td>
                                
                                <td>
                                    {!! Form::label('Topview', 'Topview', []) !!}<br>
                                    {!! Form::select('topview', ['0'=>'Ngày', '1'=>'Tuần','2'=>'Tháng'], isset($cate->topview) ?
                                    $cate->topview :
                                    '',['class'=>'select-topview','id'=>$cate->id,'placeholder'=>'View','style'=>'width:70px']) !!}
                                    {!! Form::label('year', 'Năm phim', []) !!}<br>
                                    {!! Form::selectYear('year', 1995, 2025, isset($cate->year) ? $cate->year :
                                    '',['class'=>'select-year','id'=>$cate->id,'placeholder'=>'Năm','style'=>'width:70px'])!!}
                                    {!! Form::label('season', 'Season', []) !!}<br>
                                    {!! Form::selectRange('season', 0, 20, isset($cate->season) ? $cate->season :
                                    '',['class'=>'select-season','id'=>$cate->id,'style'=>'width:70px'])!!}
                                </td>
                                <td>
                                    {!! Form::open(['method'=>'DELETE','route'=>['movie.destroy',$cate->id],'onsubmit'=>'return confirm("Bạn có chắc chắn xóa")']) !!}
                                    {!! Form::submit('Xóa', ['class'=>'btn btn-danger']) !!}
                                    {!! Form::close() !!}
                                    <a href="{{route('movie.edit', $cate->id)}}" style="margin-top: 5px; width:56px"
                                        class="btn btn-warning">Sửa</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        {{-- </div> --}}
    </div>

@endsection