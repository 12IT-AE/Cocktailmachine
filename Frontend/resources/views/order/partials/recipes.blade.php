<div style="width: 100%;">
    @foreach($recipes as $recipe)
        <x-order-element :recipe="$recipe" />
    @endforeach
</div>


<div class="pagination justify-content-between">
    <div class="vertical-button left">
        @if ($recipes->previousPageUrl())
            <button class="page-link" data-page="{{ $recipes->currentPage() - 1 }}"><</button>
        @endif
    </div>
    
    <div class="vertical-button right">
        @if ($recipes->nextPageUrl())
            <button class="page-link" data-page="{{ $recipes->currentPage() + 1 }}">></button>

        @endif
    </div>
</div>

