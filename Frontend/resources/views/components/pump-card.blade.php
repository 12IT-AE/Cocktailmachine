<a href="{{ route('pump.show', $pump->id) }}" class="text-decoration-none">
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <h5 class="card-title">Pumpe: {{ $pump->id }}</h5>
            <h6 class="card-subtitle mb-2">Container: {{ $pump->container->liquid->name }}</h6>
            <p class="card-text">Volume: {{ $pump->container->volume }} ml</p>
            <p class="card-text">Current Volume: {{ $pump->container->current_volume }} ml</p>
            <p class="card-text">Pin: {{ $pump->pin }}</p>
            <p class="card-text">Flowrate: {{ $pump->flowrate }}</p>
        </div>
    </div>
</a>

