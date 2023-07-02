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
    $categoryname = $_POST['categoryname'];
    $categoryDesc = $_POST['categoryDesc'];

    $categorytype = $_POST['categorytype'];

    $categoryimg = null;

    if (isset($_POST['isactive'])) {
        $isactive = $_POST['isactive'];
    } else {
        $isactive = false;
    }

    if ($_FILES["banner"]["name"] != '') {
        $banner = $_FILES["banner"]["name"];
        $extension = substr($banner, strlen($banner) - 4, strlen($banner));
        $allowed_extensions = array(".jpg", ".jpeg", ".png", ".gif", ".webp", ".svg");
        if (!in_array($extension, $allowed_extensions)) {
            echo "<script>alert('Invalid format. Only jpg / jpeg/ png /gif / Webp/ Svg format allowed for Banner');</script>";
            echo "<script>windows.reload()<script>";
        } else {
            $categoryimg = md5($banner) . $extension;
            move_uploaded_file($_FILES["banner"]["tmp_name"], "uploads/categoryimages/" . $categoryimg);
        }
    }


    _createCategory($categoryname, $categoryDesc, $categoryimg, $isactive, $categorytype);
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
                        <h4>Create Category</h4>
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

            <form action="#" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label>Category Name</label>
                            <input type="text" name="categoryname" class="form-control" />
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">

                            <label>Category For</label>
                            <select name="categorytype" class="custom-select">
                                <option selected disabled value="">Type</option>
                                <option value="blog">Blog</option>
                                <option value="courses">Course</option>
                                <option value="product">Product</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label>Description</label>
                            <input type="text" name="categoryDesc" class="form-control" />
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label>Featured Image</label>
                            <input type="file" name="banner" id="banner" class="form-control-file form-control">
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