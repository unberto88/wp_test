<?php
get_header();
?>

<main id="site-content">

    <div class="section-inner">
	<?php

	if ( have_posts() ) {

		while ( have_posts() ) {
			the_post(); 
            $news_ID = get_the_ID();
            ?>

			<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

                <div class="post-inner">
                    
                    <?php the_title('<h1>', '</h1>'); ?>
                    
                    <?php the_content(); ?>
                
                </div><!-- .post-inner -->

            </article><!-- .post -->
            <?php 
		}
	}

	?>
    </div>

    <div class="section-inner">

    <?php 
    $query = new WP_Query( array(
        'post_type' => 'event',
        'posts_per_page' => -1,
        'meta_query' => array(
            'relation' => 'AND',
            array(
                'key' => 'event_type',
                'compare' => '=',
                'value' => 'News',
            ),
            array(
                'key' => 'event_news',
                'compare' => '=',
                'value' => $news_ID,
            )
        )
    ) );

    if ( $query->have_posts() ) { ?>
        <h4><?php _e('Related events', 'twc'); ?></h4>
        <div class="related-events owl-carousel">
        <?php while ( $query->have_posts() ) { ?>
            <?php $query->the_post(); ?>
            <div class="related-event-item">
                <div class="related-event-title">
                    <?php the_title('<h5>', '</h5>'); ?> 
                </div>
                <div class="related-event-content">
                    <?php echo wp_trim_words( get_the_content(), 20 ); ?>
                </div>
            </div>
        <?php } ?>
        </div>
        <?php wp_reset_postdata(); ?>
        
    <?php } ?>

    </div>

</main><!-- #site-content -->

<?php //get_template_part( 'template-parts/footer-menus-widgets' ); ?>

<?php get_footer(); ?>
