<?php

session_start();

if (!isset($_SESSION['isLoggedIn']) || !$_SESSION['isLoggedIn'] || $_SESSION['isLoggedIn'] == '') {
    echo "<script>";
    echo "window.location.href = 'login'";
    echo "</script>";
} else {
    if ($_SESSION['userVerify'] != 'true') {
        echo "<script>";
        echo "window.location.href = 'verify'";
        echo "</script>";
    }
}

require('includes/_functions.php');
require('includes/_config.php');

if (isset($_GET['del'])) {
    $_id = $_GET['id'];
    _deletetax($_id);
}


if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $type = $_POST['type'];
    $amount = $_POST['amount'];
    if (isset($_POST['status'])) {
        $status = 'true';
    } else {
        $status = false;
    }
    _createtaxmarkup($name, $type, $amount, $status);
}

?>


<!DOCTYPE html>
<html>

<head>
    <!-- Basic Page Info -->
    <meta charset="utf-8">
    <title>Dashboard</title>


    <?php require("templates/_css_link.php") ?>


</head>

<body>
    <!-- Loader -->
    <?php require("templates/_loader.php") ?>

    <!-- Header -->
    <?php require("templates/_topbar.php") ?>

    <!-- Layout Sidebar -->
    <?php require("templates/_right_sidebar.php") ?>

    <?php require("templates/_sidebar.php") ?>


    <div class="main-container">
        <div class="pd-ltr-20 xs-pd-20-10">
            <div class="min-height-200px">

                <div class="card-box mb-30">
                    <div class="pd-20">
                        <div class="row">
                            <div class="col">
                                <h4 class="text-black h4">Manage Fees (Fee Markup)</h4>
                                <p class="mb-0">
                                    Web Help Desk uses tickets to manage service requests. These tickets can be
                                    initiated
                                    through email, created in the application, and imported from another application.
                                    Techs,
                                    admins, and clients can also manage tickets through email or through the application
                                    in
                                    a
                                    web browser.
                                </p>
                            </div>
                        </div>

                        <div class="row" style="margin-top: 30px;">
                            <div class="col">
                                <a href="#" data-toggle="modal" data-target="#modal" class="btn btn-dark"
                                    style="float: right;">
                                    Add Markup
                                </a>
                            </div>

                            <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <form method="post" action="#" enctype="multipart/form-data" class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="myLargeModalLabel">Add Markup</h4>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-hidden="true">×</button>
                                        </div>
                                        <div class="modal-body pd-5" style="padding: 15px;">
                                            <div class="row">
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label>Fee Name</label>
                                                        <input type="text" name="name" placeholder="Tax Name"
                                                            class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label>Fee Type</label>
                                                        <select class="form-control" name="type" style="width: 100%;">
                                                            <option value="Variable">Percentage</option>
                                                            <option value="Fixed">Fixed</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label>Fee Amount</label>
                                                        <input type="text" name="amount" placeholder="Tax Amount"
                                                            class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col" style="margin-top: 30px;">
                                                    <div class="form-group">
                                                        <input type="checkbox" data-size="small" value="true"
                                                            name="status" class="switch-btn" data-color="#f56767">
                                                        <label>is Active</label>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="modal-footer">
                                            <input type="submit" value="Add" name="submit" class="btn btn-primary">
                                            <button type="button" class="btn btn-default"
                                                data-dismiss="modal">Close</button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="pb-20" style="margin-top: 30px;">
                        <table class="data-table table stripe hover nowrap">
                            <thead>
                                <tr>
                                    <th>Created At</th>
                                    <th>Fee Name</th>
                                    <th>Fee Type</th>
                                    <th>Fee Amount</th>
                                    <th>Status</th>
                                    <th class="datatable-nosort">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php _gettaxmarkup(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        $('.select2').select2();

    </script>

    <!-- js -->
    <?php include("templates/_js_link.php") ?>
    <!-- buttons for Export datatable -->
    <script src="src/plugins/datatables/js/dataTables.buttons.min.js"></script>
    <script src="src/plugins/datatables/js/buttons.bootstrap4.min.js"></script>
    <script src="src/plugins/datatables/js/buttons.print.min.js"></script>
    <script src="src/plugins/datatables/js/buttons.html5.min.js"></script>
    <script src="src/plugins/datatables/js/buttons.flash.min.js"></script>
    <script src="src/plugins/datatables/js/pdfmake.min.js"></script>
    <script src="src/plugins/datatables/js/vfs_fonts.js"></script>
    <!-- Datatable Setting js -->
    <script src="vendors/scripts/datatable-setting.js"></script>



</body>

</html>