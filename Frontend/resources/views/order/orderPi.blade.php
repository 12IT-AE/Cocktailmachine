@extends('layouts.app')

<section>
    <h1 class="order_h" style="font-size: 70px; text-align:center;">DrinkPad</h1>
    <div id="cCarousel">
      <div class="arrow" id="prev"><i class="fa-solid fa-chevron-left"><</i></div>
      <div class="arrow" id="next"><i class="fa-solid fa-chevron-right">></i></div>
  
      <div id="carousel-vp">
        <div id="cCarousel-inner">
            @foreach($recipes as $recipe)
                {{-- <article class="cCarousel-item">
                    <div class="orderElement my-card" data-recipe-id="{{ $recipe->id }}">
                        <div class="imageBlock">
                            <img class="cooktailImg"
                                style=" width: 100%; height: 100%; object-fit: cover; object-position: center; border-radius: 10px"
                                src="{{ asset($recipe->image) }}" alt="">
                        </div>
                        <div class="infoBlock">
                            {{$recipe->name}}
                        </div>
                    </div>
                </article> --}}
                <article class="cCarousel-item">
                    <div style="width: 340px" class="orderElement" data-recipe-id="{{ $recipe->id }}">
                        <div class="imageBlock">
                            <img class="cooktailImg"
                                style=" width: 100%; height: 100%; object-fit: cover; object-position: center; border-radius: 10px"
                                src="{{ asset($recipe->image) }}" alt="">
                        </div>
                        <div class="infoBlock">
                            {{$recipe->name}}
                        </div>
                    </div>
                </article>
            @endforeach
  
        </div>
      </div>
    </div>
</section>
  
  <style>
          *,
      ::before,
      ::after {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      }
  
      body {
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      justify-content: center;
      background: #222;
      }
  
      #cCarousel {
      position: relative;
      max-width: 1200px;
      margin: auto;
      }
  
      #cCarousel .arrow {
      position: absolute;
      top: 50%;
      display: flex;
      width: 45px;
      height: 45px;
      justify-content: center;
      align-items: center;
      border-radius: 50%;
      z-index: 1;
      font-size: 26px;
      color: white;
      background: #00000072;
      cursor: pointer;
      }
  
      #cCarousel #prev {
      left: 0px;
      }
  
      #cCarousel #next {
      right: 0px;
      }
  
      #carousel-vp {
      width: 1080px;
      height: 450px;
      display: flex;
      align-items: center;
      position: relative;
      overflow: hidden;
      margin: auto;
      }
  
      @media (max-width: 770px) {
      #carousel-vp {
          width: 510px;
      }
      }
  
      @media (max-width: 510px) {
      #carousel-vp {
          width: 250px;
      }
      }
  
      #cCarousel #cCarousel-inner {
      display: flex;
      position: absolute;
      transition: 0.3s ease-in-out;
      gap: 10px;
      left: 0px;
      }
  
      .cCarousel-item {
      width: 350px;
      height: 400px;
      border-radius: 15px;
      overflow: hidden;
      display: flex;
      flex-direction: column;
      }
  
      .cCarousel-item img {
      width: 100%;
      object-fit: cover;
      min-height: 246px;
      color: white;
      }
  
      .cCarousel-item .infos {
      height: 100%;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: space-around;
      background: white;
      color: black;
      }
  
      .cCarousel-item .infos button {
      background: #222;
      padding: 10px 30px;
      border-radius: 15px;
      color: white;
      font-size: 1rem;
      font-weight: bold;
      cursor: pointer;
      }
  
  
  
  </style>

  <script>
    const prev = document.querySelector("#prev");
const next = document.querySelector("#next");

let carouselVp = document.querySelector("#carousel-vp");

let cCarouselInner = document.querySelector("#cCarousel-inner");
let carouselInnerWidth = cCarouselInner.getBoundingClientRect().width;

let leftValue = 0;

// Variable used to set the carousel movement value (card's width + gap)
const totalMovementSize =
  parseFloat(
    document.querySelector(".cCarousel-item").getBoundingClientRect().width,
    10
  ) +
  parseFloat(
    window.getComputedStyle(cCarouselInner).getPropertyValue("gap"),
    10
  );

prev.addEventListener("click", () => {
  if (!leftValue == 0) {
    leftValue -= -totalMovementSize;
    cCarouselInner.style.left = leftValue + "px";
  }
});

next.addEventListener("click", () => {
  const carouselVpWidth = carouselVp.getBoundingClientRect().width;
  if (carouselInnerWidth - Math.abs(leftValue) > carouselVpWidth) {
    leftValue -= totalMovementSize;
    cCarouselInner.style.left = leftValue + "px";
  }
});

const mediaQuery510 = window.matchMedia("(max-width: 510px)");
const mediaQuery770 = window.matchMedia("(max-width: 770px)");

mediaQuery510.addEventListener("change", mediaManagement);
mediaQuery770.addEventListener("change", mediaManagement);

let oldViewportWidth = window.innerWidth;

function mediaManagement() {
  const newViewportWidth = window.innerWidth;

  if (leftValue <= -totalMovementSize && oldViewportWidth < newViewportWidth) {
    leftValue += totalMovementSize;
    cCarouselInner.style.left = leftValue + "px";
    oldViewportWidth = newViewportWidth;
  } else if (
    leftValue <= -totalMovementSize &&
    oldViewportWidth > newViewportWidth
  ) {
    leftValue -= totalMovementSize;
    cCarouselInner.style.left = leftValue + "px";
    oldViewportWidth = newViewportWidth;
  }
}

</script>


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

    </script>

@endpush