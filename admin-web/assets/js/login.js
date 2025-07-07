(function ($) {
    "use strict";
    /*----------------------------------------
     passward show hide
     ----------------------------------------*/
    $('.show-hide').show();
    $('.show-hide span').addClass('show');

    $('.show-hide span').click(function () {
        if ($(this).hasClass('show')) {
            $('input[name="pass-field"]').attr('type', 'text');
            $(this).removeClass('show');
        } else {
            $('input[name="pass-field"]').attr('type', 'password');
            $(this).addClass('show');
        }
    });
    $('form button[type="submit"]').on('click', function () {
        $('.show-hide span').text('Show').addClass('show');
        $('.show-hide').parent().find('input[name="pass-field"]').attr('type', 'password');
    });

})(jQuery);