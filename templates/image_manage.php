<?php

$path = $_SERVER['DOCUMENT_ROOT'];
include_once $path . '/wp-load.php';

require __DIR__ . '/../inc/Classes/MyFunctions.php';

$limit = (isset($_GET['limit'])) ? $_GET['limit'] : 100;
$page = (isset($_GET['pagin'])) ? $_GET['pagin'] : 1;
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
                       aria-label="Search" aria-describedby="search-addon" value="<?php echo $search ?>"/>
                <input class="btn btn-danger" type="submit" name="delete" value="Delete">
                <input class="btn btn-success" type="submit" name="edit" value="Change Status">
                <input class="btn btn-secondary" type="submit" name="edit_secondary" value="Change Status">
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
            <tr>
                <td>
                    <span class="custom-checkbox">
                        <input type="checkbox" id="checkbox' <?php echo $results->data[$i]['img']; ?>"
                                       name="options[]" value="<?php echo $results->data[$i]['id']; ?>">
                        <label for="checkbox' <?php echo $results->data[$i]['img']; ?>"></label>
                    </span>
                </td>
                <td>
                    <img style="max-width:100px;"  src="<?php echo $db->buildLinkImg($results->data[$i]['img']) ?>"
                         alt="img">
                </td>
                <td>
                    <?php echo $results->data[$i]['img']?>
                </td>
                <td>
                    <span type="button" class="btn <?php echo current($file->getStatus($results->data[$i]['done']))
                    ?>"><?php echo key($file->getStatus($results->data[$i]['done']))?></span>
                <td>
                    <button type="button"
                            class="btn btn-info"><?php echo $file->getExtImg($results->data[$i]['img']) ?></button>
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


