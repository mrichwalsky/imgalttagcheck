<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://gasmark8.com
 * @since             1.0.0
 * @package           Imgalttagcheck
 *
 * @wordpress-plugin
 * Plugin Name:       Image Alt Tag Reviewer
 * Plugin URI:        https://gasmark8.com
 * Description:       This checks your media for alt tags and shows any issues or missing tags. 
 * Version:           1.0.0
 * Author:            Gas Mark 8, Ltd.
 * Author URI:        https://gasmark8.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       imgalttagcheck
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'IMGALTTAGCHECK_VERSION', '1.0.0' );

function column_id($columns) {
    $columns['media_alt'] = __('Alt Text');
    return $columns;
} 

 
function column_id_row($columnName, $columnID){
    if ($columnName == 'media_alt') {
        $image_alt = get_post_meta($columnID, '_wp_attachment_image_alt', true);
        echo $image_alt;

        $file_type = get_post_mime_type($columnID);
        if (in_array($file_type, ['image/png', 'image/jpeg', 'image/svg+xml', 'image/gif']) && empty($image_alt)) {
            // Use inline JavaScript to add a class to the entire row
            echo "<script>jQuery(document).ready(function($) { $('#post-$columnID').css('background-color', '#ffcccc'); });</script>";
        }
    }
}

add_filter( 'manage_media_custom_column', 'column_id_row', 10, 2 );
add_filter( 'manage_media_columns', 'column_id' );


function my_custom_admin_styles() {
    wp_enqueue_style('my-custom-admin-style', plugin_dir_url(__FILE__) . 'admin-styles.css');
}
add_action('admin_enqueue_scripts', 'my_custom_admin_styles');