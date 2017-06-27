const webpack = require('webpack');
const path = require('path');

const ExtractTextPlugin = require('extract-text-webpack-plugin');

module.exports = {
    entry: './webpack.js',
    output: {
        filename: './millmanphotography.js'
    },
    module: {
        loaders: [
            {
                test: /\.styl$/,
                loader: ExtractTextPlugin.extract("style", "!css!stylus") // plugin used to extract css file from your compiled `styl` files
            },
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
    plugins: [
        new ExtractTextPlugin('millmanphotography.css')
    ],
    watch: true,
};
