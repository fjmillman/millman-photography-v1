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
