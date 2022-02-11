<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
	<div class="post-inner">
		
	<?php 
		if(is_single()){
			the_title('<h1>', '</h1>');
		}else{
			the_title('<h4>', '</h4>');
		}
		the_content(); 
	?>

		
	</div><!-- .post-inner -->
</article><!-- .post -->
