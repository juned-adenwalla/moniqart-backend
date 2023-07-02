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

if (isset($_SESSION['forgot_success']) || !isset($_SESSION['forgot_success'])) {
    $_SESSION['forgot_success'] = false;
}

require('includes/_functions.php');

if (isset($_POST['submit'])) {
    $subCategoryname = $_POST['subCategoryname'];
    $subCategoryDesc = $_POST['subCategoryDesc'];
    $categoryId = $_POST['categoryId'];




    if (isset($_POST['isactive'])) {
        $isactive = $_POST['isactive'];
    } else {
        $isactive = false;
    }

    _createSubCategory($subCategoryname, $categoryId, $subCategoryDesc, $isactive);
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

        <div class="pd-20 card-box mb-30">

            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <div class="title">
                        <h4>Create Sub-Category</h4>
                    </div>
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                Fill this information
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
            <form action="#" method="POST">
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label>Sub Category Name</label>
                            <input type="text" name="subCategoryname" class="form-control" />
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <?php _showCategoryOptions() ?>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label>Description</label>
                            <input type="text" name="subCategoryDesc" class="form-control" />
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <input type="checkbox" data-size="small" value="true" name="isactive" class="switch-btn"
                                data-color="#f56767">
                            <label>is Active</label>
                        </div>
                    </div>
                </div>
        </div>



        <div class="row">
            <div class="col-3">
                <div class="input-group mb-0">
                    <input class="btn btn-primary btn-lg btn-block" name="submit" type="submit" value="Create">
                </div>
            </div>
        </div>
        </form>
    </div>

    </div>
    </div>

    </div>
    <!-- js -->
    <?php require("templates/_js_link.php") ?>



</body>

</html>