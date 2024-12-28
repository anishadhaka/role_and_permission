<link rel="stylesheet" href="{{ asset('css/sitefooter.css') }}">

<footer class="footer">
    <div class="footer-container">
        <!-- About Us Section -->
        <div class="footer-section">
            <h3>About Us</h3>
            <p>We are a team of passionate individuals working to create a better online experience for everyone.</p>
        </div>

        <!-- Quick Links Section -->
        <div class="footer-section">
            <h3>Quick Links</h3>
            <ul>
                <li><a href="{{ route('blogsite') }}">Home</a></li>
                <li><a href="#">Services</a></li>
                <li><a href="{{ route('about') }}">About</a></li>
                <li><a href="{{ route('contactus') }}">Contact</a></li>
            </ul>
        </div>

        <!-- Contact Us Section -->
        <div class="footer-section">
            <h3>Contact Us</h3>
            <p>Email: info@example.com</p>
            <p>Phone: +1 234 567 890</p>
        </div>

        <!-- Follow Us Section -->
        <div class="footer-section">
            <h3>Follow Us</h3>
            <ul class="social-links">
                <li><a href="#" target="_blank"><i class="fa-brands fa-facebook"></i></a></li>
                <li><a href="#" target="_blank"><i class="fa-brands fa-twitter"></i></a></li>
                <li><a href="#" target="_blank"><i class="fa-brands fa-square-instagram"></i></a></li>
                <li><a href="#" target="_blank"><i class="fa-brands fa-linkedin"></i></a></li>
            </ul>
        </div>
    </div>

    <!-- Footer Bottom -->
    <div class="footer-bottom">
        <p>&copy; {{ date('Y') }} My Website. All rights reserved.</p>
    </div>
</footer>

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

  document.querySelector('.dropbtn').addEventListener('click', function(event) {
    event.preventDefault();
    var dropdown = document.querySelector('.dropdown-content');
    dropdown.style.display = (dropdown.style.display === 'block') ? 'none' : 'block';
  });
</script>
