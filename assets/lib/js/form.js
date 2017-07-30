$(document).ready(function () {
    const $form = $('#enquiry-form');
    const $submit = $('#submit');
    $form.on('submit', function () {
        $.ajax({
            url: $form.attr('action'),
            method: $form.attr('method'),
            data: $form.serialize(),
            cache: false,
            dataType: 'json'
        }).done(success).fail(error).always(complete);
        return false;
    });
    function success(data) {
        $form.trigger('reset');
        let $message = $('<p>').text(data).css('color', 'green').prependTo($submit.parent());
        setTimeout(function() { $message.remove(); }, 2500);
    }
    function error(request) {
        let $message = $('<p>').text(request.responseJSON).css('color', 'red').prependTo($submit.parent());
        setTimeout(function() { $message.remove(); }, 2500);
    }
    function complete (request) {
        let csrfToken = request.getResponseHeader('X-CSRFToken');
        if (csrfToken) {
            csrfToken = $.parseJSON(csrfToken);
            const csrfTokenKeys = Object.keys(csrfToken);
            const hiddenFields = $form.find('input.csrf[type="hidden"]');
            if (csrfTokenKeys.length === hiddenFields.length) {
                hiddenFields.each(function(i) {
                    $(this).attr('name', csrfTokenKeys[i]);
                    $(this).val(csrfToken[csrfTokenKeys[i]]);
                });
            }
        }
    }
});
