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

if (isset($_SESSION['send_mail']) || !isset($_SESSION['send_mail'])) {
    $_SESSION['send_mail'] = false;
}

require('includes/_functions.php');

if (isset($_POST['submit'])) {
    $hostname = $_POST['hostname'];
    $hostport = $_POST['hostport'];
    $emailid = $_POST['email'];
    $password = $_POST['password'];
    $sendername = $_POST['sender'];
    if (isset($_POST['smtpauth'])) {
        $smtpauth = $_POST['smtpauth'];
    } else {
        $smtpauth = false;
    }
    if (isset($_POST['status'])) {
        $status = $_POST['status'];
    } else {
        $status = false;
    }
    _saveemailconfig($hostname, $hostport, $smtpauth, $emailid, $password, $sendername, $status);
}
if (isset($_POST['send'])) {
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    _notifyuser($email, '', $message, $subject);
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
                            <h4>Email Configuration (SMTP)</h4>
                        </div>
                        <nav aria-label="breadcrumb" role="navigation">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    If you have set up an E-Mail address in the Control Panel, Log in to your panel
                                    account. Navigate to Email > Email Account > Checkmail. you must have recieved a
                                    mial with configuration details, paste the credentials over here, Kindly fo not make
                                    any changes over here if you have no knowlddge of SMTP contact support in case of
                                    any confusion.
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>


                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <input type="text" value="<?php echo _emailconfig('_hostname'); ?>" name="hostname"
                                placeholder="Host Name" class="form-control" />
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <input type="password" placeholder="Host Port"
                                value="<?php echo _emailconfig('_hostport'); ?>" name="hostport" class="form-control" />
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <input type="text" value="<?php echo _emailconfig('_emailaddress'); ?>" name="email"
                                placeholder="Email Id" class="form-control" />
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <input type="password" value="<?php echo _emailconfig('_emailpassword'); ?>" name="password"
                                placeholder="Email Password" class="form-control" />
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <input type="text" value="<?php echo _emailconfig('_sendername'); ?>" name="sender"
                                placeholder="Sender Name" class="form-control" />
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <?php

                            $status = _emailconfig('_smtpauth');
                            if ($status == true) {
                                ?>
                                <input type="checkbox" checked data-size="small" value="true" name="smtpauth"
                                    class="switch-btn" data-color="#f56767">
                                <label>SMTP Auth</label>
                                <?php
                            } else {
                                ?>
                                <input type="checkbox" data-size="small" value="true" name="smtpauth" class="switch-btn"
                                    data-color="#f56767">
                                <label>SMTP Auth</label>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <?php

                            $status = _emailconfig('_supplierstatus');
                            if ($status == true) {
                                ?>
                                <input type="checkbox" checked data-size="small" value="true" name="status"
                                    class="switch-btn" data-color="#f56767">
                                <label>is Active</label>
                                <?php
                            } else {
                                ?>
                                <input type="checkbox" data-size="small" value="true" name="status" class="switch-btn"
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



        <div class="pd-20 card-box mb-30">

            <form action="#" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="col">
                        <div class="title">
                            <h4>Service Delivery Testing (Email SMTP)</h4>
                        </div>
                        <nav aria-label="breadcrumb" role="navigation">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    Log in to your Fast2SMS account. Navigate to Settings > All settings > API Keys. If
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
                            <input type="text" name="email" placeholder="Email" class="form-control" />
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <input type="text" placeholder="Subject" name="subject" class="form-control" />
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <input type="text" placeholder="Message" name="message" class="form-control" />
                        </div>
                    </div>
                </div>




                <div class="row">
                    <div class="col-3">
                        <div class="input-group mb-0">
                            <input class="btn btn-primary btn-lg btn-block" name="send" type="submit" value="Send">
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