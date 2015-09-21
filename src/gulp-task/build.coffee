gulp       = require('gulp')
path       = require('path')
del        = require('del')             # ファイルの削除
coffee     = require('gulp-coffee')     # CoffeeScript
compass    = require('gulp-compass')
pleeease   = require('gulp-pleeease')   # CSS便利ツール
plumber    = require('gulp-plumber')    # 監視の停止を防ぐ
notify     = require('gulp-notify')     # 通知
cached     = require('gulp-cached')     # キャッシュ
uglify     = require('gulp-uglify')     # 圧縮
sourcemaps = require('gulp-sourcemaps') # ソースマップ出力
conf       = require('../gulpfile')     # 設定データ

# ==============================================================================
# タスク
# ==============================================================================
build = ->

	# --------------------------------------------------------------------------
	# Compass / Sass
	# --------------------------------------------------------------------------
	_notifyConf = notify.onError({
		title   : 'Compass エラー'
		message : '<%= error.message %>'
		sound   : conf.notify.sound
	})

	_plumberConf = 
		errorHandler : _notifyConf

	gulp
		.src(path.join(conf.path.src.sass,'/**/*.sass'))
		.pipe(plumber(_plumberConf))
		.pipe(compass(conf.compass.build))
		.pipe(pleeease(conf.pleeeaseConf))

	# --------------------------------------------------------------------------
	# Coffee
	# --------------------------------------------------------------------------

	_notifyConf = notify.onError({
		title   : 'Compass エラー'
		message : '<%= error.message %>'
		sound   : conf.notify.sound
	})

	_plumberConf = 
		errorHandler : _notifyConf

	gulp
		.src(path.join(conf.path.src.coffee,'/**/*.coffee'))
		.pipe(plumber(_plumberConf))
		.pipe(sourcemaps.init(conf.sourcemap))
		.pipe(coffee(conf.coffee))
		.pipe(uglify(conf.uglify))
		.pipe(sourcemaps.write('./'))
		.pipe(gulp.dest(conf.path.build.js))

	return

# ==============================================================================
# 監視タスク登録
# ==============================================================================
gulp.task 'build',->
	del.sync(conf.del.area,conf.del.option)
	build()
	return