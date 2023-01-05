<?php

$path = $_SERVER['DOCUMENT_ROOT'];
include_once $path . '/wp-load.php';

require __DIR__ . '/../inc/Classes/MyFunctions.php';

$limit = (isset($_GET['limit'])) ? $_GET['limit'] : 100;
$page = (!empty($_GET['pagin'])) ? $_GET['pagin'] : 1;
$links = (isset($_GET['links'])) ? $_GET['links'] : 4;
$search = (isset($_POST['search'])) ? $_POST['search'] : null;
$search = trim($search);
$query = "SELECT * FROM `optimize_img`";
$Paginator = new \Inc\Classes\Paginator($query);

$results = $Paginator->getData($limit, $page,$search);
$db = new \Inc\Classes\MyFunctions();
$file = new \Inc\Classes\File();
if (!empty($_POST)){
    $db->make($_POST);
}
?>

<form action="" method="post" name="chose_img">
    <div class="table-title">
        <div class="row">
            <div class="col-sm-6">
                <h2>Manage <b>Img</b></h2>
            </div>
            <div class="col-sm-6">
                <input style="margin-bottom: 15px" name="search" type="search" class="form-control rounded"
                       placeholder="Search"
                       aria-label="Search" aria-describedby="search-addon" value="<?php echo $search ?>">
                <input class="btn btn-danger" type="submit" name="delete" value="Delete"
                       onclick="return confirm('Confirm?')">
                <input class="btn btn-success" type="submit" name="edit" value="Change Status"
                       onclick="return confirm('Confirm change status: Optimise?')">
                <input class="btn btn-secondary" type="submit" name="edit_secondary" value="Change Status"
                       onclick="return confirm('Confirm change status: Optimise?')">
            </div>
        </div>
    </div>
    <table class="table table-striped table-condensed table-bordered table-rounded" id="dtVerticalScrollExample">
        <thead>
        <tr>
            <th>
                <span class="custom-checkbox">
                    <input type="checkbox" onclick="toggle(this);" id="select-all">
                    <label for="selectAll"></label>
                </span>
            </th>
            <th>Img</th>
            <th>Name</th>
            <th>Status</th>
            <th>Format</th>
        </tr>
        </thead>
        <tbody>
        <?php for ($i = 0; $i < count($results->data); $i++) : ?>
        <?php
            $img_id = $results->data[$i]['id'];
            $img_path = $results->data[$i]['img'];
            $img_status = $results->data[$i]['done'];
        ?>
            <tr>
                <td>
                    <span class="custom-checkbox">
                        <input type="checkbox" id="checkbox"
                                       name="options[]" value="<?php echo $img_id; ?>">
                        <input type="hidden" name="img_path" value="<?php echo $img_path?>">
                    </span>
                </td>
                <td>
                    <img style="max-width:100px;"  src="<?php echo $db->buildLinkImg($img_path) ?>"
                         alt="img">
                </td>
                <td>
                    <?php echo $img_path?>
                </td>
                <td>
                    <span type="button" class="btn <?php echo current($file->getStatus($img_status))
                    ?>"><?php echo key($file->getStatus($img_status))?></span>
                <td>
                    <button type="button"
                            class="btn btn-info"><?php echo $file->getExtImg($img_path) ?></button>
                </td>
            </tr>
        <?php endfor; ?>
        </tbody>
    </table>
    <?php if (empty($search)):?>
        <nav aria-label="Page navigation example">
		    <?php echo $Paginator->createLinks($links, 'pagination'); ?>
        </nav>
    <?php endif;?>
</form>


