<?php
/*
    Plugin Name: SOMC Subpages IgorAndelic
    Plugin URI: https://github.com/IgorAndelic/somc-subpages-IgorAndelic
    Description: This Wordpress plugin is listing subpages of the current page using either a widget or shortcode [somc-subpages-igor].
    Version: 1.0
    Author: Igor Andelic
    Author Email: igo.randjelic011@gmail.com
    License:

    Copyright 2015 Igor Andelic (igor.andjelic011@gmail.com)

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

include_once dirname( __FILE__ ) . '/somc-subpages-igor-widget.php';
include_once dirname( __FILE__ ) . '/somc-subpages-igor-walker.php';
include_once dirname( __FILE__ ) . '/somc-subpages.php';

class SOMC_Subpages_Igor {

    //Constants
    const name = 'SOMC Subpages Igor';
    const slug = 'somc_subpages_igor';

    //Constructor
    function __construct() {
        add_action( 'init', array( &$this, 'init_somc_subpages_igor' ) );
    }

    //Runs when the plugin is initialized
    function init_somc_subpages_igor() {
        // Load JavaScript and stylesheets
        $this->register_scripts_and_styles();

        // Register the shortcode [somc­-subpages-igor]
        add_shortcode( 'somc­-subpages-igor', array( &$this, 'render_shortcode' ) );

        //Truncate the title
        add_filter( 'somc_subpages_the_title', array( &$this, 'somc_filter_truncate_title' ) );
    }

    //Filter function that truncates titles longer than 20 chars
    function somc_filter_truncate_title($title) {
        $new_title = $title;

        if(strlen($new_title) > 20) {
            $new_title = substr($new_title, 0, 20) . '…';
        }

        return $new_title;
    }

    function render_shortcode() {
        $subpages = new SOMC_Subpages();

        if( $subpages->render_subpages() ) {
            echo '<div class="subpages-container">';
            echo $subpages->render_subpages();
            echo '</div>';
        }
    }

    // Registers and enqueues stylesheets for the administration panel and the public facing site.
    private function register_scripts_and_styles() {
        if ( is_admin() ) {
             $this->load_file( self::slug . '-admin-script', '/js/admin.js', true );
             $this->load_file( self::slug . '-admin-style', '/css/admin.css' );
        } else {
            $this->load_file( self::slug . '-script', 'js/somc-subpages-igor.js', true );
            $this->load_file( self::slug . '-style', 'css/somc-subpages-igor-style.css' );
        }
    }

    //Helper function for registering and enqueueing scripts and styles.
    private function load_file( $name, $file_path, $is_script = false ) {

        $url = plugins_url($file_path, __FILE__);
        $file = plugin_dir_path(__FILE__) . $file_path;

        if( file_exists( $file ) ) {
            wp_register_script( $name, $url, array('jquery') );
            if( $is_script ) {
                wp_enqueue_script( $name );
            } else {
                wp_register_style( $name, $url );
                wp_enqueue_style( $name );
            }
        }

    }

} // end class

new SOMC_Subpages_Igor();