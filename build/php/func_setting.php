<?php

namespace theme\setting;
use Helper as help;

call_user_func(function(){
	// =========================================================================
	// robots.txtの追加設定
	// =========================================================================
	//add_filter('robots_txt','addRobotsTxt');
	//function addRobotsTxt($output){
	//	$output .= "Disallow: robots.txt\n";
	//	return $output;
	//}

	// =========================================================================
	// ブレイクポイントの設定
	// =========================================================================
	// CSSファイルの読み込みにブレイクポイントが必要であれば利用。
	// wp_enqueue_styleの代わりに
	// help::enqueue_style_custom($label,$pass,$dependency,$size)
	// を使用すること

	// help::set_break_point(array(
	// 	'large' => 'screen and (min-width: 500px)',
	// 	'small' => 'screen and (max-width: 500px)'
	// ));

	// =========================================================================
	// 管理バーの非表示
	// =========================================================================
	// add_filter( 'show_admin_bar', '__return_false' );
	// =========================================================================
	// 各種サポート
	// =========================================================================
	// add_theme_support('custom-header');        // カスタムヘッダー
	// add_theme_support('menus');                // ナビゲーションメニュー
	// add_theme_support('post-thumbnails');      // アイキャッチ画像
	// add_theme_support('post-formats',array()); // 投稿フォーマット
	// add_theme_support('editor-style');         // エディタスタイル
	// =========================================================================
	// 不要なメタタグの削除
	// =========================================================================
	remove_action('wp_head','wp_generator');
	remove_action('wp_head','index_rel_link');
	remove_action('wp_head','parent_post_rel_link',10);
	remove_action('wp_head','start_post_rel_link',10);
	remove_action('wp_head','adjacent_posts_rel_link',10);
	remove_action('wp_head','rsd_link');
	remove_action('wp_head','wlwmanifest_link');
	// =========================================================================
	// 自動で挿入されるpタグを削除
	// =========================================================================
	add_filter(
		'the_content',
		function($content){
			global $post;
			// 投稿タイプ別に削除
			if(is_page()) remove_filter('the_content','wpautop');
			// <!--handmade-->を入れると削除
			if(preg_match('|<!--handmade-->|siu',$content)) remove_filter('the_content','wpautop');
			return $content;
		},
		5
	);
	remove_filter('the_excerpt','wpautop');
	// =========================================================================
	// 時間設定
	// =========================================================================
	// date_default_timezone_set('Asia/Tokyo');

});
