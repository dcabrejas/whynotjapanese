$(document).ready(function() {
    //Contact Form Validation
    $.validator.setDefaults({
        highlight: function(element) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function(element) {
            $(element).removeClass('is-invalid');
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

    //Students voice carousel
    $('.students-voice-carousel').flickity({
      cellAlign: 'center',
      contain: true,
      wrapAround: true,
      autoPlay: 5000,
      adaptiveHeight: true
    });

    //terms and conditions
    switch (window.location.hash) {
        case '#general':
            $('body.terms-and-conditions #v-pills-general-tab').tab('show');
            break;
        case '#jlpt':
            $('body.terms-and-conditions #v-pills-jlpt-tab').tab('show');
            break;
        case '#medical':
            $('body.terms-and-conditions #v-pills-medical-tab').tab('show');
            break;
    }
});
