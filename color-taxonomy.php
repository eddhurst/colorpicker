<?php
/*
Plugin Name: Color Taxonomy
Description: Provide a way for users to easily filter by color, based on dominant colours within the selected featured image.
Version:     1.4
Author:      Edd Hurst
Author URI:  https://eddhurst.co.uk
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: color-taxonomy
Domain Path: /languages
Requires at least: 4.0
Tested up to: 4.7.3
Stable tag: 1.4
*/

// Generate color palette.
require( 'generate-color-palette.php' );

// Load helper functions.
require( 'helper-functions.php' );

// Main color identification code.
require( 'identify-color.php' );

// Generate taxonomy to use colors with post types.
require( 'generate-taxonomy.php' );
