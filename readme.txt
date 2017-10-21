=== Color Taxonomy ===
Plugin Name: Color Taxonomy
Plugin URI:	 https://developer.wordpress.org/plugins/color-taxonomy
Description: Provide a way for users to easily filter by color, based on dominant colours within the selected featured image.
Version:     1.4
Author:      Edd Hurst
Author URI:  https://eddhurst.co.uk
License:     GPL3
License URI: https://www.gnu.org/licenses/gpl-3.0.html
Text Domain: color-taxonomy
Domain Path: /languages
Requires at least: 4.0
Tested up to: 4.7.3
Stable tag: 1.4


Generate a list of dominant colours on any uploaded image and save to attachment image post_meta. Automatically compares dominant colours to a swatch of pre-filled colours and finds the closest match. Upon saving a post, the featured image will be analysed and these colours will be used to add a custom taxonomy to the post, allowing all post types to be searched for by colour.

== Description ==
Generate a list of dominant colours on any uploaded image and save to attachment image post_meta. Automatically compares dominant colours to a swatch of pre-filled colours and finds the closest match.

Upon saving a post, the featured image will be analysed and these colours will be used to add a custom taxonomy to the post, allowing all post types to be searched for by colour.

== Installation ==
The colour palette, as well as the swatch-friendly colour palette are automatically saved on upload and edit to post meta.

Values are saved in an array, under the post_meta values of ‘raw_color_palette’ and ‘closest_color_palette’. The values for each are “hex” and “rob”, with the closest_color_palette meta value having an extra value of “name”.

The hex returns as a string, including the #.

RGB returns as an array, with key 0 as red, 1 as green, and 2 as blue.

== Changelog ==

1.4
---

Split files out for easier updates and tracking.

1.3
---

Added custom taxonomy to allow color to auto-populate based on featured image.

1.0
---

Initial Build