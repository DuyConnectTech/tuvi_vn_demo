<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel - Bootstrap 4 Edition</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    
    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body {
            font-family: 'Nunito', sans-serif;
            background-color: #f8fafc;
        }
        .hero-section {
            background-color: #ffffff;
            border-bottom: 1px solid #e2e8f0;
            padding: 4rem 0;
        }
        .card {
            border: none;
            transition: transform 0.2s;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 1rem 3rem rgba(0,0,0,.175)!important;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand font-weight-bold text-danger" href="#">
                <img src="https://laravel.com/img/logomark.min.svg" width="30" height="30" class="d-inline-block align-top mr-2" alt="Laravel Logo">
                Laravel
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    @if (Route::has('login'))
                        @auth
                            <li class="nav-item">
                                <a href="{{ url('/dashboard') }}" class="nav-link btn btn-sm btn-outline-secondary mx-1">Dashboard</a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a href="{{ route('login') }}" class="nav-link">Log in</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a href="{{ route('register') }}" class="nav-link btn btn-danger text-white ml-2">Register</a>
                                </li>
                            @endif
                        @endauth
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="hero-section text-center">
        <div class="container">
            <h1 class="display-4 font-weight-bold mb-3">Welcome to Laravel</h1>
            <p class="lead text-muted mb-4">The PHP Framework for Web Artisans, now styled with <span class="badge badge-info">Bootstrap 4</span>.</p>
            <div class="d-flex justify-content-center">
                <a href="https://laravel.com/docs" class="btn btn-danger btn-lg mr-3 shadow-sm">Get Started</a>
                <a href="https://github.com/laravel/laravel" class="btn btn-outline-dark btn-lg shadow-sm">GitHub</a>
            </div>
        </div>
    </div>

    <!-- Content Grid -->
    <div class="container py-5">
        <div class="row">
            <!-- Documentation -->
            <div class="col-md-6 mb-4">
                <div class="card h-100 shadow-sm p-3">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-danger text-white rounded-circle p-2 mr-3 d-flex justify-content-center align-items-center" style="width: 48px; height: 48px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-book" viewBox="0 0 16 16">
                                    <path d="M1 2.828c.885-.37 2.154-.769 3.388-.893 1.33-.134 2.458.063 3.112.752v9.746c-.935-.53-2.12-.603-3.213-.493-1.18.12-2.37.461-3.287.811V2.828zm7.5-.141c.654-.689 1.782-.886 3.112-.752 1.234.124 2.503.523 3.388.893v9.923c-.918-.35-2.107-.692-3.287-.81-1.094-.111-2.278-.039-3.213.492V2.687zM8 1.783C7.015.936 5.587.81 4.287.94c-1.514.153-3.042.672-3.994 1.105A.5.5 0 0 0 0 2.5v11a.5.5 0 0 0 .707.455c.882-.4 2.303-.881 3.68-1.02 1.409-.142 2.59.087 3.223.877a.5.5 0 0 0 .78 0c.633-.79 1.814-1.019 3.222-.877 1.378.139 2.8.62 3.681 1.02A.5.5 0 0 0 16 13.5v-11a.5.5 0 0 0-.293-.455c-.952-.433-2.48-.952-3.994-1.105C10.413.809 8.985.936 8 1.783z"/>
                                </svg>
                            </div>
                            <h4 class="card-title mb-0">Documentation</h4>
                        </div>
                        <p class="card-text text-secondary">Laravel has wonderful, thorough documentation covering every aspect of the framework. Whether you are new to the framework or have previous experience with Laravel, we recommend reading all of the documentation from beginning to end.</p>
                        <a href="https://laravel.com/docs" class="font-weight-bold text-danger stretched-link">Read the Docs &rarr;</a>
                    </div>
                </div>
            </div>

            <!-- Laracasts -->
            <div class="col-md-6 mb-4">
                <div class="card h-100 shadow-sm p-3">
                    <div class="card-body">
                         <div class="d-flex align-items-center mb-3">
                            <div class="bg-primary text-white rounded-circle p-2 mr-3 d-flex justify-content-center align-items-center" style="width: 48px; height: 48px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-play-circle" viewBox="0 0 16 16">
                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                    <path d="M6.271 5.055a.5.5 0 0 1 .52.038l3.5 2.5a.5.5 0 0 1 0 .814l-3.5 2.5A.5.5 0 0 1 6 10.5v-5a.5.5 0 0 1 .271-.445z"/>
                                </svg>
                            </div>
                            <h4 class="card-title mb-0">Laracasts</h4>
                        </div>
                        <p class="card-text text-secondary">Laracasts offers thousands of video tutorials on Laravel, PHP, and JavaScript. Check them out, see for yourself, and massively level up your development skills in the process.</p>
                        <a href="https://laracasts.com" class="font-weight-bold text-danger stretched-link">Watch Videos &rarr;</a>
                    </div>
                </div>
            </div>

            <!-- Laravel News -->
             <div class="col-md-6 mb-4">
                <div class="card h-100 shadow-sm p-3">
                    <div class="card-body">
                         <div class="d-flex align-items-center mb-3">
                            <div class="bg-warning text-dark rounded-circle p-2 mr-3 d-flex justify-content-center align-items-center" style="width: 48px; height: 48px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-newspaper" viewBox="0 0 16 16">
                                  <path d="M0 2.5A1.5 1.5 0 0 1 1.5 1h11A1.5 1.5 0 0 1 14 2.5v10.528c0 .3-.05.654-.238.972h.738a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 1 1 0v9a1.5 1.5 0 0 1-1.5 1.5H1.497A1.497 1.497 0 0 1 0 13.5v-11zM12 14c.37 0 .654-.211.853-.441.092-.106.147-.279.147-.531V2.5a.5.5 0 0 0-.5-.5h-11a.5.5 0 0 0-.5.5v11c0 .278.223.5.497.5H12z"/>
                                  <path d="M2 3h10v2H2V3zm0 3h4v3H2V6zm0 4h4v1H2v-1zm0 2h4v1H2v-1zm5-6h2v1H7V6zm3 0h2v1h-2V6zM7 8h2v1H7V8zm3 0h2v1h-2V8zm-3 2h2v1H7v-1zm3 0h2v1h-2v-1zm-3 2h2v1H7v-1zm3 0h2v1h-2v-1z"/>
                                </svg>
                            </div>
                            <h4 class="card-title mb-0">Laravel News</h4>
                        </div>
                        <p class="card-text text-secondary">A community driven portal and newsletter aggregating all the latest and most important news in the Laravel ecosystem.</p>
                        <a href="https://laravel-news.com" class="font-weight-bold text-danger stretched-link">Read News &rarr;</a>
                    </div>
                </div>
            </div>

            <!-- Ecosystem -->
             <div class="col-md-6 mb-4">
                <div class="card h-100 shadow-sm p-3">
                    <div class="card-body">
                         <div class="d-flex align-items-center mb-3">
                            <div class="bg-success text-white rounded-circle p-2 mr-3 d-flex justify-content-center align-items-center" style="width: 48px; height: 48px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-diagram-3" viewBox="0 0 16 16">
                                  <path fill-rule="evenodd" d="M6 3.5A1.5 1.5 0 0 1 7.5 2h1A1.5 1.5 0 0 1 10 3.5v1A1.5 1.5 0 0 1 8.5 6v1H14a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-1 0V8h-5v.5a.5.5 0 0 1-1 0V8h-5v.5a.5.5 0 0 1-1 0v-1A.5.5 0 0 1 2 7h5.5V6A1.5 1.5 0 0 1 6 4.5v-1zM8.5 5a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1zM0 11.5A1.5 1.5 0 0 1 1.5 10h1A1.5 1.5 0 0 1 4 11.5v1A1.5 1.5 0 0 1 2.5 14h-1A1.5 1.5 0 0 1 0 12.5v-1zm1.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1zm4.5.5A1.5 1.5 0 0 1 7.5 10h1a1.5 1.5 0 0 1 1.5 1.5v1A1.5 1.5 0 0 1 8.5 14h-1A1.5 1.5 0 0 1 6 12.5v-1zm1.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1zm4.5.5a1.5 1.5 0 0 1 1.5-1.5h1a1.5 1.5 0 0 1 1.5 1.5v1a1.5 1.5 0 0 1-1.5 1.5h-1a1.5 1.5 0 0 1-1.5-1.5v-1zm1.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1z"/>
                                </svg>
                            </div>
                            <h4 class="card-title mb-0">Ecosystem</h4>
                        </div>
                        <p class="card-text text-secondary">Laravel's robust library of first-party tools and libraries, such as Forge, Vapor, Nova, and Envoyer help you take your projects to the next level.</p>
                        <a href="https://laravel.com" class="font-weight-bold text-danger stretched-link">Explore Ecosystem &rarr;</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-white border-top py-4 mt-auto">
        <div class="container text-center text-muted">
            <small>
                Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
                <span class="mx-2">&bull;</span>
                Running on Bootstrap 4.6.2
            </small>
            <div class="mt-2">
                 <small>Designed with &hearts; by <span class="text-danger">Gemini</span></small>
            </div>
        </div>
    </footer>
</body>
</html>