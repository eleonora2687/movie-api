<div class="card mb-3 shadow-sm w-100 p-3 position-relative" style="min-height: 350px;">
    <div class="row g-3">
        <!-- Movie Poster -->
        <div class="col-md-4 d-flex justify-content-center align-items-center">
            <img src="{{ $poster_url }}" class="img-fluid" alt="{{ $title }}">
        </div>

        <!-- Movie Details -->
        <div class="col-md-8">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <!-- Title and Details -->
                    <div>
                        <h4 class="card-title">{{ $title }}</h4>
                        <p class="card-text">
                            <small class="text-muted">
                                <strong>Release Date:</strong> {{ $release_date }}
                            </small><br>
                            <small class="text-muted">
                                <strong>Categories:</strong> {{ $categories }}
                            </small><br>
                            
                            <!-- Conditionally Display Duration for Movies -->
                            @if($type === 'movie')
                                <small class="text-muted">
                                    <strong>Duration:</strong> {{ $duration }}
                                </small><br>
                            @endif

                            <small class="text-muted">
                                <strong>Rating:</strong> {{ number_format($rating, 1) }}
                            </small>
                            
                        </p>
                    </div>
                    @if($type === 'movie')
                        <livewire:toggle-favorite :movieId="$id" :type="'movie'" />
                    @elseif($type === 'tvshow')
                        <livewire:toggle-favorite :movieId="$id" :type="'tvshow'" />
                    @endif
                </div>

                <!-- Movie Overview -->
                <p class="card-text mt-3 text-muted"><strong>Overview: </strong>{{ $overview }}</p>
                
            </div>
        </div>
    </div>
</div>
