import React from 'react';
import Gallery from 'react-photo-gallery';
import Lightbox from 'react-images';
import SelectedImage from './selected-image';

class GalleryType extends React.Component {
    constructor(props) {
        super(props);
        this.state = { currentImage: 0, photos: this.props.photos, selectAll: false };
        this.closeLightbox = this.closeLightbox.bind(this);
        this.openLightbox = this.openLightbox.bind(this);
        this.gotoNext = this.gotoNext.bind(this);
        this.gotoPrevious = this.gotoPrevious.bind(this);
        this.selectPhoto = this.selectPhoto.bind(this);
        this.gotoPhoto = this.gotoPhoto.bind(this);
    }
    openLightbox(event, obj) {
        this.setState({
            currentImage: obj.index,
            lightboxIsOpen: true,
        });
    }
    closeLightbox() {
        this.setState({
            currentImage: 0,
            lightboxIsOpen: false,
        });
    }
    gotoPrevious() {
        this.setState({
            currentImage: this.state.currentImage - 1,
        });
    }
    gotoNext() {
        this.setState({
            currentImage: this.state.currentImage + 1,
        });
    }
    selectPhoto(event, obj) {
        let photos = this.state.photos;
        photos[obj.index].selected = !photos[obj.index].selected;
        this.setState({photos: photos});
        this.setPhotos();
    }
    setPhotos() {
        const selectedPhotos = this.state.photos.filter(function (photo) { return photo.selected === true; });
        const selectedImages = selectedPhotos.map(photo => ( photo.id ));
        document.getElementById('images').value = JSON.stringify(selectedImages)
    }
    gotoPhoto(event, obj) {
        let photos = this.state.photos;
        let selectedPhoto = photos[obj.index];
        location.href = '/image/' + selectedPhoto.filename;
    }
    render() {
        if (this.props.type === 'selectable') {
            this.setPhotos();
            return (
                <div>
                    <Gallery
                        photos={this.state.photos}
                        columns={this.props.columns}
                        onClick={this.selectPhoto}
                        ImageComponent={SelectedImage}
                    />
                </div>
            );
        }

        if (this.props.type === 'linkable') {
            return (
                <div>
                    <Gallery
                        photos={this.state.photos}
                        columns={this.props.columns}
                        onClick={this.gotoPhoto}
                    />
                </div>
            );
        }

        return (
            <div>
                <Gallery
                    photos={this.props.photos}
                    columns={this.props.columns}
                    onClick={this.openLightbox}
                />
                <Lightbox
                    theme={{container: {background: 'rgba(0, 0, 0, 0.85)'}}}
                    images={this.props.photos.map(x => ({ ...x, srcset: x.srcSet, caption: x.title }))}
                    backdropClosesModal={true}
                    onClose={this.closeLightbox}
                    onClickPrev={this.gotoPrevious}
                    onClickNext={this.gotoNext}
                    currentImage={this.state.currentImage}
                    isOpen={this.state.lightboxIsOpen}
                    width={1600}
                />
            </div>
        );
    }
}

export default GalleryType;
