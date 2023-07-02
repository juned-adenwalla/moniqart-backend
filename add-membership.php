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
if (isset($_SESSION['membership_success']) || !isset($_SESSION['membership_success'])) {
    $_SESSION['membership_success'] = false;
}

if (isset($_SESSION['membership_error']) || !isset($_SESSION['membership_error'])) {
    $_SESSION['membership_error'] = false;
}

require('includes/_functions.php');

if (isset($_POST['submit'])) {

    $membershipname = $_POST['membershipname'];
    $membershipdesc = $_POST['membershipdesc'];
    $duration = $_POST['duration'];
    $discount = $_POST['discount'];
    $discounttype = $_POST['discounttype'];
    $price = $_POST['price'];

    if (isset($_POST['isactive'])) {
        $isactive = 'true';
    } else {
        $isactive = 'false';
    }

    if ($_FILES["file"]["name"] != '') {
        $file = $_FILES["file"]["name"];
        $extension = substr($file, strlen($file) - 4, strlen($file));
        $allowed_extensions = array(".jpg", ".jpeg", ".png", ".gif");
        // Validation for allowed extensions .in_array() function searches an array for a specific value.
        if (!in_array($extension, $allowed_extensions)) {
            echo "<script>alert('Invalid format. Only jpg / jpeg/ png /gif format allowed');</script>";
        } else {
            $img = md5($file) . $extension;
            move_uploaded_file($_FILES["file"]["tmp_name"], "uploads/membershipimages/" . $img);
        }
    }

    _createMembership($membershipname,$img, $membershipdesc, $duration, $discount, $discounttype, $price, $isactive);
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
                        <h4>Add Subscription</h4>
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
                            <label>Subscription Name</label>
                            <input type="text" name="membershipname" placeholder="Subscription Name" class="form-control" />
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label>Duration(Months)</label>
                            <select name="duration" class="custom-select">
                                <option selected>Select Duration</option>
                                <option value="1">1 month </option>
                                <option value="2">2 month </option>
                                <option value="3">3 month </option>
                                <option value="4">4 month </option>
                                <option value="5">5 month </option>
                                <option value="6">6 month </option>
                                <option value="7">7 month </option>
                                <option value="8">8 month </option>
                                <option value="9">9 month </option>
                                <option value="10">10 month </option>
                                <option value="11">11 month </option>
                                <option value="12">12 month </option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label>Subscription Price</label>
                            <input type="text" name="price" placeholder="Subscription Price"
                                class="form-control" />
                        </div>
                    </div>

                    <div class="col">
                        <div class="form-group">
                            <label>Discount Type</label>
                            <select name="discounttype" class="custom-select">
                                <option selected="">Type</option>
                                <option value="fixed">Fixed</option>
                                <option value="percentage">Percentage</option>
                            </select>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label>Discount</label>
                            <input type="text" name="discount" placeholder="Discount" class="form-control" />
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
                            <h4 class="h4 text-dark">Subscription Description</h4>
                            <textarea id="mytextarea" name="membershipdesc" class="form-control border-radius-0"
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