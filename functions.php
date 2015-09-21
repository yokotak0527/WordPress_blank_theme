<?php
// =============================================================================
// 注意
// =============================================================================
// ■ robots.txtを追加する場合は・・・
// 　 外部ファイル出力ディレクトリ/php/func_setting.php
// 　 を変更してください。
// 
// ■ マルチサイトを利用する場合は・・・
// 　 下記$dir_namesに追加してください。

// =============================================================================
// グローバル変数
// =============================================================================
$THEME_DIR_NAMES;

call_user_func(function(){
	global $THEME_DIR_NAMES;
	// =========================================================================
	// 定数
	// =========================================================================
	define('DOMAIN',$_SERVER['SERVER_NAME']);
	define('PROTOCOL',isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] ? 'https://' : 'http://');
	// パス周りは構成により適宜変更
	$dir_names = array(
		// name => dir_name
		'root'  => 'blank_v150825',
		'this'  => 'blank_v150825',
		// 'child' => 'child'
	);
	if(defined('MULTISITE') && MULTISITE && defined('THEME_NAME')){
		$dir_names['this'] = THEME_NAME;
	}else{
		// マルチサイト化していないもしくは親テーマの場合は
		define('THEME_NAME',$dir_names['root']);
	}
	// テーマディレクトリ名
	define('THEME_DIR_NAME',$dir_names['this']);
	// 外部ファイルが入っているディレクトリ"/"で挟む。テーマディレクトリからの相対パス
	define('EXT_FILE_DIR','/build/');
	// ヘルパーメソッドなどへのパス (基本的には親テーマの中に存在)
	$path = get_theme_root().'/'.$dir_names['root'].EXT_FILE_DIR;
	define('EXT_PHP',$path);
	// 外部ファイル置き場のパス (ルート)
	$path = get_theme_root().'/'.THEME_DIR_NAME.EXT_FILE_DIR;
	define('SRC_PATH_BY_ROOT',$path);
	// 外部ファイル置き場のパス
	$path = get_theme_root_uri().'/'.THEME_DIR_NAME.EXT_FILE_DIR;
	define('SRC_PATH',$path);
	// テーマ外にある外部ファイル置き場のパス
	define('USER_SRC_PATH','/user-src/'.THEME_DIR_NAME.'/');
	// =========================================================================
	// 外部ファイル
	// =========================================================================
	$path = EXT_PHP.'php/';
	set_include_path(get_include_path().PATH_SEPARATOR.$path);
	// =========================================================================
	$THEME_DIR_NAMES = $dir_names;
});

require_once('class/Helper.php');      // ヘルパーメソッド
Helper::set_blogs($THEME_DIR_NAMES);
require_once('func_setting.php');      // WordPressの設定
require_once('func_control_view.php'); // 管理画面
require_once('func_customs.php');      // カスタム投稿タイプ、タクソノミー
require_once('func_thumbnail.php');    // サムネイル
require_once('func_widget.php');       // ウィジェット
require_once('shortcode.php');         // ショートコード

// マルチサイト化しており子テーマから呼ばれた場合のみ実行する処理
if(defined('MULTISITE') && MULTISITE && $THEME_DIR_NAMES['root'] != $THEME_DIR_NAMES['this']){
	do_action('after_parent_setup');
}