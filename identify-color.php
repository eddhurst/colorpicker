<?php

require( 'vendor/autoload.php' );
use ColorThief\ColorThief;

add_action( 'plugins_loaded', 'color_taxonomy__load_textdomain' );
function color_taxonomy__load_textdomain() {
	load_plugin_textdomain( 'color-taxonomy', false, plugin_basename( dirname( __FILE__ ) ) . '/languages' );
}

// Add our css to the admin
add_action( 'admin_enqueue_scripts', 'color_taxonomy__scripts' );

function color_taxonomy__scripts() {
	wp_register_style( 'colorTaxonomyCSS', plugins_url( 'assets/dominant_colour_admin.css', __FILE__ ) );
	wp_enqueue_style( 'colorTaxonomyCSS' );

	wp_register_script( 'colorTaxonomyJS', plugins_url( 'assets/dominant_colour_admin.js', __FILE__ ) );
	wp_enqueue_script( 'colorTaxonomyJS' );
}

//Color dominance detection and saving.
add_action( 'add_attachment', 'color_taxonomy__update_attachment_color_dominance', 10, 1 );

function color_taxonomy__update_attachment_color_dominance( $attachment_id ) {

	if ( ! wp_attachment_is_image( $attachment_id ) ) { return; }

	$upload_dir = wp_upload_dir();
	$image = $upload_dir['basedir'] . '/' . get_post_meta( $attachment_id, '_wp_attached_file', true );

	if ( ! $image ) { return; }
	try {
		$dominant_color = ColorThief::getColor( $image );
	} catch ( Exception $e ) {
		//Probably should do something here. I think realistically this just means the image doesn't exist, or isn't an image. So maybe return is fine anyway?
		return;
	}

	// Get palette of 8 colours from image.
	$palette = ColorThief::getPalette( $image, 8 );

	// Instantiate empty arrays.
	$raw_color_palette = array();
	$closest_match = array();
	// Foreach color in palette, generate hex code and find closest color in preset palette.
	foreach ( $palette as $rgb ) {
		$raw_color_palette[] = array( 'hex' => color_taxonomy__rgb2hex( $rgb ), 'rgb' => $rgb );
		$closest_match[] = color_taxonomy__find_closest_color( $rgb );
	}

	// Save palette as post meta in hex and rgb form.
	update_post_meta( $attachment_id, 'raw_color_palette', $raw_color_palette );

	// Remove duplicates from condensed color palette list.
	$unique_closest_match = array_unique( $closest_match, SORT_REGULAR );

	// Reindex - for aesthetics and easy management.
	$unique_closest_match = array_values( $unique_closest_match );
	// Save closest color list as post meta.
	update_post_meta( $attachment_id, 'closest_color_palette', $unique_closest_match );

}

// Admin field for overriding.
add_filter( 'attachment_fields_to_edit', 'color_taxonomy__add_colour_dominance_fields', 10, 2 );
function color_taxonomy__add_colour_dominance_fields( $fields, $post ) {

	//Get the colour pallete, or rebuild it if it doesn't exist.
	$closest_color_palette = get_post_meta( $post->ID, 'closest_color_palette', true );

	if ( empty( $closest_color_palette ) || false === $closest_color_palette ) {
		$html = __( 'No Color Dominance Available.','dominant-color' );
		$html .= '<br /><a href="#" class="trigger-rebuild" data-dominance-rebuild="' . $post->ID . '">';
		$html .= __( 'Calculate Now?','dominant-color' );
		$html .= '</a>';
	} else {

		$html = '<div class="color-taxonomy--holder">';

		foreach ( $closest_color_palette as $closest_color_single ) :

			$closest_match_hex = $closest_color_single['hex'];

			$html .= '<div class="color-taxonomy--squares" data-col="' . $closest_match_hex . '" style="background-color: ' . $closest_match_hex . '"></div>';

			$htmls[] = $html;

		endforeach;

		$html .= '<div>';

	}
	$html .= '<script>attachDominantColor();</script>';

	$fields['dominant-override'] = array(
		'value' => get_post_meta( $post->ID, 'dominant_override', true ),
		'class' => 'dominant-override',
		'input' => 'hidden',
	);

	$fields['color-taxonomy'] = array(
		'value' => '',
		'input' => 'html',
		'html'  => $html,
		'label' => __( 'Dominant Colors', 'color-taxonomy' ),
	);
	return $fields;
}

//Save dominant-override.
add_filter( 'attachment_fields_to_save', 'color_taxonomy__save_dominant_override', 10, 2 );

function color_taxonomy__save_dominant_override( $post, $attachment ) {
	if ( isset( $attachment['dominant-override'] ) ) {
		if ( 'trigger-rebuild' === $attachment['dominant-override'] ) {
			color_taxonomy__update_attachment_color_dominance( $post['ID'] );
		} else {
			update_post_meta( $post['ID'], 'dominant_override', $attachment['dominant-override'] );
		}
	}
	return $post;
}

/**
 * Find the closest color to a provided RGB value from a predetermined palette
 *
 * @return array $palette_colors	Single row of palette. Format: Array( 'name' => friendly name, 'rgb' => array( red, green, blue ), 'hex' => hex code ).
 *
 **/
function color_taxonomy__find_closest_color( $rgb ) {

	// Set palette of color to check against
	$palette_colors = color_taxonomy__generate_color_palette();

	// Instantiate empty array for comparison
	$color_comparison = array();

	// Loop through each color in the palette and compare against provided RGB to measure proximity.
	foreach ( $palette_colors as $palette ) :

		$difference = sqrt( pow( $rgb[0] - $palette['rgb'][0], 2 ) + pow( $rgb[1] - $palette['rgb'][1], 2 ) + pow( $rgb[2] - $palette['rgb'][2], 2 ) );

		// Add color difference to array.
		array_push( $color_comparison, $difference );

	endforeach;

	// Identify color with shortest distance from provided RGB.
	$smallest = min( $color_comparison );

	// Retrieve the array key for relevant item.
	$key = array_search( $smallest, $color_comparison, true );

	// Return array of closest color to provided RGB.
	return $palette_colors[ $key ];

}

