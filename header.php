<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="keywords" content="">
<meta name="description" content="">
<meta name="viewport" content="width=device-width">
<title><?php wp_title('|', true, 'right' ); ?></title>
<!--[if lt IE 9]>
    <script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.2/html5shiv-printshiv.min.js"></script>
<![endif]-->
<?php
	// 外部ファイルの依存関係
	do_action('add_enqueue');
	wp_head();
?>
<? do_action('above_head_end_tag'); ?>
</head>
<body <?php body_class(); ?>>
<? do_action('below_body_start_tag'); ?>