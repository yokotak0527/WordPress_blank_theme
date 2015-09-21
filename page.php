<?php get_header(); ?>
<?php
	use Helper as help;
	help::url();
	echo '<br>';
	help::url();
	echo '<br>';
	help::child_url('this');
?>
<?php get_footer(); ?>