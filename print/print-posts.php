<?php
/*
+----------------------------------------------------------------+
|																 |
|	WordPress 2.7 Plugin: WP-Print 2.50							 |
|	Copyright (c) 2008 Lester "GaMerZ" Chan						 |
|																 |
|	File Written By:											 |
|	- Lester "GaMerZ" Chan										 |
|	- http://lesterchan.net										 |
|																 |
|	File Information:											 |
|	- Printer Friendly Post/Page Template						 |
|	- wp-content/plugins/wp-print/print-posts.php				 |
|																 |
+----------------------------------------------------------------+
*/
?>

<?php global $text_direction; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head>
	<title><?php bloginfo('name'); ?> <?php wp_title(); ?></title>
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
	<meta name="Robots" content="noindex, nofollow" />
	<?php if(@file_exists(TEMPLATEPATH.'/print-css.css')): ?>
		<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/print-css.css" type="text/css" media="screen, print" />
	<?php else: ?>
		<link rel="stylesheet" href="<?php echo plugins_url('wp-side-comments/print/print-css.css'); ?>" type="text/css" media="screen, print" />
	<?php endif; ?>
	<?php if('rtl' == $text_direction): ?>
		<?php if(@file_exists(TEMPLATEPATH.'/print-css-rtl.css')): ?>
			<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/print-css-rtl.css" type="text/css" media="screen, print" />
		<?php else: ?>
			<link rel="stylesheet" href="<?php echo plugins_url('wp-side-comments/print/print-css-rtl.css'); ?>" type="text/css" media="screen, print" />
		<?php endif; ?>
	<?php endif; ?>
</head>
<body>
<p style="text-align: center;"><strong>- <?php bloginfo('name'); ?> - <span dir="ltr"><?php bloginfo('url')?></span> -</strong></p>
<div class="Center">
	<div id="Outline">
		<?php if (have_posts()): ?>
			<?php while (have_posts()): the_post(); ?>
					<p id="BlogTitle"><?php the_title(); ?></p>
					<p id="BlogDate"><?php _e('Postado por', 'wp-side-comments'); ?> <u><?php the_author(); ?></u> <?php _e('em', 'wp-side-comments'); ?> <?php the_time(sprintf(__('%s @ %s', 'wp-side-comments'), get_option('date_format'), get_option('time_format'))); ?> <?php _e('na', 'wp-side-comments'); ?> <?php print_categories('<u>', '</u>'); ?> | <u><a href='#comments_controls'><?php print_comments_number(); ?></a></u></p>
					<div id="BlogContent"><?php 
						$regex = '|(<p)[^>]*(>)|';
						$paragraphs = preg_split($regex, print_content(false));
						
						global $CTLT_WP_Side_Comments;
						if(!is_object($CTLT_WP_Side_Comments))
						{
							$CTLT_WP_Side_Comments = new CTLT_WP_Side_Comments();
						}
						
						$sidecomments = $CTLT_WP_Side_Comments->getCommentsData(get_the_ID());
						if(is_array($sidecomments) && array_key_exists('comments', $sidecomments) && is_array($sidecomments['comments']))
						{
							$sidecomments = $sidecomments['comments'];
						}
						else 
						{
							$sidecomments = array();
						}
						
						for($i = 1; $i < count($paragraphs); $i++)
						{
							echo sprintf( '<p class="commentable-section" data-section-id="%d">', $i).$paragraphs[$i];
							//echo print_r();
							if(array_key_exists($i, $sidecomments))
							{
								$comments = $sidecomments[$i];
								$comment_template = print_template_comments();
								require $comment_template;
							}
							?>
							<hr class="Divider" style="text-align: center;" /><?php
						}
						
						?>
					</div>
			<?php if(print_can('comments')): ?>
				<?php //comments_template(); ?>
			<?php endif; ?>
			<p><?php _e('Postagem impressa de', 'wp-side-comments'); ?> <?php bloginfo('name'); ?>: <strong dir="ltr"><?php bloginfo('url'); ?></strong></p>
			<p><?php _e('URL da Postagem', 'wp-side-comments'); ?>: <strong dir="ltr"><?php the_permalink(); ?></strong></p>
			<?php if(print_can('links')): ?>
				<p><?php print_links(); ?></p>
			<?php endif;
			endwhile; ?>
			<p style="text-align: <?php echo ('rtl' == $text_direction) ? 'left' : 'right'; ?>;" id="print-link"><?php _e('Click', 'wp-side-comments'); ?> <a href="#Print" onclick="window.print(); return false;" title="<?php _e('Click aqui para imprimir.', 'wp-side-comments'); ?>"><?php _e('aqui', 'wp-side-comments'); ?></a> <?php _e('para imprimir.', 'wp-side-comments'); ?></p>
		<?php else: ?>
				<p><?php _e('Não há Postagems relacionadas a esse critério.', 'wp-side-comments'); ?></p>
		<?php endif; ?>
	</div>
</div>
</body>
</html>