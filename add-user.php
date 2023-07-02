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
    $username = $_POST['username'];
    $useremail = $_POST['useremail'];
    $usertype = $_POST['usertype'];
    $userphone = $_POST['userphone'];

    if (isset($_POST['notify'])) {
        $notify = $_POST['notify'];
    } else {
        $notify = false;
    }
    if (isset($_POST['isactive'])) {
        $isactive = $_POST['isactive'];
    } else {
        $isactive = false;
    }
    if (isset($_POST['isverified'])) {
        $isverified = $_POST['isverified'];
    } else {
        $isverified = false;
    }

    _createuser($username, $useremail, $usertype, $userphone, $isactive, $isverified, $notify);
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
                        <h4>Add User</h4>
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
                            <label>Username</label>
                            <input type="text" name="username" class="form-control" />
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label>Useremail</label>
                            <input type="text" name="useremail" class="form-control" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label>Userphone</label>
                            <input type="text" name="userphone" class="form-control" />
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label>User Type</label>
                            <select name="usertype" class="custom-select">
                                <option selected="">Choose...</option>
                                <option value="0">Student</option>
                                <option value="1">Teacher</option>
                                <option value="2">Admin</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <input type="checkbox" checked data-size="small" value="true" name="isactive"
                                class="switch-btn" data-color="#f56767">
                            <label>is Active</label>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <input type="checkbox" data-size="small" value="true" name="isverified" class="switch-btn"
                                data-color="#f56767">
                            <label>is Verified</label>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <input type="checkbox" data-size="small" value="true" name="notify" class="switch-btn"
                                data-color="#f56767">
                            <label>Notify</label>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-3">
                        <div class="input-group mb-0">
                            <input class="btn btn-primary btn-lg btn-block" name="submit" type="submit" value="Add">
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