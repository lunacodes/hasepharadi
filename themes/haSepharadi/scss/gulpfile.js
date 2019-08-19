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

gulp.task('sass', function() {
  return gulp
  .src(input)
  .pipe(sourcemaps.init())
  .pipe(sass(sassOptions).on('error', sass.logError))
  // .pipe(autoprefixer(autoprefixerOptions))
  .pipe(autoprefixer(autoprefixerOptions))
  .pipe(sourcemaps.write(output))
  .pipe(gulp.dest('../'))
  // .pipe(sassdoc())
  .resume();
});

gulp.task('sassdoc', function () {
  return gulp
    .src('./**/*.scss')
    .pipe(sassdoc())
    .resume();
});

// exports.sassdoc = function() {
//   return gulp
//   .src('./partials/')
//   .pipe(sassdoc('./partials/'))
//   console.log('Fuck');
//   .resume();
// }

// exports.watch = function(scss) {
// }


gulp.task('watch', function() {
    gulp.watch('./**/*.scss', gulp.series(
      [
        'sass',
        'sassdoc'
      ]
    ));
    //   function() {
    //   console.log('did it work?');
    //   return
    //   // default();
    // });
});

gulp.task('default', gulp.parallel(['watch']))

// gulp.watch('./**/*.scss', ['gulp.default']);
// gulp.watch('./**/*.scss', ['default']);

// semi-working
// exports.watch = function() {
//   gulp.watch('./**/*.scss', function() {
//     console.log('did it work?');
//     default();
//   })
// }
