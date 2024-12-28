@extends('layout2.app2')
@yield('scripts')
@section('content')
<section class="featured-reviews">
    <h1 style="color:#395568; font-size:30px; font-weight:bold; margin:20px; text-decoration:underline;"><i>News</i></h1>
    <h1 style="margin-bottom:20px;">THE TIMES OF INDIA</h1>
    <div class="review-grid">
        @foreach($news as $news)
            <div class="review-card2">
            <img src="{{ asset('images/' . $news->image) }}" class="card-img-top">

                <h1>{{ $news->name }}</h1>
                <a href="{{ url('/News/' . $news->slug) }}"  class="read-more">Read More</a>
            </div>
        @endforeach
    </div>
    <button id="loadMore2" class="load-more-btn">Load More</button>
</section>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $(".review-card2").slice(3).hide(); 
        $("#loadMore2").on("click", function(e) {
            e.preventDefault();
            $(".review-card2:hidden").slice(0, 3).slideDown();
            if ($(".review-card2:hidden").length == 0) {
                $("#loadMore2").hide(); 
            }
        });
    });
</script>
@endsection