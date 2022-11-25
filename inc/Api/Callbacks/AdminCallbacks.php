<?php
/**
 * @package  ProfileBearPlugin
 */
namespace Inc\Api\Callbacks;

use Inc\Base\BaseController;

class AdminCallbacks extends BaseController
{
	public function adminDashboard()
	{
		return require_once( "$this->plugin_path/templates/admin.php" );
	}

	public function adminCpt()
	{
		return require_once( "$this->plugin_path/templates/cpt.php" );
	}

	public function adminTaxonomy()
	{
		return require_once( "$this->plugin_path/templates/taxonomy.php" );
	}

	public function adminWidget()
	{
		return require_once( "$this->plugin_path/templates/widget.php" );
	}

	public function profileBearOptionsGroup( $input )
	{
		return $input;
	}

    public function profileBearSelect()
    {
        $value = esc_attr( get_option( 'select_test' ) );
        if (empty($value)){
            $value = 50;
        }
        echo '<input type="range" class="regular-text" min="1" max="100" name="select_test" value="' . $value . '" placeholder="select_test" oninput="this.nextElementSibling.value = this.value">
        <output>' .$value. '</output>
        ';
    }



}
?>
