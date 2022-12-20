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
        return require_once("$this->plugin_path/templates/dashboard.php");
    }
    public function adminOptimizationImg()
    {
        return require_once("$this->plugin_path/templates/optimization_img.php");
    }

    public function adminPortwest()
    {
        return require_once("$this->plugin_path/templates/portwest.php");
    }

    public function adminBastadgruppen()
    {
        return require_once("$this->plugin_path/templates/bastadgruppen.php");
    }

    public function adminJobman()
    {
        return require_once("$this->plugin_path/templates/jobman.php");
    }


    public function profileBearOptionsGroup($input)
    {
        return $input;
    }

    public function profileBearSelectImgQuality()
    {
        $value = esc_attr(get_option('optimize_quality_img'));
        if (empty($value)) {
            $value = 50;
        }
        echo '<input type="range" class="regular-text" min="1" max="100" name="optimize_quality_img" value="' . $value . '" placeholder="optimize_quality_img" oninput="this.nextElementSibling.value = this.value">
        <output>' . $value . '</output>
        ';
    }

    public function profileBearOptions()
    {
        $value = esc_attr(get_option('optimize_img_time_update'));
        if (empty($value)) {
            $value = 24;
        }
        echo '

<select name="optimize_img_time_update" class="optimize_img_time_update">
  <option value="'.$value.'">'.$value.' Hour</option>
  <option value="1">1 Hour</option>
  <option value="2">2 Hour</option>
  <option value="3">3 Hour</option>
  <option value="4">4 Hour</option>
  <option value="5">5 Hour</option>
  <option value="6">6 Hour</option>
  <option value="7">7 Hour</option>
  <option value="8">8 Hour</option>
  <option value="9">9 Hour</option>
  <option value="10">10 Hour</option>
  <option value="11">11 Hour</option>
  <option value="12">12 Hour</option>
  <option value="13">13 Hour</option>
  <option value="14">14 Hour</option>
  <option value="15">15 Hour</option>
  <option value="16">16 Hour</option>
  <option value="17">17 Hour</option>
  <option value="18">18 Hour</option>
  <option value="19">19 Hour</option>
  <option value="20">20 Hour</option>
  <option value="21">21 Hour</option>
  <option value="22">22 Hour</option>
  <option value="23">23 Hour</option>
  <option value="24">24 Hour</option>

</select>';
    }
}

?>
