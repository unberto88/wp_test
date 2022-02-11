<?php
get_header();
?>

<main id="site-content">

    <div class="section-inner">
        <h2><?php _e('Current events', 'twc') ?></h2>
        <?php
        $query = new WP_Query( array(
            'post_type' => 'event',
            'posts_per_page' => 5,
            'meta_query' => array(
                'relation' => 'OR',
                array(
                    'relation' => 'AND',
                    array(
                        'key' => 'event_end_date',
                        'value' => '',
                        'compare' => '=',
                    ),
                    array(
                        'key' => 'event_start_date',
                        'value' => date('Y/m/d'),
                        'compare' => '>=',
                        'type' => 'DATE'
                    ),
                    array(
                        'key' => 'event_start_date',
                        'value' => date('Y/m/d', time() + 86400),
                        'compare' => '<=',
                        'type' => 'DATE'
                    )
                ),
                array(
                    'relation' => 'AND',
                    array(
                        'key' => 'event_end_date',
                        'value' => '',
                        'compare' => '!=',
                    ),
                    array(
                        'key' => 'event_start_date',
                        'value' => date('Y/m/d'),
                        'compare' => '<=',
                        'type' => 'DATE'
                    ),
                    array(
                        'key' => 'event_end_date',
                        'value' => date('Y/m/d'),
                        'compare' => '>=',
                        'type' => 'DATE'
                    )
                ),
            ),
            'meta_key' => 'event_start_date',
	        'orderby'  => array( 'meta_value_num' => 'ASC' ),
        ) );
        if ( $query->have_posts() ) { ?>
            <div class="event-list">
            <?php 
                while ( $query->have_posts() ) {
                    $query->the_post(); ?>
                    <article id="post-<?php the_ID(); ?>">
                        <div class="post-title">
                            <h5><a href="<?php the_permalink(); ?>"><?php  the_title(); ?></a></h5>
                        </div>
                        <div class="event-date">
                            <span><?php echo get_field('event_start_date') ?></span>
                            <?php 
                            if(get_field('event_end_date')){ ?>
                                <span><?php echo get_field('event_end_date') ?></span>
                            <?php } ?>
                        </div>
                        <div class="post-content">
                            <?php echo wp_trim_words( get_the_content(), 20 ); ?>
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

                    </article>
                    
            <?php } ?>
            </div>
            <?php 
        }else{
            echo '<p>'.__('No events today', 'twc').'</p>';
        }
        wp_reset_postdata();
        ?>
        <div class="event-page-link">
            <a href="<?php echo site_url('/event/'); ?>"><?php _e('View all events', 'twc'); ?></a>
        </div>
    </div>

</main><!-- #site-content -->

<?php get_footer(); ?>
