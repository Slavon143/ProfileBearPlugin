<?php 
/**
 * @package  ProfileBearPlugin
 */
namespace Inc\Base;

use Inc\Base\BaseController;

/**
* 
*/
class Enqueue extends BaseController
{
	public function register() {
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue' ) );
	}
	
	function enqueue() {
        // enqueue all our scripts

        wp_enqueue_style( 'googleapis', 'https://fonts.googleapis.com/icon?family=Material+Icons' );
		wp_enqueue_style( 'mypluginstyle', $this->plugin_url . '/assets/mystyle.css' );
		wp_enqueue_style( 'bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css' );


		wp_enqueue_script( 'jquery', 'https://code.jquery.com/jquery-3.2.1.slim.min.js' );
		wp_enqueue_script( 'popper', 'https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js' );
		wp_enqueue_script( 'bootstrapJs', 'https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js' );
		wp_enqueue_script( 'mypluginscript', $this->plugin_url . 'assets/myscript.js' );


	}
}