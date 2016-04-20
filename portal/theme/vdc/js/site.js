/**
 * Created by Thomas on 02.03.16.
 */
(function ($) {
    $('ul.dropdown-menu>li>a[href^="#"]').addClass(' disabled');
}(jQuery));


(function ($) {

    $('body').on('beforeSubmit', 'form#machine-comment', function () {
        var form = $(this);
        // return false if form still have some validation errors
        if (form.find('.has-error').length) {
            return false;
        }
        // submit form
        $.ajax({
            url: form.attr('action'),
            type: 'post',
            data: form.serialize(),
            success: function (response) {
                var tempFun = new Function(response['apply']);
                if (typeof tempFun === "function") tempFun.apply(null, response['param']);
                $('#modal').modal('hide');
            }
        });
        return false;
    });


    $(document).on('click', '.showModalButton', function () {
        //check if the modal is open. if it's open just reload content not whole modal
        //also this allows you to nest buttons inside of modals to reload the content it is in
        //the if else are intentionally separated instead of put into a function to get the
        //button since it is using a class not an #id so there are many of them and we need
        //to ensure we get the right button and content.
        if ($('#modal').data('bs.modal').isShown) {
            $('#modal').find('#modalContent')
                .load($(this).attr('href'));

            //dynamiclly set the header for the modal
            $('#modalHeaderTitel').html('<b>' + $(this).attr('title') + '</b>');
        } else {
            //if modal isn't open; open it and load content
            $('#modal').modal('show')
                .find('#modalContent')
                .load($(this).attr('href'));
            //dynamiclly set the header for the modal
            $('#modalHeaderTitel').html('<b>' + $(this).attr('title') + '</b>');
        }
        return false;
    });
})(jQuery);


$(document).on('pjax:complete ready', function () {
    $(".comment").dotdotdot({
        /*	The text to add as ellipsis. */
        ellipsis: '... ',
        /*	Whether to update the ellipsis: true/'window' */
        height: 20
    })
});





