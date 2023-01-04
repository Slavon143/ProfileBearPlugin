<?php settings_errors(); ?>
<ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home"
           aria-selected="true">Manage Img</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile"
           aria-selected="false">Settings Img</a>
    </li>
</ul>
<div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
		<?php
		require_once plugin_dir_path( __FILE__ ) . '../templates/image_manage.php';
		?>
    </div>
    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
        <div class="row">
            <div class="col-md-6">
                <form method="post" action="options.php">
					<?php
					settings_fields( 'profile_bear_plugin_settings' );
					do_settings_sections( 'profile_bear_plugin' );
					submit_button();
					?>
                </form>
            </div>
            <div class="col-md-6">
				<?php require_once plugin_dir_path( __FILE__ ) . '/../widgets/img_manage_widget.php' ?>
            </div>
        </div>
    </div>
</div>