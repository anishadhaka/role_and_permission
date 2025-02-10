@extends('frontend.SiteLayout.appSite')
@yield('scripts')
@section('content')
<section class="featured-reviews">
    <h1 style="color:#395568; font-size:30px; font-weight:bold; margin:20px; text-decoration:underline;"><i>Blogs</i>
    </h1>
    <h1 style="margin-bottom:20px;">Blog templates that set you up for success</h1>
    <div class="review-grid">
        @foreach($blogs as $blog)
        <div class="review-card">
            <div style="display:flex;">
                <img src="{{ asset($blog->image) }}" class="card-img-top">
                <i class="fa-{{ $blog->isFavorited ? 'solid' : 'regular' }} fa-heart favorite-btn action"
                    data-id="{{ $blog->id }}" data-type="blog" data-action="favorite"
                    style="margin-left:-30px; margin-top:10px; font-size:24px; cursor: pointer;">
                </i>
            </div>
            <div class="date">{{ $blog->created_at }}</div>
            <h1>{{ $blog->name }}</h1>
            <a href="{{ url('/Blogs/' . $blog->slug) }}" class="read-more">Read More</a>
            <i class="fa-{{ $blog->isLiked ? 'solid' : 'regular' }} fa-thumbs-up like-btn action"
                data-id="{{ $blog->id }}" data-type="blog" data-action="like"
                style="margin:10px; font-size:24px; cursor: pointer;">
            </i>
            <i class="fa-{{ $blog->isDisliked ? 'solid' : 'regular' }} fa-thumbs-down dislike-btn action"
                data-id="{{ $blog->id }}" data-type="blog" data-action="dislike"
                style="margin:10px; font-size:24px; cursor: pointer;">
            </i>
        </div>
        @endforeach
    </div>
</section>

<section class="featured-reviews">
    <h1 style="color:#395568; font-size:30px; font-weight:bold; margin:20px; text-decoration:underline;"><i>News</i>
    </h1>
    <h1 style="margin-bottom:20px;">THE TIMES OF INDIA</h1>
    <div class="review-grid">
        @foreach($news as $newsItem)

        <div class="review-card2">
            <div style="display:flex;">
                <img src="{{ asset($newsItem->image) }}" class="card-img-top">
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
    // Handle like, dislike, and favorite actions
    $(".action").on("click", function() {
        const $this = $(this);
        const actionData = {
            id: $this.data("id"),
            type: $this.data("type"),
            action: $this.data("action"),
        };

        // Toggle the class for visual feedback (for favorite, like, or dislike)
        if ($this.hasClass("fa-regular")) {
            $this.removeClass("fa-regular").addClass("fa-solid");
        } else {
            $this.removeClass("fa-solid").addClass("fa-regular");
        }

        // If it's a like or dislike action, ensure the opposite button is deselected
        if ($this.hasClass("fa-thumbs-up")) {
            // Deselect the dislike button
            $this.closest('.review-card, .review-card2').find('.fa-thumbs-down').removeClass('fa-solid')
                .addClass('fa-regular');
        } else if ($this.hasClass("fa-thumbs-down")) {
            // Deselect the like button
            $this.closest('.review-card, .review-card2').find('.fa-thumbs-up').removeClass('fa-solid')
                .addClass('fa-regular');
        }

        // AJAX call to backend
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