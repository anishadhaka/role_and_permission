
<!-- Include the required CSS and JS -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="{{ asset('css/styles.css') }}">
<link rel="stylesheet" href="{{ asset('css/blogsite.css') }}">
<link rel="stylesheet" href="{{ asset('css/contactus.css') }}">
<link rel="stylesheet" href="{{ asset('css/about.css') }}">
<link rel="stylesheet" href="{{ asset('css/categorias.css') }}">

<!-- Hero Section -->
<section class="hero">
  <h2>INBOUND MARKETING BLOG</h2>
  <ul>
    <li><a href="{{ route('blogsite') }}"><i class="fa-solid fa-house"></i> Home</a></li>
    <li><a href="{{ route('blogcategories') }}">Blog Categories</a></li>
    <li><a href="{{ route('newscategories') }}">News Section</a></li>
    <li><a href="{{ route('about') }}">SEO</a></li>
    <li><a href="{{ route('contactus') }}">Contact Marketing</a></li>
    <li><a href="{{ route('contactus') }}">Inbound Marketing</a></li>
  </ul>
</section>

<!-- Top Section -->
<section>
  <div class="top3">
    <h5>Receive the monthly newsletter</h5>
    <button>
      <a href="{{ url('/login') }}"><i class="fa-regular fa-user"></i></a>
    </button>
  </div>
</section>
