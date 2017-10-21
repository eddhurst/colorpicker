<?php

if ( ! function_exists( 'color_taxonomy__generate_color_palette' ) ) {

	/**
	 * Generate a palette of user facing colors for taxonomy queries.
	 *
	 * @return array $palette_colors	Array( 'name' => friendly name, 'rgb' => array( red, green, blue ) ).
	 *
	 **/
	function color_taxonomy__generate_color_palette() {
		// Set palette of color to check against
		$palette_colors = array(
			array( 'name' => 'lblue-1', 'hex' => '#73dcf4', 'rgb' => array( 115, 220, 244 ) ),
			array( 'name' => 'dblue-1', 'hex' => '#76a4f4', 'rgb' => array( 118, 164, 244 ) ),
			array( 'name' => 'violet-1', 'hex' => '#7260f5', 'rgb' => array( 114, 96, 245 ) ),
			array( 'name' => 'purple-1', 'hex' => '#a360f5', 'rgb' => array( 163, 96, 245 ) ),
			array( 'name' => 'pink-1', 'hex' => '#d07fb1', 'rgb' => array( 208, 127, 177 ) ),
			array( 'name' => 'red-1', 'hex' => '#db838b', 'rgb' => array( 219, 131, 139 ) ),
			array( 'name' => 'orange-1', 'hex' => '#ecb577', 'rgb' => array( 236, 181, 119 ) ),
			array( 'name' => 'yellow-1', 'hex' => '#ece681', 'rgb' => array( 236, 230, 129 ) ),
			array( 'name' => 'green1', 'hex' => '#bad083', 'rgb' => array( 186, 208, 131 ) ),
			array( 'name' => 'lblue-2', 'hex' => '#23c5eb', 'rgb' => array( 35, 197, 235 ) ),
			array( 'name' => 'dblue-2', 'hex' => '#256eeb', 'rgb' => array( 37, 110, 235 ) ),
			array( 'name' => 'violet-2', 'hex' => '#2b11eb', 'rgb' => array( 43, 17, 235 ) ),
			array( 'name' => 'purple-2', 'hex' => '#7311eb', 'rgb' => array( 115, 17, 235 ) ),
			array( 'name' => 'pink-2', 'hex' => '#c1358b', 'rgb' => array( 193, 53, 139 ) ),
			array( 'name' => 'red-2', 'hex' => '#cf3643', 'rgb' => array( 207, 54, 67 ) ),
			array( 'name' => 'orange-2', 'hex' => '#e78b22', 'rgb' => array( 231, 139, 34 ) ),
			array( 'name' => 'yellow-2', 'hex' => '#e6dc2c', 'rgb' => array( 230, 220, 44 ) ),
			array( 'name' => 'green-2', 'hex' => '#99c03a', 'rgb' => array( 153, 192, 58 ) ),
			array( 'name' => 'lblue-3', 'hex' => '#0097ba', 'rgb' => array( 0, 151, 186 ) ),
			array( 'name' => 'dblue-3', 'hex' => '#0045bc', 'rgb' => array( 0, 69, 188 ) ),
			array( 'name' => 'violet-3', 'hex' => '#1400a9', 'rgb' => array( 20, 0, 169 ) ),
			array( 'name' => 'purple-3', 'hex' => '#4c00a9', 'rgb' => array( 76, 0, 169 ) ),
			array( 'name' => 'pink-3', 'hex' => '#8d165f', 'rgb' => array( 141, 22, 95 ) ),
			array( 'name' => 'red-3', 'hex' => '#a20f1c', 'rgb' => array( 162, 15, 28 ) ),
			array( 'name' => 'orange-3', 'hex' => '#b56100', 'rgb' => array( 181, 97, 0 ) ),
			array( 'name' => 'yellow-3', 'hex' => '#beb400', 'rgb' => array( 190, 180, 0 ) ),
			array( 'name' => 'green-3', 'hex' => '#6d8f18', 'rgb' => array( 109, 143, 24 ) ),
			array( 'name' => 'lblue-4', 'hex' => '#00586d', 'rgb' => array( 0, 88, 109 ) ),
			array( 'name' => 'dblue-4', 'hex' => '#00296f', 'rgb' => array( 0, 41, 111 ) ),
			array( 'name' => 'violet-4', 'hex' => '#0b005d', 'rgb' => array( 11, 0, 93 ) ),
			array( 'name' => 'purple-4', 'hex' => '#2a005d', 'rgb' => array( 42, 0, 93 ) ),
			array( 'name' => 'pink-4', 'hex' => '#4f0834', 'rgb' => array( 79, 8, 52 ) ),
			array( 'name' => 'red-4', 'hex' => '#61030c', 'rgb' => array( 97, 3, 12 ) ),
			array( 'name' => 'orange-4', 'hex' => '#693800', 'rgb' => array( 105, 56, 0 ) ),
			array( 'name' => 'yellow-4', 'hex' => '#716b00', 'rgb' => array( 113, 107, 0 ) ),
			array( 'name' => 'green-4', 'hex' => '#3d5309', 'rgb' => array( 61, 83, 9 ) ),
			array( 'name' => 'white', 'hex' => '#ffffff', 'rgb' => array( 255, 255, 255 ) ),
			array( 'name' => 'grey-1', 'hex' => '#eaeaea', 'rgb' => array( 234, 234, 234 ) ),
			array( 'name' => 'grey-2', 'hex' => '#d5d5d5', 'rgb' => array( 213, 213, 213 ) ),
			array( 'name' => 'grey-3', 'hex' => '#c0c0c0', 'rgb' => array( 192, 192, 192 ) ),
			array( 'name' => 'grey-4', 'hex' => '#aaaaaa', 'rgb' => array( 170, 170, 170 ) ),
			array( 'name' => 'grey-5', 'hex' => '#959595', 'rgb' => array( 149, 149, 149 ) ),
			array( 'name' => 'grey-6', 'hex' => '#6b6b6b', 'rgb' => array( 107, 107, 107 ) ),
			array( 'name' => 'grey-7', 'hex' => '#2b2b2b', 'rgb' => array( 43, 43, 43 ) ),
			array( 'name' => 'grey-8', 'hex' => '#161616', 'rgb' => array( 22, 22, 22 ) ),
		);

		return $palette_colors;
	}
}
