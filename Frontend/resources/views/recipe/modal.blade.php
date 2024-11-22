

<div class="modal fade" id="modal-xl" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen" style="width: 90%; margin: 0 auto">
        <div class="modal-content">


<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <img src="{{ asset($recipe->image) }}" class="img-fluid rounded mb-3" alt="{{ $recipe->name }}">
                </div>
                <div class="col-md-8">
                    <p class="card-text">{{ $recipe->description }}</p>
                    <h2>Zutaten</h2>
                    <ul class="list-group mb-3">
                        @foreach ($recipe->ingredients as $ingredient)
                        <li class="list-group-item d-flex justify-content-between align-items-center" style="background-color: {{ $ingredient->liquid->color }}; background-color: rgba({{ hexdec(substr($ingredient->liquid->color, 1, 2)) }}, {{ hexdec(substr($ingredient->liquid->color, 3, 2)) }}, {{ hexdec(substr($ingredient->liquid->color, 5, 2)) }}, 0.5);">
                        {{ $ingredient->liquid->name }}
                                <span class="badge badge-primary badge-pill">{{ $ingredient->amount }} ml</span>
                            </li>
                        @endforeach
                    </ul>
                    <h2>Garnierungen</h2>
                    <ul class="list-group mb-3">
                        @foreach($recipe->garnishes as $garnish)
                            <li class="list-group-item">{{ $garnish->name }}</li>
                        @endforeach
                    </ul>
                    <h2>Glass</h2>
                    <x-glass-media :glass="$recipe->glass" />
                </div>
            </div>
        </div>
    </div>
</div>


</div>
</div>
</div>