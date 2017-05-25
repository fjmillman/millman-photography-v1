/**
 * Page Scroll
 */
$(function() {
    $(document).on('click', 'a[href*=\\#]:not([href=\\#])', function(e) {
        e.preventDefault();
        var target = $(this).attr('href');
        var scrollToPosition = $(target).offset().top;
        $('html, body').animate({ 'scrollTop': scrollToPosition }, 600);
    });
});

/**
 * Post Form Data using Csrf Token
 */
$(function () {
    var $form = $('form');
    var $submit = $('#submit');
    $form.on('submit', function () {
        $.ajax({
            url: $form.attr('action'),
            method: $form.attr('method'),
            data: $form.serialize(),
            cache: false,
            dataType: 'json',
            success: function (data, status, request) {
                console.log(status);
                $form.trigger('reset');
                var $message = $('<p>').text('Success').css('color', 'green').prependTo($submit.parent());
                setTimeout(function() { $message.remove() }, 2500);
            },
            error: function (request, status, error) {
                console.log(status + ' : ' + error);
                var $message = $('<p>').text(request.responseJSON).css('color', 'red').prependTo($submit.parent());
                setTimeout(function() { $message.remove() }, 2500);
            },
            complete: function (jqXHR) {
                var csrfToken = jqXHR.getResponseHeader('X-CSRFToken');
                if (csrfToken) {
                    try {
                        csrfToken = $.parseJSON(csrfToken);
                        var csrfTokenKeys = Object.keys(csrfToken);
                        var hiddenFields = $form.find('input.csrf[type="hidden"]');
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
        return false;
    });
});
