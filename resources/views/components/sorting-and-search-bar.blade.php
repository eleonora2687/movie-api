<div class="d-flex flex-column flex-md-row justify-content-between align-items-start mb-4">
    <!-- Sorting Dropdown -->
    <div class="dropdown w-100 w-md-50 mb-3 mb-md-0 me-md-5 custom-margin">
        <button class="btn dropdown-toggle w-100 text-secondary border" type="button" id="sortDropdown" data-bs-toggle="dropdown" aria-expanded="false">
            @switch($sort ?? 'default') 
                @case('popularity_asc')
                    Rating (Ascending)
                    @break
                @case('popularity_desc')
                    Rating (Descending)
                    @break
                @case('release_date_asc')
                    Release Date (Oldest)
                    @break
                @case('release_date_desc')
                    Release Date (Newest)
                    @break
                @case('title_asc')
                    Title (A-Z)
                    @break
                @case('title_desc')
                    Title (Z-A)
                    @break
                @default
                    Sort By
            @endswitch
        </button>
        <ul class="dropdown-menu" aria-labelledby="sortDropdown">
            @foreach ([ 
                'popularity_desc' => 'Rating (Descending)', 
                'popularity_asc' => 'Rating (Ascending)', 
                'release_date_asc' => 'Release Date (Oldest)', 
                'release_date_desc' => 'Release Date (Newest)', 
                'title_asc' => 'Title (A-Z)', 
                'title_desc' => 'Title (Z-A)' 
            ] as $value => $label)
                <li>
                    <a class="dropdown-item" href="?sort={{ $value }}">{{ $label }}</a>
                </li>
            @endforeach
        </ul>
    </div>

    <!-- Search Bar -->
    <div id="w-search-results" class="w-100 w-md-50 position-relative" >
        <div class="input-group">
            <input type="text" id="item-search" class="form-control" placeholder="Search by Title..." autocomplete="off">
        </div>
        <ul id="search-results" class="list-group mt-2" style="display:none; max-height: 200px; overflow-y: scroll;"></ul>
    </div>
</div>

<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function () {
    let currentIndex = -1; // Track the currently highlighted item
    const $searchInput = $('#item-search');
    const $searchResults = $('#search-results');

    let category = null; // Default to null for "all movies" or "all tv shows"
    let type = null;

    // Dynamically set the type and category based on the current URL
    if (window.location.href.includes('/movies/all-movies')) {
        type = 'movies';
    } else if (window.location.href.includes('/tv-shows/all-tv-shows')) {
        type = 'tv_shows';
    } else if (window.location.href.includes('/movies/popular-movies')) {
        category = 'popular';
        type = 'movies';
    } else if (window.location.href.includes('/movies/upcoming-movies')) {
        category = 'upcoming';
        type = 'movies';
    } else if (window.location.href.includes('/movies/top-rated-movies')) {
        category = 'top_rated';
        type = 'movies';
    } else if (window.location.href.includes('/tv-shows/popular-tv-shows')) {
        category = 'popular';
        type = 'tv_shows';
    } else if (window.location.href.includes('/tv-shows/on-the-air-tv-shows')) {
        category = 'on_the_air';
        type = 'tv_shows';
    } else if (window.location.href.includes('/tv-shows/top-rated-tv-shows')) {
        category = 'top_rated';
        type = 'tv_shows';
    }

    // Check if the query has enough characters to perform a search
    $searchInput.on('input', function () {
        let query = $(this).val(); // Capture the input text
        if (query.length > 1 && ![38, 40, 13].includes(event.keyCode)) {
            $.ajax({
                url: '{{ route('search') }}', 
                data: { query: query, category: category, type: type },
                success: function(data) {
                    $searchResults.empty().show();
                    currentIndex = -1; 

                    if (data.length === 0) {
                        $searchResults.append('<li class="list-group-item">No results found</li>');
                    } else {
                        const uniqueResults = [];
                        const seenIds = new Set();

                        data.forEach(function(item) {
                            if (!seenIds.has(item.id)) {
                                seenIds.add(item.id);
                                uniqueResults.push(item);
                            }
                        });

                        uniqueResults.forEach(function(item) {
                            let itemLink;

                            if (type === 'movies') {
                                itemLink = `/movies/${category ? category.replace('_', '-') : 'all-movies'}/${item.id}`;
                            } else if (type === 'tv_shows') {
                                itemLink = `/tv-shows/${category ? category.replace('_', '-') : 'all-tv-shows'}/${item.id}`;
                            }

                            $searchResults.append(
                                `<li class="list-group-item">
                                    <a href="${itemLink}" class="dropdown-link">${item.title}</a>
                                </li>`
                            );
                        });
                    }
                },
                error: function() {
                    $searchResults.empty().append('<li class="list-group-item">Error fetching results</li>').show();
                }
            });
        } else if (query.length <= 1) {
            $searchResults.hide();
        }
    });

    $searchInput.on('keydown', function (e) {
        const $items = $searchResults.find('li');

        if (e.keyCode === 40) { // Arrow Down
            currentIndex = (currentIndex + 1) % $items.length;
            updateHighlight($items);
        } else if (e.keyCode === 38) { // Arrow Up
            currentIndex = (currentIndex - 1 + $items.length) % $items.length;
            updateHighlight($items);
        } else if (e.keyCode === 13) { // Enter
            if (currentIndex >= 0 && $items.length > 0) {
                const $currentItem = $items.eq(currentIndex).find('a');
                if ($currentItem.length) {
                    window.location.href = $currentItem.attr('href');
                }
            }
        }
    });

    // Hide the search results when clicking outside the search area
    $(document).click(function (event) {
        if (!$(event.target).closest('#search-results').length && !$(event.target).closest('#item-search').length) {
            $searchResults.hide();
        }
    });

    // Function to update the highlighted item
    function updateHighlight($items) {
        $items.removeClass('active');
        if (currentIndex >= 0) {
            const $currentItem = $items.eq(currentIndex);
            $currentItem.addClass('active');

            // Scroll to keep the highlighted item in view
            $searchResults.scrollTop(
                $currentItem.position().top + $searchResults.scrollTop() - $searchResults.height() / 2 + $currentItem.height() / 2
            );

            const $link = $currentItem.find('a');
            $searchInput.val($link.text()); // Update input with the highlighted item's text
        }
    }

    // Update the dropdown button text based on the selected sort option in the URL
    const urlParams = new URLSearchParams(window.location.search);
    const sortParam = urlParams.get('sort');

    const sortLabels = {
        'popularity_desc': 'Rating (Descending)',
        'popularity_asc': 'Rating (Ascending)',
        'release_date_asc': 'Release Date (Oldest)',
        'release_date_desc': 'Release Date (Newest)',
        'title_asc': 'Title (A-Z)',
        'title_desc': 'Title (Z-A)',
    };

    if (sortParam && sortLabels[sortParam]) {
        $('#sortDropdown').text(sortLabels[sortParam]);
    } else {
        $('#sortDropdown').text('Sort By'); // Default text
    }

    // When a sorting option is selected
    $('.dropdown-item').on('click', function() {
        var selectedText = $(this).text();
        $('#sortDropdown').text(selectedText); // Update the button text
    });
});
</script>

<style>
    div#w-search-results ul#search-results .list-group-item.active {
        background-color: rgb(61, 118, 252);
        color: white;
    }

    div#w-search-results ul#search-results .list-group-item.active a {
        color: white;
    }
</style>
