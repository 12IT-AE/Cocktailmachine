<div class="card mt-3">
    <div class="card-header">
        <h3>{{ $title }}</h3>
        @if($subtitle)
            <sub>{{ $subtitle }}</sub>
        @endif
    </div>
    <div class="card-body">
        {{ $slot }}

        <x-crud-buttons model="recipe" :id="$id" />

    </div>
</div>
