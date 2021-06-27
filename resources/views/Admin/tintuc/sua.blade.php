@extends('Admin.layout.index')

@section('content')
    <!-- Page Content -->
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Tin Tức
                        <small>{{$tintuc->TieuDe}}</small>
                    </h1>
                </div>

                    @if(count($errors) > 0)
                        <div class="col-lg-12 alert alert-danger">
                            @foreach($errors->all() as $err)  
                                {{$err}}<br>
                            @endforeach
                        </div>
                    @endif
                    @if(session('thongbao')) 
                        <div class="col-lg-12 alert alert-success">
                            {{session('thongbao')}}
                        </div>
                    @endif

                    @if(session('loi')) 
                        <div class="col-lg-12 alert alert-danger">
                            {{session('loi')}}
                        </div>
                    @endif
                <!-- /.col-lg-12 -->
                <div class="col-lg-7" style="padding-bottom:120px">
                    <form action="admin/tintuc/sua/{{$tintuc->id}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label>Thể loại</label>
                            <select id="TheLoai" class="form-control" name="TheLoai">
                                @foreach($theloai as $item)
                                <option 
                                    @if($tintuc->loaitin->theloai->id == $item->id)
                                    {{"selected"}}
                                    @endif
                                value="{{$item->id}}">{{$item->Ten}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Loại tin</label>
                            <select id="LoaiTin" class="form-control" name="LoaiTin">
                                @foreach($loaitin as $item)
                                <option
                                    @if($tintuc->loaitin->id == $item->id)
                                    {{"selected"}}
                                    @endif
                                value="{{$item->id}}">{{$item->Ten}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Tiêu đề</label>
                            <input class="form-control" name="TieuDe" value="{{$tintuc->TieuDe}}" placeholder="Nhập tiêu đề" />
                        </div>
                        <div class="form-group">
                            <label>Tóm tắt</label>
                            <textarea id="demo" class="form-control ckeditor" name="TomTat" rows="3">{{$tintuc->TomTat}}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Nội dung</label>
                            <textarea id="demo" class="form-control ckeditor" name="NoiDung" rows="5">{{$tintuc->NoiDung}}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Hình ảnh</label>
                            <p>
                                <img width="400px" src="upload/tintuc/{{$tintuc->Hinh}}">
                            </p>
                            <input type="file" name="Hinh" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Nổi bật</label>
                            <label class="radio-inline">
                                <input name="NoiBat" value="0" 
                                @if($tintuc->NoiBat == 0) 
                                    {{"checked"}}
                                @endif
                                type="radio">Không
                            </label>
                            <label class="radio-inline">
                                <input name="NoiBat" value="1"
                                @if($tintuc->NoiBat == 1) 
                                    {{"checked"}}
                                @endif
                                type="radio">Có
                            </label>
                        </div>
                        <button type="submit" class="btn btn-default">Sửa</button>
                        <button type="reset" class="btn btn-default">Làm mới</button>
                    <form>
                </div>
            </div>
            <!-- /.row -->
            <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Bình Luận
                            <small>Danh sách</small>
                        </h1>
                    </div>

                    <!-- /.col-lg-12 -->
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                            <tr align="center">
                                <th>ID</th>
                                <th>Người dùng</th>
                                <th>Nội dung</th>
                                <th>Ngày đăng</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tintuc->comment as $item)
                            <tr class="odd gradeX" align="center">
                                <td>{{$item->id}}</td>
                                <td>{{$item->user->name}}</td>
                                <td>{{$item->NoiDung}}</td>
                                <td>{{$item->created_at}}</td>
                                <td class="center"><i class="fa fa-trash-o  fa-fw"></i><a href="admin/comment/xoa/{{$item->id}}/{{$tintuc->id}}">Xóa</a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                        <!-- end Row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->
    <!-- new row Comment -->
               

@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('#TheLoai').change(function() {
                var idTheLoai = $(this).val();
                $.get("admin/ajax/loaitin/"+idTheLoai, function(data) {
                    $('#LoaiTin').html(data);
                });
            });
        });
    </script>
@endsection 