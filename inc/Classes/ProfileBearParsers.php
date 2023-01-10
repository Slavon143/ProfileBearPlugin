<?php
/**
 * @package  ProfileBearPlugin
 */

namespace Inc\Classes;
$path = $_SERVER['DOCUMENT_ROOT'];
include_once $path . '/wp-load.php';
require_once __DIR__ . '/PCrone.php';
set_time_limit( - 1 );

final class ProfileBearParsers {

	public function __construct() {
		$portwest_enable      = esc_attr( get_option( 'portwest_enable' ) );
		$jobman_enable        = esc_attr( get_option( 'jobman_enable' ) );
		$bastadgruppen_enable = esc_attr( get_option( 'bastadgruppen_enable' ) );

		if ( $portwest_enable == '1' ) {
			$portwest = new ParserPortwest();
			$portwest->run();
		}
		if ( $jobman_enable == '1' ) {
			$jobman = new ParserJobman();
			$jobman->run();
		}
		if ( $bastadgruppen_enable == '1' ) {
			$bastadgruppen = new ParserBasta();
			$bastadgruppen->run();
		}
	}
}

interface ParserProfileBear {
	public function getSettings();

	public function getData();

	public function run();
}

class ParserPortwest implements ParserProfileBear {

	public function getSettings() {
//		$url = 'https://d11ak7fd9ypfb7.cloudfront.net/marketing_files/simple_soh/simpleSOH20.csv';
		$url = 'https://www.portwest.com/account/downloadProductCSV/soh/sohSE.csv';

		$portwest_enable                = esc_attr( get_option( 'portwest_enable' ) );
		$porewest_set_update_hour       = esc_attr( get_option( 'porewest_set_update_hour' ) );
		$porewest_set_update_percentage = (int) esc_attr( get_option( 'porewest_set_update_percentage' ) );

		return compact( 'portwest_enable', 'porewest_set_update_hour', 'porewest_set_update_percentage', 'url' );
	}

	public function getData() {
		$getSettings     = $this->getSettings();
		$products_update = '';

		$data = MyFunctions::getContents( $getSettings['url'] );

		if ( ! $data ) {
			$logs = LogsProfelebear::getInstance();
			$logs->setLogs( "No connect to portwest server!" );

			return;
		}
		$data = explode( "\n", $data );
		array_shift( $data );

		foreach ( $data as $item ) {
			$item = explode( ',', $item );

			$sku   = isset( $item[1] ) ? $item[1] : null;
			$stock = isset( $item[9] ) ? $item[9] : null;
			$price = isset( $item[3] ) ? $item[3] : null;

			$prod_id = MyFunctions::find_prod_id_by_sku( $sku );

			if ( ! empty( $prod_id ) ) {

				$products_update ++;
				$AddPercentage = $getSettings['porewest_set_update_percentage'];
				$price         = (int) $price;

				if ( ! empty( $AddPercentage ) && ! empty( $price ) ) {

					$newPrice = $price + ( $price * ( $AddPercentage / 100 ) );

					update_post_meta( $prod_id, '_price', $newPrice );
					update_post_meta( $prod_id, '_regular_price', $newPrice );
				} else {
					update_post_meta( $prod_id, '_price', $price );
					update_post_meta( $prod_id, '_regular_price', $price );
				}

				MyFunctions::add_custom_external_stock( $prod_id, $stock );
			}
		}
		update_option( 'porewest_set_update_percentage', 0 );
		update_option( 'portwest_products_update', $products_update );
		update_option( 'portwest_last_update', date( "F j,Y,g:i a" ) );
	}

	public function run() {

		$getSettings = $this->getSettings();

		$timeToUpdate = 3600 * $getSettings['porewest_set_update_hour'];

		if ( $getSettings['portwest_enable'] == '0' ) {
			return;
		}

		$crone = new PCrone( 'Portwest parser', $timeToUpdate, "Update ever: " . $timeToUpdate / 3600 . ' Hours' );

		add_filter( 'cron_schedules', [ $crone, 'cron_add_five_min' ] );

		add_action( 'wp', [ $crone, 'my_activation' ] );

		add_action( 'Portwest parser', [ $this, 'getData' ] );
	}

}

class ParserJobman implements ParserProfileBear {

	public function getSettings() {

		$url = 'ftp://ProfileBear:5kdRJ6enC*PY@ftp.nwg.se/InventoryBalance_Jobman.csv';

		$jobman_enable                = esc_attr( get_option( 'jobman_enable' ) );
		$jobman_set_update_hour       = esc_attr( get_option( 'jobman_set_update_hour' ) );
		$jobman_set_update_percentage = (int) esc_attr( get_option( 'jobman_set_update_percentage' ) );

		return compact( 'jobman_enable', 'jobman_set_update_hour', 'jobman_set_update_percentage', 'url' );
	}

	public function getData() {
		$getSettings     = $this->getSettings();
		$products_update = '';

		$data = MyFunctions::getContents( $getSettings['url'] );

		if ( ! $data ) {
			$logs = LogsProfelebear::getInstance();
			$logs->setLogs( "No connect to jobman server!" );

			return;
		}
		$data = explode( "\r\n", $data );

		if ( ! is_array( $data ) ) {
			return;
		}
		array_shift( $data );
		array_shift( $data );

		foreach ( $data as $item ) {

			$item = explode( ';', $item );

			$article = trim( $item[0] );
			$stock   = trim( $item[1] );

			$prod_id = MyFunctions::find_prod_id_by_sku( $article );

			if ( ! empty( $prod_id ) ) {
				$products_update ++;
				$AddPercentage = $getSettings['jobman_set_update_percentage'];
				$price         = (int) MyFunctions::find_price_by_product_id( $prod_id );

				if ( ! empty( $AddPercentage ) && ! empty( $price ) ) {
					$newPrice = $price + ( $price * ( $AddPercentage / 100 ) );

					update_post_meta( $prod_id, '_price', $newPrice );
					update_post_meta( $prod_id, '_regular_price', $newPrice );

				}
				MyFunctions::add_custom_external_stock( $prod_id, $stock );
			}
		}
		update_option( 'jobman_set_update_percentage', 0 );
		update_option( 'jobman_products_update', $products_update );
		update_option( 'jobman_last_update', date( "F j,Y,g:i a" ) );
	}

	public function run() {

		$getSettings = $this->getSettings();

		$timeToUpdate = 3600 * $getSettings['jobman_set_update_hour'];

		if ( $getSettings['jobman_enable'] == '0' ) {
			return;
		}

		$crone = new PCrone( 'Jobman parser', $timeToUpdate, "Update ever: " . $timeToUpdate / 3600 . ' Hours' );

		add_filter( 'cron_schedules', [ $crone, 'cron_add_five_min' ] );

		add_action( 'wp', [ $crone, 'my_activation' ] );

		add_action( 'Jobman parser', [ $this, 'getData' ] );
	}
}

class ParserBasta implements ParserProfileBear {
	public function getSettings() {
		$url = 'ftp://saldofil:3astad5ruppen!@cmueshzubkda.bastadgruppen.se/Saldo.txt';

		$bastadgruppen_enable                = esc_attr( get_option( 'bastadgruppen_enable' ) );
		$bastadgruppen_set_update_hour       = esc_attr( get_option( 'bastadgruppen_set_update_hour' ) );
		$bastadgruppen_set_update_percentage = (int) esc_attr( get_option( 'bastadgruppen_set_update_percentage' ) );

		return compact( 'bastadgruppen_enable', 'bastadgruppen_set_update_hour', 'bastadgruppen_set_update_percentage', 'url' );
	}

	public function getData() {

		$getSettings     = $this->getSettings();
		$products_update = '';

		$contents = file( $getSettings['url'] );

		if ( ! $contents ) {
			$logs = LogsProfelebear::getInstance();
			$logs->setLogs( "No connect to bastadgruppen server!" );

			return;
		}
		if ( is_array( $contents ) && ! empty( $contents ) ) {
			array_shift( $contents );
			array_shift( $contents );
			foreach ( $contents as $item ) {
				if ( ! empty( $item ) ) {

					$item = trim( $item );
					$item = str_replace( [ "         ", "        ", "    " ], ' ', $item );
					$item = substr_replace( $item, null, 0, 12 );
					$item = explode( ' ', $item );

					$sku_number = trim( $item[2] );
					$saldo      = ltrim( substr( $item[0], 0, 5 ), '0' );

					$post_id = MyFunctions::find_prod_id_by_sku( $sku_number );

					if ( ! empty( $post_id ) ) {

						$products_update ++;
						$AddPercentage = $getSettings['bastadgruppen_set_update_percentage'];
						$price         = (int) MyFunctions::find_price_by_product_id( $post_id );

						if ( ! empty( $AddPercentage ) && ! empty( $price ) ) {
							$newPrice = $price + ( $price * ( $AddPercentage / 100 ) );

							update_post_meta( $post_id, '_price', $newPrice );
							update_post_meta( $post_id, '_regular_price', $newPrice );

						}
						MyFunctions::add_custom_external_stock( $post_id, $saldo );
					}
				}
			}
			update_option( 'bastadgruppen_set_update_percentage', 0 );
			update_option( 'bastadgruppen_products_update', $products_update );
			update_option( 'bastadgruppen_last_update', date( "F j,Y,g:i a" ) );
		}
	}

	public function run() {
		$getSettings = $this->getSettings();

		$timeToUpdate = 3600 * $getSettings['bastadgruppen_set_update_hour'];

		if ( $getSettings['bastadgruppen_enable'] == '0' ) {
			return;
		}

		$crone = new PCrone( 'Bastadgruppen parser', $timeToUpdate, "Update ever: " . $timeToUpdate / 3600 . ' Hours' );

		add_filter( 'cron_schedules', [ $crone, 'cron_add_five_min' ] );

		add_action( 'wp', [ $crone, 'my_activation' ] );

		add_action( 'Bastadgruppen parser', [ $this, 'getData' ] );
	}
}



