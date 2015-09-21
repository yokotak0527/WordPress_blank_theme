gulp               = require('gulp')
path               = require('path')
compass            = require('gulp-compass')
coffee             = require('gulp-coffee')     # CoffeeScript
pleeease           = require('gulp-pleeease')   # CSS便利ツール
plumber            = require('gulp-plumber')    # 監視の停止を防ぐ
notify             = require('gulp-notify')     # 通知
# changed           = require 'gulp-changed'    # 変更されたファイルだけストリームに出す
cached             = require ('gulp-cached')    # キャッシュ
sourcemaps         = require('gulp-sourcemaps') # ソースマップ出力
conf               = require('../gulpfile')     # 設定データ

# ==============================================================================
# タスク
# ==============================================================================
# Sass
# ------------------------------------------------------------------------------
sassBuild = (_type,_path)->

	_notifyConf = notify.onError({
		title   : 'Compass エラー'
		message : '<%= error.message %>'
		sound   : conf.notify.sound
	})

	_plumberConf = 
		errorHandler : _notifyConf

	return gulp
		.src(_path)
		# .pipe(cached('sass'))
		.pipe(plumber(_plumberConf))
		.pipe(compass(conf.compass.watch))
		.pipe(pleeease(conf.pleeeaseConf))

# ------------------------------------------------------------------------------
# Coffee
# ------------------------------------------------------------------------------
coffeeBuild = (_type,_path)->

	_notifyConf = notify.onError({
		title   : 'CoffeeScript エラー'
		message : '<%= error.message %>'
		sound   : conf.notify.sound
	})

	_plumberConf = 
		errorHandler : _notifyConf

	return gulp
		.src(path.join(conf.path.src.coffee,'/**/*.coffee'))
		.pipe(plumber(_plumberConf))
		.pipe(sourcemaps.init(conf.sourcemap))
		.pipe(coffee(conf.coffee))
		.pipe(sourcemaps.write('./'))
		.pipe(gulp.dest(conf.path.build.js))

# ==============================================================================
# 監視タスク登録
# ==============================================================================
gulp.task('watch',()->
	_path = 
		sass   : path.join(conf.path.src.sass,'/**/*.sass')
		coffee : path.join(conf.path.src.coffee,'/**/*.coffee')
	# --------------------------------------------------------------------------
	# Sass
	# --------------------------------------------------------------------------
	gulp.watch(_path.sass,(e)->
		sassBuild(e.type,e.path)
		return
	)
	# --------------------------------------------------------------------------
	# CoffeeScript
	# --------------------------------------------------------------------------
	gulp.watch(_path.coffee,(e)->
		coffeeBuild(e.type,e.path)
		return
	)
	return
)