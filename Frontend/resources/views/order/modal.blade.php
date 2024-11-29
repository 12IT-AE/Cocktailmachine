
    <div class="modal-content" >
                <div class="container mt-5">
                    <div class="order-card shadow-sm">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-3 d-flex flex-column">
                                    <div class="order_image_div">
                                        <img onload="updateAmounts({{ $recipe->id }}, 0)"
                                            src="{{ asset($recipe->image) }}" class=""
                                            style=" width: 100%; height: 100%; object-fit: cover; object-position: center; border-radius: 15px"
                                            alt="{{ $recipe->name }}">
                                    </div>
                                    @php
                                        $fullAmount = $recipe->ingredients->sum('amount');
                                        $small = $recipe->ingredients->contains(function ($ingredient) {
                                            return $ingredient->amount < 10;
                                        });
                                        $numberIng = $recipe->ingredients->count();
                                        $alcoholMl = 0;
                                        foreach ($recipe->ingredients as $ingredient) {
                                            $alcoholMl =
                                                $alcoholMl +
                                                ($ingredient->amount / 100) * $ingredient->liquid->volume_percent;
                                        }
                                    @endphp
                                    <div class="order_image_div"
                                        style="margin-top: 20px; position: relative; border-radius: 15px; overflow: hidden;">
                                        <img src="{{ asset($recipe->glass->image) }}" class="card-img-top"
                                            alt="{{ $recipe->glass->name }}"
                                            style="width: 100%; height: 100%; object-fit: cover; object-position: center; border-radius: 15px;">
                                        <div class="image-text-overlay"
                                            style="position: absolute; bottom: 0; left: 0; width: 100%; background: rgba(0, 0, 0, 0.5); color: white; text-align: center; padding: 5px; font-size: 20px;">
                                            {{ $recipe->glass->name }} - {{ $recipe->glass->volume }} ml
                                        </div>
                                    </div>
                                    <div class="order_image_div"
                                        style="margin-top: 20px; flex: 1; position: relative; display: inline-block;">
                                        <!-- Button für -1 -->
                                        <div style="width: 30%; float: left;">
                                            <button type="submit" class="btn btn-lg btn-block"
                                                style="height: 100%; background-color: grey; width: 100%; border-radius: 15px;">-1</button>
                                        </div>

                                        <!-- Aktueller Wert -->
                                        <div class="order_h"
                                            style="width: 40%; float:left; text-align: center; font-size: 33px">
                                            <strong class="volumePercent">*11</strong> %
                                        </div>

                                        <!-- Button für +1 -->
                                        <div style="width: 30%; float: left;">
                                            <button class="btn btn-lg btn-block"
                                                style="height: 100%; background-color: grey; width: 100%; border-radius: 15px;">+1</button>
                                        </div>
                                    </div>

                                    <div class="order_image_div"
                                        style="margin-top: 20px; flex: 1; position: relative; display: inline-block;">
                                        <button class="btn btn-lg btn-block"
                                            style=" height: 100%; background-color: grey; width: 30%; float: left; border-radius: 15px;"
                                            onclick="updateAmounts(-10)">-10</button>
                                        <div class="order_h"
                                            style="width: 40%; float:left; text-align: center; font-size: 33px"><strong
                                                class="totalAmount">{{ $fullAmount }}</strong> ml</div>
                                        <button class="btn btn-lg btn-block"
                                            style=" height: 100%; background-color: grey; width: 30%; float: right; border-radius: 15px;"
                                            onclick="updateAmounts(+10)">+10</button>
                                    </div>
                                </div>
                                <div class="col-6 d-flex flex-column">
                                    <h1 class="order_h" style="font-size: 65px">{{ $recipe->name }}</h1>

                                    <h2 class="order_h" style="font-size: 40px">Beschreibung</h2>
                                    <p class="card-text">{{ $recipe->description }}</p>

                                    <h2 class="order_h" style="font-size: 40px">Garnierungen</h2>
                                    <ul class="list-group mb-3">
                                        @foreach ($recipe->garnishes as $garnish)
                                            <li class="list-group-item">{{ $garnish->name }}</li>
                                        @endforeach
                                    </ul>

                                    <div class="order_image_div mt-auto"
                                        style="height: 50px; display: flex; align-items: center;">
                                        <button class="btn btn-lg btn-block"
                                            style="height: 100%; background-color: grey; width: 47.5%; margin-right: 5%; border-radius: 15px;"
                                            data-bs-dismiss="modal">Abbrechen</button>
                                        <button class="btn btn-lg btn-block"
                                            style="height: 100%; background-color: green; width: 47.5%; border-radius: 15px;">Produzieren</button>
                                    </div>
                                </div>
                                <div class="col-3" style="border: none;">
                                    <div class="order_ingredients" style="border: none; height: calc(100% + 5px);">
                                        @foreach ($recipe->ingredients as $ingredient)
                                            @if (!$small && $numberIng <= 5)
                                                <div class="order_ingredient" data-id="{{ $ingredient->id }}"
                                                    data-amount="{{ $ingredient->amount }}" style="background-color: rgba({{ hexdec(substr($ingredient->liquid->color, 1, 2)) }}, 
                                                                              {{ hexdec(substr($ingredient->liquid->color, 3, 2)) }}, 
                                                                              {{ hexdec(substr($ingredient->liquid->color, 5, 2)) }}, 
                                                                              0.5);">
                                                    <span class="order_ingredient_name">{{ $ingredient->liquid->name }}</span>
                                                    <span class="order_ingredient_amount">{{ $ingredient->amount }}
                                                        ml</span>
                                                </div>
                                            @else
                                                <div class="order_ingredient" data-id="{{ $ingredient->id }}"
                                                    data-amount="{{ $ingredient->amount }}" style="background-color: rgba({{ hexdec(substr($ingredient->liquid->color, 1, 2)) }}, 
                                                                              {{ hexdec(substr($ingredient->liquid->color, 3, 2)) }}, 
                                                                              {{ hexdec(substr($ingredient->liquid->color, 5, 2)) }}, 
                                                                              0.5);">
                                                    <span class="order_ingredient_name">{{ $ingredient->liquid->name }}</span>
                                                    <span class="order_ingredient_amount">{{ $ingredient->amount }}
                                                        ml</span>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>