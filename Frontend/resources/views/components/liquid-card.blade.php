<a href="{{ route('liquid.show', $liquid->id) }}" class="text-decoration-none">
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <div class="liquid-container mb-3">
                <div class="liquid" style="background-color: {{ $liquid->color }};">
                    <div class="liquid-wave liquid-wave1"></div>
                    <div class="liquid-wave liquid-wave2"></div>
                </div>
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
    height: 100%;
    background-color: inherit;
    overflow: hidden;
    animation: fill 3s forwards;
}

.liquid-wave {
    position: absolute;
    bottom: 0;
    width: 200%;
    height: 200%;
    background: inherit;
    border-radius: 40%;
    opacity: 0.5;
    animation: wave 3s infinite linear;
}

.liquid-wave1 {
    left: -50%;
    animation-delay: 0s;
}

.liquid-wave2 {
    left: -50%;
    animation-delay: 1.5s;
}

@keyframes fill {
    0% {
        height: 0;
    }
    100% {
        height: 100%;
    }
}

@keyframes wave {
    0% {
        transform: translateX(0) translateY(0);
    }
    50% {
        transform: translateX(25%) translateY(-25%);
    }
    100% {
        transform: translateX(50%) translateY(0);
    }
}

.text-decoration-none {
    text-decoration: none;
    color: inherit;
}
</style>