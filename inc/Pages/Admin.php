<?php 
/**
 * @package  ProfilebearPlugin
 */
namespace Inc\Pages;

use Inc\Api\SettingsApi;
use Inc\Base\BaseController;
use Inc\Api\Callbacks\AdminCallbacks;
use Inc\Api\Callbacks\ManagerCallbacks;
/**
* 
*/

class Admin extends BaseController
{
	public $settings;

	public $callbacks;
	public $callbacks_mngr;

	public $pages = array();

	public $subpages = array();

	public function register() 
	{
		$this->settings = new SettingsApi();

		$this->callbacks = new AdminCallbacks();
        $this->callbacks_mngr = new ManagerCallbacks();

		$this->setPages();

		$this->setSubpages();

		$this->setSettings();
		$this->setSections();
		$this->setFields();

		$this->settings->addPages( $this->pages )->withSubPage( 'Dashboard' )->addSubPages( $this->subpages )->register();
	}

	public function setPages() 
	{
		$this->pages = array(
			array(
				'page_title' => 'ProfileBear Plugin',
				'menu_title' => 'ProfileBear',
				'capability' => 'manage_options', 
				'menu_slug' => 'profile_bear_plugin',
				'callback' => array( $this->callbacks, 'adminDashboard' ), 
				'icon_url' => 'dashicons-store', 
				'position' => 110
			)
		);
	}

	public function setSubpages()
	{
		$this->subpages = array(
			array(
				'parent_slug' => 'profile_bear_plugin',
				'page_title' => 'Optimization IMG Settings',
				'menu_title' => 'Manage Settings IMG',
				'capability' => 'manage_options',
				'menu_slug' => 'profile_bear_optimization_img',
				'callback' => array( $this->callbacks, 'adminOptimizationImg' )
			),
			array(
				'parent_slug' => 'profile_bear_plugin',
				'page_title' => 'Custom Portwest',
				'menu_title' => 'Portwest Settings',
				'capability' => 'manage_options',
				'menu_slug' => 'profile_bear_portwest',
				'callback' => array( $this->callbacks, 'adminPortwest' )
			),
            array(
                'parent_slug' => 'profile_bear_plugin',
                'page_title' => 'Custom Bastadgruppen',
                'menu_title' => 'Bastadgruppen Settings',
                'capability' => 'manage_options',
                'menu_slug' => 'profile_bear_bastadgruppen',
                'callback' => array( $this->callbacks, 'adminBastadgruppen' )
            ),
            array(
                'parent_slug' => 'profile_bear_plugin',
                'page_title' => 'Custom Jobman',
                'menu_title' => 'Jobman Settings',
                'capability' => 'manage_options',
                'menu_slug' => 'profile_bear_jobman',
                'callback' => array( $this->callbacks, 'adminJobman' )
            ),

		);
	}
//bastadgruppen
	public function setSettings()
	{
		$args = array(
			array(
				'option_group' => 'profile_bear_plugin_settings',
				'option_name' => 'optimize_img',
				'callback' => array( $this->callbacks_mngr, 'checkboxSanitize' )
			),
            array(
                'option_group' => 'profile_bear_plugin_settings',
                'option_name' => 'optimize_png',
                'callback' => array( $this->callbacks_mngr, 'checkboxSanitize' )
            ),
            array(
                'option_group' => 'profile_bear_plugin_settings',
                'option_name' => 'optimize_jpg',
                'callback' => array( $this->callbacks_mngr, 'checkboxSanitize' )
            ),
            array(
                'option_group' => 'profile_bear_plugin_settings',
                'option_name' => 'optimize_jpeg',
                'callback' => array( $this->callbacks_mngr, 'checkboxSanitize' )
            ),
            array(
                'option_group' => 'profile_bear_plugin_settings',
                'option_name' => 'optimize_img_time_update',
                'callback' => array( $this->callbacks, 'profileBearOptionsGroup' )
            ),
            array(
                'option_group' => 'profile_bear_plugin_settings',
                'option_name' => 'optimize_quality_img',
            ),
		);

		$this->settings->setSettings( $args );
	}

	public function setSections()
	{
		$args = array(
			array(
				'id' => 'profile_bear_admin_index',
				'title' => 'Settings Manager IMG',
				'callback' => array( $this->callbacks_mngr, 'adminSectionManager' ),
				'page' => 'profile_bear_plugin'
			)
		);

		$this->settings->setSections( $args );
	}

	public function setFields()
	{
		$args = array(

            array(
                'id' => 'optimize_img',
                'title' => 'Optimize IMG',
                'callback' => array( $this->callbacks_mngr, 'checkboxField' ),
                'page' => 'profile_bear_plugin',
                'section' => 'profile_bear_admin_index',
                'args' => array(
                    'label_for' => 'optimize_img',
                    'class' => 'ui-toggle'
                )
            ),
            array(
                'id' => 'optimize_jpg',
                'title' => 'JPG',
                'callback' => array( $this->callbacks_mngr, 'checkboxField' ),
                'page' => 'profile_bear_plugin',
                'section' => 'profile_bear_admin_index',
                'args' => array(
                    'label_for' => 'optimize_jpg',
                    'class' => 'ui-toggle'
                )
            ),
            array(
                'id' => 'optimize_png',
                'title' => 'PNG',
                'callback' => array( $this->callbacks_mngr, 'checkboxField' ),
                'page' => 'profile_bear_plugin',
                'section' => 'profile_bear_admin_index',
                'args' => array(
                    'label_for' => 'optimize_png',
                    'class' => 'ui-toggle'
                )
            ),
            array(
                'id' => 'optimize_jpeg',
                'title' => 'JPEG',
                'callback' => array( $this->callbacks_mngr, 'checkboxField' ),
                'page' => 'profile_bear_plugin',
                'section' => 'profile_bear_admin_index',
                'args' => array(
                    'label_for' => 'optimize_jpeg',
                    'class' => 'ui-toggle'
                )
            ),
            array(
                'id' => 'optimize_quality_img',
                'title' => 'Image quality: Where 100 is the best quality',
                'callback' => array( $this->callbacks, 'profileBearSelectImgQuality' ),
                'page' => 'profile_bear_plugin',
                'section' => 'profile_bear_admin_index',
            ),
            array(
                'id' => 'optimize_img_time_update',
                'title' => 'Time for update',
                'callback' => array( $this->callbacks, 'profileBearOptions' ),
                'page' => 'profile_bear_plugin',
                'section' => 'profile_bear_admin_index',
                'args' => array(
                    'label_for' => 'optimize_img_time_update',
                    'class' => 'ui-toggle'
                )
            ),
		);

		$this->settings->setFields( $args );
	}
}