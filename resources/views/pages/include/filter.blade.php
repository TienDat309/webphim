<form action="{{route('filter')}}" method="GET">
    <style type="text/css">
        .stylish_filter {
            border: 0;
            background: #11171f;
            color: #f0eeee;
        }

        .btn-filter {
            border: 0 #b2b7bb;
            background: #11171f;
            color: #ffed4d;
            padding: 7px 27px;
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
            font-size: 14px;
        }
    </style>
    <div class="col-md-2">
        <div class="form-group">
            <select class="form-control stylish_filter" name="order" id="exampleFormControlSelect1">
                <option value="">-Sắp xếp-</option>
                <option value="datecreated">Ngày đăng</option>
                <option value="year">Năm phim</option>
                <option value="title">Tên phim</option>
                <option value="topview">Lượt xem</option>
            </select>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <select class="form-control stylish_filter" name="genre" id="exampleFormControlSelect1">
                <option value="">-- Thể loại --</option>
                @foreach ($genre_home as $key => $gen_filter)
                    <option {{ (isset($_GET['genre']) && $_GET['genre'] == $gen_filter->id) ? 'selected' : '' }} value="{{ $gen_filter->id }}">{{ $gen_filter->title }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <select class="form-control stylish_filter" name="country" id="exampleFormControlSelect1">
                <option value="">-- Quốc gia --</option>
                @foreach ($country_home as $key => $cou_filter)
                <option {{(isset($_GET['country']) && $_GET['country']==$cou_filter->id) ? 'selected' : ''}} value="{{$cou_filter->id}}">{{$cou_filter->title}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group ">
            @php
                if(isset($_GET['year'])){
                    $year = $_GET['year'];
                }else{
                    $year = null;
                }
            @endphp
            {!! Form::selectYear('year', 1995, 2025, $year,['class'=>'form-control stylish_filter','placeholder'=>'-- Năm --'])!!}
        </div>
    </div>
    <div class="col-md-1">
        <input type="submit" class="btn btn-sm btn-default btn-filter " value="Lọc phim">
    </div>
</form>