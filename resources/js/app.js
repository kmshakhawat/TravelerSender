import './bootstrap'

import Swiper from 'swiper';
import { Navigation, Autoplay, EffectFade } from 'swiper/modules';
import 'swiper/css/bundle';

import flatpickr from "flatpickr";
import 'flatpickr/dist/flatpickr.min.css';



// Function to populate dropdown
function populateDropdown(elementId, items) {
    let select = document.getElementById(elementId);
    let fragment = document.createDocumentFragment();

    items.forEach(item => {
        let option = document.createElement('option');
        option.value = item.id;
        option.textContent = item.name;
        fragment.appendChild(option);
    });

    select.appendChild(fragment);
}

function showLoading(loaderId, show) {
    let loader = document.getElementById(loaderId);
    if (loader) {
        loader.style.display = show ? 'inline-block' : 'none';
    }
}

flatpickr(".datepicker", {
    altInput: true,
    altFormat: "F j, Y",
    dateFormat: "Y-m-d",
});

flatpickr(".timepicker", {
    altInput: true,
    altFormat: "F j, Y h:i K",
    enableTime: true,
    dateFormat: "Y-m-d H:i:s",
    minDate: "today",
});
document.addEventListener('DOMContentLoaded', function () {
    const slide = new Swiper(".slide", {
        modules: [Navigation, Autoplay, EffectFade],
        spaceBetween: 20,
        slidesPerView: 1,
        loop: true,
        effect: "fade",
        autoHeight: true,
        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
        },
        navigation: {
            nextEl: ".slide-next",
            prevEl: ".slide-prev",
        },
    });
    const review = new Swiper(".review", {
        modules: [Navigation, Autoplay, EffectFade],
        spaceBetween: 20,
        slidesPerView: 1,
        loop: true,
        effect: "fade",
        autoHeight: true,
        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
        },
        navigation: {
            nextEl: ".review-next",
            prevEl: ".review-prev",
        },
    });

});
$(document).ready(function () {
    $('.select2').select2();
});

previewImage('profile_photo_path', 'profilePhoto');
previewImage('id_front', 'frontID');
previewImage('id_back', 'backID');
previewImage('photo', 'photoPath');
function previewImage(inputId, imageId) {
    const input = document.getElementById(inputId);
    const image = document.getElementById(imageId);

    if (input && image) {
        input.addEventListener('change', function (event) {
            const file = event.target.files[0];
            if (file?.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = (e) => (image.src = e.target.result);
                reader.readAsDataURL(file);
            }
        });
    }
}

$('.photo').change(function () {
    let files = $(this)[0].files;
    if (files.length > 1) {
        $(this).prev().html(files.length + " files selected");
    } else if (files.length === 1) {
        $(this).prev().html(files[0].name);
    } else {
        $(this).prev().html("No file selected");
    }
});



document.querySelectorAll('.id_card').forEach(input => {
    input.addEventListener('change', function (event) {
        const file = event.target.files[0];
        if (file && file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function (e) {
                // Select all images that need to be updated
                document.querySelectorAll('#id_card_photo').forEach(img => {
                    img.src = e.target.result;
                });
            };
            reader.readAsDataURL(file);
        }
    });
});


window.showJsonErrorMessage = (response, showAlert = true) => {
    const selector = '.invalid-feedback';

    let message = '';
    let errors = {};


    if (response.responseJSON) {
        // jQuery AJAX get Data
        message = response.responseJSON.message;
        errors = response.responseJSON.errors || {};
    } else if (response.response && response.response.data) {
        // Axios get Data
        message = response.response.data.message;
        errors = response.response.data.errors || {};
    } else {
        // Fallback in case neither jQuery nor Axios formats are present
        message = 'An unexpected error occurred';
    }




    // Clear previous error messages
    document.querySelectorAll(selector).forEach((element) => {
        element.textContent = '';
    });

    // Remove invalid class from previous fields
    document.querySelectorAll('.form .is-invalid').forEach((element) => {
        element.classList.remove('is-invalid');
    });

    // If there are field-specific errors, show them
    for (let field in errors) {
        const fieldErrorElement = document.querySelector(`.invalid-${field}`);
        if (fieldErrorElement) {
            fieldErrorElement.textContent = errors[field][0]; // Show the first error for that field
            const inputElement = document.querySelector(`[name="${field}"]`);
            if (inputElement) {
                inputElement.classList.add('is-invalid');
            }
        }
    }

    if (showAlert) {
        Swal.fire({
            title: 'Error!',
            text: message,
            icon: 'error',
            confirmButtonText: 'Ok'
        });
    }
};
