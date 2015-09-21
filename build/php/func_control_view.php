<?php

namespace theme\control_view;
use Helper as help;

call_user_func(function(){
	// =========================================================================
	// CSS追加
	// =========================================================================
	add_action(
		'admin_head',
		function(){
			echo '<link href="'.help::get_src('css').'admin_custom.css" rel="stylesheet" type="text/css">';
		},
		100
	);

	// =========================================================================
	// ダッシュボート項目追加
	// =========================================================================
	//add_action('wp_dashboard_setup',function(){
	//	wp_add_dashboard_widget(
	//		'example_dashboard_widget',
	//		'オリジナルウィジェット',
	//		function(){
	//			echo "ウィジェットの内容はここに書きます";
	//		}
	//	);
	//});

	// =========================================================================
	// カテゴリーが選択されている記事の並び順修正
	// =========================================================================
	add_action(
		'wp_terms_checklist_args',
		function($args,$post_id = null){
			$args['checked_ontop'] = false;
			return $args;
		}
	);

	// =========================================================================
	// ダッシュボード表示/非表示設定
	// =========================================================================
	add_action(
		'wp_dashboard_setup',
		function(){
			global $wp_meta_boxes;
			$normal_core = &$wp_meta_boxes['dashboard']['normal']['core'];
			$side_core   = &$wp_meta_boxes['dashboard']['side']['core'];
			unset($normal_core['dashboard_right_now']); // 概要
			unset($normal_core['dashboard_activity']);  // アクティビティ
			unset($side_core['dashboard_quick_press']); // クイックドラフト
			unset($side_core['dashboard_primary']);     // ニュース
		}
	);

	// =========================================================================
	// 投稿画面メニュー表示/非表示の設定
	// =========================================================================
	add_action(
		'admin_menu',
		function(){
			remove_meta_box('postcustom',          'post','normal'); // カスタムフィールド
			// remove_meta_box('postexcerpt',         'post','normal'); // 抜粋
			remove_meta_box('commentstatusdiv',    'post','normal'); // ディスカッション
			remove_meta_box('commentsdiv','post',  'normal');        // コメント
			remove_meta_box('trackbacksdiv','post','normal');        // トラックバック
			// remove_meta_box('revisionsdiv','post', 'normal');        // リビジョン
			remove_meta_box('formatdiv','post',    'normal');        // フォーマット
			remove_meta_box('slugdiv','post',      'normal');        // スラッグ
			remove_meta_box('authordiv',           'post','normal'); // 投稿者
			// remove_meta_box('categorydiv',         'post','normal'); // カテゴリー
			remove_meta_box('tagsdiv-post_tag',    'post','normal'); // タグ
		}
	);

	// =========================================================================
	// 固定ページ画面の項目表示/非表示の設定
	// =========================================================================
	add_action(
		'admin_menu',
		function(){
			// remove_meta_box('postcustom',      'page','normal'); // カスタムフィールド
			remove_meta_box('commentstatusdiv','page','normal'); // ディスカッション
			remove_meta_box('commentsdiv',     'page','normal'); // コメント
			remove_meta_box('authordiv',       'page','normal'); // 投稿者
			// remove_meta_box('slugdiv',         'page','normal'); // スラッグ
		}
	);

	// =========================================================================
	// ビジュアルエディタ禁止
	// =========================================================================
	add_filter(
		'user_can_richedit',
		function($r){
			$type = get_current_screen()->id;
			if($type == 'page' || $type == 'post') return false; // 固定ページか投稿
			return $r;
		}
	);

	// =========================================================================
	// 管理画面バーの表示/非表示の設定
	// =========================================================================
	add_action(
		'admin_bar_menu',
		function($wp_admin_bar){
			global $user_ID;
			global $wp_admin_bar;
			get_currentuserinfo();
			//$wp_admin_bar->remove_menu('wp-logo');
			//$wp_admin_bar->remove_menu('comments');
			//$wp_admin_bar->remove_menu('new-content');
			//$wp_admin_bar->remove_menu('new-post');
			//$wp_admin_bar->remove_menu('new-page');
			//$wp_admin_bar->remove_menu('new-user');
			//$wp_admin_bar->remove_node('edit-profile');
			//$wp_admin_bar->remove_node('user-info');
			//if(THEME_NAME == 'recruit'){
			//	$wp_admin_bar->remove_menu('new-content');
			//}
			//// 管理者権限以外の処理
			//if(!current_user_can('level_10')){
			//	$wp_admin_bar->remove_menu('my-account');
			//	$wp_admin_bar->add_menu(array(
			//		'id'    => 'new_item_in_admin_bar',
			//		'title' => __('ログアウト'),
			//		'href'  => wp_logout_url()
			//	));
			//}
			//// ---------------------------------------------------------------------
			//if(1 != $user_ID){
			//	$wp_admin_bar->remove_menu('my-account');
			//	$wp_admin_bar->remove_menu('updates');
			//	$wp_admin_bar->add_menu(array(
			//		'id'    => 'new_item_in_admin_bar',
			//		'title' => __('ログアウト'),
			//		'href'  => wp_logout_url()
			//	));
			//}
		},
		100
	);

	// =========================================================================
	// 管理画面サイドメニュー表示/非表示の設定
	// =========================================================================
	add_action(
		'admin_menu',
		function(){
			// remove_menu_page('index.php');                                     // ダッシュボード
			// remove_submenu_page( 'index.php', 'update-core.php' );             // 更新
			// remove_menu_page('edit.php');                                      // 投稿
			// remove_submenu_page('edit.php','edit-tags.php?taxonomy=category'); // カテゴリー
			// remove_submenu_page('edit.php','edit-tags.php?taxonomy=post_tag'); // 投稿タグ
			// remove_menu_page('upload.php');                                    // メディア
			// remove_menu_page('link-manager.php');                              // リンク
			// remove_menu_page('edit.php?post_type=page');                       // 固定ページ
			remove_menu_page('edit-comments.php');                             // コメント

			// remove_menu_page('themes.php');                                    // 概観
			// remove_menu_page('plugins.php');                                   // プラグイン
			// remove_menu_page('users.php');                                     // ユーザー
			// remove_menu_page('tools.php');                                     // ツール
			// remove_menu_page('options-general.php');                           // 設定
			// -------------------------------------------------------------------------
			// サンプル
			// remove_submenu_page('edit.php?post_type=info','edit-tags.php?taxonomy=sports-facility-tax&amp;post_type=info');
			// remove_menu_page('tools.php');
			// remove_menu_page('edit.php?post_type=api');
			//if(THEME_NAME != 'recruit'){
			//	remove_menu_page('upload.php');                                    // メディア
			//	remove_menu_page('themes.php');                                    // 概観
			//}
		}
	);

	// =========================================================================
	// フッターの設定
	// =========================================================================
	add_filter(
		'admin_footer_text',
		function(){
			// echo '<a href="#">お問い合わせ</a>';
			echo '';
		}
	);
});
