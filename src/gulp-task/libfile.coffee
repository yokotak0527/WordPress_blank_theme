gulp   = require('gulp')
path   = require('path')
concat = require('gulp-concat')
uglify = require('gulp-uglify')
conf   = require('../gulpfile')

# ==============================================================================
# 監視タスク登録
# ==============================================================================
gulp.task 'getlibfile',->
	libs   = conf.lib.js
	libArr = []

	for lib in libs
		libArr = []
		for key,val of lib.path
			libArr.push(val)
		if lib.uglify
			return gulp
				.src(libArr)
				.pipe(concat(lib.bundle))
				.pipe(uglify({preserveComments:'some'}))
				.pipe(gulp.dest(lib.dest))
		else
			return gulp
				.src(libArr)
				.pipe(concat(lib.bundle))
				.pipe(uglify({preserveComments:'some'}))
				.pipe(gulp.dest(lib.dest))