/*
 * Page Scroll
 */
$(function() {
    $(document).on('click', 'a[href*=\\#]:not([href=\\#])', function(e) {
        e.preventDefault();
        var target = $(this).attr('href');
        var scrollToPosition = $(target).offset().top - 75;
        $('html, body').animate({ 'scrollTop': scrollToPosition }, 600);
    });
});

$(document).ready(function(){
    $("#submit").on('click', function(){
        $.ajax({
            cache: false,
            url: 'contact',
            type : "POST",
            dataType : 'json',
            data : $('#contact-form').serialize(),
            success : function(result) {
                alert('Success');
            },
            error: function(header, response, message) {
                console.log(header, response, message);
            }
        })
    });
});
