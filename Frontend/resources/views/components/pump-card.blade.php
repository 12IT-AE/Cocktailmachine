<a href="{{ route('pump.show', $pump->id) }}" class="text-decoration-none">
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <h5 class="card-title">Pumpe: (pin) {{ $pump->pin }}</h5>
            <h6 class="card-subtitle mb-2 text-muted">Container: {{ $pump->container->liquid->name }}</h6>
            <p class="card-text">Volume: {{ $pump->container->volume }} ml</p>
            <p class="card-text">Current Volume: {{ $pump->container->current_volume }} ml</p>
            <p class="card-text">DB Id: {{ $pump->id }}</p>
        </div>
    </div>
</a>

