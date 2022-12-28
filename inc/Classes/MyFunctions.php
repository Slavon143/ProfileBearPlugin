<?php

namespace Inc\Classes;

$path = $_SERVER['DOCUMENT_ROOT'];
include_once $path . '/wp-load.php';

class MyFunctions {

	public function make( $post ) {
		if ( ! empty( $post['delete'] ) && isset( $_POST['options'] ) ) {
			$this->delete( $_POST );
		}
		if ( ! empty( $post['edit_secondary'] ) && isset( $_POST['options'] ) ) {
			$this->update( $post, '0' );
		}
		if ( ! empty( $post['edit'] ) && isset( $_POST['options'] ) ) {
			$this->update( $post, '1' );
		}
	}

	public function getCount() {
		global $wpdb;
		$sql    = "SELECT count(id) AS id FROM `optimize_img`";
		$result = $wpdb->get_results( $sql );
		if ( $result ) {
			return $result[0]->id;
		}
	}

	public function update( $data, $arg ) {
		global $wpdb;
		$queryStr = '';
		if ( empty( $data ) ) {
			return;
		}
		foreach ( $data['options'] as $id ) {
			$queryStr .= "'$id',";
		}
		$queryStr = substr( $queryStr, 0, - 1 );
		$sql      = "UPDATE `optimize_img` SET `done` = $arg WHERE `id` IN ($queryStr);";
		$wpdb->query( $sql );
	}

	public function delete( $arg ) {
		if ( empty( $arg['options'] ) ) {
			return;
		}
		global $wpdb;
		$queryStr = '';
		if ( ! empty( $arg['options'] ) ) {
			for ( $i = 0; $i <= count( $arg['options'] ); $i ++ ) {
				if ( ! empty( $arg['options'][ $i ] ) ) {
					$img      = trim( $arg['options'][ $i ] );
					$queryStr .= "`id` = '$img' OR";
				}
			}
		}
		if ( ! empty( $queryStr ) ) {
			$queryStr = substr( $queryStr, 0, - 2 );
			$query    = "DELETE FROM `optimize_img` WHERE $queryStr;";
			$wpdb->query( $query );
		}
	}

	public function buildLinkImg( $img ) {
		$cat         = str_replace( "\\", '/', wp_upload_dir()['basedir'] );
		$img         = str_replace( $cat, '', $img );
		$base_dir    = wp_upload_dir()['baseurl'];
		$img_url_dir = $base_dir . $img;

		return $img_url_dir;
	}
}

class File {
	public function getExtImg( $path ): string {
		if ( ! empty( $path ) ) {
			$file = explode( ".", $path );
			if ( $file ) {
				return array_pop( $file );
			}
		}
	}

	public function getStatus( $arr ):array {
		$status = [];
		if ( $arr == 1 ) {
			$status = [
				'Optimized' => 'btn-success'
			];
		} else {
			$status = [
				'Not optimized' => 'btn-secondary'
			];
		}
		return $status;
	}
}

class Paginator {

	private $_limit;
	private $_page;
	private $_query;
	private $_total;

	public function __construct( $query ) {
		global $wpdb;

		$this->_query = $query;

		$rs = $wpdb->get_results( $this->_query, ARRAY_A );;
		$this->_total = count( $rs );
	}

	public function getData( $limit = 10, $page = 1, $search ) {

		global $wpdb;

		$this->_limit = $limit;
		$this->_page  = $page;

		if ( $this->_limit == 'all' ) {
			$query = $this->_query; //SELECT * FROM `optimize_img` LIMIT 36700, 100;
		} elseif ( ! empty( $search ) ) {
			$query = $this->_query . "WHERE `img` LIKE '%$search%'";
		} else {
			$query = $this->_query . " LIMIT " . ( ( $this->_page - 1 ) * $this->_limit ) . ", $this->_limit";
		}
		$results = $wpdb->get_results( $query, ARRAY_A );

		$result = new \stdClass();

		$result->page  = (int) $this->_page;
		$result->limit = $this->_limit;
		$result->total = $this->_total;
		$result->data  = $results;

		return $result;
	}

	public function createLinks( $links, $list_class ) {
		if ( $this->_limit == 'all' ) {
			return '';
		}

		$last = ceil( $this->_total / $this->_limit );

		$start = ( ( $this->_page - $links ) > 0 ) ? $this->_page - $links : 1;

		$end = ( ( $this->_page + $links ) < $last ) ? $this->_page + $links : $last;

		$html = '<ul class="' . $list_class . '">';

		$class = ( $this->_page == 1 ) ? "disabled" : "";

		if ( $this->_page == 1 ) {
			$html .= '<li class="page-item disabled"><a class="page-link" data-page="' . ( $this->_page - 1 ) . '" href="?page=profile_bear_optimization_img&limit=' . $this->_limit . '&pagin=' . ( $this->_page - 1 ) . '">&laquo;</a></li>';
		} else {
			$html .= '<li class="page-item"><a class="page-link" data-page="' . ( $this->_page - 1 ) . '" href="?page=profile_bear_optimization_img&limit=' . $this->_limit . '&pagin=' . ( $this->_page - 1 ) . '">&laquo;</a></li>';
		}

		if ( $start > 1 ) {

			$html .= '<li><a class="page-link" data-page="1" href="?page=profile_bear_optimization_img&limit=' . $this->_limit . '&pagin=1">1</a></li>';
			$html .= '<li class="disabled"><span> <a class="page-link" href="">...</a></span></li>';
		}

		for ( $i = $start; $i <= $end; $i ++ ) {
			if ( $this->_page == $i ) {
				$html .= '<li class="page-item active"><a class="page-link" data-page="' . $i . '" href="?page=profile_bear_optimization_img&limit=' . $this->_limit . '&pagin=' . $i . '">' . $i . '</a></li>';
			} else {
				$html .= '<li class="' . $class . '"><a class="page-link" data-page="' . $i . '" href="?page=profile_bear_optimization_img&limit=' . $this->_limit . '&pagin=' . $i . '">' . $i . '</a></li>';
			}
		}

		if ( $end <= $last ) {
			$html .= '<li class="disabled"><span><a class="page-link" href="">...</a></span></li>';
			$html .= '<li><a class="page-link" data-page="' . $last . '"href="?page=profile_bear_optimization_img&limit=' .
			         $this->_limit . '&pagin=' . $last . '">' .
			         $last . '</a></li>';
		}

		if ( $this->_page == $last ) {
			$html .= '<li class="page-item disabled"><a class="page-link" data-page="' . ( $this->_page + 1 ) . '" href="?page=profile_bear_optimization_img&limit=' . $this->_limit . '&pagin=' . ( $this->_page + 1 ) . '">&raquo;</a></li>';
		} else {
			$html .= '<li class="page-item"><a class="page-link" data-page="' . ( $this->_page + 1 ) . '" href="?page=profile_bear_optimization_img&limit=' . $this->_limit . '&pagin=' . ( $this->_page + 1 ) . '">&raquo;</a></li>';
		}

		$html .= '</ul>';

		return $html;
	}
}