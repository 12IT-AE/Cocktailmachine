<a href="{{ route('glass.show', $glass->id) }}" class="text-decoration-none">
    <div class="card mb-4 shadow-sm">
        <img src="{{ asset($glass->image) }}" class="card-img-top" alt="{{ $glass->name }}" style="height: 200px; object-fit: cover;">
        <div class="card-body">
            <h5 class="card-title">{{ $glass->name }}</h5>
            <p class="card-text">Volume: {{ $glass->volume }} ml</p>
        </div>
    </div>
</a>
