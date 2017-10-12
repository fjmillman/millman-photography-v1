module.exports = ctx => ({
    plugins: [
        require('postcss-import')(),
        require('postcss-url')({ url: 'inline' }),
        require('postcss-cssnext')(),
        require('cssnano')({ autoprefixer: false }),
        require('postcss-browser-reporter')(),
        require('postcss-reporter')()
    ]
});
