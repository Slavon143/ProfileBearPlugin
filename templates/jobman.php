<?php

use Inc\Classes\Parsers;

$parser = new Parsers();
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
$jobman_set_update_hour       = esc_attr( get_option( 'jobman_set_update_hour' ) );
$jobman_set_update_percentage = esc_attr( get_option( 'jobman_set_update_percentage' ) );
?>
<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css"
          rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
<h1>Jobman settings</h1>
<br>
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <form method="post" name="jobman" action="">
                <div class="form-group">
					<?php
					echo '<input name="jobman_enable" type="checkbox" ' . ( $jobman_enable == 'on' ? 'checked' : '' ) .
                         ' data-toggle="toggle" data-style="ios">';
					?>
                </div>
                <div class="form-group">
                    <label class="form-check-label" for="inlineCheckbox1"> Add percentage to products %</label>
                    <input type="range" class="regular-text percentage" min="0" max="100"
                           name="jobman_set_update_percentage"
                           value="<?php echo( !empty( $jobman_set_update_percentage ) ?
						       $jobman_set_update_percentage : 0 ) ?>"
                           placeholder="percentage" oninput="this.nextElementSibling.value = this.value">
                    <output></output>
                    <span> %</span>
                    <br>
                    <p>
                        Present value:
						<?php echo( !empty( $jobman_set_update_percentage ) ?
							$jobman_set_update_percentage : 0 ) ?>
                        %
                    </p>
                </div>
                <br>
                <div class="form-group">
                    <select class="form-control" id="exampleFormControlSelect1" name="jobman_set_update_hour">
                        <option selected="selected"><?php echo( !empty( $jobman_set_update_hour ) ?
								$jobman_set_update_hour : 24 ) ?></option>
						<?php for ( $i = 1; $i <= 24; $i ++ ): ?>
                            <option><?php echo $i ?></option>
						<?php endfor; ?>
                    </select>
                    <label for="exampleFormControlSelect1">Update
                        every: <?php echo( !empty( $jobman_set_update_hour ) ?
							$jobman_set_update_hour : 24 ) ?> hours</label>
                </div>
                <input type="submit" value="submit_jobman_settings" class="btn btn-primary">
            </form>
        </div>
        <div class="col-md-6">
			<?php echo '
            <div class="card ' .( $jobman_enable == 'on' ? 'border-success' : 'border-secondary' ). ' mb-3" style="max-width: 18rem;">
                <div class="card-header bg-transparent ' .( $jobman_enable == 'on' ? 'border-success' : 'border-secondary' ). '">Jobman import</div>
                <div class="card-body ' .( $jobman_enable == 'on' ? 'text-success' : 'text-secondary' ). '">
                    <h5 class="card-title">Status: ' .( $jobman_enable == 'on' ? 'Active' : 'Inactive' ). '</h5>
                    <p class="card-text">Items loaded: <strong><?= rand(1,100)?></strong></p>
                    <p class="card-text">Updated products: <strong><?= rand(1,100)?></strong></p>
                    <p class="card-text">Launch every: <strong>' .( $jobman_set_update_hour ?
					$jobman_set_update_hour : '' ). '</strong> clock</p>
                </div>
                <div class="card-footer bg-transparent ' .( $jobman_enable == 'on' ? 'border-success' : 'border-secondary' ). '"></div>
            </div>
            ';?>
        </div>
    </div>
</div>
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>

</body>
</html>