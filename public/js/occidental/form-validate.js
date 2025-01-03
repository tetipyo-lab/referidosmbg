
function validateForm() {
    let isValid = true;
    $('input[data-sb-validations="required"]').each(function() {
        const feedbackElement = $(this).siblings('.invalid-feedback[data-sb-feedback="' + $(this).attr('id') + ':required"]');
        if ($(this).val() === '') {
            isValid = false;
            $(this).addClass('error');
            feedbackElement.show();
        } else {
            $(this).removeClass('error');
            feedbackElement.hide();
        }
    });
    return isValid;
}

$('#btnSubmit').on('click', function(event) {
    event.preventDefault();
    if (validateForm()) {
        // You can submit the form here if needed
        $('#__vtigerWebForm').submit();
    } else {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Please fill out all required fields!',
        });
    }
});

$('.phoneValid').on('blur', function() {
    const phoneNumber = $(this).val();
    const formattedPhoneNumber = phoneNumber.replace(/\D/g, '');
    if (formattedPhoneNumber.length === 10) {
        $(this).val('1' + formattedPhoneNumber);
    } else if (formattedPhoneNumber.length === 11 && formattedPhoneNumber.startsWith('1')) {
        $(this).val(formattedPhoneNumber);
    } else {
        $(this).addClass('error');
        Swal.fire({
            icon: 'error',
            title: 'Invalid phone number',
            text: 'Please enter a valid 10-digit phone number.',
        });
    }
});