'use strict';

let gulp = require('gulp');
let concat = require('gulp-concat');
let rename = require('gulp-rename');
let sourcemaps = require('gulp-sourcemaps');
let browserSync = require('browser-sync').create();
let paths = {
    css: {
        source: 'assets/styles/',
        destination: 'public/css/',
    },
    js: {
        source: 'assets/scripts/',
        destination: 'public/js/'
    },
    img: {
        source: 'assets/images/',
        destination: 'public/img/'
    }
};

///////////////////////
//    Style Tasks    //
///////////////////////

let stylus = require('gulp-stylus');
let jeet = require('jeet');
let nib = require('nib');
let rupture = require('rupture');
let poststylus = require('poststylus');
let postcss = require('gulp-postcss');
let cssimport = require('postcss-import');
let cssurl = require('postcss-url');
let cssnext = require('postcss-cssnext');
let lost = require('lost');
let autoprefixer = require('autoprefixer');
let cssnano = require('cssnano');
let reporter = require('postcss-reporter');
let processors = [
    cssimport(),
    cssurl({ url: 'inline' }),
    cssnext({ autoprefixer: false }),
    autoprefixer({ browsers: ['last 2 versions', 'IE > 8'] }),
    cssnano({ autoprefixer: false }),
    reporter()
];

gulp.task('styles', function () {
    return gulp.src(paths.css.source + '*.styl',)
        .pipe(concat('millmanphotography.styl'))
        .pipe(stylus({
            paths:  ['node_modules'],
            include: [ 'jeet', 'nib', 'rupture'],
            use: [ nib(), jeet(), rupture() ],
            'include css': true,
            compress: true
        }))
        .pipe(sourcemaps.init())
        .pipe(postcss(processors))
        .pipe(rename('millmanphotography.min.css'))
        .pipe(sourcemaps.write('./'))
        .pipe(gulp.dest(paths.css.destination))
        .pipe(browserSync.stream());
});

gulp.task('email', function () {
    return gulp.src(paths.css.source + 'email/*.styl')
        .pipe(concat('millmanphotography-email.styl'))
        .pipe(stylus({
            paths:  ['node_modules'],
            include: [ 'jeet', 'nib', 'rupture'],
            use: [ nib(), jeet(), rupture() ],
            'include css': true,
            compress: true
        }))
        .pipe(sourcemaps.init())
        .pipe(postcss(processors))
        .pipe(rename('millmanphotography-email.min.css'))
        .pipe(sourcemaps.write('./'))
        .pipe(gulp.dest(paths.css.destination))
});

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

let babel = require('gulp-babel');
let uglify = require('gulp-uglify');
let stripDebug = require('gulp-strip-debug');

gulp.task('scripts', function() {
    return gulp.src(paths.js.source + '*.js')
        .pipe(concat('millmanphotography.js'))
        .pipe(sourcemaps.init())
        .pipe(stripDebug())
        .pipe(babel())
        .pipe(uglify())
        .on('error', function (err) {
            console.error(err.toString());
        })
        .pipe(rename('millmanphotography.min.js'))
        .pipe(sourcemaps.write('./'))
        .pipe(gulp.dest(paths.js.destination))
});

///////////////////////
//    Image Tasks    //
///////////////////////
let cache = require('gulp-cache');
let imagemin = require('gulp-imagemin');

gulp.task('images', function() {
    return gulp.src(paths.img.source + '*.+(png|jpg|jpeg|gif|svg)')
        .pipe(cache(imagemin({ optimizationLevel: 5 })))
        .pipe(gulp.dest(paths.img.destination));
});

///////////////////////
//       Watch       //
///////////////////////
gulp.task('watch', function () {
    gulp.watch(paths.css.source + '*.styl', ['styles']);
    gulp.watch(paths.css.source + '/email/*.styl', ['email']);
    gulp.watch(paths.js.source + '*.js', ['lint', 'scripts']);
    gulp.watch(paths.img.source + '*.img', ['images']);
});

/////////////////////////
//  BrowserSync Tasks  //
/////////////////////////

let args = require('yargs').argv;
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
gulp.task('default', ['styles', 'email', 'scripts', 'images', 'watch']);
gulp.task('serve', ['styles', 'scripts', 'images', 'watch', 'browsersync']);
