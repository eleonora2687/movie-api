<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Movie;
use App\Models\TVShow;

class ToggleFavorite extends Component
{
    public $movieId;
    public $type;
    public $isFavorite;

    public function mount($movieId = null, $type = 'movie')
    {
        $this->movieId = $movieId;
        $this->type = $type;

        if ($this->movieId) {
            $this->initializeFavorite();
        }
    }

    public function initializeFavorite()
    {
        // Initialize favorite based on the type (movie or tvshow)
        if ($this->type === 'movie') {
            $item = Movie::find($this->movieId);
        } else {
            $item = TVShow::find($this->movieId);
        }

        $this->isFavorite = $item ? $item->is_favorite : false;
    }

    public function toggleFavorite()
    {
        // Toggle the favorite status
        if ($this->type === 'movie') {
            $item = Movie::find($this->movieId);
        } else {
            $item = TVShow::find($this->movieId);
        }

        if ($item) {
            $item->is_favorite = !$item->is_favorite;
            $item->save();
        }

        $this->initializeFavorite();
        event('favoriteUpdated');  // Trigger event to update UI
    }

    public function render()
    {
        return view('livewire.toggle-favorite');
    }
}
