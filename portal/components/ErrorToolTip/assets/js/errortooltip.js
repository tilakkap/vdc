/**
 * Created by Thomas on 12.02.16.
 */
$('form').on('afterValidateAttribute', function(event, attribute, messages) {

    var hasError = messages.length !==0;
    var field = $(attribute.container);
    var element = $(field.find('input[type=text]'));

    var message = '';

    if(hasError) {
        message = messages[0];
    }

    var options = {
        animation: $(element).data('animation') || true,
        html: $(element).data('html') || false,
        placement: $(element).data('placement') || 'top',
        selector: $(element).data('selector') || false,
        title: $(element).attr('title') || message,
        trigger: $.trim('manual ' + ($(element).data('trigger') || '')),
        delay: $(element).data('delay') || 0,
        container: $(element).data('container') || false,
    };

    if(hasError) {
        if (element.data('bs.tooltip') !== undefined) {
            element.data('bs.tooltip').options.title = message;
        } else {
            element.tooltip(options);
        }
        element.tooltip('show');
        //alert(messages[0]);
    }
    else {
        if (element.data('bs.tooltip') !== undefined) {
            element.tooltip('hide');
        }
    }
});

(function($) {
    var formControl = $('.has-error');
    var input = $('input[type=text]',formControl);
    var message = $('.help-block', formControl).hide().text();
}(jQuery));


