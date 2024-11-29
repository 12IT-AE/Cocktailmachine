@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="order_h" style="font-size: 70px; text-align:center;">DrinkPad</h1>
    <div style="width: 100%;">
        @foreach($recipes as $recipe)
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
        @endforeach
    </div>
    <div class="modal fade" id="modal">
        <div class="modal-dialog modal-fullscreen">

        </div>
    </div>
</div>
@endsection


@push("scripts")
    <script>
        $(function () {
            $(document).on('click', '.orderElement', function () {
                var recipeId = $(this).data('recipe-id');

                $.ajax({
                    url: `/order/modal/${recipeId}`,
                    type: 'GET',
                    success: function (response) {
                        $('.modal-dialog').html(response);
                        $('#modal').modal('show');

                    },
                    error: function (xhr) {
                        console.error('Error fetching modal content:', xhr);
                    }
                });

            });
        })



        // Modal Functions
        function updateAmounts(delta) {
            const modal = document.getElementById(`modal`);
            if (!modal) return; // Exit if the modal is not found

            const ingredientElements = modal.querySelectorAll('.order_ingredient');
            const numberIng = ingredientElements.length;
            const isSmall = Array.from(ingredientElements).some(ingredient =>
                parseFloat(ingredient.getAttribute('data-amount')) < 10
            );

            const fullAmount = getFullAmount(modal);
            const newFullAmount = getFullAmount(modal) + delta;
            let dif = 0;
            let anz = 0;

            ingredientElements.forEach((ingredient) => {
                let currentAmount = parseFloat(ingredient.getAttribute('data-amount'));
                const currentHeight = (100 / fullAmount) * currentAmount;
                if (currentHeight <= 7) {
                    dif = dif + 7 - currentHeight;
                    ingredient.setAttribute("height", 7);
                } else {
                    ingredient.setAttribute("height", currentHeight);
                    anz++;
                }
            });
            const add_dif = dif / anz;
            ingredientElements.forEach((ingredient) => {
                const currentHeight = parseFloat(ingredient.getAttribute('height'));
                if (currentHeight > 7) {
                    newHeight = currentHeight - add_dif;
                    ingredient.setAttribute("height", newHeight);
                }
            });

            ingredientElements.forEach((ingredient) => {
                const currentAmount = parseFloat(ingredient.getAttribute('data-amount'));
                const height = parseFloat(ingredient.getAttribute('height'));
                const newAmount = Math.max(0, currentAmount + (currentAmount / fullAmount) * delta);
                ingredient.setAttribute('data-amount', newAmount);
                ingredient.querySelector('.order_ingredient_amount').textContent = `${Math.round(newAmount)} ml`;
                ingredient.style.height = `calc(${height}% - 5px)`;
            });
            updateFullAmount(modal);
        }

        function getFullAmount(modal) {
            let total = 0;
            const ingredientElements = modal.querySelectorAll('.order_ingredient');
            ingredientElements.forEach((ingredient) => {
                total += parseFloat(ingredient.getAttribute('data-amount'));
            });
            return total;
        }

        function updateFullAmount(modal) {
            const totalAmountElement = modal.querySelector('.totalAmount');
            if (totalAmountElement) {
                totalAmountElement.textContent = Math.round(getFullAmount(modal));
            }
        }

        function updateTotalPercent(modal, percent) {
            const volumePercentElement = modal.querySelector('.volumePercent');
            if (volumePercentElement) {
                volumePercentElement.textContent = Math.round(percent);
            }
        }
    </script>
@endpush