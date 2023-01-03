<?php
$portwest_enable                     = esc_attr( get_option( 'portwest_enable' ) );
$porewest_set_update_hour            = esc_attr( get_option( 'porewest_set_update_hour' ) );
$porewest_set_update_percentage      = esc_attr( get_option( 'porewest_set_update_percentage' ) );
$portewest_get_count_products_update = esc_attr( get_option( 'portwest_products_update' ) );
$portwest_last_update                = esc_attr( get_option( 'portwest_last_update' ) );
?>

<div class="col-md-6">
	<?php echo '
            <div class="card ' . ( $portwest_enable == '1' ? 'border-success' : 'border-secondary' ) . ' mb-3" style="max-width: 18rem;">
                <div class="card-header bg-transparent ' . ( $portwest_enable == '1' ? 'border-success' : 'border-secondary' ) . '">Portwest import</div>
                <div class="card-body ' . ( $portwest_enable == '1' ? 'text-success' : 'text-secondary' ) . '">
                    <h5 class="card-title">Status: ' . ( $portwest_enable == '1' ? 'Active' : 'Inactive' ) . '</h5>
                   <p class="card-text">Updated products: <strong> ' .
	           ( $portewest_get_count_products_update ? $portewest_get_count_products_update : 0 ) . '</strong></p>
                    <p class="card-text">Percentage to products: <strong> ' . $porewest_set_update_percentage . ' </strong></p>
                    <p class="card-text">Launch every: <strong>' . ( $porewest_set_update_hour ?
			$porewest_set_update_hour : '' ) . '</strong> hours</p>
                    <p class="card-text">Last update: <strong>' . ( $portwest_last_update ?
			$portwest_last_update : '' ) . '</strong></p>
                </div>
                <div class="card-footer bg-transparent ' . ( $portwest_enable == '1' ? 'border-success' : 'border-secondary' ) . '"></div>
            </div>
            '; ?>
</div>
