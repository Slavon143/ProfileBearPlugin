<?php

namespace Inc\Classes;

class LogsProfelebear {

	private $dir = __DIR__ . '/../../logs/';
	private $filename = 'logs.log';

	public $message;

	private static $instance = null;

	public function __construct($message){
		$this->message = $message;
		file_put_contents($this->dir . $this->filename,date('l jS \of F Y h:i:s A') . '->>>' . $this->message
		                                                      . "\r\n",
			FILE_APPEND);
	}

	public static function getInstance($message){
		if (self::$instance == null){
			self::$instance = new self($message);
		}
	}

}