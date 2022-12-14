<?php

use Inc\Classes\MyFunctions;

$parser = new MyFunctions();
if ( ! empty( $_POST ) ) {
	if ( $parser->add_settings( $_POST ) ) {
		echo '
<br>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
  Settings updated!
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
        ';
	}
}
$jobman_enable                = esc_attr( get_option( 'jobman_enable' ) );
$jobman_set_update_percentage = esc_attr( get_option( 'jobman_set_update_percentage' ) );
?>
<h1>Jobman settings</h1>
<br>
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <form method="post" name="jobman" action="">
                <div class="form-group">
                    <label class="switch">
                        <input type="hidden" name="jobman_enable"
                               value="<?php echo ( $jobman_enable == '1' ) ? '1' : '0'
						       ?>"><input
							<?php echo ( $jobman_enable == '1' ) ? 'checked="checked"' : ''
							?>type="checkbox" onclick="this
                    .previousSibling.value=1-this.previousSibling.value">
                        <span class="slider round"></span>
                    </label>
                </div>
                <div class="form-group">
                    <label class="form-check-label" for="inlineCheckbox1"> Add percentage to products %</label>
                    <input type="range" class="regular-text percentage" min="-100" max="100"
                           name="jobman_set_update_percentage"
                           value="<?php echo( ! empty( $jobman_set_update_percentage ) ?
						       $jobman_set_update_percentage : 0 ) ?>"
                           placeholder="percentage" oninput="this.nextElementSibling.value = this.value">
                    <output></output>
                    <span> %</span>
                    <p>
                        Present value:
						<?php echo( ! empty( $jobman_set_update_percentage ) ?
							$jobman_set_update_percentage : 0 ) ?>
                        %
                    </p>
                </div>
                <br>
                <div class="form-group">
                    <select class="form-control" id="exampleFormControlSelect1" name="jobman_set_update_hour">
                        <option selected="selected"><?php echo( ! empty( $jobman_set_update_hour ) ?
								$jobman_set_update_hour : 24 ) ?></option>
						<?php for ( $i = 1; $i <= 24; $i ++ ): ?>
                            <option><?php echo $i ?></option>
						<?php endfor; ?>
                    </select>
                    <label for="exampleFormControlSelect1">Update
                        every: <?php echo( ! empty( $jobman_set_update_hour ) ?
							$jobman_set_update_hour : 24 ) ?> hours</label>
                </div>
                <input type="submit" value="Save settings" class="btn btn-primary">
            </form>
        </div>
        <div class="col-md-6">
			<?php require_once __DIR__ . '/../widgets/jobman_widget.php' ?>
        </div>
    </div>
</div>