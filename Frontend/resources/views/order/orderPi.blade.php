@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="order_h" style="font-size: 70px; text-align:center;">DrinkPad</h1>
    <div class="card-carousel" style="height: 600px; border: solid">
        {{-- <div class="my-card"></div>
        <div class="my-card"></div>
        <div class="my-card"></div>
        <div class="my-card"></div>
        <div class="my-card"></div> --}}
        @foreach($recipes as $recipe)
            <x-order-element :recipe="$recipe" />
        @endforeach
        @foreach($recipes as $recipe)
            <x-order-element :recipe="$recipe" />
        @endforeach
        @foreach($recipes as $recipe)
            <x-order-element :recipe="$recipe" />
        @endforeach
    </div>

    <div class="modal fade" id="modal">
        <div class="modal-dialog modal-fullscreen">

        </div>
    </div>    
    {{-- <br>
    <hr style="width: 100%">
    <div class="card-carousel" style="width: 100%; border: solid">
        <div style="height: 200px; width: 200px" class="my-card"></div>
        <div style="height: 200px; width: 200px" class="my-card"></div>
        <div style="height: 200px; width: 200px" class="my-card"></div>
        <div style="height: 200px; width: 200px" class="my-card"></div>
        <div style="height: 200px; width: 200px" class="my-card"></div>
    </div> --}}



</div>
@endsection


@push("scripts")
    <script>
        // $(function () {
        //     $(document).on('click', '.orderElement', function () {
        //         var recipeId = $(this).data('recipe-id');

        //         $.ajax({
        //             url: `/order/modal/${recipeId}`,
        //             type: 'GET',
        //             success: function (response) {
        //                 $('.modal-dialog').html(response);
        //                 $('#modal').modal('show');

        //             },
        //             error: function (xhr) {
        //                 console.error('Error fetching modal content:', xhr);
        //             }
        //         });

        //     });
        // })



        // Modal Functions
        function updateAmounts(delta) {
            const modal = document.getElementById('modal');
            if (!modal) return; // Exit if the modal is not found

            const ingredientElements = Array.from(modal.querySelectorAll('.order_ingredient'));
            const numberIng = ingredientElements.length;

            const fullAmount = getFullAmount(modal);
            const newFullAmount = fullAmount + delta;
            let dif = 0;
            let anz = 0;

            // Calculate height adjustments and update attributes
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

            // Adjust heights based on the difference calculated
            ingredientElements.forEach(ingredient => {
                const currentHeight = parseFloat(ingredient.getAttribute('height'));
                if (currentHeight > 7) {
                    const newHeight = currentHeight - add_dif;
                    ingredient.setAttribute("height", newHeight);
                }
            });

            // Update amounts and styles
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











        $num = $('.my-card').length;
        $even = $num / 2;
        $odd = ($num + 1) / 2;

        if ($num % 2 == 0) {
        $('.my-card:nth-child(' + $even + ')').addClass('active');
        $('.my-card:nth-child(' + $even + ')').prev().addClass('prev');
        $('.my-card:nth-child(' + $even + ')').next().addClass('next');
        } else {
        $('.my-card:nth-child(' + $odd + ')').addClass('active');
        $('.my-card:nth-child(' + $odd + ')').prev().addClass('prev');
        $('.my-card:nth-child(' + $odd + ')').next().addClass('next');
        }

        $('.my-card').click(function() {
        $slide = $('.active').width();
        console.log($('.active').position().left);
        
        if ($(this).hasClass('next')) {
            $('.card-carousel').stop(false, true).animate({left: '-=' + $slide});
        } else if ($(this).hasClass('prev')) {
            $('.card-carousel').stop(false, true).animate({left: '+=' + $slide});
        }
        
        $(this).removeClass('prev next');
        $(this).siblings().removeClass('prev active next');
        
        $(this).addClass('active');
        $(this).prev().addClass('prev');
        $(this).next().addClass('next');
        });


        // Keyboard nav
        $('html body').keydown(function(e) {
        if (e.keyCode == 37) { // left
            $('.active').prev().trigger('click');
        }
        else if (e.keyCode == 39) { // right
            $('.active').next().trigger('click');
        }
        });

    </script>

    <script src="https://code.jquery.com/jquery-3.3.1.min.js" 
    integrity="sha384-tsQFqpEReu7ZLhBV2VZlAu7zcOV+rXbYlF2cqB8txI/8aZajjp4Bqd+V6D5IgvKT" 
    crossorigin="anonymous">
    </script> 

@endpush