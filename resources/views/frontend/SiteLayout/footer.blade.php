  <!--footer start-->
  <footer id="footer" class="footer">
      <div class="container">
          <div class="footer-menu">
              <div class="row">
                  <div class="col-sm-3">
                      <div class="navbar-header">
                          <a class="navbar-brand" href="index.html">WEL<span>COME</span></a>
                      </div>
                  </div>
                  <div class="col-sm-9">
                      <ul class="footer-menu-item">
                          <li class="scroll"><a href="#works">how it works</a></li>
                          <li class="scroll"><a href="#explore">explore</a></li>
                          <li class="scroll"><a href="#reviews">review</a></li>
                          <li class="scroll"><a href="#blog">blog</a></li>
                          <li class="scroll"><a href="#contact">contact</a></li>
                          <li class="scroll"><a href="#contact">my account</a></li>
                      </ul>
                  </div>
              </div>
          </div>
          <div class="hm-footer-copyright">
              <div class="row">
                  <div class="col-sm-5">
                      <p>
                          &copy;copyright. designed and developed by
                          <a href="https://www.themesine.com/">themesine</a>
                      </p>
                  </div>
                  <div class="col-sm-7">
                      <div class="footer-social">
                          <span><i class="fa fa-phone"> +1 (222) 777 8888</i></span>
                          <a href="#"><i class="fa fa-facebook"></i></a>
                          <a href="#"><i class="fa fa-twitter"></i></a>
                          <a href="#"><i class="fa fa-linkedin"></i></a>
                          <a href="#"><i class="fa fa-google-plus"></i></a>
                      </div>
                  </div>
              </div>
          </div>
      </div>

      <div id="scroll-Top">
          <div class="return-to-top">
              <i class="fa fa-angle-up" id="scroll-top" data-toggle="tooltip" data-placement="top" title=""
                  data-original-title="Back to Top" aria-hidden="true"></i>
          </div>
      </div>
  </footer>

  <script src="{{ asset('js/jquery.js') }}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js"></script>
  <script src="{{ asset('js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('js/bootsnav.js') }}"></script>
  <script src="{{ asset('js/feather.min.js') }}"></script>
  <script src="{{ asset('js/jquery.counterup.min.js') }}"></script>
  <script src="{{ asset('js/waypoints.min.js') }}"></script>
  <script src="{{ asset('js/slick.min.js') }}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
  <script src="{{ asset('js/custom.js') }}"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
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
            $this.closest('.review-card, .review-card2').find('.fa-thumbs-down').removeClass(
                'fa-solid').addClass('fa-regular');
        } else if ($this.hasClass("fa-thumbs-down")) {
            // Deselect the like button
            $this.closest('.review-card, .review-card2').find('.fa-thumbs-up').removeClass(
                'fa-solid').addClass('fa-regular');
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
  </body>

  </html>