<?php
/**
 * @package  ProfileBearPlugin
 */

namespace Inc\Base;

class Deactivate {
	public static function deactivate() {
		self::deleteTable();
		flush_rewrite_rules();
	}

	public static function deleteTable() {
		global $wpdb;
		$wpdb->query( "DROP TABLE `wp_local`.`optimize_img`;" );
	}
}