var gulp = require('gulp');
var plumber = require('gulp-plumber');
var uglify = require('gulp-uglify');
var rename = require('gulp-rename');
var sass = require('gulp-ruby-sass');
var browserSync = require('browser-sync').create();
var reload = browserSync.reload;
var manifest = require('./assets/manifest.json');
var config = manifest.config;


// Scripts Task

// Minify JS
gulp.task('scripts_min', function(){

	gulp.src('assets/js/*.js')
	.pipe(plumber())
	.pipe(uglify())
	.pipe(rename({ suffix: '-min' }))
	.pipe(gulp.dest('js/min'))
	.pipe(reload({ stream: true }))

});

// Styles Task

// Compile Main Styles
gulp.task('styles', function() {

	return sass('assets/scss/style.scss', {
		style: 'compressed' 
	})
	.pipe(gulp.dest(''))
	.pipe(reload({ stream: true }))

});﻿

// Compile Responsive Styles
gulp.task('responsive_styles_min', function() {

	return sass('assets/scss/responsive.scss', {
		style: 'compressed' 
	})
	.pipe(rename({ suffix: '-min' }))
	.pipe(gulp.dest('css/min'))
	.pipe(reload({ stream: true }))

});﻿

// Compile RTL Styles
gulp.task('rtl_styles_min', function() {

	return sass('assets/scss/rtl.scss', {
		style: 'compressed' 
	})
	.pipe(rename({ suffix: '-min' }))
	.pipe(gulp.dest('css/min'))
	.pipe(reload({ stream: true }))

});﻿

// Compile EDD Styles
gulp.task('edd_styles_min', function() {

	return sass('assets/edd/scss/edd.scss', {
		style: 'compressed' 
	})
	.pipe(rename({ suffix: '-min' }))
	.pipe(gulp.dest('css/min'))
	.pipe(reload({ stream: true }))

});﻿

// Compile Woo Styles
gulp.task('woo_styles_min', function() {

	return sass(['assets/woocommerce/scss/woocommerce-layout.scss', 'assets/woocommerce/scss/woocommerce.scss', 'assets/woocommerce/scss/woocommerce-smallscreen.scss'], {
		style: 'compressed' 
	})
	.pipe(rename({ suffix: '-min' }))
	.pipe(gulp.dest('css/min'))
	.pipe(reload({ stream: true }))

});﻿

// Browser Sync
gulp.task('serve', function() {

	browserSync.init( {
		proxy: "http://" + config.url,
		host: config.host,
		notify: false,
	});

});

// Watch Tasks
gulp.task('watch', function() {

	// Styles & Scripts to be watched
	gulp.watch('assets/js/*.js', ['scripts_min']);
	gulp.watch('assets/scss/**/*.scss', ['styles']);
	gulp.watch('assets/scss/**/*.scss', ['responsive_styles_min']);
	gulp.watch('assets/scss/**/*.scss', ['rtl_styles_min']);
	gulp.watch('assets/woocommerce/scss/**/*.scss', ['woo_styles_min']);
	gulp.watch('assets/edd/scss/**/*.scss', ['edd_styles_min']);

	// browserSync
	gulp.watch('**/*.php').on('change', reload);
})

// Gulp
gulp.task('default', ['scripts_min', 'styles', 'responsive_styles_min', 'rtl_styles_min', 'edd_styles_min', 'woo_styles_min', 'watch', 'serve']);