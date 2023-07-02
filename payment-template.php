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

if (isset($_SESSION['template_success']) || !isset($_SESSION['template_success'])) {
    $_SESSION['template_success'] = false;
}

if (isset($_SESSION['template_error']) || !isset($_SESSION['template_error'])) {
    $_SESSION['template_error'] = false;
}

require('includes/_functions.php');

if (isset($_POST['submit'])) {

    $templateName = '_paymenttemplate';
    $templateCode = $_POST['paymentcode'];

    _updateEmailTemplate($templateName, $templateCode);
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
                <div class="col">
                    <div class="title">
                        <h4>Add Payment Template</h4>
                    </div>
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                Web Help Desk uses tickets to manage service requests. These tickets can be initiated
                                through email, created in the application, and imported from another application. Techs,
                                admins, and clients can also manage tickets through email or through the application in
                                a web browser.
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>

            <form action="#" method="POST">

                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <textarea rows="20" name="paymentcode"
                                class="form-control"><?php echo _getSingleEmailTemplate('_paymenttemplate'); ?></textarea>
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
    <!-- js -->
    <?php require("templates/_js_link.php") ?>



</body>

</html>