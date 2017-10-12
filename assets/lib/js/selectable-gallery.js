import React from 'react';
import ReactDOM from 'react-dom';
import Gallery from './gallery';

let selectableGallery;

if (selectableGallery = document.getElementById('selectable-gallery')) {
    const photos = JSON.parse(selectableGallery.dataset.imageData);
    ReactDOM.render(
        <Gallery photos={photos}
                 type='selectable'/>,
        selectableGallery
    );
}
