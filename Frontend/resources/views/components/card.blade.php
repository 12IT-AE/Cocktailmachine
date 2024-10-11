<div class="card mt-3 sm-12" style="padding: 1rem; touch-action: manipulation;">
    <div class="card-header" style="padding: 1rem; font-size: 1.5rem;">
        <h3>{{ $title }}</h3>
        @if($subtitle)
            <sub>{{ $subtitle }}</sub>
        @endif
    </div>
    <div class="card-body" style="padding: 1rem; font-size: 1.2rem;">
        {{ $slot }}
        <x-crud-buttons :id="$id" />
    </div>
</div>
