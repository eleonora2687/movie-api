<div id="w-search-results" class="w-75 w-md-50 position-relative">
    <div class="input-group">
        <input type="text" id="item-search" class="form-control" placeholder="Search Movies and TV Shows by Title..." autocomplete="off">
    </div>
    <ul id="search-results" class="list-group" style="display:none; max-height: 200px; overflow-y: auto; position: absolute; top: 100%; z-index: 1050; width: 100%;"></ul>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        let currentIndex = -1; // Track the currently highlighted item
        const $searchInput = $('#item-search');
        const $searchResults = $('#search-results');

        // Handle keyup for search input
        $searchInput.on('keyup', function (e) {
            let query = $(this).val();
            let type = 'all';

            if (query.length > 1 && ![38, 40, 13].includes(e.keyCode)) { 
                $.ajax({
                    url: '{{ route('search') }}',
                    data: { query: query, type: type },
                    success: function (data) {
                        $searchResults.empty().show();
                        currentIndex = -1; 

                        if (data.length === 0) {
                            $searchResults.append('<li class="list-group-item">No results found</li>');
                        } else {
                            const uniqueResults = [];
                            const seenIds = new Set();

                            data.forEach(function (item) {
                                if (!seenIds.has(item.id)) {
                                    seenIds.add(item.id);
                                    uniqueResults.push(item);
                                }
                            });

                            uniqueResults.forEach(function (item) {
                                let itemLink;
                                if (item.type === 'movies') {
                                    itemLink = `/movies/all-movies/${item.id}`;
                                } else if (item.type === 't_v_shows') {
                                    itemLink = `/tv-shows/all-tv-shows/${item.id}`;
                                }

                                $searchResults.append(
                                    `<li class="list-group-item">
                                        <a href="${itemLink}" class="dropdown-link">${item.title}</a>
                                    </li>`
                                );
                            });
                        }
                    },
                    error: function () {
                        $searchResults.empty().append('<li class="list-group-item">Error fetching results</li>').show();
                    }
                });
            } else if (query.length <= 1) {
                $searchResults.hide();
            }
        });

        // Keyboard navigation
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

        // Hide results when clicking outside
        $(document).click(function (event) {
            if (!$(event.target).closest('#search-results').length && !$(event.target).closest('#item-search').length) {
                $searchResults.hide();
            }
        });

        // Highlight function
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
