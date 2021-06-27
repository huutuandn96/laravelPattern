<!-- slider -->
<div class="row carousel-holder">
    <div class="col-md-12">
        <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <?php $no = 0;?>
                @foreach($slide as $item)
                    <li data-target="#carousel-example-generic" data-slide-to="{{$no}}" 
                    @if($no==0)
                        class="active"
                    @endif
                    ></li>
                    <?php $no++; ?>
                @endforeach
            </ol>
            <div class="carousel-inner">
                <?php $no = 0; ?>
                @foreach($slide as $item)
                    <div 
                    @if($no==0)
                        class="item active"
                    @else 
                        class="item"
                    @endif
                    >
                    <?php $no++; ?>
                        <img class="slide-image" src="upload/slide/{{$item->Hinh}}" alt="{{$item->NoiDung}}">
                    </div>
                @endforeach
            </div>
            <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left"></span>
            </a>
            <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right"></span>
            </a>
        </div>
    </div>
</div>
<!-- end slide -->