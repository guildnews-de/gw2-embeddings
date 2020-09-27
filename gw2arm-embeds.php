<?php
/**
 * Plugin Name:       GuildWars2 Embeddings
 * Description:       Implements a shortcode for simplyfied use of the GW2 Armory embeddings
 * Version:           0.6.4
 * Author:            guildnews.de
 * Author URI:        https://guildnews.de
 * License:           BSD-3 or later
 * License URI:       https://opensource.org/licenses/BSD-3-Clause
 */

 if ( ! defined( 'WPINC' ) ) {
 	die;
 }

/*
 *  main function called by WP with sc attributes
 */

function gw2arm_shortcode($atts=[])
{
  require_once plugin_dir_path( __FILE__ ) .'includes/class_gw2arm_main.php';
  require_once plugin_dir_path( __FILE__ ) .'includes/class_gw2arm_embeds.php';

  // open new instance of shortcode builder
  $shortcode = new GW2arm_shortcode();

  // give attributes-array to builder
  $shortcode->parse_attributes($atts);

  // trigger embed-building functions and get final embedding html
  $embedding = $shortcode->get_embedding();

  // check if scripts are added
  wp_enqueue_script('armory-embeds.js', "https://unpkg.com/armory-embeds@^0.x.x/armory-embeds.js", null, null, true);
  wp_enqueue_script('GW2arm-locale.js', plugin_dir_url( __FILE__ ).'languages/js/gw2arm_locale.js', null, null, null);

  // return embedding back to wordpress
  return $embedding;
}

/**
* Central location to create all shortcodes.
*/
function gw2arm_shortcodes_init()
{
    add_shortcode('gw2arm', 'gw2arm_shortcode');
}

add_action('init', 'gw2arm_shortcodes_init');
