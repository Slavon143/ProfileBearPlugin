<?php
/**
 * @package  ProfileBearPlugin
 */
namespace Inc\Api\Callbacks;

use Inc\Base\BaseController;

class ManagerCallbacks extends BaseController
{

    public function checkboxSanitize( $input )
    {
        return (isset($input) ? true : false);
    }

    public function adminSectionManager(){
        echo 'Activate the Section';
    }

    public function checkboxField($args){
        $name = $args['label_for'];
        $class = $args['class'];
        $checkbox = get_option($name);
        echo "<div class='$class'><input type='checkbox' id='$name' name='$name' value='1' class='$class' ". ($checkbox ?
                'checked' :
                '') ." ><label for='$name'><div></div></label></div>";
    }
}