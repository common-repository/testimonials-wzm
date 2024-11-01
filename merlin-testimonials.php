<?php
/*
Plugin Name: testimonials_wzm
Description: This plugin is used to make testimonials.
Version:     1.0.6
Author:      wij zijn Merlin
*/

/*  Copyright 2017 wij zijn merlin bv  (email : info@wijzijnmerlin.nl)

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License, version 2, as
  published by the Free Software Foundation.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
  
if ( ! defined( 'ABSPATH' ) ) exit;
$dir = plugin_dir_path( __FILE__ );


function testimonialswzm_custom_posts_per_page($query) {
    if (is_home()) {
        $query->set('posts_per_page', get_option('testimonialswzm_limitpp'));
    }
    if (is_search()) {
        $query->set('posts_per_page', -1);
    }
    if (is_archive()) {
        $query->set('posts_per_page', get_option('testimonialswzm_limitpp'));
    } //endif
} //function

//this adds the function above to the 'pre_get_posts' action     
add_action('pre_get_posts', 'testimonialswzm_custom_posts_per_page');

add_filter("plugin_action_links_" . plugin_basename(__FILE__), 'TESTIMONIALS_UPGRADE_TO_PRO');
    function TESTIMONIALS_UPGRADE_TO_PRO($links) {
        $links[0] = '<a href="http://plugins.wijzijnmerlin.nl/index.php?pagina=mollie&WebsiteOverview=true" target="_blank">' . "Go Pro" . '</a>';
        $links[1] = '<a href="' . admin_url( 'admin.php?page=Testimonials' ) . '">Settings</a>';
        return $links;
    }


function testimonialswzm_register_testimonial() {
 
    $labels = array(
        'name' => _x( 'testimonial', 'testimonial' ),
        'singular_name' => _x( 'Testimonial', 'testimonial' ),
        'add_new' => _x( 'Add New', 'testimonial' ),
        'add_new_item' => _x( 'Add New Testimonial', 'testimonial' ),
        'edit_item' => _x( 'Edit Testimonial', 'testimonial' ),
        'new_item' => _x( 'New Testimonial', 'testimonial' ),
        'view_item' => _x( 'View Testimonial', 'testimonial' ),
        'search_items' => _x( 'Search Testimonials', 'testimonial' ),
        'not_found' => _x( 'No Testimonials found', 'testimonial' ),
        'not_found_in_trash' => _x( 'No Testimonials found in Trash', 'testimonial' ),
        'parent_item_colon' => _x( 'Parent Testimonial:', 'testimonial' ),
        'menu_name' => _x( 'Testimonials', 'testimonial' ),
    );

    $args = array(
        'labels' => $labels,
        'hierarchical' => true,
        'description' => 'testimonial',
        'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'page-attributes' ),
        'taxonomies' => array( 'testimonials' ),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => false,
        'menu_position' => 99,
        'menu_icon' => 'dashicons-format-aside',
        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => true,
        'capability_type' => 'post'
    );
    register_post_type( 'testimonial', $args );
}

add_action( 'init', 'testimonialswzm_register_testimonial' );

function testimonialswzm_page(){?>
<script language="javascript">
    window.location.href = "edit.php?post_type=testimonial"
</script>
<?php
}

function testimonialswzm_admin_page() {
    add_menu_page("testimonials", "Testimonials", 1, "testimonialswzm_page", "testimonialswzm_page", "dashicons-testimonial", 4);
}


add_action('admin_menu', 'testimonialswzm_admin_page');

function testimonialswzm_create_testimonial_pages()
  {
   //post status and options
    $post = array(
          'comment_status' => 'closed',
          'ping_status' =>  'closed' ,
          'post_date' => date('Y-m-d H:i:s'),
          'post_name' => 'testimonial',
          'post_status' => 'publish' ,
          'post_title' => 'Testimonials',
          'post_type' => 'page'
    );

    //insert page and save the id
    $newvalue = wp_insert_post( $post, false );
    //save the id in the database
    update_option( 'tpage', $newvalue );
  }


register_activation_hook( __FILE__, 'testimonialswzm_create_testimonial_pages');

add_action( 'wp_enqueue_scripts', 'testimonialswzm_prefix_add_my_stylesheet_main_grid');



function testimonialswzm_prefix_add_my_stylesheet_main_grid(){
    $dir = plugin_dir_path( __FILE__ );
    wp_register_style( 'prefix-style', plugins_url($dir.'style_main_grid.css', __FILE__) );
    wp_enqueue_style( 'prefix-style' );
}


function testimonialswzm_admin() {
    include('testimonials_import_admin.php');
}
 
function testimonialswzm_admin_actions() {
    add_submenu_page("testimonialswzm_page", "Settings", "Settings", 1, "Testimonials", "testimonialswzm_admin");
}
 
add_action('admin_menu', 'testimonialswzm_admin_actions');


?>