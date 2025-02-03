@extends('frontend.SiteLayout.appSite')

@section('content')
<link rel="stylesheet" href="{{ asset('css/contactus.css') }}">

<!-- <header>
  <div class="logo">
    <h1>Watch My Review</h1>
  </div>
  <nav>
    <ul>
      <li><a href="/">Home</a></li>
      <li><a href="/about">About</a></li>
      <li><a href="{{ url('contact-us') }}">Contact Us</a></li>
    </ul>
  </nav>
</header> -->

<section class="contact">
    <div class="contact-info">
        <h2>Contact Information</h2>
        <p>If you have any questions, feel free to reach out to us through the form below.</p>
        <ul>
            <li><strong>Email:</strong> support@watchmyreview.com</li>
            <li><strong>Phone:</strong> +123 456 789</li>
            <li><strong>Address:</strong> 123 Review Street, Suite 101, New York, NY</li>
        </ul>
    </div>

    <div class="contact-form">
        <h2>Get in Touch</h2>
        @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <form method="post" action="">
            @csrf
            <div class="input-group">
                <label for="name">Your Name</label>
                <input type="text" id="name" name="name" placeholder="Enter your name" value="{{ old('name') }}"
                    required>
                @error('name')<div class="error">{{ $message }}</div>@enderror
            </div>

            <div class="input-group">
                <label for="email">Your Email</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" value="{{ old('email') }}"
                    required>
                @error('email')<div class="error">{{ $message }}</div>@enderror
            </div>

            <div class="input-group">
                <label for="message">Your Message</label>
                <textarea id="message" name="message" placeholder="Write your message here"
                    required>{{ old('message') }}</textarea>
                @error('message')<div class="error">{{ $message }}</div>@enderror
            </div>

            <button type="submit" class="submit-btn">Send Message</button>
        </form>
    </div>
</section>

<section class="map">
    <h2>Find Us</h2>
    <div id="map">

        <p>Map integration goes here.</p>
    </div>
</section>
@endsection