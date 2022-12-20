<?php

namespace Inc\Classes;
$path = $_SERVER['DOCUMENT_ROOT'];
include_once $path . '/wp-load.php';

global $wpdb;

$img_status = get_option('optimize_img');
$total = $wpdb->get_results("SELECT COUNT(`id`) FROM `optimize_img`", ARRAY_N);
$complete = $wpdb->get_results("SELECT COUNT(`id`) FROM `optimize_img` WHERE `done` = 1", ARRAY_N);
$memory = $wpdb->get_results("SELECT SUM(`diff`) FROM `optimize_img` WHERE `done` = 1", ARRAY_N);
$error = $wpdb->get_results("SELECT COUNT(`id`) FROM `optimize_img` WHERE `error` <> ''", ARRAY_N);
$quality = (int)get_option('optimize_quality_img');
$timeUpdate = get_option('optimize_img_time_update');
?>
<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>ProfileBear Plugin Dashboard</title>
</head>
<body>
<h1>ProfileBear Plugin Dashboard!</h1>
<div class="container">
    <div class="row">
        <div class="col-md-3">
            <?php
            if ($img_status) {
                ?>
                <div class="card border-success mb-3" style="max-width: 18rem;">
                    <div class="card-header bg-transparent border-success">Optimization IMG</div>
                    <div class="card-body text-success">
                        <h5 class="card-title">Status: active</h5>
                        <p class="card-text">Total img: <strong><?= $total[0][0] ?></strong></p>
                        <p class="card-text">Complete: <strong><?= $complete[0][0] ?></strong></p>
                        <p class="card-text">Launch every: <strong><?= $timeUpdate ?></strong> clock</p>

                        <p class="card-text">Quality: <strong><?= $quality?></strong></p>
                        <p class="card-text">Memory: <strong> <?= round($memory[0][0] / 1024 / 1024, 2) ?></strong> Mb</p>
                        <p class="card-text">Error: <strong><?= $error[0][0] ?></strong></p>
                    </div>
                    <div class="card-footer bg-transparent border-success"></div>
                </div>
                <?
            } else {
                ?>
                <div class="card border-secondary mb-3" style="max-width: 18rem;">
                    <div class="card-header bg-transparent border-secondary">Optimization IMG</div>
                    <div class="card-body text-secondary">
                        <h5 class="card-title">Status: deactivated</h5>
                    </div>
                    <div class="card-footer bg-transparent border-secondary"></div>
                </div>
                <?
            }
            ?>

        </div>
        <div class="col-md-3">
            <div class="card border-success mb-3" style="max-width: 18rem;">
                <div class="card-header bg-transparent border-success">Portwest import</div>
                <div class="card-body text-success">
                    <h5 class="card-title">Status: active</h5>
                    <p class="card-text">Items loaded: <strong><?= rand(1,100)?></strong></p>
                    <p class="card-text">Updated products: <strong><?= rand(1,100)?></strong></p>
                    <p class="card-text">Launch every: <strong><?= rand(1,24)?> clock</strong></p>
                </div>
                <div class="card-footer bg-transparent border-success"></div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-success mb-3" style="max-width: 18rem;">
                <div class="card-header bg-transparent border-success">Bastadgruppen import</div>
                <div class="card-body text-success">
                    <h5 class="card-title">Status: active</h5>
                    <p class="card-text">Items loaded: <strong><?= rand(1,100)?></strong></p>
                    <p class="card-text">Updated products: <strong><?= rand(1,100)?></strong></p>
                    <p class="card-text">Launch every: <strong><?= rand(1,24)?> clock</strong></p>
                </div>
                <div class="card-footer bg-transparent border-success"></div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-success mb-3" style="max-width: 18rem;">
                <div class="card-header bg-transparent border-success">Jobman import</div>
                <div class="card-body text-success">
                    <h5 class="card-title">Status: active</h5>
                    <p class="card-text">Items loaded: <strong><?= rand(1,100)?></strong></p>
                    <p class="card-text">Updated products: <strong><?= rand(1,100)?></strong></p>
                    <p class="card-text">Launch every: <strong><?= rand(1,24)?> clock</strong></p>
                </div>
                <div class="card-footer bg-transparent border-success"></div>
            </div>
        </div>
    </div>

</div>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
</body>
</html>