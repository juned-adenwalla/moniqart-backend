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
    $suppliername = $_POST['suppliername'];
    $apikey = $_POST['apikey'];
    $secretkey = $_POST['secretkey'];
    $companyname = $_POST['companyname'];
    if (isset($_POST['isactive'])) {
        $isactive = $_POST['isactive'];
    } else {
        $isactive = false;
    }
    _savepaymentconfig($suppliername, $apikey,$secretkey, $companyname, $isactive);
}
if (isset($_POST['send'])) {
    $phonenumber = $_POST['phone'];
    $message = $_POST['message'];

    _notifyuser('', $phonenumber, $message, '');
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

            <form action="#" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="col">
                        <div class="title">
                            <h4>Payment Configuration (Razorpay)</h4>
                        </div>
                        <nav aria-label="breadcrumb" role="navigation">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    Log in to your Razorpay account. Navigate to Settings > All settings > API Keys. If
                                    you have previously created an API key, paste the credentials over here, Kindly fo
                                    not make any changes over here if you have no knowlddge of API contact support in
                                    case of any confusion.
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>


                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <input type="text" value="<?php echo _paymentconfig('_suppliername'); ?>"
                                name="suppliername" placeholder="Supplier Name" class="form-control" />
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <input type="password" placeholder="Api Key"
                                value="<?php echo _paymentconfig('_apikey'); ?>" name="apikey" class="form-control" />
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <input type="password" placeholder="Key Secret"
                                value="<?php echo _paymentconfig('_secretkey'); ?>" name="secretkey" class="form-control" />
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <input type="text" value="<?php echo _paymentconfig('_companyname'); ?>" name="companyname"
                                placeholder="Company Name" class="form-control" />
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <?php

                            $status = _smsconfig('_supplierstatus');
                            if ($status == true) {
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
                </div>


                <div class="row">
                    <div class="col-3">
                        <div class="input-group mb-0">
                            <input class="btn btn-primary btn-lg btn-block" name="submit" type="submit"
                                value="Save Settings">
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