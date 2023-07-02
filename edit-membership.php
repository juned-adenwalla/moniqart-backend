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


$_id = $_GET['id'];

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
    } else {
        $img = _getSingleMembership($_id, '_img');
    }

    _updateMembership($_id, $membershipname, $img, $membershipdesc, $duration, $discount, $discounttype, $price, $isactive);
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
                        <h4>Update Subscription</h4>
                    </div>
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                Update this information
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
                            <input type="text" value="<?php echo _getSingleMembership($_id, '_membershipname'); ?>"
                                name="membershipname" placeholder="Subscription Name" class="form-control" />
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label>Duration(Months)</label>
                            <select name="duration" class="custom-select">
                                <?php
                                $duration = _getSingleMembership($_id, '_duration');

                                for ($i = 1; $i <= 12; $i++) {

                                    if ($duration == $i) {
                                        ?>
                                        <option value="<?php echo $duration ?>" selected>
                                            <?php echo $duration ?> month
                                        </option>
                                        <?php
                                    } else {
                                        ?>
                                        <option value="<?php echo $i ?>">
                                            <?php echo $i ?> month
                                        </option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label>Subscription Price</label>
                            <input type="text" name="price" value="<?php echo _getSingleMembership($_id, '_price'); ?>"
                                placeholder="Subscription Price" class="form-control" />
                        </div>
                    </div>

                    <div class="col">
                        <div class="form-group">
                            <label>Discount Type</label>
                            <select name="discounttype" class="custom-select">
                                <?php

                                $benetype = _getSingleMembership($_id, '_benefittype');

                                if ($benetype == 'Fixed') {
                                    ?>
                                    <option selected value="Fixed">Fixed</option>
                                    <option value="Variable">Percentage</option>
                                    <?php
                                } else {
                                    ?>
                                    <option value="Fixed">Fixed</option>
                                    <option selected value="Variable">Percentage</option>
                                    <?php
                                }

                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label>Discount</label>
                            <input type="text" name="discount"
                                value="<?php echo _getSingleMembership($_id, '_benefit'); ?>" placeholder="Discount"
                                class="form-control" />
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col" style="margin-top: 30px;">
                        <div class="form-group">
                            <?php

                            $status = _getSingleMembership($_id, '_status');
                            if ($status == 'true') {
                                ?>
                                <input type="checkbox" checked data-size="small" value="true" name="isactive"
                                    class="switch-btn" data-color="#f56767">
                                <label>is Active</label>
                                <?php
                            } else {
                                ?>
                                <input type="checkbox" data-size="small" value="true" name="isactive" class="switch-btn"
                                    data-color="#f56767">
                                <label>is Active</label>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label>Featured Image</label>
                            <input type="file" name="file" id="file" class="form-control-file form-control height-auto">
                            <a href="uploads/membershipimages/<?php echo _getSingleMembership($_id, '_img'); ?>"
                                target="_blank">Open Featured Image &nbsp;<svg xmlns="http://www.w3.org/2000/svg"
                                    style="width: 15px;" viewBox="0 0 512 512">
                                    <!-- Font Awesome Pro 5.15.4 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) -->
                                    <path
                                        d="M326.612 185.391c59.747 59.809 58.927 155.698.36 214.59-.11.12-.24.25-.36.37l-67.2 67.2c-59.27 59.27-155.699 59.262-214.96 0-59.27-59.26-59.27-155.7 0-214.96l37.106-37.106c9.84-9.84 26.786-3.3 27.294 10.606.648 17.722 3.826 35.527 9.69 52.721 1.986 5.822.567 12.262-3.783 16.612l-13.087 13.087c-28.026 28.026-28.905 73.66-1.155 101.96 28.024 28.579 74.086 28.749 102.325.51l67.2-67.19c28.191-28.191 28.073-73.757 0-101.83-3.701-3.694-7.429-6.564-10.341-8.569a16.037 16.037 0 0 1-6.947-12.606c-.396-10.567 3.348-21.456 11.698-29.806l21.054-21.055c5.521-5.521 14.182-6.199 20.584-1.731a152.482 152.482 0 0 1 20.522 17.197zM467.547 44.449c-59.261-59.262-155.69-59.27-214.96 0l-67.2 67.2c-.12.12-.25.25-.36.37-58.566 58.892-59.387 154.781.36 214.59a152.454 152.454 0 0 0 20.521 17.196c6.402 4.468 15.064 3.789 20.584-1.731l21.054-21.055c8.35-8.35 12.094-19.239 11.698-29.806a16.037 16.037 0 0 0-6.947-12.606c-2.912-2.005-6.64-4.875-10.341-8.569-28.073-28.073-28.191-73.639 0-101.83l67.2-67.19c28.239-28.239 74.3-28.069 102.325.51 27.75 28.3 26.872 73.934-1.155 101.96l-13.087 13.087c-4.35 4.35-5.769 10.79-3.783 16.612 5.864 17.194 9.042 34.999 9.69 52.721.509 13.906 17.454 20.446 27.294 10.606l37.106-37.106c59.271-59.259 59.271-155.699.001-214.959z" />
                                </svg></a>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <h4 class="h4 text-dark">Subscription Description</h4>
                            <textarea id="mytextarea" name="membershipdesc" class="form-control border-radius-0"
                                placeholder="Enter text ..."><?php echo _getSingleMembership($_id, '_membershipdesc'); ?></textarea>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-3">
                        <div class="input-group mb-0">
                            <input class="btn btn-primary btn-lg btn-block" name="submit" type="submit" value="Update">
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