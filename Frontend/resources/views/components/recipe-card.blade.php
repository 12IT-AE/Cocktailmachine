<a href="{{ route('recipe.show', $recipe->id) }}" class="text-decoration-none">
    <div class="card mb-4 shadow-sm">
        <img src="{{ asset($recipe->image) }}" class="card-img-top" alt="{{ $recipe->name }}">
        <div class="card-body">
            <h5 class="card-title">{{ $recipe->name }}</h5>
            <p class="card-text">{{ $recipe->description }}</p>
            <p class="card-text"><small class="text-muted">Glass: {{ $recipe->glass->name }}</small></p>
            <p class="card-text"><small class="text-muted">Ice: {{ $recipe->ice ? 'Yes' : 'No' }}</small></p>
            <p class="card-text">Ingredients:</p>
            <ul>
                @foreach($recipe->ingredients as $ingredient)
                    <li>{{ $ingredient->liquid->name }} - {{ $ingredient->amount }} ml</li>
                @endforeach
                <li>{{ $ingredient->liquid->volume_percent }} - {{ $ingredient->amount }} ml</li>
            </ul>
        </div>
    </div>
</a>

<style>
.card-img-top {
    max-height: 200px;
    object-fit: cover;
}
</style>