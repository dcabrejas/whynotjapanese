$(document).ready(function() {
    //Tuition Fees Display
    $('.tuition-fees-toggle').click(function () {
        $(this).siblings('.tuition-fees').fadeToggle();
    });

    //Contact Form Validation
    $.validator.setDefaults({
        highlight: function (element) {
            $(element).addClass('error');
        }
    });

    $('form.get-in-touch').validate();

    //Session messages
    $('.message').delay(5000).fadeOut();
});



