<?php
$jobman_enable                    = esc_attr( get_option( 'jobman_enable' ) );
$jobman_set_update_hour           = esc_attr( get_option( 'jobman_set_update_hour' ) );
$jobman_set_update_percentage     = esc_attr( get_option( 'jobman_set_update_percentage' ) );
$jobman_get_count_products_update = esc_attr( get_option( 'jobman_products_update' ) );
$jobman_last_update               = esc_attr( get_option( 'jobman_last_update' ) );

echo '
       <div class="card ' . ( $jobman_enable == '1' ? 'border-success' : 'border-secondary' ) . ' mb-3" style="max-width: 18rem;">
       <div class="card-header bg-transparent ' . ( $jobman_enable == '1' ? 'border-success' : 'border-secondary' ) . '">Jobman import</div>
       <div class="card-body ' . ( $jobman_enable == '1' ? 'text-success' : 'text-secondary' ) . '">
           <h5 class="card-title">Status: ' . ( $jobman_enable == '1' ? 'Active' : 'Inactive' ) . '</h5>
           <p class="card-text">Updated products: <strong> ' .
     ( $jobman_get_count_products_update ? $jobman_get_count_products_update : 0 ) . '</strong></p>
           <p class="card-text">Percentage to products: <strong> ' . $jobman_set_update_percentage . ' </strong></p>
           <p class="card-text">Launch every: <strong>' . ( $jobman_set_update_hour ?
		$jobman_set_update_hour : '' ) . '</strong> hours</p>
           <p class="card-text">Last update: <strong>' . ( $jobman_last_update ?
		$jobman_last_update : '' ) . '</strong></p>
       </div>
        <div class="card-footer bg-transparent ' . ( $jobman_enable == '1' ? 'border-success' : 'border-secondary' ) . '"></div>
        </div> ';
?>
