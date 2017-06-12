'use strict';

let gulp = require('gulp');
let concat = require('gulp-concat');
let rename = require('gulp-rename');
let sourcemaps = require('gulp-sourcemaps');
let browserSync = require('browser-sync').create();
let paths = {
    css: {
        source: 'assets/styles/',
        destination: 'public/css/'
    },
    js: {
        source: 'assets/scripts/',
        destination: 'public/js/'
    }
};

////////////////////////
//    Script Tasks    //
////////////////////////

let jshint = require('gulp-jshint');
let stylish = require('jshint-stylish');

gulp.task('lint', function () {
    return gulp.src([paths.js.source + '*.js'])
        .pipe(jshint())
        .pipe(jshint.reporter(stylish))
});

let uglify = require('gulp-uglify');
let stripDebug = require('gulp-strip-debug');

gulp.task('scripts', function() {
    return gulp.src(paths.js.source + '*.js')
        .pipe(concat('millmanphotography.js'))
        .pipe(gulp.dest(paths.js.destination))
        .pipe(rename('millmanphotography.min.js'))
        .pipe(stripDebug())
        .pipe(uglify())
        .pipe(gulp.dest(paths.js.destination));
});

///////////////////////
//     CSS Tasks     //
///////////////////////

let stylus = require('gulp-stylus');
let poststylus = require('poststylus');
let cssnext = require('postcss-cssnext');
let cssnano = require('cssnano');
let nib = require('nib');

gulp.task('styles', function () {
    let processors = [
        cssnext({ autoprefixer: true }),
        cssnano(),
    ];
    return gulp.src(paths.css.source + '*.styl')
        .pipe(concat('millmanphotography.styl'))
        .pipe(sourcemaps.init())
        .pipe(stylus({
            paths:  ['node_modules'],
            import: ['jeet/stylus/jeet', 'stylus-type-utils', 'nib', 'rupture/rupture', 'variables', 'mixins'],
            use: [
                nib(),
                poststylus(processors)
            ],
            'include css': true
        }))
        .pipe(sourcemaps.write('./'))
        .pipe(rename('millmanphotography.min.css'))
        .pipe(gulp.dest(paths.css.destination))
        .pipe(browserSync.stream());
});

///////////////////////
//       Watch       //
///////////////////////
gulp.task('watch', function () {
    gulp.watch(paths.js.source + '*.js', ['lint', 'scripts']);
    gulp.watch(paths.css.source + '*.styl', ['styles']);
});

/////////////////////////
//  BrowserSync Tasks  //
/////////////////////////

let args   = require('yargs').argv;
let serverUrl = args.proxy;

if (!serverUrl) {
    serverUrl = 'millmanphotography.dev';
}

gulp.task('browsersync', function () {
    browserSync.init({
        proxy: serverUrl
    });
});

////////////////////////
//    Server Tasks    //
////////////////////////
gulp.task('default', ['scripts', 'styles', 'watch']);
gulp.task('serve', ['scripts', 'styles', 'watch', 'browserSync']);
