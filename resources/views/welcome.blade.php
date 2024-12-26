@extends('layouts.app')

@section('title', 'Home Page')

@section('content')
<div class="container d-flex flex-column justify-content-center align-items-center mt-5" style="height: 66vh;">
    <!-- Title -->
    <h1 class="mb-4 text-center">Welcome to the Movie API!</h1>

    @include('components.search-bar')  

    
    <div class="w-100 d-flex justify-content-center mt-3 position-relative">
        <img src="{{ asset('images/pop-corn.jpeg') }}" alt="Movie API" class="img-fluid rounded" style="max-height: 400px; max-width: 100%; object-fit: cover;" />
    </div>
</div>

@endsection

