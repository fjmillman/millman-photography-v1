let gulp = require('gulp'),
    postcss = require('gulp-postcss'),
    sourcemaps = require('gulp-sourcemaps'),
    processors = [
            require("postcss-import")(),
            require("postcss-url")(),
            require("postcss-cssnext")(),
            require("cssnano")({ autoprefixer: false }),
            require("postcss-browser-reporter")(),
            require("postcss-reporter")()
    ],
    paths = {
        source: 'src/css/*.css',
        destination: 'public/css/'
    };

gulp.task('css', function () {
    return gulp.src(paths.source)
        .pipe(sourcemaps.init())
        .pipe(postcss(processors))
        .pipe(sourcemaps.write('./'))
        .pipe(gulp.dest(paths.destination)
    )
});
