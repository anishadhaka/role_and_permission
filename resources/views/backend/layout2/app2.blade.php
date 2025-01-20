<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Laravel')</title>

</head>
    
<body>
  
    @include('layout2.blogsiteheader')
    @include('layout2.blogsiteheader2')

    <main>
        @yield('content')
    </main>
    @yield('scripts')
    @include('layout2.blogsitefooter')
</body>

</html>