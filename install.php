<?php

require('includes/_functions.php');
if (isset($_POST['submit'])) {
    $dbhost = $_POST['dbhost'];
    $dbname = $_POST['dbname'];
    $dbpass = $_POST['dbpassword'];
    $dbuser = $_POST['dbuser'];
    $siteurl = $_POST['siteurl'];
    $username = $_POST['username'];
    $userpassword = $_POST['userpassword'];
    $useremail = $_POST['useremail'];

    if ($dbhost && $dbname && $dbuser && $siteurl && $username && $userpassword && $useremail != '') {
        _install($dbhost, $dbname, $dbpass, $dbuser, $siteurl, $username, $userpassword, $useremail);
    } else {
        $alert = new PHPAlert();

        $alert->warn("All Feilds are Required");
    }

}

?>

<!DOCTYPE html>
<html>

<head>
    <!-- Basic Page Info -->
    <meta charset="utf-8">
    <title>Installation</title>

    <!-- Site favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="vendors/images/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="vendors/images/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="vendors/images/favicon-16x16.png">

    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="vendors/styles/core.css">
    <link rel="stylesheet" type="text/css" href="vendors/styles/icon-font.min.css">
    <link rel="stylesheet" type="text/css" href="vendors/styles/style.css">

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-119386393-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag() { dataLayer.push(arguments); }
        gtag('js', new Date());

        gtag('config', 'UA-119386393-1');
    </script>
</head>

<body class="login-page">
    <div class="login-header box-shadow">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <div class="brand-logo">
                <a href="login.html">
                    <img src="vendors/images/deskapp-logo.svg" alt="">
                </a>
            </div>
        </div>
    </div>
    <div class="login-wrap d-flex align-items-center flex-wrap justify-content-center">
        <div class="container">
            <div class="row align-items-center">
                <div class="col">
                    <div class="login-box bg-white box-shadow border-radius-10">
                        <div class="login-title">
                            <h2 class="text-center text-primary">Install To Continue</h2>
                        </div>
                        <form action="#" method="POST">
                            <div class="input-group custom">
                                <input type="text" class="form-control form-control-lg" name="dbhost"
                                    placeholder="Database Host">
                                <div class="input-group-append custom">
                                    <span class="input-group-text"></span>
                                </div>
                            </div>

                            <div class="input-group custom">
                                <input type="text" class="form-control form-control-lg" name="dbname"
                                    placeholder="Database Name">
                                <div class="input-group-append custom">
                                    <span class="input-group-text"></span>
                                </div>
                            </div>
                            <div class="input-group custom">
                                <input type="text" class="form-control form-control-lg" name="dbuser"
                                    placeholder="Database User">
                                <div class="input-group-append custom">
                                    <span class="input-group-text"></span>
                                </div>
                            </div>
                            <div class="input-group custom">
                                <input type="password" class="form-control form-control-lg" name="dbpassword"
                                    placeholder="Database Password">
                                <div class="input-group-append custom">
                                    <span class="input-group-text"></span>
                                </div>
                            </div>

                            <div class="input-group custom">
                                <input type="text" class="form-control form-control-lg" name="siteurl"
                                    placeholder="Site Url">
                                <div class="input-group-append custom">
                                    <span class="input-group-text"></span>
                                </div>
                            </div>

                            <div class="input-group custom">
                                <input type="text" class="form-control form-control-lg" name="username"
                                    placeholder="User Name">
                                <div class="input-group-append custom">
                                    <span class="input-group-text"></span>
                                </div>
                            </div>

                            <div class="input-group custom">
                                <input type="email" class="form-control form-control-lg" name="useremail"
                                    placeholder="User Email">
                                <div class="input-group-append custom">
                                    <span class="input-group-text"></span>
                                </div>
                            </div>

                            <div class="input-group custom">
                                <input type="password" class="form-control form-control-lg" name="userpassword"
                                    placeholder="User Password">
                                <div class="input-group-append custom">
                                    <span class="input-group-text"></span>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="input-group mb-0">
                                        <input class="btn btn-primary btn-lg btn-block" name="submit" type="submit"
                                            value="Install">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- js -->
    <script src="vendors/scripts/core.js"></script>
    <script src="vendors/scripts/script.min.js"></script>
    <script src="vendors/scripts/process.js"></script>
    <script src="vendors/scripts/layout-settings.js"></script>
</body>

</html>