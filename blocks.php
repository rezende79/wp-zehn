<?php
function wptest_block_category( $categories, $post ) {
	return array_merge(
		$categories,
		array(
			array(
				'slug' => 'wptest',
				'title' => 'WP-Test',
			),
		)
	);
}
add_filter( 'block_categories', 'wptest_block_category', 10, 2);

function wptest_block_editor_style() {
    wp_enqueue_style( 'icomoon_style_block_css', get_template_directory_uri() . '/assets/fonts/icomoon/style.css' );
	wp_enqueue_style( 'bootstrap_style_block_css', get_template_directory_uri() . '/assets/css/bootstrap.min.css' );
	wp_enqueue_style( 'jquery_style_block_css', get_template_directory_uri() . '/assets/css/jquery-ui.css' );
	wp_enqueue_style( 'flaticon_style_block_css', get_template_directory_uri() . '/assets/fonts/flaticon/font/flaticon.css' );
    wp_enqueue_style( 'css_style_block_css', get_template_directory_uri() . '/assets/css/style.css' );
    wp_enqueue_style( 'style_block_css', get_template_directory_uri() . '/style.css' );
}
add_action( 'enqueue_block_assets', 'wptest_block_editor_style' );

function wptest_block_render_callback( $block, $content = '', $is_preview = false ) {
	$slug = str_replace('acf/', '', $block['name']);
	$context = Timber::context();
    $context['block'] = $block;
    $context['fields'] = get_fields();
    $context['is_preview'] = $is_preview;
    Timber::render( 'views/blocks/'.$slug.'.twig', $context );	
}

function wptest_register_block() {
	if( function_exists('acf_register_block') ) {
		acf_register_block(array(
			'name'				=> 'about',
			'title'				=> __('About Us'),
			'description'		=> __('A custom about us block.'),
			'render_callback'	=> 'wptest_block_render_callback',
			'category'			=> 'wptest',
			'icon'				=> 'admin-comments',
			'keywords'			=> array( 'about' ),
		));
		acf_register_block(array(
			'name'				=> 'hero',
			'title'				=> __('Hero'),
			'description'		=> __('A custom hero block.'),
			'render_callback'	=> 'wptest_block_render_callback',
			'category'			=> 'wptest',
			'icon'				=> 'slides',
			'keywords'			=> array( 'hero' ),
		));
	}
}
add_action('acf/init', 'wptest_register_block');