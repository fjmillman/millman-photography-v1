const path = require('path');

module.exports = {
    SRC: path.resolve(__dirname, '..', 'public'),
    DIST: path.resolve(__dirname, '..', 'public', 'dist'),
    ASSETS: '/dist',
    entry: './webpack.js',
    output: {
        filename: './millmanphotography.js'
    },
    module: {
        loaders: [
            {
                test: /\.css$/,
                exclude: /node_modules/,
                loader: 'style!css'
            },
            {
                test: /\.js$/,
                exclude: /node_modules/,
                loader: 'babel',
                query: {
                    presets: ['es2015']
                }
            }
        ],
    },
    watch: true,
};
