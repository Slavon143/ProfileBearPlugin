<?php
$bastadgruppen_enable                = esc_attr( get_option( 'bastadgruppen_enable' ) );
$bastadgruppen_set_update_hour       = esc_attr( get_option( 'bastadgruppen_set_update_hour' ) );
$bastadgruppen_set_update_percentage = esc_attr( get_option( 'bastadgruppen_set_update_percentage' ) );
$bastadgruppen_products_update       = esc_attr( get_option( 'bastadgruppen_products_update' ) );
$bastadgruppen_last_update           = esc_attr( get_option( 'bastadgruppen_last_update' ) );
?>
<div class="col-md-6">
	<?php echo '
            <div class="card ' . ( $bastadgruppen_enable == '1' ? 'border-success' : 'border-secondary' ) . ' mb-3" style="max-width: 18rem;">
                <div class="card-header bg-transparent ' . ( $bastadgruppen_enable == 'on' ? 'border-success' : 'border-secondary' ) . '">Bastadgruppen import</div>
                <div class="card-body ' . ( $bastadgruppen_enable == '1' ? 'text-success' : 'text-secondary' ) . '">
                    <h5 class="card-title">Status: ' . ( $bastadgruppen_enable == '1' ? 'Active' : 'Inactive' ) . '</h5>
                    <p class="card-text">Updated products: <strong> ' .
	           ( $bastadgruppen_products_update ? $bastadgruppen_products_update : 0 ) . '</strong></p>
                    <p class="card-text">Percentage to products: <strong> ' . $bastadgruppen_set_update_percentage . ' </strong></p>
                    <p class="card-text">Launch every: <strong>' . ( $bastadgruppen_set_update_hour ?
			$bastadgruppen_set_update_hour : '' ) . '</strong> hours</p>
                    <p class="card-text">Last update: <strong>' . ( $bastadgruppen_last_update ?
			$bastadgruppen_last_update : '' ) . '</strong></p>
                </div>
                <div class="card-footer bg-transparent ' . ( $bastadgruppen_enable == '1' ? 'border-success' : 'border-secondary' ) . '"></div>
            </div>
            '; ?>
</div>
