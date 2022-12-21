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
        wp_enqueue_script( 'bootstrap_script', 'https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js' );
        wp_enqueue_style( 'bootstrap_style', 'https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css' );

		wp_enqueue_style( 'mypluginstyle', $this->plugin_url . '/assets/mystyle.css' );
		wp_enqueue_script( 'mypluginscript', $this->plugin_url . '/assets/myscript.js' );


	}
}