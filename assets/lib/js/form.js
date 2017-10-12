$(document).ready(function () {
    const $enquiryForm = $('.enquiry-form');
    $enquiryForm.on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            url: $enquiryForm.attr('action'),
            method: $enquiryForm.attr('method'),
            data: $enquiryForm.serialize(),
            cache: false,
            dataType: 'json'
        }).done(function (data) {
            $enquiryForm.trigger('reset');
            let $message = $('<p>').text(data).css('color', 'green').prependTo($('.submit').parent());
            setTimeout(function () {
                $message.remove();
            }, 2500);
        }).fail(function (request) {
            let $message = $('<p>').text(request.responseJSON).css('color', 'red').prependTo($('.submit').parent());
            setTimeout(function () {
                $message.remove();
            }, 2500);
        }).always(function (a, b, request) {
            let csrfToken = request.getResponseHeader('X-CSRFToken');
            if (csrfToken) {
                csrfToken = $.parseJSON(csrfToken);
                const csrfTokenKeys = Object.keys(csrfToken);
                const hiddenFields = $enquiryForm.find('input.csrf[type="hidden"]');
                if (csrfTokenKeys.length === hiddenFields.length) {
                    hiddenFields.each(function (i) {
                        $enquiryForm.attr('name', csrfTokenKeys[i]);
                        $enquiryForm.val(csrfToken[csrfTokenKeys[i]]);
                    });
                }
            }
        });
        return false;
    });
});
