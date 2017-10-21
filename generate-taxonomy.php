<?php

// hook into the init action and hook color_taxonomy__create_color_taxonomies when it fires
add_action( 'init', 'color_taxonomy__create_color_taxonomies', 0 );

// create two taxonomies, genres and writers for the post type "book"
function color_taxonomy__create_color_taxonomies() {
	// Add new taxonomy, make it hierarchical (like categories)
	$labels = array(
		'name'              => _x( 'Dominant Colors', 'taxonomy general name', 'color-taxonomy' ),
		'singular_name'     => _x( 'Color', 'taxonomy singular name', 'color-taxonomy' ),
		'search_items'      => __( 'Search Colors', 'color-taxonomy' ),
		'all_items'         => __( 'All Colors', 'color-taxonomy' ),
		'parent_item'       => __( 'Parent Color', 'color-taxonomy' ),
		'parent_item_colon' => __( 'Parent Color:', 'color-taxonomy' ),
		'edit_item'         => __( 'Edit Color', 'color-taxonomy' ),
		'update_item'       => __( 'Update Color', 'color-taxonomy' ),
		'add_new_item'      => __( 'Add New Color', 'color-taxonomy' ),
		'new_item_name'     => __( 'New Color Name', 'color-taxonomy' ),
		'menu_name'         => __( 'Colors', 'color-taxonomy' ),
	);

	$args = array(
		'hierarchical'      => false,
		'labels'            => $labels,
		'show_ui'           => false,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'color' ),
	);

	register_taxonomy( 'colors', array( 'page' ), $args );

}

// Hook into the save_post action and run color_taxonomy__save_color_tax_terms when it fires.
add_action( 'save_post', 'color_taxonomy__save_color_tax_terms' );

// On post save, find featured image and set dominant colors as taxonomy terms.
function color_taxonomy__save_color_tax_terms( $post_id ) {

	// If this is just a revision, don't send the email.
	if ( wp_is_post_revision( $post_id ) ) {
		return;
	}

	// Get post featured image.
	$featured_image_id = get_post_thumbnail_id( $post_id );

	// If featured image is set, and featured image is considered a valid image.
	if ( $featured_image_id && wp_attachment_is_image( $featured_image_id ) ) :

		$closest_color_palette = get_post_meta( $featured_image_id, 'closest_color_palette', true );

		// If meta is empty, identify the color dominance for image and set variable for use later.
		if ( empty( $closest_color_palette ) ) :
			color_taxonomy__update_attachment_color_dominance( $featured_image_id );
			$closest_color_palette = get_post_meta( $featured_image_id, 'closest_color_palette', true );
		endif;

		// Check just to make sure variable has in fact been set correctly.
		if ( ! empty( $closest_color_palette ) ) :

			$category_swatch = array();

			// For each palette, get hex value for taxonomy
			foreach ( $closest_color_palette as $closest_color ) :

				$category_swatch[] = $closest_color['hex'];

			endforeach;

			// This will automatically override what was there previously, so we don't need to unset and reset taxonomy terms.
			$term_taxonomy_ids = wp_set_object_terms( $post_id, $category_swatch, 'colors' );

			// If there's an error, output - otherwise continue.
			if ( is_wp_error( $term_taxonomy_ids ) ) {
				// There was an error somewhere and the terms couldn't be set.
				$error_string = $result->get_error_message();
				echo '<div id="message" class="error"><p>' . esc_attr( $error_string ) . '</p></div>';
			}

		endif;

	endif;

}
