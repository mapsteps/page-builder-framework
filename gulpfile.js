const { src, dest, watch, parallel, series } = require('gulp');
const concat = require('gulp-concat');
const plumber = require('gulp-plumber');
const uglify = require('gulp-uglify');
const sass = require('gulp-dart-sass');
const autoprefixer = require('gulp-autoprefixer');
const rename = require('gulp-rename');
const babel = require('gulp-babel');
const browserSync = require('browser-sync').create();
var manifest = require('./manifest.json');
var config = manifest.config;

function compileStyleSCSS() {
	return src(['assets/scss/style.scss'])
		.pipe(sass({ outputStyle: 'compressed' }))
		.pipe(autoprefixer())
		.pipe(dest('./'))
		.pipe(browserSync.stream());
}

function compilePartialSCSS() {
	return src([
		'assets/scss/*.scss',
		'!assets/scss/style.scss',
		'assets/edd/scss/*.scss',
		'assets/lifterlms/scss/*.scss',
		'assets/woocommerce/scss/*.scss'
	])
		.pipe(sass({ outputStyle: 'compressed' }))
		.pipe(autoprefixer())
		.pipe(rename({
			suffix: '-min'
		}))
		.pipe(dest('css/min'))
		.pipe(browserSync.stream());
}

function buildSiteJS() {
	return src([
		'assets/js/site.js',
		'assets/js/desktop-menu.js',
		'assets/js/mobile-menu.js'
	])
		.pipe(plumber())
		.pipe(concat('site-min.js'))
		.pipe(babel({
			presets: ['@babel/preset-env']
		}))
		.pipe(uglify())
		.pipe(dest('js/min'))
		.pipe(browserSync.reload({ stream: true }));
}

function buildPartialJS() {
	return src([
		'assets/js/*.js',
		'!assets/js/site.js',
		'!assets/js/desktop-menu.js',
		'!assets/js/mobile-menu.js'
	])
		.pipe(plumber())
		.pipe(babel({
			presets: ['@babel/preset-env']
		}))
		.pipe(uglify())
		.pipe(rename({
			suffix: '-min'
		}))
		.pipe(dest('js/min'))
		.pipe(browserSync.reload({ stream: true }));
}

function serveBrowserSync(cb) {
	browserSync.init({
		proxy: config.url,
		ui: {
			port: 3050,
		},
		notify: true,
	});

	cb();
}

function streamAssets(cb) {
	browserSync.stream();
	cb();
}

function reloadStream(cb) {
	browserSync.reload({ stream: true });
	cb();
}

function reloadPage(cb) {
	browserSync.reload();
	cb();
}

function watchChanges(cb) {
	watch(['assets/js/site.js', 'assets/js/desktop-menu.js', 'assets/js/mobile-menu.js'], parallel(buildSiteJS));
	watch(['assets/js/*.js', '!assets/js/site.js', '!assets/js/desktop-menu.js', '!assets/js/mobile-menu.js'], parallel(buildPartialJS));

	watch(['assets/scss/style.scss', 'assets/scss/**/*.scss'], parallel(compileStyleSCSS));
	watch([
		'assets/scss/*.scss',
		'!assets/scss/style.scss',
		'assets/scss/**/*.scss',

		'assets/edd/scss/*.scss',
		'assets/edd/scss/**/*.scss',

		'assets/lifterlms/scss/*.scss',
		'assets/lifterlms/scss/**/*.scss',

		'assets/woocommerce/scss/*.scss',
		'assets/woocommerce/scss/**/*.scss'
	], parallel(compilePartialSCSS));

	watch(['**/*.php', 'assets/img/*'], parallel(reloadPage));

	cb();
}

function mainTasks(cb) {
	buildSiteJS();
	buildPartialJS();
	compileStyleSCSS();
	compilePartialSCSS();

	cb();
}

exports.default = parallel(serveBrowserSync, mainTasks, watchChanges);