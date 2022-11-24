<?php

/**
 * @package  ProfilebearPlugin
 */
/*
Plugin Name: ProfileBear Plugin
Plugin URI: https://github.com/Slavon143/ProfileBearPlugin
Description: Plugin for ProfileBear.
Version: 1.0.0
Author: Slava Stovpjaga
Author URI: https://slavon143.github.io/Profile/
License: GPLv2 or later
Text Domain: profile-bear-plugin
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.

Copyright 2005-2015 Automattic, Inc.
*/

// If this file is called firectly, abort!!!
defined('ABSPATH') or die('Hey, what are you doing here? You silly human!');

// Require once the Composer Autoload
if (file_exists(dirname(__FILE__) . '/vendor/autoload.php')) {
    require_once dirname(__FILE__) . '/vendor/autoload.php';
}

/**
 * The code that runs during plugin activation
 */
function activate_profile_bear_plugin() {
    Inc\Base\Activate::activate();
}
register_activation_hook( __FILE__, 'activate_profile_bear_plugin' );

/**
 * The code that runs during plugin deactivation
 */
function deactivate_profile_bear_plugin() {
    Inc\Base\Deactivate::deactivate();
}
register_deactivation_hook( __FILE__, 'deactivate_profile_bear_plugin' );

/**
 * Initialize all the core classes of the plugin
 */
if (class_exists('Inc\\Init')) {
    Inc\Init::register_services();
}