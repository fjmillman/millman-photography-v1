/*
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

$(function () {
    var form = $('form');
    form.on('submit', function () {
        $.ajax({
            url: form.attr('action'),
            method: form.attr('method'),
            data: {
                csrfName: $('csrfName'),
                csrfValue: $('csrfValue'),
                name: $('name'),
                email: $('email'),
                message: $('message')
            },
            cache: false,
            dataType: 'json',
            success: function (data) {
                console.log('OK');
            },
            error: function () {
                console.log('Error')
            },
            complete: function (jqXHR) {
                var csrfToken = jqXHR.getResponseHeader('X-CSRF-Token');
                if (csrfToken) {
                    try {
                        csrfToken = $.parseJSON(csrfToken);
                        var csrfTokenKeys = Object.keys(csrfToken);
                        var hiddenFields = form.find('input.csrf[type="hidden"]');

                        if (csrfTokenKeys.length === hiddenFields.length) {
                            hiddenFields.each(function(i) {
                                $(this).attr('name', csrfTokenKeys[i]);
                                $(this).val(csrfToken[csrfTokenKeys[i]]);
                            });
                        }
                    } catch (e) {

                    }
                }
            }
        });
        return false;
    });
});
