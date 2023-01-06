<?php
/**
 * @package  ProfileBearPlugin
 */
namespace Inc\Classes;

class LogsProfelebear {

	public $dir = __DIR__ . '/../../logs/';
	public $filename = 'logs.log';

	private static LogsProfelebear $instance;

	public function __construct(){
	}

	public static function getInstance(): LogsProfelebear{
		if (empty(self::$instance)){
			self::$instance = new LogsProfelebear();
		}
		return self::$instance;
	}

	public function setLogs(string $message = ''){
		file_put_contents($this->dir . $this->filename,date('l jS \of F Y h:i:s A') . '->>>' . $message
					                                               . "\r\n",
						FILE_APPEND);
	}
}