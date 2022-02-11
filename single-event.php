<?php
get_header();
?>

<main id="site-content">

    <div class="section-inner">
	<?php

	if ( have_posts() ) {

		while ( have_posts() ) {
			the_post(); ?>

			<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

                <div class="post-inner">
                    
                    <?php the_title('<h1>', '</h1>'); ?>

                    <div class="event-date">
                        <span><?php echo get_field('event_start_date') ?></span>
                        <?php 
                        if(get_field('event_end_date')){ ?>
                            <span><?php echo get_field('event_end_date') ?></span>
                        <?php } ?>
                    </div>
         
                    <div class="post-content">
                        <?php the_content(); ?>
                    </div>

                    <?php if( get_field('event_external_link') ){ ?>
                        <div class="event-link">
                            <a href="<?php the_field('event_external_link') ?>" target="_blank"><?php _e('More information', 'twc') ?></a>
                        </div>
                    <?php } ?>
                    <?php if( get_field('event_news') ){ ?>
                        <div class="event-link">
                            <a href="<?php echo get_permalink(get_field('event_news')) ?>"><?php _e('More information', 'twc') ?></a>
                        </div>
                    <?php } ?>
                
                </div><!-- .post-inner -->

            </article><!-- .post -->
            <?php 
		}
	}

	?>
    </div>

</main><!-- #site-content -->

<?php get_footer(); ?>
