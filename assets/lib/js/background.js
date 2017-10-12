$(document).ready(function() {
    let backgroundImage = document.getElementById('background-image');
    if (backgroundImage !== null) {
        let images = JSON.parse(backgroundImage.dataset.imageData);
        setInterval(function () {
            backgroundImage.src = images[Math.floor(Math.random() * images.length)];
        }, 10000);
    }
});
