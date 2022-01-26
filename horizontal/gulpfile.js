//gulpfile.js
const gulp = require('gulp'),
    minifyCSS = require('gulp-minify-css'),
    uglify = require('gulp-uglify'),
    rename = require("gulp-rename"),
    sass = require('gulp-sass');
    browserSync = require('browser-sync').create();

const sassFiles = 'dist/scss/*.scss',
    cssDest = 'dist/css/';

//compile scss into css
function style() {

    //1. Where is my scss
    return gulp.src(sassFiles)

        //2.pass through compiler
        .pipe(sass().on('error', sass.logError))

        //3.wher to save css
        .pipe(gulp.dest(cssDest))

        .pipe(browserSync.stream());

}
//This is for the minify css
function minifycss() {
    return gulp.src(['dist/css/*.css', '!dist/css/**/*.min.css'])
        .pipe(rename({
            suffix: '.min'
        }))
        .pipe(minifyCSS())
        .pipe(gulp.dest(cssDest))
}

// This is for the minifyjs
function minifyjs() {
    return gulp.src(['dist/js/**/*.js', '!dist/js/**/*.min.js'])
        .pipe(rename({
            suffix: '.min'
        }))
        .pipe(uglify())
        .pipe(gulp.dest('js'))
}

const npmDist = require('gulp-npm-dist');


function watch() {
    gulp.watch(['dist/scss/**/*.scss'], style);
    gulp.watch(['dist/css/style.css'], minifycss);
    gulp.watch(['dist/js/**/*.js', '!js/**/*.min.js'], minifyjs);
}


gulp.task('default', watch);

exports.style = style;
exports.minifycss = minifycss;
exports.minifyjs = minifyjs;
exports.watch = watch;