// Include gulp
var babelify     = require('babelify'),
    browserify   = require('browserify'),
    changed      = require('gulp-changed'),
    concat       = require('gulp-concat'),
    gulp         = require('gulp'),
    autoprefixer = require('gulp-autoprefixer'),
    jshint       = require('gulp-jshint'),
    livereload   = require('gulp-livereload'),
    merge        = require('merge-stream'),
    sass         = require('gulp-sass'),
    scsslint     = require('gulp-scss-lint'),
    vinylSource  = require('vinyl-source-stream'),
    watchify     = require('watchify');

var SRC = 'src';
var DEST = 'dest';

var isProd = true;
gulp.task('setdev', function () {
  isProd = false;
});

//Copy
gulp.task('copy', function () {
    var source = ['./src/**', '!./src/assets/js/**', '!./src/assets/scss/**', '!./src/style.css'];
    return gulp.src(source)
        .pipe(changed(DEST))
        .pipe(gulp.dest(DEST))
        .pipe(livereload());
});

// Lint Task
var bundler = watchify(browserify({
  entries: ['./src/assets/js/app.js'],
  transform: [babelify],
  debug: true,
  cache: {},
  packageCache: {},
  fullPaths: true
}));

function bundle() {
  return bundler
    .bundle()
    .pipe(vinylSource('app.js'))
    .pipe(gulp.dest('dest/js'))
    .pipe(livereload());
}
bundler.on('update', bundle);

gulp.task('build', function() {
  bundle()
});

// Compile Our Sass
gulp.task('sass', function() {

    var scss = gulp.src('./src/assets/scss/*.scss')
        // .pipe(scsslint())
        .pipe(sass())
        .pipe(autoprefixer());

    var css = gulp.src('./src/style.css');

    return merge(scss, css)
        .pipe(concat('style.css'))
        .pipe(gulp.dest(DEST))
        .pipe(livereload());
});

// Watch Files For Changes
gulp.task('watch', function() {
    livereload.listen();
    gulp.watch('./src/**/*.php', ['copy']);
    gulp.watch('./src/assets/js/**/*.js', ['build']);
    gulp.watch(['./src/assets/scss/**/*.scss', './src/style.css'], ['sass']);
});

// Default Task
gulp.task('dev', ['setdev', 'copy', 'build', 'sass', 'watch']);
gulp.task('default', ['copy', 'build', 'sass']);