$(function() {
    let images = ['ashnessjetty', 'swaledale', 'northumberland'];
    let time = setInterval(function() {
        let image = images[Math.floor(Math.random() * images.length)];
        $('#background-image').css('background-image', 'url(http://millmanphotography.co.uk/img/' + image + '.jpg)');
    }, 10000);
});
