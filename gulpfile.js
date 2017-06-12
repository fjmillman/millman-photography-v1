let gulp = require('gulp');
let paths = {
    css: {
        source: 'assets/css/*.css',
        destination: 'public/css/'
    }
};
let sourcemaps = require('gulp-sourcemaps');
let postcss = require('gulp-postcss');
let processors = [
        require("postcss-import")(),
        require("postcss-url")(),
        require("postcss-cssnext")(),
        require("cssnano")({ autoprefixer: false }),
        require("postcss-browser-reporter")(),
        require("postcss-reporter")()
    ];
let concat = require('gulp-concat');
let rename = require('gulp-rename');

gulp.task('css', function () {
    return gulp.src(paths.css.source)
        .pipe(concat('millmanphotography.css'))
        .pipe(sourcemaps.init())
        .pipe(postcss(processors))
        .pipe(sourcemaps.write('./'))
        .pipe(rename('millmanphotography.min.css'))
        .pipe(gulp.dest(paths.css.destination))
});
