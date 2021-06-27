@extends('layout.index')  
@section('content')
<!-- Page Content -->
<div class="container">
    <div class="row">
        @include('layout.menu')
        <?php
            function changeColor($str, $keyword) {
                return str_replace($keyword, "<span style='color: red;'>$keyword</span>", $str);
            }
        ?>
        <div class="col-md-9 ">
            <div class="panel panel-default">
                <div class="panel-heading" style="background-color:#337AB7; color:white;">
                    <h4><b>Tìm kiếm: {{$keyword}}</b></h4>
                </div>
                
                @foreach($tintuc as $item)
                <div class="row-item row">
                    <div class="col-md-3">

                        <a href="tintuc/{{$item->id}}/{{$item->TieuDeKhongDau}}.html">
                            <br>
                            <img width="200px" height="200px" class="img-responsive" src="upload/tintuc/{{$item->Hinh}}" alt="">
                        </a>
                    </div>

                    <div class="col-md-9">
                        <h3>{!! changeColor($item->TieuDe, $keyword) !!}</h3>
                        <p>{!! changeColor($item->TomTat, $keyword) !!}</p>
                        <a class="btn btn-primary" href="tintuc/{{$item->id}}/{{$item->TieuDeKhongDau}}.html">Xem thêm <span class="glyphicon glyphicon-chevron-right"></span></a>
                    </div>
                    <div class="break"></div>
                </div>
                @endforeach


                <!-- Pagination -->
                <div style="text-align: center;">
                    {{$tintuc->appends(Request::all())->links()}}
                </div>
                <!-- /.row -->

            </div>
        </div> 

    </div>

</div>
<!-- end Page Content -->
@endsection