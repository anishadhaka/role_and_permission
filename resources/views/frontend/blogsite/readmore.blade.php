@extends('frontend.SiteLayout.appSite')
@section('content')
<style>
.post-image,
.post-content {
    width: -webkit-fill-available;
    text-align: center;
}
</style>
<div class="row">
    <section id="recent-posts" class="col-md-9">
        <div class="post-grid">
            <article class="featured">
                <div class="post-image">
                    <img src="{{ asset($blog->image) }}" class="card-img-top"
                        style="height:600px;width:700px;">

                </div>
                <div class="post-content">
                    <h3 style="margin-top: 24px;"><strong> Title: </strong>{{ $blog['name'] }}</h3>
                    <p style="margin-top: 24px;">{{ $blog['content'] }}</p>
                    <p class="para"> <strong> Post Date: </strong>{{ $blog['create_date'] }}</p>
                    <p class="para"> <strong> Update Date:</strong>{{ $blog['update_date'] }}</p>
                </div>
            </article>
        </div>

    </section>
    <div class="col-md-3" style=" margin-top: 40px;">
        <ul class="list">
            <h4><strong>Related Category Blogs</strong></h4>
            @foreach ($related_blogs as $row)
            <a href="{{ url('/Blogs/' . $row->slug) }}" class="text-decoration-none text-dark">
                <li class="li-container"> <img src="{{ asset($row->image) }}" class="card-img-top"
                        style="height:100px;width:100px;">
                    <h5 class="card-title">{{substr( $row['name'],0,20 )}}...</h5>
            </a>
            </li>
            @endforeach
        </ul>
    </div>
</div>

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