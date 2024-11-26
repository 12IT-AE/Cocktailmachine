<div class="modal fade" id="modal-{{ $recipe->id }}" aria-labelledby="modalLabel-{{ $recipe->id }}" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen" style="width: 90%; margin: 0 auto;">
        <div class="modal-content" style='background-color: transparent; backdrop-filter: blur(6px);'>


            <div class="container mt-5">
                <div class="order-card shadow-sm">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4" style="display: flex; flex-direction: column;">
                                <div class="order_image_div">
                                    <img onload="updateAmounts({{ $recipe->id }}, 0)" src="{{ asset($recipe->image) }}" class=""
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
                                <div class="order_image_div" style="margin-top: 20px; flex: 1; position: relative; display: inline-block;">
                                    <button class="btn btn-lg btn-block" style=" height: 100%; background-color: grey; width: 30%; float: left; border-radius: 15px;" onclick="updateAmounts({{ $recipe->id }}, -10)">-10</button>
                                    <div class="order_h" style="width: 40%; float:left; text-align: center; font-size: 33px"><strong class="totalAmount">{{ $fullAmount }}</strong> ml</div>
                                    <button class="btn btn-lg btn-block" style=" height: 100%; background-color: grey; width: 30%; float: right; border-radius: 15px;" onclick="updateAmounts({{ $recipe->id }}, +10)">+10</button>
                                </div>
                            </div>
                            <div class="col-md-5 d-flex flex-column">
                                <h1 class="order_h" style="font-size: 65px">{{ $recipe->name }}</h1>
                            
                                <h2 class="order_h" style="font-size: 40px">Beschreibung</h2>
                                <p class="card-text">{{ $recipe->description }}</p>
                            
                                <h2 class="order_h" style="font-size: 40px">Garnierungen</h2>
                                <ul class="list-group mb-3">
                                    @foreach ($recipe->garnishes as $garnish)
                                        <li class="list-group-item">{{ $garnish->name }}</li>
                                    @endforeach
                                </ul>
                            
                                <!-- Div at the bottom -->
                                <div class="order_image_div mt-auto" style="height: 50px; display: flex; align-items: center;">
                                    <button class="btn btn-lg btn-block"
                                        style="height: 100%; background-color: grey; width: 40%; margin-right: 5%; border-radius: 15px;"
                                        data-bs-dismiss="modal">Abbrechen</button>
                                    <button class="btn btn-lg btn-block"
                                        style="height: 100%; background-color: green; width: 55%; border-radius: 15px;">Produzieren</button>
                                </div>
                            </div>

                            
                            {{-- height:calc({{ (100 / $fullAmount) * $ingredient->amount }}% - 15px); --}}
                            <div class="col-md-3" style="border: none;">
                                <div class="order_ingredients" style="border: none; height: calc(100% + 15px);">
                                    @foreach ($recipe->ingredients as $ingredient)
                                        @if (!$small && $numberIng <= 5)
                                            <div class="order_ingredient" data-id="{{ $ingredient->id }}"
                                                data-amount="{{ $ingredient->amount }}"
                                                style="background-color: rgba({{ hexdec(substr($ingredient->liquid->color, 1, 2)) }}, 
                                                                      {{ hexdec(substr($ingredient->liquid->color, 3, 2)) }}, 
                                                                      {{ hexdec(substr($ingredient->liquid->color, 5, 2)) }}, 
                                                                      0.5);">
                                                <span
                                                    class="order_ingredient_name">{{ $ingredient->liquid->name }}</span>
                                                <span class="order_ingredient_amount">{{ $ingredient->amount }}
                                                    ml</span>
                                            </div>
                                        @else
                                            <div class="order_ingredient" data-id="{{ $ingredient->id }}"
                                                data-amount="{{ $ingredient->amount }}"
                                                style="background-color: rgba({{ hexdec(substr($ingredient->liquid->color, 1, 2)) }}, 
                                                                      {{ hexdec(substr($ingredient->liquid->color, 3, 2)) }}, 
                                                                      {{ hexdec(substr($ingredient->liquid->color, 5, 2)) }}, 
                                                                      0.5);">
                                                <span
                                                    class="order_ingredient_name">{{ $ingredient->liquid->name }}</span>
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
    </div>
</div>


<script>
    function test() {
        alert();
    }

    function updateAmounts(recipeId, delta) {
        // Select the specific modal container by ID
        const modal = document.getElementById(`modal-${recipeId}`);
        if (!modal) return; // Exit if the modal is not found

        // Get all ingredients within the modal
        const ingredientElements = modal.querySelectorAll('.order_ingredient');

        // Get the number of ingredients and check if there's a "small" amount
        const numberIng = ingredientElements.length;
        console.log("numberIng", numberIng);
        const isSmall = Array.from(ingredientElements).some(ingredient =>
            parseFloat(ingredient.getAttribute('data-amount')) < 10
        );

        // Calculate the current fullAmount dynamically within the modal
        const fullAmount = getFullAmount(modal);
        const newFullAmount = getFullAmount(modal) + delta;


        // height:calc({{ (100 / $fullAmount) * $ingredient->amount }}% - 15px);


        let dif = 0;
        let anz = 0;
        ingredientElements.forEach((ingredient) => {
            let currentAmount = parseFloat(ingredient.getAttribute('data-amount'));
            console.log("currentAmount: ", currentAmount);
            const currentHeight = (100 / fullAmount) * currentAmount;
            console.log("currentHeight: ", currentHeight);
            if(currentHeight <= 7) {
                dif = dif + 7 - currentHeight;
                console.log("dif", dif);
                ingredient.setAttribute("height", 7);
            }
            else {
                ingredient.setAttribute("height", currentHeight);
                anz++;
            }
        });

        console.log("dif: ", dif);
        console.log("anz: ", anz);
        const add_dif = dif / anz;
        console.log("add_dif", add_dif);

        ingredientElements.forEach((ingredient) => {
            const currentHeight = parseFloat(ingredient.getAttribute('height'));
            console.log("Name: ", ingredient.getAttribute('data-name'));
            console.log("currentHeight2: ", currentHeight);
            if(currentHeight > 7) {
                newHeight = currentHeight - add_dif;
                console.log("newHeight2: ", newHeight);
                ingredient.setAttribute("height", newHeight);
            }
        });

        ingredientElements.forEach((ingredient) => {
            const currentAmount = parseFloat(ingredient.getAttribute('data-amount'));
            const height = parseFloat(ingredient.getAttribute('height'));

            // Calculate the new amount proportionally
            const newAmount = Math.max(0, currentAmount + (currentAmount / fullAmount) * delta);
            console.log("newAmount", newAmount);

            // Update the data attribute and the displayed amount
            ingredient.setAttribute('data-amount', newAmount);
            ingredient.querySelector('.order_ingredient_amount').textContent = `${Math.round(newAmount)} ml`;

            ingredient.style.height = `calc(${height}% - 15px)`;
        });


        // ingredientElements.forEach((ingredient) => {
        //     const currentAmount = parseFloat(ingredient.getAttribute('data-amount'));

        //     // Calculate the new amount proportionally
        //     const newAmount = Math.max(0, currentAmount + (currentAmount / fullAmount) * delta);

        //     // Update the data attribute and the displayed amount
        //     ingredient.setAttribute('data-amount', newAmount);
        //     ingredient.querySelector('.order_ingredient_amount').textContent = `${Math.round(newAmount)} ml`;

        //     // Adjust height dynamically based on the conditions
        //     if (!isSmall && numberIng <= 7) {
        //         console.log(newFullAmount + " " + newAmount)
        //         ingredient.style.height = `calc(${(100 / newFullAmount) * newAmount}% - 15px)`;
        //     } else {
        //         ingredient.style.height = `calc(${100 / numberIng}% - 15px)`;
        //     }
        // });

        updateFullAmount(modal);
    }

    function getFullAmount(modal) {
        // Dynamically calculate the total amount within the modal
        let total = 0;
        const ingredientElements = modal.querySelectorAll('.order_ingredient');
        ingredientElements.forEach((ingredient) => {
            total += parseFloat(ingredient.getAttribute('data-amount'));
        });
        return total;
    }

    function updateFullAmount(modal) {
        // Update the displayed total amount within the modal
        const totalAmountElement = modal.querySelector('.totalAmount');
        if (totalAmountElement) {
            totalAmountElement.textContent = Math.round(getFullAmount(modal));
        }
    }
</script>
