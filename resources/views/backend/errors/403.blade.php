@extends('layouts.app')

@section('content')
<style>
    .error-container {
    max-width: 600px;
    margin: auto;
    padding: 50px 20px;
    border: 1px solid #ddd;
    background-color: #f9f9f9;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.error-code {
    font-size: 72px;
    font-weight: bold;
    color: #dc3545;
}

.error-title {
    font-size: 36px;
    font-weight: 600;
    color: #333;
}

.error-message {
    font-size: 18px;
    margin-top: 10px;
    color: #666;
}

.btn-primary {
    font-size: 16px;
    padding: 10px 20px;
}

    </style>
<div class="container text-center mt-5">
    <div class="error-container">
    <h1 class="error-code ">@yield('code', '403')</h1>
    <h2 class="error-title">@yield('title', 'Forbidden')</h2>
    <p class="error-message">@yield('message', 'You do not have permission to access this resource.')</p>
    <a href="{{ url('/login') }}" class="btn btn-primary mt-3">Go Home</a>
</div>
</div>
@endsection
