<?php

use Inc\Classes\MyFunctions;

$db = new MyFunctions();

$limit = 10;
$page = isset($_GET['pagin']) ? $_GET['pagin'] : 1;
$start = ((int)$page - 1) * $limit;
$total = $db->getCount();
$pages = ceil($total / $limit);

if ($page != 1) {
    $previous = (int)$page - 1;
} else {
    $previous = 1;
}
$next = (int)$page + 1;
if ($next > $pages) {
    $next = $pages;
}

$request_uri = $_SERVER['REQUEST_URI'];

$search = '';
if (!empty($_POST['search'])) {
    $search = $_POST['search'];
}

$db->make($_POST);

$getAll = $db->getAllImg($start, $limit, $search);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title></title>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <script>
        $(document).ready(function () {
            // Activate tooltip
            $('[data-toggle="tooltip"]').tooltip();

            // Select/Deselect checkboxes
            var checkbox = $('table tbody input[type="checkbox"]');
            $("#selectAll").click(function () {
                if (this.checked) {
                    checkbox.each(function () {
                        this.checked = true;
                    });
                } else {
                    checkbox.each(function () {
                        this.checked = false;
                    });
                }
            });
            checkbox.click(function () {
                if (!this.checked) {
                    $("#selectAll").prop("checked", false);
                }
            });
        });
    </script>
</head>
<body>
<?php settings_errors();?>
<ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home"
           aria-selected="true">Manage Img</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile"
           aria-selected="false">Options Img</a>
    </li>
<!--    <li class="nav-item">-->
<!--        <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Contact</a>-->
<!--    </li>-->
</ul>
<div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
        <div class="container-md">
            <div class="table-responsive">
                <div class="table-wrapper">
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
                        <table class="table table-striped table-bordered table-smr" id="dtVerticalScrollExample">
                            <thead>
                            <tr>
                                <th>
							<span class="custom-checkbox">
								<input type="checkbox" id="selectAll">
								<label for="selectAll"></label>
							</span>
                                </th>
                                <th>Img</th>
                                <th>Status</th>
                                <th>Name</th>
                                <th>Format</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody style="overflow-y:auto;">
                            <?php foreach ($getAll as $img): ?>
                                <?php
                                $status = [];
                                if ($img['done'] == 1) {
                                    $status = [
                                        'Optimized' => 'bg-success'
                                    ];
                                } else {
                                    $status = [
                                        'Not optimized' => 'bg-secondary'
                                    ];
                                }
                                echo '
                        <tr>
                        <td>
							<span class="custom-checkbox">
								<input type="checkbox" id="checkbox' . $img['id'] . '" name="options[]" value=" ' . $img['id'] .
                                    '">
								<label for="checkbox' . $img['id'] . '"></label>
							</span>
                        </td>
                        <td>
                        <img style="max-width:100px;" class src="' . $db->buildLinkImg($img['img']) . '" alt="img">
                        </td>
                        <td><span style="color: white" class="badge ' . current($status) . '"> ' . key($status) . ' </span></td>
                        <td>' . $img['img'] .
                                    '</td>
                        <td>png</td>
                        <td>
                            <a href="#editEmployeeModal" class="edit" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Edit">&#xE254;</i></a>
                        </td>
                    </tr>
                        ';
                                ?>
                            <?php endforeach; ?>
                    </form>
                    </tbody>
                    </table>
                    <div class="clearfix">
                        <div class="hint-text">Showing <b><?php echo count($getAll) ?></b> out of <b><?php echo $total ?></b>
                            entries
                        </div>
                        <ul class="pagination">
                            <li class="page-item disabled"><a href="<?php echo $request_uri ?>&pagin=<?php echo $previous; ?>">Previous</a>
                            </li>
                            <?php for ($i = 1; $i <= $pages; $i++): ?>
                                <?php if ($i === (int)$page): ?>
                                    <li class="page-item active"><a href="&pagin=<?php echo $i; ?>" class="page-link"><?php echo
                                            $i;
                                            ?></a></li>
                                <?php elseif ($i != (int)$page): ?>
                                    <li class="page-item"><a href="<?php echo $request_uri ?>&pagin=<?php echo $i; ?>"
                                                             class="page-link"><?php echo $i;
                                            ?></a></li>
                                <?php endif; ?>
                            <?php endfor; ?>
                            <li class="page-item"><a href="<?php echo $request_uri ?>&pagin=<?php echo $next; ?>"
                                                     class="page-link">Next</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
        <form method="post" action="options.php">
            <?php
            settings_fields('profile_bear_plugin_settings');
            do_settings_sections('profile_bear_plugin');
            submit_button();
            ?>
        </form>
    </div>
<!--    <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">3333</div>-->
</div>
</body>
</html>
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</body>
</html>
