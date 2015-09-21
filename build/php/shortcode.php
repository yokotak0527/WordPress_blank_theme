<?php

namespace theme\shortcode;
use Helper as help;

call_user_func(function(){
	// =========================================================================
	// 画像タグを出力
	// pathを相対パスで書くと
	// [img path="" alt="" theme=""]
	// =========================================================================
	add_shortcode('img',function(){
		extract(shortcode_atts(array(
			'src'   => '',
			'alt'   => '',
			'theme' => 'root'
		),$arg));
		var_dump($path);
	});
});

//// =============================================================================
//// ヘルパーメソッド：src
//// =============================================================================
//function src_func($arg){
//	extract(shortcode_atts(array(
//		'path' => ''
//	),$arg));
//	return src($path,true);
//}


//// =============================================================================
//// ヘルパーメソッド：parent_src
//// =============================================================================
//function parent_src_func($arg){
//	extract(shortcode_atts(array(
//		'path' => ''
//	),$arg));
//	return parent_src($path,true);
//}
//add_shortcode('parent_src','parent_src_func');

//// =============================================================================
//// ヘルパーメソッド：child_src
//// =============================================================================
//function child_src_func($arg){
//	extract(shortcode_atts(array(
//		'target' => '',
//		'path'   => ''
//	),$arg));
//	return child_src($target,$path,true);
//}
//add_shortcode('child_src','child_src_func');

//// =============================================================================
//// ヘルパーメソッド：src
//// =============================================================================
//function usr_img_func($arg){
//	extract(shortcode_atts(array(
//		'theme' => 'exam'
//	),$arg));
//	global $URLs;
//	return $URLs[$theme].USR_DIR.$theme.'/img/';
//}
//add_shortcode('usr_img','usr_img_func');

//// =============================================================================
//// ヘルパーメソッド：url
//// =============================================================================
//function url_func(){
//	return url(true);
//}
//add_shortcode('url','url_func');

//// =============================================================================
//// ヘルパーメソッド：parent_url
//// =============================================================================
//function parent_url_func(){
//	return parent_url(true);
//}
//add_shortcode('parent_url','parent_url_func');

//// =============================================================================
//// ヘルパーメソッド：child_url
//// =============================================================================
//function child_url_func($arg){
//	extract(shortcode_atts(array(
//		'target' => ''
//	),$arg));
//	return child_url($target,true);
//}
//add_shortcode('child_url','child_url_func');

//// =============================================================================
//// 外部PHPファイルを読み込む
//// =============================================================================
//function include_func($arg){
//	extract(shortcode_atts(array(
//		'file'   => '',
//		'target' => 'exam'
//	),$arg));
//	ob_start();
//	include(get_theme_root().'/'.$target.'/'.$file);
//	return ob_get_clean();
//}
//add_shortcode('include','include_func');

//// =============================================================================
//// ページリンク生成 (モジュール：link_list内でのみ機能します。)
//// =============================================================================
//function child_page_list_func($arg){
//	extract(shortcode_atts(array(
//		'parent' => false,
//		'layout' => 'full'
//	),$arg));
//	if(!$parent) return false;
//	// -------------------------------------------------------------------------
//	$parent = get_page($parent);
//	$i;
//	$l;
//	$t;
//	// -------------------------------------------------------------------------
//	// ページリストの設定
//	// -------------------------------------------------------------------------
//	$arr   = array();
//	$pages = get_posts(array(
//		'numberposts' => -1,
//		'post_type'   => 'page',
//		'orderby'     => 'menu_order',
//		'order'       => 'ASC',
//		'post_parent' => $parent->ID
//	));
//	for($i=0,$l=count($pages); $i<$l; $i++){
//		$arr[] = array(
//			'ID'        => $pages[$i]->ID,
//			'title'     => get_the_title($pages[$i]->ID),
//			'permalink' => get_permalink($pages[$i]->ID)
//		);
//	}
//	if($layout == 'half'){
//		$pages     = array();
//		$slice_num = ceil($l / 2);
//		$pages[]   = array_slice($arr,0,$slice_num);
//		$pages[]   = array_slice($arr,$slice_num);
//	}else{
//		$pages = $arr;
//	}
//	// -------------------------------------------------------------------------
//	// $parentに登録されている関連リンクの設定
//	// -------------------------------------------------------------------------
//	$related = array();
//	if(have_rows('page_linked_rep',$parent->ID)){
//		while(have_rows('page_linked_rep',$parent->ID)){ the_row();
//			if(get_sub_field('text') && get_sub_field('url')){
//				$related[] = array(
//					'title'    => get_sub_field('text'),
//					'url'      => get_sub_field('url'),
//					'external' => get_sub_field('external')
//				);
//			}
//		}
//	}
//	// -------------------------------------------------------------------------
//	// 出力
//	// -------------------------------------------------------------------------
//	$cnt  = '';
//	if($layout == 'half'){
//		$cnt .= '<div class="list_set">';
//		for($i=0;$i<2;$i++){
//			$cnt .= '<div class="list"><ul>';
//			for($ii=0,$ll=count($pages[$i]); $ii<$ll; $ii++){
//				$t = $pages[$i][$ii];
//				$cnt .= '<li><a href="'.$t['permalink'].'" class="decor__icon--arrow"><i></i>'.$t['title'].'</a></li>';
//			}
//			$cnt .= '</ul></div>';
//		}
//		$cnt .= '</div>';
//	}else{
//		$cnt .= '<div class="list">';
//		for($i=0,$l=count($pages); $i<$l; $i++){
//			$t = $pages[$i];
//			$cnt .= '<li><a href="'.$t['permalink'].'" class="decor__icon--arrow"><i></i>'.$t['title'].'</a></li>';
//		}
//		$cnt .= '</div>';
//	}
//	// -------------------------------------------------------------------------
//	if(!empty($related)){
//		$cnt .= '<div class="related"><ul>';
//		for($i=0,$l=count($related); $i<$l; $i++){
//			$t = $related[$i];
//			if($t['external']){
//				$cnt .= '<li><a href="'.$t['url'].'" class="decor__icon--external" target="_blank"><i></i>'.$t['title'].'</a></li>';
//			}else{
//				$cnt .= '<li><a href="'.$t['url'].'" class="decor__icon--arrow"><i></i>'.$t['title'].'</a></li>';
//			}
//		}
//		$cnt .= '</ul></div>';
//	}
//	return $cnt;
//}
//add_shortcode('child_page_list','child_page_list_func');

//// =============================================================================
//// アーカイブリスト出力
//// =============================================================================
//function archive_list_func($arg){
//	extract(shortcode_atts(array(
//		'num'      => 5,
//		'cat'      => 'news',
//		'cat_flg'  => false,
//		'root_cat' => true
//	),$arg));
//	// -------------------------------------------------------------------------
//	global $cat_attr_2_col;
//	$catArr = explode(',',$cat);
//	$cat    = '';
//	for($i=0,$l=count($catArr); $i<$l; $i++){
//		$catSlug = $catArr[$i];
//		$_cat    = get_category_by_slug($catSlug);
//		if($i != 0) $cat .= ',';
//		$cat .= $_cat->term_id;
//	}
//	if(isset($post)) $temp = $post;
//	$posts = get_posts(array(
//		'category'    => $cat,
//		'order'       => 'DESC',
//		'numberposts' => $num,
//		'orderby'     => 'date'
//	));
//	if($root_cat == "true"){
//		$root_cat = true;
//	}else if($root_cat == "false"){
//		$root_cat = false;
//	}
//	if($cat_flg == "true"){
//		$cat_flg  = true;
//	}else if($cat_flg == "false"){
//		$cat_flg  = false;
//	}
//	$cnt = '<ul>';
//	foreach($posts as $post){ setup_postdata($post);
//		$cat = get_the_category($post->ID);
//		if($cat[0]->parent && $root_cat) $cat = _get_root_category($cat);
//		$cat   = $cat[0];
//		$color = isset($cat_attr_2_col[$cat->slug]) ? $cat_attr_2_col[$cat->slug] : $cat_attr_2_col['none'];
//		$cnt .= '<li>';
//		$cnt .= '<time>'.get_the_date('Y/m/d',$post->ID).'</time>';
//		if($cat_flg) $cnt .= '<p class="cat" data-color="'.$color.'"><span>'.$cat->cat_name.'</span></p>';
//		$cnt .= '<a href="'.get_permalink($post->ID).'">'.get_the_title($post->ID).'</a>';
//		$cnt .= '</li>';
//	}
//	$cnt .= '</ul>';
//	if(isset($temp)) $post = $temp;
//	return $cnt;
//}
//add_shortcode('archive_list','archive_list_func');
