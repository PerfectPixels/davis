'use strict';

var gulp         = require('gulp');
var sass         = require('gulp-sass');
var autoprefixer = require('gulp-autoprefixer');
var rename       = require('gulp-rename');
var uglify       = require('gulp-uglify');
var jshint       = require('gulp-jshint');
var stylish      = require('jshint-stylish');
var wpPot        = require('gulp-wp-pot');
var sort         = require('gulp-sort');
var gcmq         = require('gulp-group-css-media-queries');
var del          = require('del');
var zip          = require('gulp-zip');
var browserSync = require('browser-sync');
var runSequence  = require('run-sequence');
var js_files     = ['js/*.js', '!js/*.min.js', '!js/lib/**/*.js'];

var build_files = [
  '**',
  '!node_modules',
  '!node_modules/**',
  '!build',
  '!build/**',
  '!sass',
  '!sass/**',
  '!.git',
  '!.git/**',
  '!package.json',
  '!.gitignore',
  '!gulpfile.js',
  '!.editorconfig',
  '!.jshintrc'
];

gulp.task('sass', function () {
  gulp.src(['sass/style.scss'])
    .pipe(sass({outputStyle: 'expanded'}))
    .pipe(autoprefixer(['last 2 versions']))
    .pipe(gcmq())
    .pipe(gulp.dest('.'))
    .pipe(browserSync.reload({stream:true}));
});

gulp.task('lint', function() {
  return gulp.src(js_files)
    .pipe(jshint())
    .pipe(jshint.reporter(stylish));
});

gulp.task('compress', function() {
  return gulp.src(js_files, {base: '.'})
    .pipe(gulp.dest('.'))
    .pipe(uglify())
    .pipe(rename({extname: '.min.js'}))
    .pipe(gulp.dest('.'));
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
    .pipe(gulp.dest('languages'));
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
  gulp.watch('sass/**/*.scss', ['sass']);
});

gulp.task('build-clean', function() {
  del(['dist/**/*']);
});

gulp.task('build-copy', function() {
  return gulp.src(build_files)
    .pipe(gulp.dest('dist/davis'));
});

gulp.task('build-zip', function() {
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

gulp.task('default', ['sass', 'lint', 'compress', 'makepot', 'watch', 'browserSync']);
