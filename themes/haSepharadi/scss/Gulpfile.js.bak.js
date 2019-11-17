var gulp = require('gulp');
var sass = require('gulp-sass');
var sourcemaps = require('gulp-sourcemaps');
var autoprefixer = require('gulp-autoprefixer');
var sassdoc = require('sassdoc');
const { watch } = require('gulp');

var input = './style.scss'
var output = './'

var sassOptions = {
  errorLogToConsole: true,
  outputStyle: 'expanded'
};

var autoprefixerOptions = {
  overrideBrowserslist: ['last 2 versions', '>5%', 'Firefox ESR'],
};

exports.default = function() {
  return gulp
  .src(input)
  .pipe(sourcemaps.init())
  .pipe(sass(sassOptions).on('error', sass.logError))
  // .pipe(autoprefixer(autoprefixerOptions))
  .pipe(autoprefixer(autoprefixerOptions))
  .pipe(sourcemaps.write(output))
  .pipe(gulp.dest('../'))
  // .pipe(sassdoc('partials/*'))
  .resume();
};

exports.sassdoc = function() {
  return gulp
  .src(input)
  .pipe(sassdoc())
  .resume();
}

// gulp.watch('./**/*.scss', ['default']);
gulp.watch('./**/*.scss', ['sass']);

// semi-working
// exports.watch = function() {
//   gulp.watch('./**/*.scss', function() {
//     console.log('did it work?');
//     default();
//   })
// }
