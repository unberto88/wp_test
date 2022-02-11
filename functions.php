<?php 
	
    
function twc_register_styles() {
	$theme_version = wp_get_theme()->get( 'Version' );
	wp_enqueue_style( 'twentytwenty-style', get_template_directory_uri() . '/style.css', array(), $theme_version );
    wp_enqueue_style( 'twc-style', get_stylesheet_directory_uri() . '/assets/css/main.css', array(), time() );
	global $wp_query;
	if( isset($wp_query->query['post_type']) and $wp_query->query['post_type'] == 'news'){
		wp_enqueue_style( 'owl-carousel-style', get_stylesheet_directory_uri() . '/assets/css/owl.carousel.min.css' );
		wp_enqueue_style( 'owl-theme-style', get_stylesheet_directory_uri() . '/assets/css/owl.theme.default.min.css' );
		
		wp_enqueue_script('owl-carousel-js', get_stylesheet_directory_uri() . '/assets/js/owl.carousel.min.js', array('jquery') );
		wp_enqueue_script('main-js', get_stylesheet_directory_uri() . '/assets/js/main.js', array('jquery') );
	}
}
add_action( 'wp_enqueue_scripts', 'twc_register_styles' );


function twc_init(){
    register_post_type('event', array(
		'labels'             => array(
			'name'               => __('Event', 'twc'), 
			'singular_name'      => __('Event', 'twc'), 
			'add_new'            => __('Add Event', 'twc'), 
			'add_new_item'       => __('Add new Event', 'twc'), 
			'edit_item'          => __('Edit Event', 'twc'), 
			'new_item'           => __('New Event', 'twc'), 
			'view_item'          => __('View Event', 'twc'), 
			'search_items'       => __('Search Events', 'twc'), 
			'not_found'          => __('Event not found', 'twc'), 
			'not_found_in_trash' => __('Event not found in trash', 'twc'), 
			'parent_item_colon'  => '',
			'menu_name'          => __('Events', 'twc')

		),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => true,
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
        'menu_icon'          => 'dashicons-calendar',
		'supports'           => array('title','editor', 'custom-fields')
	) );

	register_post_type('news', array(
		'labels'             => array(
			'name'               => __('News', 'twc'), 
			'singular_name'      => __('News', 'twc'), 
			'add_new'            => __('Add News', 'twc'), 
			'add_new_item'       => __('Add new News', 'twc'), 
			'edit_item'          => __('Edit News', 'twc'), 
			'new_item'           => __('New News', 'twc'), 
			'view_item'          => __('View News', 'twc'), 
			'search_items'       => __('Search News', 'twc'), 
			'not_found'          => __('News not found', 'twc'), 
			'not_found_in_trash' => __('News not found in trash', 'twc'), 
			'parent_item_colon'  => '',
			'menu_name'          => __('News', 'twc')

		),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => true,
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
        'menu_icon'          => 'dashicons-megaphone',
		'supports'           => array('title', 'editor', 'custom-fields')
	) );
}
add_action('init', 'twc_init');



function twc_acf_add_field_groups() {
	acf_add_local_field_group(array(
		'key' => 'events_group',
		'title' => 'Events Group',
		'fields' => array (
			array (
				'key' => 'event_start_date',
				'label' => 'Start Date',
				'name' => 'event_start_date',
                'required' => 1,
				'type' => 'date_picker',
                'wrapper' => array (
                    'width' => '25%',
                ),
                'display_format' => 'd/m/Y',
                'return_format' => 'd/m/Y',
                'first_day' => 1,
            ),
            array (
				'key' => 'event_end_date',
				'label' => 'End Date',
				'name' => 'event_end_date',
                'required' => 0,
				'type' => 'date_picker',
                'wrapper' => array (
                    'width' => '25%',
                ),
                'display_format' => 'd/m/Y',
                'return_format' => 'd/m/Y',
                'first_day' => 1,
			),
            array (
				'key' => 'event_type',
				'label' => 'Event type',
				'name' => 'event_type',
                'required' => 1,
				'type' => 'select',
                'choices' => array(
                    'external'	=> 'External link',
                    'news'	=> 'News'
                ),
                'wrapper' => array (
                    'width' => '25%',
                ),
            ),
            array (
				'key' => 'event_external_link',
				'label' => 'Event external link',
				'name' => 'event_external_link',
                'required' => 0,
				'type' => 'url',
                'conditional_logic' => array(
                    array(
                        array(
                            'field' => 'event_type',
                            'operator' => '==',
                            'value' => 'external',
                        ),
                    ),
                ),
                'wrapper' => array (
                    'width' => '25%',
                ),
            ),
            array (
				'key' => 'event_news',
				'label' => 'Event related news',
				'name' => 'event_news',
                'required' => 0,
				'type' => 'post_object',
                'conditional_logic' => array(
                    array(
                        array(
                            'field' => 'event_type',
                            'operator' => '==',
                            'value' => 'news',
                        ),
                    ),
                ),
                'post_type' => array(
                    0 => 'news',
                ),
                'wrapper' => array (
                    'width' => '25%',
                ),
			)
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'event',
				),
			),
		),
	));
}

add_action('acf/init', 'twc_acf_add_field_groups');



function twc_theme_init() {
    flush_rewrite_rules();
}
add_action('after_switch_theme', 'twc_theme_init');

function twc_rewrite( $vars ) {
    add_rewrite_rule('(event)/(current)/([0-9-]+)/?$', 'index.php?post_type=event&current=$matches[3]', 'top' );
    add_filter( 'query_vars', function( $vars ){
		$vars[] = 'current';
		return $vars;
	} );
}
add_filter( 'init', 'twc_rewrite' );
