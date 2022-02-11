<?php
get_header();
?>

<main id="site-content">

    <div id="events-list-page" class="section-inner">
        <h1><?php _e('Events', 'twc')?></h1>
        <?php
        
        $current = ( get_query_var('current') ) ? (int)get_query_var('current') : 0;

        $posts_per_page = 1;

        $args = array(
            'meta_key' => 'event_start_date',
	        'orderby'  => array( 'meta_value_num' => 'ASC' ),
            'post_type' => 'event',
            'posts_per_page' => $posts_per_page,
        );

        $paged_current = ( $current >= 0 ) ? abs($current) + 1 : null;
        $paged_past = ( $current < 0 ) ? abs($current) : null;

        $args_current = array_merge($args, 
            array(
                'paged' => $paged_current,
                'meta_query' => array(
                    'relation' => 'OR',
                    array(
                        'relation' => 'AND',
                        array(
                            'key' => 'event_end_date',
                            'value' => '',
                            'compare' => '==',
                        ),
                        array(
                            'key' => 'event_start_date',
                            'value' => date('Y/m/d'),
                            'compare' => '>=',
                            'type' => 'DATE'
                        ),
                    ),
                    array(
                        'relation' => 'AND',
                        array(
                            'key' => 'event_end_date',
                            'value' => '',
                            'compare' => '!=',
                        ),
                        array(
                            'key' => 'event_end_date',
                            'value' => date('Y/m/d'),
                            'compare' => '>=',
                            'type' => 'DATE'
                        )
                    )
                )
            )
        );
        
        $args_past = array_merge($args, 
            array(
                'paged' => $paged_past,
                'meta_query' => array(
                    'relation' => 'OR',
                    array(
                        'relation' => 'AND',
                        array(
                            'key' => 'event_end_date',
                            'value' => '',
                            'compare' => '==',
                        ),
                        array(
                            'key' => 'event_start_date',
                            'value' => date('Y/m/d'),
                            'compare' => '<',
                            'type' => 'DATE'
                        ),
                    ),
                    array(
                        'relation' => 'AND',
                        array(
                            'key' => 'event_end_date',
                            'value' => '',
                            'compare' => '!=',
                        ),
                        array(
                            'key' => 'event_end_date',
                            'value' => date('Y/m/d'),
                            'compare' => '<',
                            'type' => 'DATE'
                        )
                    )
                )
            )
        );

        $query_current = new WP_Query($args_current); 
        $count_current = $query_current->found_posts;

        $query_past = new WP_Query($args_past); 
        $count_past = $query_past->found_posts;

        //echo 'past:'.$count_past.' - current:'.$count_current;
        
        if( $current >= 0){
            $query = $query_current;
        }else{
            $query = $query_past;
        }

        if ( $query->have_posts() ) {
            while ( $query->have_posts() ) {
                $query->the_post(); ?>

                <article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

                    <div class="post-inner">
                        
                        <h5><a href="<?php the_permalink(); ?>"><?php  the_title(); ?></a></h5>
                        
                        <div class="post-content">

                            <?php echo wp_trim_words( get_the_content(), 100 ); ?>
                        
                        </div>

                        <div class="event-date">
                            <span><?php echo get_field('event_start_date') ?></span>
                            <?php 
                            if(get_field('event_end_date')){ ?>
                                <span><?php echo get_field('event_end_date') ?></span>
                            <?php } ?>
                        </div>
                    
                    </div><!-- .post-inner -->

                </article><!-- .post -->
                <?php 
            } ?>
        
        <?php }else{

            echo '<p>'.__('Events not found', 'twc').'</p>';

        }

        ?>
        
        <?php 
        $current_max = $query_current->max_num_pages;
        $past_max = $query_past->max_num_pages;

        $pagination = '<div class="event-pagination">';
        if( $past_max ){
            for( $p = $past_max; $p > 0; $p-- ){
                if( $current < 0 && $p == abs($current) ){
                    $pagination .= '<span class="current-page">-'.$p.'</span>';
                }else{
                    $pagination .= '<a href="'.site_url( '/event/current/-'.$p ).'">-'.$p.'</a>';
                }
            }
        }
        if( $current == 0 ){
            $pagination .= '<span class="current-page">0</span>';
        }else{
            $pagination .= '<a href="'.site_url( '/event/' ).'">0</a>';
        }
        if( $current_max ){
            for( $p = 1; $p < $current_max; $p++ ){
                if( $current > 0 && $p == abs($current) ){
                    $pagination .= '<span class="current-page">'.$p.'</span>';
                }else{
                    $pagination .= '<a href="'.site_url( '/event/current/'.$p ).'">'.$p.'</a>';
                }
            }
        }
        $pagination .= '</div>';

        echo $pagination;
        ?>
    </div>

</main><!-- #site-content -->

<?php get_footer(); ?>
