<?php
/**
 * @package  ProfileBearPlugin
 */

namespace Inc\Api\Callbacks;

use Inc\Base\BaseController;

class ManagerCallbacks extends BaseController
{

    public function checkboxSanitize($input)
    {
        return (isset($input) ? true : false);
    }

    public function adminSectionManager()
    {
        echo 'Activate the Section';
    }

    public function checkboxField($args)
    {
        $name = $args['label_for'];
        $class = $args['class'];
        $checkbox = get_option($name);

        echo "
<label class='switch'>
        <input type='checkbox' id='$name' name='$name' value='$checkbox' class='$class' " .
             ($checkbox ?
	             'checked' :
	             '') . " >
        <span class='slider round'></span>
        </label>
        ";
    }
}