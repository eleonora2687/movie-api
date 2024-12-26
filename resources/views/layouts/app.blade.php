<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Movie API for searching and managing your favorite movies">
    <meta name="keywords" content="movies, API, favorite movies, movie database">
    <meta name="author" content="Your Name">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <title>@yield('title', 'Movie API')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @livewireStyles

</head>
<body>

    <!-- Include the menu -->
    @include('partials.menu')

    <!-- Add a wrapper for content -->
    <div class="content-wrapper">
        <div class="container">
            @yield('content') <!-- Main content -->
        </div>
    </div>

    <!-- Include the footer -->
    @include('partials.footer')

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        @livewireScripts

        <div id="back-to-top" class="back-to-top">
            <i class="arrow-up">&#x2191;</i> 
        </div>
        
    </body>
</html>

<script>
    // Show or hide the back-to-top button based on scroll position
window.addEventListener('scroll', function() {
    const backToTopButton = document.getElementById('back-to-top');
    if (window.scrollY > 300) { // Show button when scrolled 300px
        backToTopButton.classList.add('show');
    } else {
        backToTopButton.classList.remove('show');
    }
});

// Smooth scroll to top when the button is clicked
document.getElementById('back-to-top').addEventListener('click', function() {
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
});
</script>