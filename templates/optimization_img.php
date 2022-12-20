<div class="wrap">
    <?php settings_errors(); ?>

    <ul class="nav nav-tabs">
        <li class="active"><a href="#tab-1">Manage Settings</a></li>
        <li><a href="#tab-2">Status Optimize IMG</a></li>
        <!--		<li><a href="#tab-3">About</a></li>-->
    </ul>

    <div class="tab-content">
        <div id="tab-1" class="tab-pane active">

            <form method="post" action="options.php">
                <?php
                settings_fields( 'profile_bear_plugin_settings' );
                do_settings_sections( 'profile_bear_plugin' );
                submit_button();
                ?>
            </form>
        </div>

        <div id="tab-2" class="tab-pane">
            <!doctype html>

            <html lang="ru">
            <head>
                <meta charset="utf-8">
                <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
                <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
                <title>Image optimization report</title>
            </head>
            <body>
            <div class="container" style="max-width: 900px;">
                <h2>Image optimization report</h2>
                <dl class="row">
                    <dt class="col-sm-3">Total:</dt>
                    <dd class="col-sm-9">
                        <?php
                        global $wpdb;
                        $sth = $wpdb->get_results("SELECT COUNT(`id`) FROM `optimize_img`",ARRAY_N);
                        echo $sth[0][0];
                        ?> Things
                    </dd>
                    <dt class="col-sm-3">Completed:</dt>
                    <dd class="col-sm-9">
                        <?php
                        $sth = $wpdb->get_results("SELECT COUNT(`id`) FROM `optimize_img` WHERE `done` = 1",ARRAY_N);
                        echo $sth[0][0];
                        ?> Things
                    </dd>
                    <dt class="col-sm-3">Optimized:</dt>
                    <dd class="col-sm-9">
                        <?php
                        $sth =  $wpdb->get_results("SELECT SUM(`diff`) FROM `optimize_img` WHERE `done` = 1",ARRAY_N);

                        echo round($sth[0][0] / 1024 / 1024, 2);
                        ?> MB
                    </dd>
                    <dt class="col-sm-3">Errors:</dt>
                    <dd class="col-sm-9">
                        <?php
                        $sth = $wpdb->get_results("SELECT COUNT(`id`) FROM `optimize_img` WHERE `error` <> ''",ARRAY_N);
                        echo $sth[0][0];
                        ?>
                        Things
                    </dd>
                </dl>
            </div>

            </body>
            </html>
        </div>

        <!--		<div id="tab-3" class="tab-pane">-->
        <!--			<h3>About</h3>-->
        <!--		</div>-->
    </div>
</div>
