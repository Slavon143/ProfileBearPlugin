<?php
/**
 * @package  ProfileBearPlugin
 */
namespace Inc\Api\Callbacks;

use Inc\Base\BaseController;

class AdminCallbacks extends BaseController {
	public function adminDashboard() {
		return require_once( "$this->plugin_path/templates/dashboard.php" );
	}

	public function adminOptimizationImg() {
		return require_once( "$this->plugin_path/templates/optimization_img.php" );
	}

	public function adminPortwest() {
		return require_once( "$this->plugin_path/templates/portwest.php" );
	}

	public function adminBastadgruppen() {
		return require_once( "$this->plugin_path/templates/bastadgruppen.php" );
	}

	public function adminJobman() {
		return require_once( "$this->plugin_path/templates/jobman.php" );
	}


	public function profileBearOptionsGroup( $input ) {
		return $input;
	}

	public function profileBearSelectImgQuality() {
		$value = esc_attr( get_option( 'optimize_quality_img' ) );
		if ( empty( $value ) ) {
			$value = 50;
		}
		echo '<input type="range" class="regular-text" min="1" max="100" name="optimize_quality_img" value="' . $value
		     . '" placeholder="optimize_quality_img" oninput="this.nextElementSibling.value = this.value">
        <output>' . $value . '</output>
        ';
	}

	public function profileBearOptions() {
		$value = esc_attr( get_option( 'optimize_img_time_update' ) );
		if ( empty( $value ) ) {
			$value = 24;
		}
		$html = '';
		$html .= '<select name="optimize_img_time_update" class="optimize_img_time_update">';
		$html .= '<option value="' . $value . '">' . $value . ' Hour</option>';
		for ( $i = 1; $i <= 24; $i ++ ) {
			$html .= '<option value="' . $i . '">' . $i . ' Hour</option>';
		}
		$html .= '</select>';
		echo $html;
	}
}

?>
