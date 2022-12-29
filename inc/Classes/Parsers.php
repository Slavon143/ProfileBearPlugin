<?php

namespace Inc\Classes;

class Parsers {

	public function add_settings( $post ) {
		if ( ! empty( $post ) && is_array( $post ) ) {
			if (!array_key_exists('portwest_enable',$post)){
				update_option( 'portwest_enable', 'off' );
			}elseif (!array_key_exists('jobman_enable',$post)){
				update_option( 'jobman_enable', 'off' );
			}elseif (!array_key_exists('bastadgruppen_enable',$post)){
				update_option( 'bastadgruppen_enable', 'off' );
			}
			foreach ( $post as $key => $value ) {
				update_option( $key, $value );
			}
			return true;
		}else{
			return false;
		}
	}
}