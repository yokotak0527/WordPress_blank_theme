<?php

class Helper{
	// =========================================================================
	// マルチサイト利用時の角テーマのディレクトリ名
	// =========================================================================
	private static $theme_dir_names = false;
	private static $theme_dir_ID    = false;
	public static function set_blogs($arr){
		Helper::$theme_dir_names = $arr;
	}
	// =========================================================================
	// スラッグを渡すとそのスラッグのIDを返す
	// =========================================================================
	public static function slug2id($val){
		$page = get_page_by_path($val);
		return $page ? $page->ID : false;
	}
	// =========================================================================
	// パスチェック
	// =========================================================================
	public static function check_path(){
		echo '<pre>';
		echo 'EXT_PHP : '.EXT_PHP;
		echo '<br>-----------------------------------------------------<br>';
		echo 'SRC_PATH_BY_ROOT : '.SRC_PATH_BY_ROOT;
		echo '<br>-----------------------------------------------------<br>';
		echo 'SRC_PATH : ' .SRC_PATH;
		echo '<br>-----------------------------------------------------<br>';
		echo 'USER_SRC_PATH : '.USER_SRC_PATH;
		echo '</pre>';
	}
	// =========================================================================
	// HTTPかHTTPSか
	// =========================================================================
	public static function is_http(){
		return isset($_SERVER['HTTPS']) ? false : true;
	}
	public static function is_https(){
		return isset($_SERVER['HTTPS']) ? true : false;
	}
	// =========================================================================
	// 外部ファイルのディレクトリを返す
	// =========================================================================
	// get_theme_root_uri()への負担を軽減
	// -------------------------------------------------------------------------
	private static $src_arr = array();
	private static function is_existing_path($theme_name,$path){
		$arr = Helper::$src_arr;
		if(!isset($arr[$theme_name]) || ( isset($arr[$theme_name]) && !isset($arr[$theme_name][$path]) ) ){
			return false;
		}else{
			return true;
		}
	}
	private static function _get_src($type,$target,$kind){
		$path            = '';
		$base_path       = '';
		$theme_dir_names = Helper::$theme_dir_names;
		$kind            = preg_replace('/\/$/','',$kind);
		if(empty($kind)) $kind = 'default';
		// ユーザーディレクトリの場合
		if(!$target){
			// 一度パスを設定していればそれを利用する
			if($kind == 'default'){
				$path = USER_SRC_PATH;
			}else{
				$path = USER_SRC_PATH.$kind.'/';
			}
			return $path;
		}
		// テーマディレクトリの場合
		else{
			$arr = Helper::$src_arr;
			// 一度パスを設定していればそれを利用する
			if(Helper::is_existing_path($target,$kind)){
				$path = Helper::$src_arr[$target][$kind];
			}
			// パスがなければ追加
			else{
				if($kind == 'default'){
					$path = get_theme_root_uri().'/'.$target.EXT_FILE_DIR;
				}else{
					$path = get_theme_root_uri().'/'.$target.EXT_FILE_DIR.$kind.'/';
				}
				if(!isset($arr[$target])) $arr[$target] = array();
				$arr[$target][$kind] = $path;
				Helper::$src_arr     = $arr;
			};
			return $path;
		}
	}
	// -------------------------------------------------------------------------
	// 自身のテーマ内の外部ファイル置き場を返す
	// -------------------------------------------------------------------------
	public static function src($kind = 'default'){
		$dir_arr = Helper::$theme_dir_names;
		echo Helper::_get_src('theme',$dir_arr['this'],$kind);
	}
	public static function get_src($kind = 'default'){
		$dir_arr = Helper::$theme_dir_names;
		return Helper::_get_src('theme',$dir_arr['this'],$kind);
	}
	// -------------------------------------------------------------------------
	// 親テーマ内の外部ファイル置き場を返す
	// -------------------------------------------------------------------------
	public static function parent_src($kind = 'default'){
		$dir_arr = Helper::$theme_dir_names;
		echo Helper::_get_src('theme',$dir_arr['root'],$kind);
	}
	public static function get_parent_src($kind = 'default'){
		$dir_arr = Helper::$theme_dir_names;
		return Helper::_get_src('theme',$dir_arr['root'],$kind);
	}
	// -------------------------------------------------------------------------
	// 子テーマ内の外部ファイル置き場を返す
	// -------------------------------------------------------------------------
	public static function child_src($target = false,$kind = 'default'){
		$dir_arr = Helper::$theme_dir_names;
		echo Helper::_get_src('theme',$dir_arr[$target],$kind);
	}
	public static function get_child_src($target = false,$kind = 'default'){
		$dir_arr = Helper::$theme_dir_names;
		return Helper::_get_src('theme',$dir_arr[$target],$kind);
	}
	// -------------------------------------------------------------------------
	// テーマ外の外部ファイル置き場を返す
	// -------------------------------------------------------------------------
	public static function user_src($kind = 'default'){
		echo Helper::_get_src('user',false,$kind);
	}
	public static function get_user_src($kind){
		return Helper::_get_src('user',false,$kind);
	}
	// =========================================================================
	// URLを返す
	// =========================================================================
	private static $site_url = array();
	private static function _url($target){
		$url = Helper::$site_url;
		if(!isset($url[$target])){
			if($target == 'this'){
				$path = get_home_url();
			}elseif($target == 'root'){
				$path = preg_replace('/\/$/','',network_home_url());
			}else{
				$path = get_home_url( get_id_from_blogname($target) );
			}
			$url[$target]     = $path;
			Helper::$site_url = $url;
		}else{
			$path = $url[$target];
		}
		return $path.'/';
	}
	// -------------------------------------------------------------------------
	public static function url(){
		echo Helper::_url('this');
	}
	public static function get_url(){
		return Helper::_url('this');
	}
	public static function parent_url(){
		echo Helper::_url('root');
	}
	public static function get_parent_url(){
		return Helper::_url('root');
	}
	public static function child_url($theme){
		echo Helper::_url($theme);
	}
	public static function get_child_url($theme){
		return Helper::_url($theme);
	}
	// =========================================================================
	// 固定ページの一番上のページ(ルートとなるページ)のオブジェクトを返す
	// 引数にはページオブジェクトか、ページID
	// =========================================================================
	// Object = get_root_page($id : Int / Object)
	public static function get_root_page($id){
		$page = get_page($id);
		while($page->post_parent) $page = get_page($page->post_parent);
		return $page;
	}
	// =========================================================================
	// 固定ページの一番上のページ(ルートとなるページ)のスラッグを返す
	// 引数にはページオブジェクトか、ページID
	// =========================================================================
	// String = get_root_page_slug($id : Int / Object)
	public static function get_root_page_slug($id){
		$page = get_page($id);
		while($page->post_parent) $page = get_page($page->post_parent);
		return $page->post_name;
	}
	// =========================================================================
	// ルートカテゴリを返す
	// 引数にはカテゴリオブジェクトか、カテゴリオブジェクトの配列
	// =========================================================================
	// Array / Object = get_root_category( $cat : Array / Object )
	public static function get_root_category($cat){
		// 配列の場合
		if(is_array($cat)){
			$cnt = count($cat);
			for($i = 0;$i<$cnt;$i++){
				while($cat[$i]->parent) $cat[$i] = get_category($cat[$i]->parent);
			}
		}
		// カテゴリーオブジェクトの場合
		elseif(is_object($cat)){
			while($cat->parent) $cat = get_category($cat->parent);
		}
		return $cat;
	}
	// =========================================================================
	// 引数で指定したページからそのページのルートとなるページまでの情報を配列で返す
	// デフォルトでは最後に配列を反転させるのでルートページ->指定したページの順の配列になる
	// =========================================================================
	public static function get_page_history($id,$reverse=true){
		$setArr = function($child){
			$result_arr = array(
				'id'         => $child->ID,
				'post_name'  => $child->post_name,
				'post_title' => $child->post_title,
				'permalink'  => get_permalink($child->ID)
			);
			return apply_filters('get_page_history_format',$result_arr,$child);
		};
		// ---------------------------------------------------------------------
		$page  = get_page($id);
		$arr   = array($setArr($page));
		while($page->post_parent){
			$page  = get_page($page->post_parent);
			$arr[] = $setArr($page);
		}
		return $reverse ? array_reverse($arr) : $arr;
	}
	// =========================================================================
	//
	// =========================================================================
	public static function get_category_history($id,$reverse=true){
		$setArr = function($cat){
			$result_arr = array(
				'id'   => $cat->term_id,
				'name' => $cat->name,
				'slug' => $cat->slug
			);
			return apply_filters('get_category_history_format',$result_arr,$cat);
		};
		// ---------------------------------------------------------------------
		$cat = get_category($id);
		$arr = array($setArr($cat));
		while($cat->parent){
			$cat   = get_category($cat->parent);
			$arr[] = $setArr($cat);
		}
		return $reverse ? array_reverse($arr) : $arr;
	}
	// =========================================================================
	// ポストタイプの判定
	// =========================================================================
	// String = is_post_type( $name : String )
	public static function is_post_type($name){
		if(get_post_type() == $name) return true;
		return false;
	}
	// =========================================================================
	// シングルページのポストタイプの判定
	// =========================================================================
	// String = is_single_type( $name : String )
	public static function is_single_type($name){
		if(is_single() && Helper::is_post_type($name)) return true;
		return false;
	}
	// =========================================================================
	// アーカイブページのポストタイプの判定
	// =========================================================================
	// String = is_archive_type( $name : String )
	public static function is_archive_type($name){
		if(is_archive() && Helper::is_post_type($name)) return true;
		return false;
	}
	// =========================================================================
	// 指定された親カテゴリに属するか否か
	// 引数には親となるカテゴリのオブジェクトかカテゴリーID、スラッグを指定する
	// =========================================================================
	// Boolean = is_parent_cateogory($parent : Object | Int | String)
	public static function is_parent_cateogory($parent){
		if(is_string($parent)){
			$parent = get_category_by_slug($parent);
		}elseif(is_int($parent)){
			$parent = get_category($parent);
		}

		if(is_object($parent)){
			$parnet    = $parent->term_id;
			$post_cats = get_the_category();
			foreach($post_cats as $post) if( cat_is_ancestor_of( $parent, $post->term_id ) ){ return true; }
		}
		return false;
	}
	// =========================================================================
	// 指定された固定ページの親子関係か否か
	// 引数には親となる固定ページのURIをルートから指定する
	// 例えば、/sample/child/child-in-child で使用した場合
	// Helper::in_page('sample')       // -> true
	// Helper::in_page('sample/child') // -> true
	// Helper::in_page('child')        // -> false
	// =========================================================================
	// Boolean = in_page($val : String)
	public static function in_page($val = ''){
		if(!is_page()) return false;
		global $post;
		$val     = preg_replace('/\/$/', '', $val);
		$val     = preg_replace('/^\//', '', $val);
		$valArr  = preg_split("/\//", $val);
		$slugArr = array();
		$not     = false;
		$page    = get_page($post->ID);
		while($page->post_parent){
			$page      = get_page($page->post_parent);
			$slugArr[] = $page->post_name;
		}
		$slugArr = array_reverse($slugArr);
		for($i=0,$l=count($valArr); $i<$l ;$i++){
			if(!isset($slugArr[$i]) || $slugArr[$i] != $valArr[$i]) $not = true;
		}
		if($not){
			return false;
		}else{
			return true;
		}
	}
	// =========================================================================
	// 子ページか否か
	// =========================================================================
	// Boolean = in_subpage()
	public static function is_subpage(){
		global $post;
		if(is_page() && $post->post_parent){
			$parentID   = $post->post_parent;
			$parentSlug = get_page_uri($parentID);
			return true;
		}else{
			return false;
		}
	}
	// =========================================================================
	// 子ページを持っているか否か
	// =========================================================================
	public static function has_subpage($other=false){
		global $post;
		$temp     = $post;
		$post     = $other ? $other : $post;
		$children = get_pages('child_of='.$post->ID);
		$post     = $temp;
		if(count($children) != 0){
			return true;
		}else{
			return false;
		}
	}
	// =========================================================================
	// wp_enqueue_styleのヘルパー
	// =========================================================================
	private static $break_points = false;
	public static function set_break_point($arr){
		Helper::$break_points = $arr;
	}
	public static function enqueue_style_custom($label,$pass,$dependency,$size){
		$break_points = Helper::$break_points;
		if(is_array($break_points)){
			$size = $break_points[$size];
			wp_enqueue_style($label,$pass,$dependency,'1.0.0',$size);
		}
	}
}