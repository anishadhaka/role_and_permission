<!-- <link rel="stylesheet" href="{{ asset('css/particularblog.css') }}"> -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
@extends('layout2.app2')
@section('content')
<div class="row">
    <section id="recent-posts" class="col-md-9">
            <div class="post-grid">
                <article class="featured">
                    <div class="post-image" >
                    <img src="{{ asset('images/' . $news->image) }}" class="card-img-top" style="height:500px;">

                    </div>
                    <div class="post-content">
                        <h3><strong> Title: </strong>{{ $news['name'] }}</h3>
                        <p>{{ $news['description'] }}</p>
                        <p class="para"> <strong> Post Date: </strong>{{ $news['created_at'] }}</p>
                        <p class="para"> <strong> Update Date:</strong>{{ $news['updated_at'] }}</p>
                    </div>
                </article>
            </div>
               
    </section>
    <div class="col-md-3" style=" margin-top: 40px;">
        
          <ul class="list">
            <h4><strong>Related Category Blogs</strong></h4>
            @foreach ($related_news as $row)
              <a href="{{ url('/News/' . $row->slug) }}" class="text-decoration-none text-dark">
              <li class="li-container">  <img src="{{ asset('images/' . $row->image) }}" class="card-img-top"style="height:100px;width:100px;">                  
                <h5 class="card-title">{{ $row['name'] }}</h5>
                </a>
              </li>
              @endforeach
          </ul>
    </div>
    </div>
@endsection