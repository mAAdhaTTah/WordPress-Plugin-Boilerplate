var gulp = require('gulp'),
	composer = require('gulp-composer'),
	bower = require('gulp-bower'),
	glob = require('glob'),
	fs = require('fs'),
	Q = require('Q'),
	path = require('path'),
	merge = require('merge-stream'),
	runs = require('run-sequence'),
	concat = require('gulp-concat'),
	uglify = require('gulp-uglify'),
	minify = require('gulp-minify-css'),
	sass = require('gulp-sass'),
	rimraf = require('rimraf'),
	extrep = require('gulp-ext-replace'),
	zip = require('gulp-zip');

gulp.task('default', ['init', 'watch']);

gulp.task('init', function() {
	runs(
		['clean-bower', 'clean-composer'],
		'install',
		['scripts', 'styles', 'packages']
	);
});

gulp.task('watch', function () {
	gulp.watch(
		'assets/js/**',
		['scripts']);
		gulp.watch(
		'assets/scss/**',
		['styles']);
});

gulp.task('build', function() {
	runs(
		'init',
		'copy',
		'zip',
		'clean-build'
	);
});

gulp.task('scripts', function() {
	var promises = [];

	glob.sync('assets/js/*').forEach(function(filePath) {
		if (fs.statSync(filePath).isDirectory()) {
			var defer = Q.defer();
			var pipeline = gulp.src(filePath + '/**/*.js')
				.pipe(concat(path.basename(filePath) + '.js'))
				.pipe(gulp.dest(path.resolve(filePath, '..')))
				.pipe(uglify())
				.pipe(concat(path.basename(filePath) + '.min.js'))
				.pipe(gulp.dest('assets/js'));
			pipeline.on('end', function() {
				defer.resolve();
			});
			promises.push(defer.promise);
		}
	});

	return Q.all(promises);
});

gulp.task('styles', function() {
	return gulp.src('assets/scss/*.scss')
		.pipe(sass())
		.pipe(gulp.dest('assets/css'))
		.pipe(minify())
		.pipe(extrep('.min.css'))
		.pipe(gulp.dest('assets/css'));
});

gulp.task('packages', ['package1']);

gulp.task('package1', function() {
	// Copy or concat your packages
	// and place them in the appropriate assets folder
});

gulp.task('clean-bower', function(cb) {
	rimraf('bower_components', cb);
});

gulp.task('clean-composer', function(cb) {
	rimraf('lib', cb);
});

gulp.task('install', function() {
	return merge(composer({ bin: 'composer' }), bower());
});

gulp.task('copy', function() {
	return gulp.src([
		'./**',
		'!./*.png',
		'!./.*',
		'!./*.json',
		'!./*.lock',
		'!./*.xml',
		'!./gulpfile.js',
		'!./*.sublime-*',
		'!./node_modules/**',
		'!./node_modules/',
		'!./bower_components/**',
		'!./bower_components/',
		'!./test/**',
		'!./test/',
	], { base: './' })
		.pipe(gulp.dest('build'));
});

gulp.task('zip', function() {
	return gulp.src('build/**')
		.pipe(zip('plugin-name.zip'))
		.pipe(gulp.dest('./'));
});

gulp.task('clean-build', function(cb) {
	rimraf('build', cb);
});
