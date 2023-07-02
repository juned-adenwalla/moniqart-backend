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

if (isset($_SESSION['blog_success']) || !isset($_SESSION['blog_success'])) {
    $_SESSION['blog_success'] = false;
}

if (isset($_SESSION['blog_error']) || !isset($_SESSION['blog_error'])) {
    $_SESSION['blog_error'] = false;
}
require('includes/_functions.php');

if (isset($_POST['submit'])) {

    $_blogtitle = $_POST['_blogtitle'];
    $_blogdesc = $_POST['_blogdesc'];
    $_blogcategory = $_POST['categoryId'];
    $_blogsubcategory = $_POST['subcategoryId'];
    $_blogmetadesc = $_POST['_blogmetadesc'];

    if (isset($_POST['isactive'])) {
        $_status = 'true';
    } else {
        $_status = false;
    }

    $_userid = $_SESSION['userId'];


    if ($_FILES["file"]["name"] != '') {
        $file = $_FILES["file"]["name"];
        $extension = substr($file, strlen($file) - 4, strlen($file));
        $allowed_extensions = array(".jpg", ".jpeg", ".png", ".gif");
        // Validation for allowed extensions .in_array() function searches an array for a specific value.
        if (!in_array($extension, $allowed_extensions)) {
            echo "<script>alert('Invalid format. Only jpg / jpeg/ png /gif format allowed');</script>";
        } else {
            $_blogimg = md5($file) . $extension;
            move_uploaded_file($_FILES["file"]["tmp_name"], "uploads/blogsPics/" . $_blogimg);
        }
    }



    _createBlog($_blogtitle, $_blogdesc, $_blogcategory, $_blogsubcategory, $_blogmetadesc, $_blogimg, $_userid, $_status);
}

?>


<!DOCTYPE html>
<html>

<head>
    <!-- Basic Page Info -->
    <meta charset="utf-8">
    <title>Dashboard</title>


    <?php require("templates/_css_link.php") ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.5.1/tinymce.min.js"
        integrity="sha512-UhysBLt7bspJ0yBkIxTrdubkLVd4qqE4Ek7k22ijq/ZAYe0aadTVXZzFSIwgC9VYnJabw7kg9UMBsiLC77LXyw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        tinymce.init({
            selector: '#mytextarea',
            statusbar: false,
            branding: false,
            promotion: false,
        });
    </script>

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
                        <h4>Create Blog</h4>
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
                            <label>Blog Title</label>
                            <input type="text" name="_blogtitle" class="form-control" />
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <?php _showCategoryOptions("", "blog") ?>

                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <?php _showSubCategoryOptions() ?>

                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col" style="margin-top: 30px;">
                        <div class="form-group">
                            <input type="checkbox" data-size="small" value="true" name="isactive" class="switch-btn"
                                data-color="#f56767">
                            <label>is Active</label>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label>Featured Image</label>
                            <input type="file" name="file" id="file" class="form-control-file form-control height-auto">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <h4 class="h4 text-dark">Meta Description</h4>
                            <textarea name="_blogmetadesc" class="form-control border-radius-0"
                                placeholder="Enter text ..."></textarea>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <h4 class="h4 text-dark">Detailed Description</h4>
                            <textarea id="mytextarea" name="_blogdesc" class="form-control border-radius-0"
                                placeholder="Enter text ..."></textarea>
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

    <script>
        const getSubCategory = (val) => {
            $.ajax({
                type: "POST",
                url: "utils/getSubCategory.php",
                data: 'catid=' + val,
                success: function (data) {
                    $(`#subcategoryId`).html(data);
                }
            });
        }
        $('.select2').select2();

    </script>

    <!-- js -->
    <?php require("templates/_js_link.php") ?>





</body>

</html>