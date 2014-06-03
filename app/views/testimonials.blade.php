@extends('layout.main')

@section('content')

 <!-- Carousel
    ================================================== -->
    <div id="myCarousel" class="carousel slide" data-ride="carousel">
      <!-- Indicators -->
      <ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#myCarousel" data-slide-to="1"></li>
        <li data-target="#myCarousel" data-slide-to="2"></li>
      </ol>
      <div class="carousel-inner">
        
        <div class="item active">
          <div class="container">
            <div class="well well-large">
            </div>
              <div class="carousel-caption">
                <p>"Lorem ipsum dolor sit amet, consectetur adipiscing elit."</p>
              </div>
          </div>
        </div>
        
        <div class="item">
          <div class="container">
            <div class="well well-large">
            </div>
              <div class="carousel-caption">
                <p>"Curabitur augue sapien, imperdiet id sem sit amet, euismod tristique neque. Praesent congue dui a eleifend luctus. Integer vitae nisi in diam tincidunt rhoncus. "</p>
              </div>
          </div>
        </div>
        
        <div class="item">
          <div class="container">
            <div class="well well-large">
            </div>
              <div class="carousel-caption">
                <p>"Donec sollicitudin egestas dolor, id egestas dui commodo eu. Maecenas scelerisque pretium massa non volutpat. In ornare tempor orci, in ultricies tortor suscipit et. Nulla at dui sit amet orci scelerisque sagittis. Proin non dolor est. Etiam nulla nunc, semper sed tortor non, sodales rhoncus est. Cras justo eros, auctor ut dolor eu, blandit rutrum libero.

"</p>
              </div>
          </div>
        </div>

      </div>
      <a class="left carousel-control" href="#myCarousel" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a>
      <a class="right carousel-control" href="#myCarousel" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a>
    </div><!-- /.carousel -->

@stop