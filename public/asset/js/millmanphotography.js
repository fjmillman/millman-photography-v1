/**
 * Page Scroll
 */
$(function() {
    $(document).on('click', 'a[href*=\\#]:not([href=\\#])', function(e) {
        e.preventDefault();
        let target = $(this).attr('href');
        let scrollToPosition = $(target).offset().top;
        $('html, body').animate({ 'scrollTop': scrollToPosition }, 600);
    });
});

/**
 * Post Form Data using Csrf Token
 */
$(function () {
    const $form = $('form');
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
    function success(data, status, request) {
        console.log(status);
        $form.trigger('reset');
        let $message = $('<p>').text('Success').css('color', 'green').prependTo($submit.parent());
        setTimeout(function() { $message.remove() }, 2500);
    }
    function error(request, status, error) {
        console.log(status + ' : ' + error);
        let $message = $('<p>').text(request.responseJSON).css('color', 'red').prependTo($submit.parent());
        setTimeout(function() { $message.remove() }, 2500);
    }
    function complete (request) {
        let csrfToken = request.getResponseHeader('X-CSRFToken');
        if (csrfToken) {
            try {
                csrfToken = $.parseJSON(csrfToken);
                const csrfTokenKeys = Object.keys(csrfToken);
                const hiddenFields = $form.find('input.csrf[type="hidden"]');
                if (csrfTokenKeys.length === hiddenFields.length) {
                    hiddenFields.each(function(i) {
                        $(this).attr('name', csrfTokenKeys[i]);
                        $(this).val(csrfToken[csrfTokenKeys[i]]);
                    });
                }
            } catch (e) {
                console.log(e);
            }
        }
    }
});
