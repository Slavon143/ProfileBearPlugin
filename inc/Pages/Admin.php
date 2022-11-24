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
				'page_title' => 'Custom Post Types', 
				'menu_title' => 'CPT', 
				'capability' => 'manage_options', 
				'menu_slug' => 'profile_bear_cpt',
				'callback' => array( $this->callbacks, 'adminCpt' )
			),
			array(
				'parent_slug' => 'profile_bear_plugin',
				'page_title' => 'Custom Taxonomies', 
				'menu_title' => 'Taxonomies', 
				'capability' => 'manage_options',
				'menu_slug' => 'profile_bear_taxonomies',
				'callback' => array( $this->callbacks, 'adminTaxonomy' )
			),
			array(
				'parent_slug' => 'profile_bear_plugin',
				'page_title' => 'Custom Widgets', 
				'menu_title' => 'Widgets', 
				'capability' => 'manage_options', 
				'menu_slug' => 'profile_bear_widgets',
				'callback' => array( $this->callbacks, 'adminWidget' )
			)
		);
	}

	public function setSettings()
	{
		$args = array(
			array(
				'option_group' => 'profile_bear_plugin_settings',
				'option_name' => 'cpt_manager',
				'callback' => array( $this->callbacks, 'checkboxSanitize' )
			),
			array(
				'option_group' => 'profile_bear_plugin_settings',
				'option_name' => 'taxanomy_manager',
                'callback' => array( $this->callbacks, 'checkboxSanitize' )
			),
            array(
                'option_group' => 'profile_bear_plugin_settings',
                'option_name' => 'media_widgets',
                'callback' => array( $this->callbacks, 'checkboxSanitize' )
            ),
		);

		$this->settings->setSettings( $args );
	}

	public function setSections()
	{
		$args = array(
			array(
				'id' => 'profile_bear_admin_index',
				'title' => 'Settings Manager',
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
				'id' => 'cpt_manager',
				'title' => 'Activate CPT Manager',
				'callback' => array( $this->callbacks_mngr, 'checkboxField' ),
				'page' => 'profile_bear_plugin',
				'section' => 'profile_bear_admin_index',
				'args' => array(
					'label_for' => 'cpt_manager',
                    'class' => 'ui-toggle'
				)
			),
            array(
                'id' => 'taxanomy_manager',
                'title' => 'Taxanomy',
                'callback' => array( $this->callbacks_mngr, 'checkboxField' ),
                'page' => 'profile_bear_plugin',
                'section' => 'profile_bear_admin_index',
                'args' => array(
                    'label_for' => 'taxanomy_manager',
                    'class' => 'ui-toggle'
                )
            ),
            array(
                'id' => 'equ',
                'title' => 'Text',
                'callback' => array( $this->callbacks, 'profileBearTextExample' ),
                'page' => 'profile_bear_plugin',
                'section' => 'profile_bear_admin_index',
                'args' => array(
                    'label_for' => 'equ',
                    'class' => 'ui-toggle'
                )
            ),

		);

		$this->settings->setFields( $args );
	}
}