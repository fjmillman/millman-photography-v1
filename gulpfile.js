'use strict';

let gulp = require('gulp');
let prefix = require('gulp-autoprefixer');
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
let nib = require('nib');

gulp.task('styles', function () {
    gulp.src(paths.css.source + '*.styl')
        .pipe(sourcemaps.init())
        .pipe(stylus({
            paths:  ['node_modules', 'styles/globals'],
            import: ['jeet/stylus/jeet', 'stylus-type-utils', 'nib', 'rupture/rupture', 'variables', 'mixins'],
            use: [nib()],
            'include css': true
        }))
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest(paths.css.destination))
        .pipe(browserSync.stream());
});

let postcss = require('gulp-postcss');
let processors = [
    require("postcss-import")(),
    require("postcss-url")(),
    require("postcss-cssnext")(),
    require("cssnano")({ autoprefixer: true }),
    require("postcss-browser-reporter")(),
    require("postcss-reporter")()
];

gulp.task('postcss', function () {
    return gulp.src(paths.css.source + '*.css')
        .pipe(concat('millmanphotography.css'))
        .pipe(sourcemaps.init())
        .pipe(postcss(processors))
        .pipe(sourcemaps.write('.'))
        .pipe(rename('millmanphotography.min.css'))
        .pipe(gulp.dest(paths.css.destination))
});

///////////////////////
//       Watch       //
///////////////////////
gulp.task('watch', function () {
    gulp.watch(paths.js.source + '*.js', ['lint', 'scripts']);
    gulp.watch(paths.css.source + '*.styl', ['styles', 'postcss']);
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
gulp.task('default', ['scripts', 'styles', 'postcss', 'watch']);
gulp.task('serve', ['scripts', 'styles', 'postcss', 'watch', 'browserSync']);
