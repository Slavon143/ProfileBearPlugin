<?php
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
<div class="card <?php echo ($img_status == '1') ? 'border-success' : 'border-secondary' ?> mb-3" style="max-width: 18rem;">
    <div class="card-header bg-transparent <?php echo ($img_status == '1') ? 'border-success' : 'border-secondary' ?>">Optimization IMG</div>
    <div class="card-body <?php echo ($img_status == '1') ? 'text-success' : 'text-secondary' ?>">
        <h5 class="card-title"><?php echo ($img_status == '1') ? 'Status: active' : 'Status: inactive' ?></h5>
        <p class="card-text">Total img: <strong><?php echo $total[0][0] ?></strong></p>
        <p class="card-text">Complete: <strong><?php echo $complete[0][0] ?></strong></p>
        <p class="card-text">Launch every: <strong><?php echo $timeUpdate ?></strong> hours</p>

        <p class="card-text">Quality: <strong><?php echo $quality?></strong></p>
        <p class="card-text">Memory: <strong> <?php echo round($memory[0][0] / 1024 / 1024, 2) ?></strong> Mb</p>
        <p class="card-text">Error: <strong><?php echo $error[0][0] ?></strong></p>
    </div>
    <div class="card-footer bg-transparent <?php echo ($img_status == '1') ? 'border-success' : 'border-secondary' ?>"></div>
</div>

