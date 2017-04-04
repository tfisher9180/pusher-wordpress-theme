const themename = 'pusher';

const gulp = require('gulp');
const sass = require('gulp-sass');
const postcss = require('gulp-postcss');
const autoprefixer = require('autoprefixer');
const image = require('gulp-image');
const sourcemaps = require('gulp-sourcemaps');
const newer = require('gulp-newer');

const root = '../' + themename + '/';
const scss = root + 'sass/';
const fonts = root + '/fonts';
const js = root + 'js/';
const img = root + 'images/';
const bower = root + 'bower_components/';
const materialize = bower + 'materialize/';
const jquery = bower + 'jquery/';

gulp.task('materialize-css', () => {
	return gulp.src(materialize + 'dist/css/materialize.min.css')
	.pipe(gulp.dest(root + 'css/'));
});

gulp.task('css', () => {
	return gulp.src(scss + '{style.scss,rtl.scss}')
	.pipe(sourcemaps.init())
	.pipe(sass({
		outputStyle: 'expanded',
		indentType: 'tab',
		indentWidth: '1'
	}).on('error', sass.logError))
	.pipe(postcss([
		autoprefixer('last 2 versions', '> 1%')
	]))
	.pipe(sourcemaps.write(scss + 'maps'))
	.pipe(gulp.dest(root));
});

gulp.task('fonts', () => {
	return gulp.src(materialize + 'fonts/**/*')
	.pipe(gulp.dest(fonts));
});

gulp.task('images', () => {
	return gulp.src(img + 'RAW/**/*.{jpg,JPG,png}')
	.pipe(newer(img))
	.pipe(image())
	.pipe(gulp.dest(img));
});

gulp.task('javascript', () => {
	return gulp.src([materialize + 'dist/js/materialize.min.js', jquery + 'dist/jquery.min.js'])
	.pipe(gulp.dest(root + 'js/'));
});

gulp.task('watch', () => {
	gulp.watch([root + '**/*.css', root + '**/*.scss'], ['css']);
	gulp.watch(js + '**/*.js', ['javascript']);
	gulp.watch(img + 'RAW/**/*.{jpg,JPG,png}', ['images']);
});

gulp.task('default', ['materialize-css', 'fonts', 'javascript', 'watch']);