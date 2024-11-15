<a href="{{ route('liquid.show', $liquid->id) }}" class="text-decoration-none">
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <div class="liquid-container mb-3">
                <div class="liquid" style="background-color: {{ $liquid->color }};"></div>
            </div>
            <h5 class="card-title">{{ $liquid->name }}</h5>
            <h6 class="card-subtitle mb-2 text-muted">{{ $liquid->alternative_name }}</h6>
            <p class="card-text">{{ $liquid->description }}</p>
        </div>
    </div>
</a>

<style>
.liquid-container {
    position: relative;
    width: 100%;
    height: 150px;
    overflow: hidden;
    border-radius: 10px;
    background: #f0f0f0;
}

.liquid {
    position: absolute;
    bottom: 0;
    width: 100%;
    height: 0;
    background-color: inherit;
    animation: fill 3s forwards;
}

@keyframes fill {
    0% {
        height: 0;
    }
    100% {
        height: 100%;
    }
}

.text-decoration-none {
    text-decoration: none;
    color: inherit;
}
</style>