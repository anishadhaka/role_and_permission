<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/sidebar.css') }}">

</head>
<body>
    <div id="app">
    
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    User Roles and Permissions Tutorial
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
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

        <div class="main-container">
        @auth
            <aside class="sidebar">
                <ul>
                <h4> 
                <!-- <i class="fa-solid fa-plane-departure"></i> -->
                <img src="https://www.absglobaltravel.com/public/images/footer-abs-logo.webp" height="60" >
             </h4>
                    <li><a href="{{ route('home') }}"><i class="fa-solid fa-bars"></i> Dashboard</a></li>
                  
                    @if(auth()->user()->hasRole(['user team','Admin']))
                    <li><a href="{{ route('users.index') }}"><i class="fa-solid fa-user-tie"></i> Manage Users</a></li>
                    <!-- <li><a href="{{ route('roles.index') }}"><i class="fa-brands fa-elementor"></i> Manage Roles</a></li> -->
                    @endrole

                    @if(auth()->user()->hasRole(['user team','Admin']))
                    <li>
                       <a href="#" class="dropdown-toggle sidebar-link" id="blogDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                       <i class="fa-solid fa-gear"></i> Setting  </i>
                       </a>
                       <ul class="dropdown-menu sidebar-dropdown" aria-labelledby="blogDropdown">
                           <li><a class="dropdown-item sidebar-dropdown-item" href="{{ route('products.index') }}"><i class="fa-brands fa-product-hunt"></i> Manage Products</a></li>
                           <li><a class="dropdown-item sidebar-dropdown-item" href="{{ route('roles.index') }}"><i class="fa fa-layer-group"></i> Manage Roles</a></li>
                       </ul>
                   </li>
                    @endrole

                    @if(auth()->user()->hasRole(['product team','Admin']))
                    <!-- <li><a href="{{ route('products.index') }}"> <i class="fa-brands fa-square-pinterest"></i> Manage Products</a></li> -->
                    @endrole
                    @if(auth()->user()->hasRole(['blog team','Admin']))
                    <li><a href="{{ route('module.index') }}"> <i class="fa-solid fa-hexagon-nodes"></i> Module </a></li>
<!-- 
                    <li><a href="{{ route('blog.index') }}"> <i class="fa-brands fa-blogger-b"></i> Blog</a></li>
                    <li><a href="{{ route('blogCategory.index') }}"> <i class="fa-solid fa-layer-group"></i> Blog Category</a></li> -->
                    @endrole
                    
                    @if(auth()->user()->hasRole(['blog team','Admin']))
                   <li>
                       <a href="#" class="dropdown-toggle sidebar-link" id="blogDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                           <i class="fa-brands fa-blogger-b"></i> Blog Management </i>
                       </a>
                       <ul class="dropdown-menu sidebar-dropdown" aria-labelledby="blogDropdown">
                           <li><a class="dropdown-item sidebar-dropdown-item" href="{{ route('blog.index') }}"><i class="fa fa-blog"></i> Blog</a></li>
                           <li><a class="dropdown-item sidebar-dropdown-item" href="{{ route('blogCategory.index') }}"><i class="fa fa-layer-group"></i> Blog Category</a></li>
                       </ul>
                   </li>
                   @endif
                    @if(auth()->user()->hasRole(['news team','Admin']))
                    <li>
                       <a href="#" class="dropdown-toggle sidebar-link" id="blogDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                           <i class="fa-brands fa-blogger-b"></i> News Management </i>
                       </a>
                       <ul class="dropdown-menu sidebar-dropdown" aria-labelledby="blogDropdown">
                           <li><a class="dropdown-item sidebar-dropdown-item" href="{{ route('news.index') }}"><i class="fa fa-blog"></i> News</a></li>
                           <li><a class="dropdown-item sidebar-dropdown-item" href="{{ route('news.index') }}"><i class="fa fa-layer-group"></i> News Category</a></li>
                       </ul>
                   </li>
                    @endrole
                    @if(auth()->user()->hasRole(['page team','Admin']))
                    <li><a href="{{ route('pages.index') }}"> <i class="fa-solid fa-layer-group"></i> Pages </a></li>
                    
                    @endrole

                </ul>
            </aside>
       @endauth
            <main class="content">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-12">
                            <div class="card p-3 m-4">
                                <div class="card-body">
                                    @yield('content')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>
</html>