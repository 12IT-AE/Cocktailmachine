<div class="orderElement" data-recipe-id="{{ $recipe->id }}">
    <div class="imageBlock">
        <img class="cooktailImg"
            style=" width: 100%; height: 100%; object-fit: cover; object-position: center; border-radius: 10px"
            src="{{ asset($recipe->image) }}" alt="">
    </div>
    <div class="infoBlock">
        {{$recipe->name}}
    </div>
</div>