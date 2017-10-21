<?php

// Helper function: Convert RGB to Hex.
function color_taxonomy__rgb2hex( $rgb ) {
	$hex = '#';
	$hex .= str_pad( dechex( $rgb[0] ), 2, '0', STR_PAD_LEFT );
	$hex .= str_pad( dechex( $rgb[1] ), 2, '0', STR_PAD_LEFT );
	$hex .= str_pad( dechex( $rgb[2] ), 2, '0', STR_PAD_LEFT );

	return $hex; // returns the hex value including the number sign (#)
}

// Helper function: Convert Hex to RGB.
function color_taxonomy__hex2rgb( $color ) {
	$color = str_replace( '#', '', $color );
	if ( strlen( $color ) !== 6 ) { return array( 0, 0, 0 ); }
	$rgb = array();
	for ( $x = 0;$x < 3;$x++ ) {
		$rgb[ $x ] = hexdec( substr( $color,(2 * $x),2 ) );
	}
	return $rgb;
}
