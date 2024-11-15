<div class="media mb-4 p-3 border rounded shadow-sm">
    <img src="{{ $glass->image }}" class="mr-3 img-thumbnail" alt="{{ $glass->name }}" style="width: 150px; height: auto;">
    <div class="media-body">
        <h5 class="mt-0 font-weight-bold">{{ $glass->name }}</h5>
        <p class="text-muted">Volume: {{ $glass->volume }} ml</p>
    </div>
</div>