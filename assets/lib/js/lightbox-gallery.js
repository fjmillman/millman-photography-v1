import React from 'react';
import ReactDOM from 'react-dom';
import Gallery from './gallery';

let lightboxGallery;

if (lightboxGallery = document.getElementById('lightbox-gallery')) {
    const photos = JSON.parse(lightboxGallery.dataset.imageData);
    ReactDOM.render(
        <Gallery photos={photos}
                 type='lightbox'/>,
        lightboxGallery
    );
}
