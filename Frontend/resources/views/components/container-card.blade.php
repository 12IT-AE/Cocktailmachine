@php
    $fillPercentage = ($container->current_volume / $container->volume) * 100;
@endphp

<a href="{{ route('container.show', $container->id) }}" class="text-decoration-none">
    <div class="card mb-4 shadow-sm" data-fill-percentage="{{ $fillPercentage }}">
        <div class="card-body">
            <h5 class="card-title">Container - {{ $container->id }}</h5>
            <h6 class="card-subtitle mb-2 text-muted">Flüssigkeit: {{ $container->liquid->name }}</h6>
            <div class="liquid-container mb-3">
            <div class="liquid" style="background-color: {{ $container->liquid->color }};">
                    <span class="percentage">{{ round($fillPercentage) }}%</span>
                </div>
            </div>
            <p class="card-text">Volume: {{ $container->volume }} ml</p>
            <p class="card-text">Current Volume: {{ $container->current_volume }} ml</p>
            <div class='row'>
                <form action="{{ route('container.update', $container->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="volume" id='volume' value="100">
                    <button class='refill-button btn btn-info' data-volume="0">Refill</button>
                    <button class='refill-button btn btn-info' data-volume="500">+0,5l</button>
                    <button class='refill-button btn btn-info' data-volume="700">+0,7l</button>
                    <button class='refill-button btn btn-info' data-volume="1000">+1l</button>
                    <button type="submit" id='submit-refill' class="d-none">Refill Container</button>
                </form>
            </div>
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
    border: 2px solid #ccc; /* Add border */
    background: transparent; /* Make background transparent */
    display: flex;
    align-items: flex-end;
}

.liquid {
    position: relative;
    width: 100%;
    bottom: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    color: white;
    font-weight: bold;
    height: 0; /* Initial height */
    transition: height 3s; /* Smooth transition */
}

.percentage {
    position: absolute;
    bottom: 10px;
    text-shadow: 
        -1px -1px 0 #000,  
        1px -1px 0 #000,
        -1px 1px 0 #000,
        1px 1px 0 #000; /* Small black border effect around the text */
}
.text-decoration-none {
    text-decoration: none;
    color: inherit;
}
</style>

@pushOnce("scripts")
<script>
$(document).ready(function() {
    $('.card').each(function() {
        var fillPercentage = $(this).data('fill-percentage');
        $(this).find('.liquid').css('height', fillPercentage + '%');
    });

    $(document).on('click', '.refill-button', function () {
        let volume = $(this).data('volume');
        $('#volume').val(volume);
        $('#submit-refill').trigger('click');
    })
});
</script>
@endpushOnce