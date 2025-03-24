(function ($) {

  "use strict";

  const rangeInput = document.querySelectorAll(".range-input input"),
    priceInput = document.querySelectorAll(".price-input input"),
    range = document.querySelector(".slider .progress");
  let priceGap = 1000;

  priceInput.forEach((input) => {
    input.addEventListener("input", (e) => {
      let minPrice = parseInt(priceInput[0].value),
        maxPrice = parseInt(priceInput[1].value);

      if (maxPrice - minPrice >= priceGap && maxPrice <= rangeInput[1].max) {
        if (e.target.className === "input-min") {
          rangeInput[0].value = minPrice;
          range.style.left = (minPrice / rangeInput[0].max) * 100 + "%";
        } else {
          rangeInput[1].value = maxPrice;
          range.style.right = 100 - (maxPrice / rangeInput[1].max) * 100 + "%";
        }
      }
    });
  });

  rangeInput.forEach((input) => {
    input.addEventListener("input", (e) => {
      let minVal = parseInt(rangeInput[0].value),
        maxVal = parseInt(rangeInput[1].value);

      if (maxVal - minVal < priceGap) {
        if (e.target.className === "range-min") {
          rangeInput[0].value = maxVal - priceGap;
        } else {
          rangeInput[1].value = minVal + priceGap;
        }
      } else {
        priceInput[0].value = minVal;
        priceInput[1].value = maxVal;
        range.style.left = (minVal / rangeInput[0].max) * 100 + "%";
        range.style.right = 100 - (maxVal / rangeInput[1].max) * 100 + "%";
      }
    });
  });

  // init Chocolat light box
  var initChocolat = function () {
    Chocolat(document.querySelectorAll('.image-link'), {
      imageSize: 'contain',
      loop: true,
    })
  }


  $(document).ready(function () {


    // swiper
    var swiper = new Swiper(".residence-swiper", {
      slidesPerView: 3,
      spaceBetween: 30,
      freeMode: true,
      navigation: {
        nextEl: ".residence-swiper-next",
        prevEl: ".residence-swiper-prev",
      },
      pagination: {
        el: ".swiper-pagination",
        clickable: true,
      },
      breakpoints: {
        300: {
          slidesPerView: 1,
          spaceBetween: 20,
        },
        768: {
          slidesPerView: 2,
          spaceBetween: 30,
        },
        1024: {
          slidesPerView: 3,
          spaceBetween: 30,
        },
      }
    });

    var swiper = new Swiper(".testimonial-swiper", {
      slidesPerView: 1,
      spaceBetween: 30,
      freeMode: true,
      navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
      },
      pagination: {
        el: ".swiper-pagination",
        clickable: true,
      },
    });

    // product single page
    var thumb_slider = new Swiper(".product-thumbnail-slider", {
      autoplay: true,
      loop: true,
      spaceBetween: 8,
      slidesPerView: 4,
      freeMode: true,
      watchSlidesProgress: true,
    });

    var large_slider = new Swiper(".product-large-slider", {
      autoplay: true,
      loop:true,
      spaceBetween: 10,
      effect: 'fade',
      thumbs: {
        swiper: thumb_slider,
      },
    });


    initChocolat();


  });


// Custom Logic for index.html

if (document.getElementById('searchForm')) {
  document.getElementById('searchForm').addEventListener('submit', function (e) {
    e.preventDefault();
    const city = document.getElementById('location').value;
    const type = document.getElementById('type').value;

    const params = new URLSearchParams({ city, type });
    window.location.href = `properties.html?${params.toString()}`;
  });
}

// Custom Logic for propreties.html


// Store inquiries by property ID
const inquiriesByProperty = {};

function openPropertyPopup(title, details, image, price, id) {
  const modal = document.getElementById('propertyPopup');
  if (!modal) return;

  document.getElementById('propertyTitle').innerText = title;
  document.getElementById('propertyDetails').innerText = details;
  document.getElementById('propertyImage').src = image;
  document.getElementById('propertyPrice').innerText = `Price: $${price} / month`;

  // Set current property ID
  document.getElementById('currentPropertyId').value = id;

  // Load inquiries
  const inquiryList = document.getElementById('inquiryList');
  inquiryList.innerHTML = ''; 

  const inquiries = inquiriesByProperty[id] || [];
  inquiries.forEach(entry => {
    const div = document.createElement('div');
    div.className = 'border-bottom border-secondary pb-2 mb-2';
    div.innerHTML = `<strong>Customer:</strong> ${entry}<br><strong>Agent:</strong> (Awaiting reply...)`;
    inquiryList.appendChild(div);
  });

  const myModal = new bootstrap.Modal(modal);
  myModal.show();
}




function filterProperties() {
  const city = document.getElementById('filterCity')?.value || 'all';
  const type = document.getElementById('filterType')?.value || 'all';
  document.querySelectorAll('.property-item').forEach(property => {
    const propertyCity = property.getAttribute('data-city');
    const propertyType = property.getAttribute('data-type');
    const show = (city === 'all' || city === propertyCity) && (type === 'all' || type === propertyType);
    property.style.display = show ? 'block' : 'none';
  });
}

document.addEventListener('DOMContentLoaded', () => {
  if (document.getElementById('filterCity')) {
    document.getElementById('filterCity').addEventListener('change', filterProperties);
    document.getElementById('filterType').addEventListener('change', filterProperties);

    const params = new URLSearchParams(window.location.search);
    document.getElementById('filterCity').value = params.get('city') || 'all';
    document.getElementById('filterType').value = params.get('type') || 'all';

    filterProperties();
  }

  // Initialize dynamic popup data bindings
  document.querySelectorAll('.property-item').forEach(item => {
    const id = item.dataset.id;
    const title = item.dataset.title;
    const details = item.dataset.details;
    const image = item.dataset.image;
    const price = item.dataset.price;

    const card = item.querySelector('.open-popup');
    if (card) {
      card.addEventListener('click', () => {
        openPropertyPopup(title, details, image, price, id);
      });
    }
  });
});


})(jQuery);