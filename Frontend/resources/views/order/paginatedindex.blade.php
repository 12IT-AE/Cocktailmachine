@extends('layouts.app')

@section('content')
<div class="container">
    <!-- <h1 class="ord er_h" style="font-size: 70px; text-align:center;">DrinkPad</h1> -->
    <div id="recipes-container">
        @include('order.partials.recipes', ['recipes' => $recipes])
    </div>
    <div class="modal fade" id="modal">
        <div class="modal-dialog modal-fullscreen">

        </div>
    </div>
    
</div>
@endsection

@push("scripts")
    <script>
        $(document).ready(function() {
            $(document).on('click', '.page-link', function(event) {
                event.preventDefault();
                var page = $(this).data('page');
                fetchRecipes(page);
            });

            function fetchRecipes(page) {
                $.ajax({
                    url: "/orders?page=" + page,
                    success: function(data) {
                        $('#recipes-container').html(data);
                    },
                    error: function(xhr) {
                        console.error('Error fetching recipes:', xhr);
                    }
                });
            }

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
        });

        // Modal Functions
        function updateAmounts(delta) {
            const modal = document.getElementById('modal');
            if (!modal) return;

            const ingredientElements = Array.from(modal.querySelectorAll('.order_ingredient'));
            const numberIng = ingredientElements.length;

            const fullAmount = getFullAmount(modal);
            const newFullAmount = fullAmount + delta;
            let dif = 0;
            let anz = 0;

            ingredientElements.forEach(ingredient => {
                let currentAmount = parseFloat(ingredient.getAttribute('data-amount'));
                const currentHeight = (100 / fullAmount) * currentAmount;
                if (currentHeight <= 7) {
                    dif += 7 - currentHeight;
                    ingredient.setAttribute("height", 7);
                } else {
                    ingredient.setAttribute("height", currentHeight);
                    anz++;
                }
            });

            const add_dif = anz > 0 ? dif / anz : 0;

            ingredientElements.forEach(ingredient => {
                const currentHeight = parseFloat(ingredient.getAttribute('height'));
                if (currentHeight > 7) {
                    const newHeight = currentHeight - add_dif;
                    ingredient.setAttribute("height", newHeight);
                }
            });

            ingredientElements.forEach(ingredient => {
                let currentAmount = parseFloat(ingredient.getAttribute('data-amount'));
                const height = parseFloat(ingredient.getAttribute('height'));
                const newAmount = Math.max(0, currentAmount + (currentAmount / fullAmount) * delta);
                ingredient.setAttribute('data-amount', newAmount);
                ingredient.querySelector('.order_ingredient_amount').textContent = `${Math.round(newAmount)} ml`;
                ingredient.style.height = `calc(${height}% - 5px)`;
            });

            updateFullAmount(modal);
        }

        function getFullAmount(modal) {
            return Array.from(modal.querySelectorAll('.order_ingredient'))
                .reduce((total, ingredient) => total + parseFloat(ingredient.getAttribute('data-amount')), 0);
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