@extends('frontend.SiteLayout.appSite')
@yield('scripts')
@section('content')
<section class="featured-reviews">
    <h1 style="color:#395568; font-size:30px; font-weight:bold; margin:20px; text-decoration:underline;"><i>News</i>
    </h1>
    <h1 style="margin-bottom:20px;">THE TIMES OF INDIA</h1>
    <div class="review-grid">
        @foreach($newss as $newsItem)

        <div class="review-card2">
            <div style="display:flex;">
                <img src="{{ asset('images/' . $newsItem->image) }}" class="card-img-top">
                <i class="fa-{{ $newsItem->isFavorited ? 'solid' : 'regular' }} fa-heart favorite-btn action"
                    data-id="{{ $newsItem->id }}" data-type="news" data-action="favorite"
                    style="margin-left:-30px; margin-top:10px; font-size:24px; cursor: pointer;">
                </i>
            </div>
            <h1>{{ $newsItem->name }}</h1>
            <a href="{{ url('/News/' . $newsItem->slug) }}" class="read-more">Read More</a>
            <i class="fa-{{ $newsItem->isLiked ? 'solid' : 'regular' }} fa-thumbs-up like-btn action"
                data-id="{{ $newsItem->id }}" data-type="news" data-action="like"
                style="margin:10px; font-size:24px; cursor: pointer;">
            </i>
            <i class="fa-{{ $newsItem->isDisliked ? 'solid' : 'regular' }} fa-thumbs-down dislike-btn action"
                data-id="{{ $newsItem->id }}" data-type="news" data-action="dislike"
                style="margin:10px; font-size:24px; cursor: pointer;">
            </i>
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

$(document).ready(function() {

    $(".action").on("click", function() {
        const $this = $(this);
        const actionData = {
            id: $this.data("id"),
            type: $this.data("type"),
            action: $this.data("action"),
        };


        if ($this.hasClass("fa-regular")) {
            $this.removeClass("fa-regular").addClass("fa-solid");
        } else {
            $this.removeClass("fa-solid").addClass("fa-regular");
        }


        if ($this.hasClass("fa-thumbs-up")) {

            $this.closest('.review-card, .review-card2').find('.fa-thumbs-down').removeClass('fa-solid')
                .addClass('fa-regular');
        } else if ($this.hasClass("fa-thumbs-down")) {

            $this.closest('.review-card, .review-card2').find('.fa-thumbs-up').removeClass('fa-solid')
                .addClass('fa-regular');
        }

        $.ajax({
            url: "/action-user-store",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                id: actionData.id,
                type: actionData.type,
                action: actionData.action,
            },
            success: function(response) {
                console.log("Action recorded:", response);
            },
            error: function(xhr, status, error) {
                console.error("Error recording action:", xhr.responseText);
                alert("An error occurred. Please try again.");
            },
        });
    });
});
</script>
@endsection