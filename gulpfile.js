'use strict';

var gulp         = require('gulp');
var sass         = require('gulp-sass');
var autoprefixer = require('gulp-autoprefixer');
var rename       = require('gulp-rename');
var uglify       = require('gulp-uglify');
// var minifyCss    = require('gulp-minify-css');
// var plumber      = require('gulp-plumber');
var concat       = require('gulp-concat');
var jshint       = require('gulp-jshint');
var stylish      = require('jshint-stylish');
var wpPot        = require('gulp-wp-pot');
var sort         = require('gulp-sort');
var gcmq         = require('gulp-group-css-media-queries');
var del          = require('del');
var zip          = require('gulp-zip');
var sourcemaps   = require('gulp-sourcemaps');
var browserSync  = require('browser-sync');
var runSequence  = require('run-sequence');
var js_files     = [
  "node_modules/bootstrap-sass/assets/javascripts/bootstrap.min.js",
  "assets/scripts/plugins/fixedsticky.js",
  "assets/scripts/plugins/flickity.js",
  "assets/scripts/plugins/fastClick.js",
  "assets/scripts/plugins/formatCurrency.js",
  "assets/scripts/plugins/placeholder.js",
  "assets/scripts/plugins/slick.js",
  "assets/scripts/plugins/hoverIntent.js",
  "assets/scripts/plugins/hashchange.js",
  "assets/scripts/plugins/scrollTo.js",
  "assets/scripts/plugins/owl.carousel.js",
  "assets/scripts/plugins/owl.carousel1.js",
  "assets/scripts/override/woocommerce-wishlists.js",
  "assets/scripts/main.js"
];

var build_files = [
  '**',
  '!node_modules',
  '!node_modules/**',
  '!build',
  '!build/**',
  '!assets/sass',
  '!assets/sass/**',
  '!.git',
  '!.git/**',
  '!package.json',
  '!.gitignore',
  '!gulpfile.js',
  '!.editorconfig',
  '!.jshintrc'
];

gulp.task('sass', function () {
  gulp.src('assets/styles/main.scss')
    .pipe(sourcemaps.init())
    .pipe(concat('main.css'))
    .pipe(sass({outputStyle: 'expanded'}))
    .pipe(autoprefixer(['last 2 versions']))
    .pipe(sourcemaps.write())
    .pipe(gulp.dest('assets/styles'))
    .pipe(browserSync.reload({stream:true}));
});

gulp.task('lint', function() {
  return gulp.src(js_files)
    .pipe(jshint())
    .pipe(jshint.reporter(stylish));
});

gulp.task('modernizr', function() {
  return gulp.src('assets/scripts/plugins/modernizr.js')
    .pipe(sourcemaps.init())
    .pipe(concat('modernizr.min.js'))
    .pipe(uglify())
    .pipe(sourcemaps.write())
    .pipe(gulp.dest('assets/scripts'));
});

gulp.task('compress', function() {
  return gulp.src(js_files)
    .pipe(sourcemaps.init())
    .pipe(concat('main.min.js'))
    .pipe(uglify())
    .pipe(sourcemaps.write())
    .pipe(gulp.dest('assets/scripts'))
    .pipe(browserSync.reload({stream:true}));
});

gulp.task('makepot', function () {
  return gulp.src(['**/*.php'])
    .pipe(sort())
    .pipe(wpPot({
      domain: 'davis',
      destFile: 'davis.pot',
      package: 'Davis',
      bugReport: 'https://example.com/bugreport/',
      team: 'PerfectPixels <info@example.com>'
    }))
    .pipe(gulp.dest('languages'))
    .pipe(browserSync.reload({stream:true}));
});

gulp.task('browserSync', function() {
  browserSync({
    proxy: 'davis.localhost/',
    port: 8080,
    open: true,
    notify: false
  });
});

gulp.task('watch', function () {
  gulp.watch(js_files, ['lint']);
  gulp.watch(js_files, ['compress']);
  gulp.watch(['**/*.php'], ['makepot']);
  gulp.watch('assets/styles/**/*.scss', ['sass']);
});

gulp.task('build-clean', function() {
  del(['dist/**/*']);
});

gulp.task('build-copy', function() {
  return gulp.src(build_files)
    .pipe(gulp.dest('dist/davis'));
});

gulp.task('build-zip', function() {
  del(['dist/davis/dist']);
  return gulp.src('dist/**/*')
    .pipe(zip('davis.zip'))
    .pipe(gulp.dest('dist'));
});

gulp.task('build-delete', function() {
  del(['dist/**/*', '!dist/davis.zip']);
});

gulp.task('build', function(callback) {
  runSequence('build-clean', 'build-copy', 'build-zip', 'build-delete');
});

gulp.task('default', ['sass', 'lint', 'modernizr', 'compress', 'makepot', 'watch', 'browserSync']);
