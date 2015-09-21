'use strict'
gulp = require('gulp')
path = require('path')
conf = {}

try
	packageJSON = require('./package.json')
catch e
	console.log module.id
	console.log ('↑と同階層にpackage.jsonが見つかりませんでした。')
	process.exit()

conf.projectName = packageJSON.name

# ------------------------------------------------------------------------------
# パスの設定
# プロジェクトディレクトリからの相対パス
# ------------------------------------------------------------------------------
conf.path = {}
conf.path.base = 
	root   : path.join(process.cwd(),'../')           # プロジェクトディレクトリ
	src    : path.join(process.cwd(),'../src/')       # ソースディレクトリ
	build  : path.join(process.cwd(),'../build/')     # 出力先ディレクトリ
	lib    : path.join(process.cwd(),'../lib/')       # 外部ライブラリなど
conf.path.src =
	dir    : conf.path.base.src
	temp   : path.join(conf.path.base.src,'temp')
	sass   : path.join(conf.path.base.src,'sass')
	coffee : path.join(conf.path.base.src,'coffee')
conf.path.lib =
	dir    : conf.path.base.lib
	sass   : path.join(conf.path.base.lib,'sass')
	css    : path.join(conf.path.base.lib,'css')
	coffee : path.join(conf.path.base.lib,'coffee')
	js     : path.join(conf.path.base.lib,'js')
conf.path.build =
	dir    : conf.path.base.build
	font   : path.join(conf.path.base.build,'font')
	php    : path.join(conf.path.base.build,'php')
	img    : path.join(conf.path.base.build,'img')
	js     : path.join(conf.path.base.build,'js')
	css    : path.join(conf.path.base.build,'css')

# ------------------------------------------------------------------------------
# libConf 読み込むライブラリを増やしたい場合はここに追記
# ------------------------------------------------------------------------------
bowerDir          = path.join(conf.path.base.src,'bower_components')
conf.lib          = {}
conf.lib['js']    = []
conf.lib['js'][0] = 
	bundle : 'common_libs.js'
	dest   : conf.path.lib.js
	uglify : true
	path   : 
		'velocity' : path.join(bowerDir,'velocity/velocity.js')
		'lodash'   : path.join(bowerDir,'lodash/lodash.js')

# ------------------------------------------------------------------------------
# delの設定 del
# ------------------------------------------------------------------------------
conf.del = 
	area : [
		path.join(conf.path.base.src,'.sass-cache')
		path.join(conf.path.build.css,'./*')
		path.join(conf.path.build.js,'./*')
	],
	option : 
		force  : true
		ignore : [
			# 無視するディレクトリなど
		]

# ------------------------------------------------------------------------------
# Pleeeaseの設定 gulp-pleeease
# ------------------------------------------------------------------------------
conf.pleeeaseConf =
	autoprefixer   : 
		browsers : ['last 4 version']
		cascade  : true
	filters        : { oldIE : true }
	rem            : true
	opacity        : true
	pseudoElements : true
	mqpacker       : true
	colors         :
		color         : true
		hexAlpha      : true
		hwb           : true
		rebbecapurple : true

# ------------------------------------------------------------------------------
# Sourcemapの設定 // gulp-sourcemap
# ------------------------------------------------------------------------------
conf.sourcemap =
	addComment     : true
	includeContent : false

# ------------------------------------------------------------------------------
# Sassの設定 // gulp-ruby-sass
# ------------------------------------------------------------------------------
conf.compass =
	watch : 
		style       : 'nested'
		sourcemap   : true
		time        : true
		environment : 'development'
		css         : conf.path.build.css
		sass        : conf.path.src.sass
		javascript  : conf.path.build.js
		image       : conf.path.build.img
		font        : conf.path.build.font
		import_path : [
			path.join(conf.path.base.lib,'sass')
			path.join(conf.path.base.lib,'compass')
		]
	build : 
		style       : 'compressed'
		sourcemap   : true
		time        : true
		environment : 'production'
		css         : conf.path.build.css
		sass        : conf.path.src.sass
		javascript  : conf.path.build.js
		image       : conf.path.build.img
		font        : conf.path.build.font
		import_path : [
			path.join(conf.path.base.lib,'sass')
			path.join(conf.path.base.lib,'compass')
		]

# ------------------------------------------------------------------------------
# CoffeeScriptの設定
# ------------------------------------------------------------------------------
conf.coffee =
	bare : false

# ------------------------------------------------------------------------------
# notifyの設定
# ------------------------------------------------------------------------------
conf.notify =
	title   : 'Default Error Title'   # 基本的にタスク内で上書きしてます。
	sound   : 'Pop'

# ------------------------------------------------------------------------------
# uglifyの設定
# ------------------------------------------------------------------------------
conf.uglify =
	mangle : true

module.exports = conf
# ==============================================================================
# タスク読み込み
# ==============================================================================
require('./gulp-task/watch')
require('./gulp-task/build')
require('./gulp-task/libfile')