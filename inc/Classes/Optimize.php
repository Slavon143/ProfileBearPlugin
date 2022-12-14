<?php
/**
 * @package  ProfilebearPlugin
 */

namespace Inc\Classes;
$path = $_SERVER['DOCUMENT_ROOT'];
include_once $path . '/wp-load.php';
set_time_limit( - 1 );

class Optimize {

	public $upload_dir;
	public $dirs = [ 'uploads' ];
	public $exts = [ 'png', 'jpg', 'jpeg' ];
	public $quality;
	public $img_status;
	public $timeUpdate;

	public function __construct() {

		$this->img_status = get_option( 'optimize_img' );
		$this->timeUpdate = (int) get_option( 'optimize_img_time_update' );
		$this->quality    = (int) get_option( 'optimize_quality_img' );
		$upload_dir       = wp_upload_dir();
		$this->timeUpdate = $this->timeUpdate ? $this->timeUpdate : 24;

		array_push( $this->dirs, $upload_dir['basedir'] );
	}

	public function glob_recursive( $pattern, $flags = 0 ) {
		$files = glob( $pattern, $flags );
		foreach ( glob( dirname( $pattern ) . '/*', GLOB_ONLYDIR | GLOB_NOSORT ) as $dir ) {
			$files = array_merge( $files, self::glob_recursive( $dir . '/' . basename( $pattern ), $flags ) );
		}

		return $files;
	}

	public function AddNewImgToDB() {
		global $wpdb;
		$getAllImgDb = $wpdb->get_results( "SELECT * FROM `optimize_img`", ARRAY_N );

		$queryStr = '';
		foreach ( $this->getImagesDirGenerator() as $dir ) {
			$searchImg = $this->searchImgGenerator( $getAllImgDb, 1, $dir )->current();
			if ( empty( $searchImg ) ) {
				$queryStr .= "(NULL, '$dir', '0', NULL, NULL),";
			}
		}

		if ( ! empty( $queryStr ) ) {
			$queryStr = substr( $queryStr, 0, - 1 );
			$wpdb->query( "INSERT INTO `optimize_img` (`id`, `img`, `done`, `error`, `diff`) VALUES $queryStr ;" );
		}

		$this->checkImgEmpty( $getAllImgDb );
	}

	public function checkImgEmpty( $arr ) {
		global $wpdb;
		$queryStr = '';
		if ( ! empty( $arr ) ) {
			foreach ( $arr as $item ) {
				if ( ! file_exists( $item[1] ) ) {
					$queryStr .= "`img` = '$item[1]' OR";
				}
			}
		}
		if ( ! empty( $queryStr ) ) {
			$queryStr = substr( $queryStr, 0, - 2 );
			$wpdb->query( "DELETE FROM `optimize_img` WHERE $queryStr;" );
		}
		if ( $this->img_status != '1' ) {
			return;
		}
		$this->checkImg();
	}

	public function searchImgGenerator( $arrGroupsInXml, $key, $search ) {
		foreach ( $arrGroupsInXml as $item ) {
			if ( is_array( $item ) ) {
				if ( $item[ $key ] === $search ) {
					yield $item[ $key ];
				}
			}
		}
	}

	public function getImagesDirGenerator() {
		foreach ( $this->dirs as $dir ) {
			foreach ( $this->glob_recursive( $dir . '/*.*' ) as $file ) {
				$ext = strtolower( substr( strrchr( $file, '.' ), 1 ) );
				if ( in_array( $ext, $this->exts ) ) {
					$file = str_replace( "\\", "/", $file );
					if ( file_exists( $file ) ) {
						yield $file;
					} else {
						return false;
					}
				}
			}
		}
	}

	public function generatorImg( $arr ) {
		if ( is_array( $arr ) ) {
			foreach ( $arr as $item ) {
				yield $item;
			}
		}
	}

	public function checkImg() {

		$optimize = new ManageImg();
		global $wpdb;
		$getNotOptimizeImg = $wpdb->get_results( "SELECT * FROM `optimize_img` WHERE `done` = 0", ARRAY_N );

		if ( ! empty( $getNotOptimizeImg ) ) {
			foreach ( $this->generatorImg( $getNotOptimizeImg ) as $img ) {

				$fileInfo = pathinfo( $img[1] );
				$filesize = filesize( $img[1] );

				$optimizeImg = $optimize->ImgOptimize( $img[1], $this->quality, $fileInfo['extension'] );
				if ( $optimizeImg ) {
					$diff = $filesize - $optimizeImg;
					$wpdb->update( "optimize_img", [ 'done' => '1', 'diff' => $diff ], [ 'id' => $img[0] ] );
				} else {
					$wpdb->update( "optimize_img", [ 'error' => $img[1] ], [ 'id' => $img[0] ] );
				}
			}
		}
	}

	public function run() {

		$timeToUpdate = $this->timeUpdate * 3600;

		$crone = new PCrone( 'Img optimizer', $timeToUpdate, "Update ever: " . $timeToUpdate / 3600 . ' Hours' );

		add_filter( 'cron_schedules', [ $crone, 'cron_add_five_min' ] );

		add_action( 'wp', [ $crone, 'my_activation' ] );

		add_action( 'Img optimizer', [ $this, 'AddNewImgToDB' ] );
	}
}
