<?php
namespace Inc\Classes;

class PCrone {
	public $name_cron;
	public $interval_cron;
	public $display;

	public function __construct($name_cron,$interval_cron,$display) {

		$this->name_cron = $name_cron;
		$this->interval_cron = $interval_cron;
		$this->display = $display;

	}

	public function cron_add_five_min( $schedules ) {
		$schedules['five_min'] = array(
			'interval' => $this->interval_cron,
			'display'  => $this->display
		);

		return $schedules;
	}

	public function my_activation() {
		if ( ! wp_next_scheduled( $this->name_cron ) ) {
			wp_schedule_event( time(), 'five_min', $this->name_cron );
		}
	}
}