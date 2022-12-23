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
		wp_enqueue_script( 'mypluginscript', $this->plugin_url . '/assets/myscript.js' );

	}
}