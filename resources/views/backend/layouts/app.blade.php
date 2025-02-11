<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
   
    <!-- <link rel="stylesheet" type="text/css" href="{{ asset('css/sidebar.css') }}"> -->

    <script src="<?php echo asset('js/jquery.js');?>"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"/>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    
<script src="<?php echo asset('bootstrap-iconpicker\js\jquery-menu-editor.js');?>"></script>
<script src="<?php echo asset('bootstrap-iconpicker\js\jquery-menu-editor.min.js');?>"></script>
 
    <!-- {{-- <link rel="stylesheet" href="{{ asset('css/blog.css') }}"> --}} -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

    <script src="<?php echo asset('js/jquery.js');?>"></script>
    <script src="<?php echo asset('bootstrap-iconpicker\js\jquery-menu-editor.js');?>"></script>
    <script src="<?php echo asset('bootstrap-iconpicker\js\jquery-menu-editor.min.js');?>"></script>
    <script src="<?php echo asset('js/bootstrap.js');?>"></script>
    <script src="<?php echo asset('js/menu.js');?>"></script>
    <script src="<?php echo asset('js/popper.js');?>"></script>
    <script src="<?php echo asset('js/perfect-scrollbar.js');?>"></script>
    <script src="<?php echo asset('js/apexcharts.js');?>"></script>
    <script src="<?php echo asset('js/perfect-scrollbar.js');?>"></script>
    <script src="<?php echo asset('js/config.js');?>"></script>
    <script src="<?php echo asset('js/menu.js');?>"></script>
    <script src="<?php echo asset('js/dashboards-analytics.js');?>"></script>
    <script src="<?php echo asset('js/helpers.js');?>"></script>
    <script src="<?php echo asset('js/main.js');?>"></script>
    <script type="text/javascript" src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js'></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
    <script src="<?php echo asset('bootstrap-iconpicker/js/iconset/fontawesome5-3-1.min.js'); ?>"></script>
    <script src="<?php echo asset('bootstrap-iconpicker/js/bootstrap-iconpicker.min.js');?>"></script>
    <script src="<?php echo asset('bootstrap-iconpicker/js/jquery-menu-editor.min.js');?>"></script>
    <script src="http://127.0.0.1:8000/bootstrap-iconpicker/js/iconset/fontawesome5-3-1.min.js"></script>
    <script src="http://127.0.0.1:8000/bootstrap-iconpicker/js/bootstrap-iconpicker.min.js"></script>
    <script src="http://127.0.0.1:8000/bootstrap-iconpicker/js/jquery-menu-editor.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.3/umd/popper.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<style>

    </style>
</head>
<body>
    <div id="app">
   @auth
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand"  style=" margin-left:70px">
                   Dashboard
                </a>
                <a href="{{ route('blogsite') }}" > <i class="fa-solid fa-eye"></i> View</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>
@endauth
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                    

                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}"> {{ __('Login') }}</a>
                                </li>
                            @endif
                           

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a  id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown"  >
                                    <a  class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
      @auth
        @include('backend.layouts.sidebar')
  @endauth
    
    <main class="content" id="main">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-12" >
                            <div class="card p-3 m-4">
                                <div class="card-body">
                                    @yield('content')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>


</body>
<script src="https://cdn.ckeditor.com/4.20.2/standard/ckeditor.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.getElementById('button-image').addEventListener('click', (event) => {
            event.preventDefault();
            const width = 600;
            const height = 400;
            const left = (window.screen.width / 2) - (width / 2);
            const top = (window.screen.height / 2) - (height / 2);
            window.open('/file-manager/fm-button', 'fm', `width=${width},height=${height},top=${top},left=${left}`);
        });
    });

    // Set file link
    function fmSetLink($url) {
        const modifiedUrl = $url.replace(/^https?:\/\/[^\/]+\//, ''); // Removes protocol and domain
        document.getElementById('image_label').value = modifiedUrl;
     }

    CKEDITOR.replace('content', {
        filebrowserImageBrowseUrl: '/file-manager/ckeditor'
    });


    function toggleSidebar() {
        const sidebar = document.getElementById('mySidebar');
        const mainContent = document.getElementById('main');
        const toggleIcon = document.getElementById('toggle-icon');

        sidebar.classList.toggle('closed');
        mainContent.classList.toggle('expanded');

        if (window.innerWidth <= 768) {
            sidebar.classList.toggle('open');
        }

        // toggleIcon.classList.toggle('fa-bars');
        // toggleIcon.classList.toggle('fa-times');
    }

</script>
</html>