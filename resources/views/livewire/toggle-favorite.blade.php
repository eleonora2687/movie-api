<div>
    <button wire:click="toggleFavorite" class="btn btn-link">
        <i class="bi {{ $isFavorite ? 'bi-heart-fill text-rose' : 'bi-heart' }}"></i>
    </button>
</div>
