$(function() {
    $(document).on('click', 'a[href*=\\#]:not([href=\\#])', function(e) {
        e.preventDefault();
        let target = $(this).attr('href');
        let scrollToPosition = $(target).offset().top + 2;
        $('html, body').animate({ 'scrollTop': scrollToPosition }, 600);
    });
});
