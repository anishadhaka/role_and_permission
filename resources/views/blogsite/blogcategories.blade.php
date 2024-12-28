@extends('layout2.app2')
@yield('scripts')
@section('content')
<section class="featured-reviews">
    <h1 style="color:#395568; font-size:30px; font-weight:bold; margin:20px; text-decoration:underline;"><i>Blogs</i></h1>
    <h1 style="margin-bottom:20px;">Blog templates that set you up for success</h1>
    <div class="review-grid">
        @foreach($blog as $blog)
            <div class="review-card">
            <div style="display:flex;">        
            <img src="{{ asset('images/' . $blog->image) }}" class="card-img-top" >
            <i class="fa-regular fa-heart" style="margin-left:-30px; margin-top:10px; font-size:24px;" ></i>
           </div>
                <div class="date">{{ $blog->create_at }}</div>
                <h1>{{ $blog->name }}</h1>
                <a href="{{ url('/Blogs/' . $blog->slug) }}"  class="read-more">Read More</a>
                <i class="fa-regular fa-thumbs-up" style="margin:10px;"></i>
                <i class="fa-regular fa-thumbs-down"></i>
            </div>
        @endforeach
    </div>
    <button id="loadMore" class="load-more-btn">Load More</button>
</section>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $(".review-card").slice(3).hide(); 
        $("#loadMore").on("click", function(e) {
            e.preventDefault();
            $(".review-card:hidden").slice(0, 3).slideDown();
            if ($(".review-card:hidden").length == 0) {
                $("#loadMore").hide(); 
            }
        });
    });
</script>
@endsection