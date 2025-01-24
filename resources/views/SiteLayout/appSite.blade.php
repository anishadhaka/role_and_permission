<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Laravel')</title>

</head>
    
<body>
  
    @include('SiteLayout.header')

    <main>
        @yield('content')
    </main>
    @yield('scripts')
    @include('SiteLayout.footer')

</body>

</html>