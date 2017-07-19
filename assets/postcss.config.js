module.exports = ctx => ({
    plugins: [
        require('postcss-import')(),
        require('postcss-url')({
            url: 'inline'
        }),
        require('postcss-cssnext')({
            browserslist: '>= ie 8, last 2 versions'
        }),
        require('cssnano')({
            autoprefixer: false
        }),
        require("postcss-reporter")()
    ]
});
