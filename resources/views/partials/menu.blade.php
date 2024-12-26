<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <!-- Home Link -->
    <a class="navbar-brand" href="{{ route('home') }}">Home</a> 

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav">

        <!-- Movies Dropdown -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Movies
          </a>
          <ul class="dropdown-menu">
            <!-- All Movies Link -->
            <li><a class="dropdown-item" href="{{ route('all-movies') }}">All Movies</a></li>
            <!-- Popular Movies Link -->
            <li><a class="dropdown-item" href="{{ route('popular-movies') }}">Popular</a></li> 
            <li><a class="dropdown-item" href="{{ route('upcoming-movies') }}">Upcoming</a></li>
            <li><a class="dropdown-item" href="{{ route('top-rated-movies') }}">Top Rated</a></li>
          </ul>
        </li>

        <!-- TV Shows Dropdown -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            TV Shows
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="{{ route('all-tv-shows') }}">All TV Shows</a></li>

            <li><a class="dropdown-item" href="{{ route('popular-tv-shows') }}">Popular</a></li>
            <li><a class="dropdown-item" href="{{ route('on-the-air-tv-shows') }}">On TV</a></li>
            <li><a class="dropdown-item" href="{{ route('top-rated-tv-shows') }}">Top Rated</a></li>
          </ul>
        </li>

        <!-- Favorites Link -->
        <li class="nav-item">
          <a class="nav-link" href="{{ route('favorites.all-favorite') }}">Favorites</a> 
        </li>
        
      </ul>
    </div>
  </div>
</nav>
