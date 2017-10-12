import React from 'react';
import ReactDOM from 'react-dom';
import Gallery from './gallery';

let linkableGallery;

if (linkableGallery = document.getElementById('linkable-gallery')) {
    const photos = JSON.parse(linkableGallery.dataset.imageData);
    ReactDOM.render(
        <Gallery photos={photos}
                 type='linkable'/>,
        linkableGallery
    );
}
