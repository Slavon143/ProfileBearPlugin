<?php
/**
 * @package  ProfileBearPlugin
 */
namespace Inc\Base;

class Activate
{

	public static function activate() {
        self::createTable();
		flush_rewrite_rules();
	}

    public static function createTable(){
        global $wpdb;
        $wpdb->query("CREATE TABLE IF NOT EXISTS `optimize_img` (

  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,

  `img` varchar(255) NOT NULL,

  `done` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',

  `error` varchar(255) NULL,

  `diff` varchar(255) NULL,

  PRIMARY KEY (`id`)

) ENGINE=MyISAM DEFAULT CHARSET=utf8;");
    }
}