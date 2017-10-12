import React from 'react';
import Measure from 'react-measure';
import GalleryType from './gallery-type';

class Gallery extends React.Component {
    constructor(props) {
        super(props);
        this.state = { width: -1 };
    }
    render() {
        const width = this.state.width;
        return (
            <Measure bounds onResize={(contentRect) => this.setState({width: contentRect.bounds.width})}>
                {
                    ({measureRef}) => {
                        if (width < 1) {
                            return <div ref={measureRef}/>;
                        }
                        let columns = this.props.type === 'selectable' ? 2 : 1;
                        if (width >= 480) {
                            columns = this.props.type === 'selectable' ? 4 : 2;
                        }
                        if (width >= 1024) {
                            columns = this.props.type === 'selectable' ? 6 : 3;
                        }
                        if (width >= 1824) {
                            columns = this.props.type === 'selectable' ? 8 : 4;
                        }
                        return <div ref={measureRef} className="Gallery">
                            <GalleryType
                                photos={this.props.photos}
                                columns={columns}
                                type={this.props.type}
                            />
                        </div>
                    }
                }
            </Measure>
        );
    }
}

export default Gallery;
