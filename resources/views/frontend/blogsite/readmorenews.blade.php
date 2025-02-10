@extends('frontend.SiteLayout.appSite')
@section('content')
<div class="row">
    <section id="recent-posts" class="col-md-9">
        <div class="post-grid">
            <article class="featured">
                <div class="post-image" style="text-align: center;">
                    <img src="{{ asset($news->image) }}" class="card-img-top" style=" height: auto; width: 700px;">

                </div>
                <div class="post-content" style="text-align: center;">
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
                <li class="li-container"> <img src="{{ asset($row->image) }}" class="card-img-top"
                        style="height:100px;width:100px;">
                    <h5 class="card-title">{{substr( $row['name'],0,20 )}}...</h5>
            </a>
            </li>
            @endforeach
        </ul>
    </div>
</div>
@endsection