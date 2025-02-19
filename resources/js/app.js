import './bootstrap'

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
