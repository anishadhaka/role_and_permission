<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Watch My Review</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/blogsite.css') }}">
    <link rel="stylesheet" href="{{ asset('css/contactus.css') }}">
    <link rel="stylesheet" href="{{ asset('css/about.css') }}">
    <link rel="stylesheet" href="{{ asset('css/categorias.css') }}">
<style>
    .dropdown {
        position: relative;
        display: inline-block;
    }
    .dropdown-content1 {
        display: none;
        position: absolute;
        background-color: #f9f9f9;
        min-width: 200px;
        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
        z-index: 1;
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .dropdown-content1 li {
        padding: 10px;
    }
    .dropdown-content1 a {
        text-decoration: none;
        color: #333;
        display: block;
    }
    .dropdown-content1 a:hover {
        background-color: #ddd;
    }
    .dropdown:hover .dropdown-content1 {
        display: block;
    }
</style>
</head>
<body>

<header>
    <div class="logo">
        <h1>
            <img src="https://www.absglobaltravel.com/public/images/footer-abs-logo.webp" width="200px" height="50px;">
        </h1>
    </div>
    <nav>
        <ul>
            <li><a href="{{ route('blogsite') }}"><i class="fa-solid fa-house"></i> Home</a></li>
            <!-- <li class="dropdown">
                <a href="#" class="dropbtn1">Categorías <i class="fa-solid fa-caret-down"></i></a>
                <ul class="dropdown-content1">
                    @if (!empty($categories))
                        @foreach ($categories as $category)
                            <li>
                                <a href="{{ route('blogsite.category', ['title' => $category['Title']]) }}" class="category-link">
                                    {{ htmlspecialchars($category['Title']) }}
                                </a>
                            </li>
                        @endforeach
                    @else
                        <li>No categories available</li>
                    @endif
                </ul>
            </li> -->
            <li><a href="{{ route('about') }}">About</a></li>
            <li><a href="{{ route('contactus') }}">Contact Us</a></li>
            <!-- <li class="dropdown">
                <a href="#" class="dropbtn1">News Categorías <i class="fa-solid fa-caret-down"></i></a>
                <ul class="dropdown-content1">
                    @if (!empty($newscategories))
                        @foreach ($newscategories as $category)
                            <li>
                                <a href="{{ route('news.category', ['title' => $category['Title']]) }}">
                                    {{ htmlspecialchars($category['Title']) }}
                                </a>
                            </li>
                        @endforeach
                    @else
                        <li>No news categories available</li>
                    @endif
                </ul>
            </li> -->
        </ul>
    </nav>
</header>

<script>
    document.querySelector('.dropbtn1').addEventListener('click', function(event) {
        event.preventDefault();
        var dropdown = document.querySelector('.dropdown-content1');
        dropdown.style.display = (dropdown.style.display === 'block') ? 'none' : 'block';
    });
</script>

