

<div class="modal fade" id="modal-{{ $recipe->id }}" aria-labelledby="modalLabel-{{ $recipe->id }}" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen" style="width: 90%; margin: 0 auto;">
        <div class="modal-content" style='background-color: transparent; backdrop-filter: blur(6px);' >


<div class="container mt-5">
    <div class="order-card shadow-sm">
        <div class="card-body">
            <div class="row" >
                <div class="col-md-4" style="display: flex; flex-direction: column;">
                    <div class="order_image_div">
                        <img src="{{ asset($recipe->image) }}" class="" style=" width: 100%; height: 100%; object-fit: cover; object-position: center; border-radius: 15px" alt="{{ $recipe->name }}">
                    </div>
                    {{-- <div class="order_image_div" style="margin-top: 20px;">
                        <img src="{{ asset($recipe->glass->image) }}" class="card-img-top" alt="{{ $recipe->glass->name }}" style=" width: 100%; height: 100%; object-fit: cover; object-position: center; border-radius: 15px;">
                        <h5 class="card-title" style="font-size: 35px;">{{ $recipe->glass->name }} - {{ $recipe->glass->volume }} ml</h5>
                    </div> --}}
                    <div class="order_image_div" style="margin-top: 20px; position: relative; border-radius: 15px; overflow: hidden;">
                        <img src="{{ asset($recipe->glass->image) }}" class="card-img-top" alt="{{ $recipe->glass->name }}" 
                             style="width: 100%; height: 100%; object-fit: cover; object-position: center; border-radius: 15px;">
                        <div class="image-text-overlay" 
                             style="position: absolute; bottom: 0; left: 0; width: 100%; background: rgba(0, 0, 0, 0.5); color: white; text-align: center; padding: 5px; font-size: 20px;">
                            {{ $recipe->glass->name }} - {{ $recipe->glass->volume }} ml
                        </div>
                    </div>                    
                    <div class="order_image_div" style="margin-top: 20px; flex: 1; position: relative; display: inline-block;">
                        <button class="btn btn-lg btn-block" style=" height: 100%; background-color: grey; width: 40%; float: left; margin-right: 5%" data-bs-dismiss="modal">Abbrechen</button>
                        <button class="btn btn-lg btn-block" style=" height: 100%; background-color: green; width: 55%; float: left">Produzieren</button>
                    </div>
                    
                </div>
                <div class="col-md-6">
                    <h1 class="order_h" style="font-size: 65px">{{$recipe->name}}</h1>

                    <h2 class="order_h" style="font-size: 40px">Beschreibung</h2>
                    <p class="card-text">{{ $recipe->description }}</p>
                    
                    <h2 class="order_h" style="font-size: 40px">Garnierungen</h2>
                    <ul class="list-group mb-3">
                        @foreach($recipe->garnishes as $garnish)
                            <li class="list-group-item">{{ $garnish->name }}</li>
                        @endforeach
                    </ul>
                </div>
                <div class="col-md-2" style="border: none">
                        @php
                            $fullAmount = 0;
                            $small = false;
                            $numberIng = 0
                        @endphp

                        @foreach ($recipe->ingredients as $ingredient)
                            @php
                                $fullAmount += $ingredient->amount; // Semikolon hinzugefügt
                                $numberIng++;
                                if ($ingredient->amount < 10) {
                                    $small = true;
                                }
                            @endphp
                        @endforeach
                        <div class="order_ingredients" style="border: none; height: calc(100% + 5px)">
                            @foreach ($recipe->ingredients as $ingredient)
                                @if(!$small && $numberIng <= 5) 
                                    <div class="order_ingredient" style='height:calc({{100 / $fullAmount * $ingredient->amount}}% - 5px); background-color: {{ $ingredient->liquid->color }}; background-color: rgba({{ hexdec(substr($ingredient->liquid->color, 1, 2)) }}, {{ hexdec(substr($ingredient->liquid->color, 3, 2)) }}, {{ hexdec(substr($ingredient->liquid->color, 5, 2)) }}, 0.5);'>
                                        <span class="order_ingredient_name">{{ $ingredient->liquid->name }}</span>
                                        <span class="order_ingredient_amount">{{ $ingredient->amount }} ml</span>
                                    </div>
                                @else 
                                    <div class="order_ingredient" style='height:calc({{100 / $numberIng}}% - 5px); background-color: {{ $ingredient->liquid->color }}; background-color: rgba({{ hexdec(substr($ingredient->liquid->color, 1, 2)) }}, {{ hexdec(substr($ingredient->liquid->color, 3, 2)) }}, {{ hexdec(substr($ingredient->liquid->color, 5, 2)) }}, 0.5);'>
                                        <span class="order_ingredient_name">{{ $ingredient->liquid->name }}</span>
                                        <span class="order_ingredient_amount">{{ $ingredient->amount }} ml</span>
                                    </div>
                                @endif
                                {{-- <div class="order_ingredient" style='height:calc({{100 / $numberIng}}% - 5px); background-color: {{ $ingredient->liquid->color }}; background-color: rgba({{ hexdec(substr($ingredient->liquid->color, 1, 2)) }}, {{ hexdec(substr($ingredient->liquid->color, 3, 2)) }}, {{ hexdec(substr($ingredient->liquid->color, 5, 2)) }}, 0.5);'>
                                    <span class="order_ingredient_name">{{ $ingredient->liquid->name }}</span>
                                    <span class="order_ingredient_amount">{{ $ingredient->amount }} ml</span>
                                </div> --}}
                                {{-- <div class="order_ingredient" style='height:calc({{100 / $fullAmount * $ingredient->amount}}% - 5px); background-color: {{ $ingredient->liquid->color }}; background-color: rgba({{ hexdec(substr($ingredient->liquid->color, 1, 2)) }}, {{ hexdec(substr($ingredient->liquid->color, 3, 2)) }}, {{ hexdec(substr($ingredient->liquid->color, 5, 2)) }}, 0.5);'>
                                    <span class="order_ingredient_name">{{ $ingredient->liquid->name }}</span>
                                    <span class="order_ingredient_amount">{{ $ingredient->amount }} ml</span>
                                </div> --}}
                            @endforeach
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
</div>

<script>
    const recipeId;
    document.getElementById('modal').addEventListener('show.bs.modal', function (event) {
        // Trigger-Element (das die Modalöffnung ausgelöst hat)
        const triggerElement = event.relatedTarget;

        // Rezept-ID auslesen
        recipeId = triggerElement.getAttribute('data-recipe-id');
        alert(recipeId);
    });

    function getID() {
        return recipeId;
    }
</script>