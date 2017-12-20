$(document).ready(function() {
    //Contact Form Validation
    $.validator.setDefaults({
        highlight: function(element) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function(element) {
            $(element).addClass('is-invalid');
        },
        errorElement: 'div',
        errorClass: 'invalid-feedback',
        errorPlacement: function(error, element) {
            error.insertAfter(element);
        }
    });

    $('form.get-in-touch').validate();

    //messages
    $('div.alert').delay(2000).fadeOut(2500);

    //terms and conditions
    switch (window.location.hash) {
        case '#online':
            $('body.terms-and-conditions #v-pills-online-tab').tab('show');
            break;
        case '#face-to-face':
            $('body.terms-and-conditions #v-pills-face-to-face-tab').tab('show');
    }
});



