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

require('includes/_functions.php');

$_id = $_GET['id'];


if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $useremail = $_POST['useremail'];
    $userpassword = $_POST['password'];
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

    _updateuser($username, $useremail, $userpassword, $usertype, $userphone, $isactive, $isverified, $_id);
}

if (isset($_POST['status'])) {
    $status = $_POST['enableOrDisable'];
    $courseid = $_POST['courseid'];

    // if ($status == true) {
    //     $status = '';
    // } else {
    //     $status = true;
    // }

    echo $_id;

    _updateCourseStatus($status, $courseid, $_id);
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

            <form action="#" method="POST">
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" value="<?php echo _getsingleuser($_id, '_username'); ?>" name="username"
                                class="form-control" />
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label>Useremail</label>
                            <input type="text" value="<?php echo _getsingleuser($_id, '_useremail'); ?>"
                                name="useremail" class="form-control" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" value="<?php echo _getsingleuser($_id, '_userpassword'); ?>"
                                name="password" class="form-control" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label>Userphone</label>
                            <input type="text" name="userphone"
                                value="<?php echo _getsingleuser($_id, '_userphone'); ?>" class="form-control" />
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label>User Type</label>
                            <select name="usertype" class="custom-select">
                                <?php
                                $type = _getsingleuser($_id, '_usertype');
                                echo $type;
                                if ($type == 0) { ?>
                                    <option value="0" selected>Student</option>
                                <?php }
                                if ($type == 1) { ?>
                                    <option value="1" selected>Teacher</option>
                                <?php }
                                if ($type == 2) { ?>
                                    <option value="2" selected>Site Admin</option>
                                <?php }
                                if ($type != 0) { ?>
                                    <option value="0">Student</option>
                                <?php }
                                if ($type != 1) { ?>
                                    <option value="1">Teacher</option>
                                <?php }
                                if ($type != 2) { ?>
                                    <option value="2">Site Admin</option>
                                <?php }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="form-group">

                            <?php

                            $status = _getsingleuser($_id, '_userstatus');
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
                    <div class="col">
                        <div class="form-group">

                            <?php

                            $status = _getsingleuser($_id, '_userverify');
                            if ($status == true) {
                                ?>

                                <input type="checkbox" checked data-size="small" value="true" name="isverified"
                                    class="switch-btn" data-color="#f56767">
                                <label>is Verified</label>
                                <?php
                            } else {
                                ?>

                                <input type="checkbox" data-size="small" value="true" name="isverified" class="switch-btn"
                                    data-color="#f56767">
                                <label>is Verified</label>
                                <?php
                            }
                            ?>

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



        <div class="pd-20 card-box mb-30">
            <div class="min-height-200px">

                <div class="row">

                    <div class="col">
                        <div class="profile-tab height-100-p">
                            <div class="tab height-100-p">
                                <ul class="nav nav-tabs customtab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="tab" href="#transcations"
                                            role="tab">Transcations</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#courses" role="tab">Courses</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#certificates"
                                            role="tab">Certificates</a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <!-- Transcations start -->
                                    <div class="tab-pane fade show active" id="transcations" role="tabpanel">
                                        <div class="pb-20" style="margin-top: 30px;">
                                            <table class="data-table table stripe hover nowrap">
                                                <thead>
                                                    <tr>
                                                        <th>Created At</th>
                                                        <th class="table-plus datatable-nosort">Id</th>
                                                        <th>Amount</th>
                                                        <th>Currency
                                                        <th>Status</th>
                                                        <th>Coupon Code</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $useremail = _getsingleuser($_id, '_useremail');
                                                    _getTranscationsForUser($useremail);
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <!-- Transcations End -->
                                    <!-- Courses Tab start -->
                                    <div class="tab-pane fade" id="courses" role="tabpanel">
                                        <form method="POST" action="#" class="pb-20" style="margin-top: 30px;">
                                            <table class="data-table table stripe hover nowrap">
                                                <thead>
                                                    <tr>
                                                        <th>Created At</th>
                                                        <th class="table-plus datatable-nosort">Course
                                                            Name</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    _getUserCourses($_id);
                                                    ?>
                                                </tbody>
                                            </table>
                                        </form>
                                    </div>
                                    <!-- Courses Tab End -->
                                    <!-- Setting Tab start -->
                                    <div class="tab-pane fade height-100-p" id="certificates" role="tabpanel">
                                        <div class="profile-setting">
                                            <form>
                                                <ul class="profile-edit-list row">
                                                    <li class="weight-500 col-md-6">
                                                        <h4 class="text-blue h5 mb-20">Edit Your Personal Setting
                                                        </h4>
                                                        <div class="form-group">
                                                            <label>Full Name</label>
                                                            <input class="form-control form-control-lg" type="text">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Title</label>
                                                            <input class="form-control form-control-lg" type="text">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Email</label>
                                                            <input class="form-control form-control-lg" type="email">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Date of birth</label>
                                                            <input class="form-control form-control-lg date-picker"
                                                                type="text">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Gender</label>
                                                            <div class="d-flex">
                                                                <div class="custom-control custom-radio mb-5 mr-20">
                                                                    <input type="radio" id="customRadio4"
                                                                        name="customRadio" class="custom-control-input">
                                                                    <label class="custom-control-label weight-400"
                                                                        for="customRadio4">Male</label>
                                                                </div>
                                                                <div class="custom-control custom-radio mb-5">
                                                                    <input type="radio" id="customRadio5"
                                                                        name="customRadio" class="custom-control-input">
                                                                    <label class="custom-control-label weight-400"
                                                                        for="customRadio5">Female</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Country</label>
                                                            <select class="selectpicker form-control form-control-lg"
                                                                data-style="btn-outline-secondary btn-lg"
                                                                title="Not Chosen">
                                                                <option>United States</option>
                                                                <option>India</option>
                                                                <option>United Kingdom</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>State/Province/Region</label>
                                                            <input class="form-control form-control-lg" type="text">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Postal Code</label>
                                                            <input class="form-control form-control-lg" type="text">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Phone Number</label>
                                                            <input class="form-control form-control-lg" type="text">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Address</label>
                                                            <textarea class="form-control"></textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Visa Card Number</label>
                                                            <input class="form-control form-control-lg" type="text">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Paypal ID</label>
                                                            <input class="form-control form-control-lg" type="text">
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="custom-control custom-checkbox mb-5">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="customCheck1-1">
                                                                <label class="custom-control-label weight-400"
                                                                    for="customCheck1-1">I agree to receive
                                                                    notification emails</label>
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-0">
                                                            <input type="submit" class="btn btn-primary"
                                                                value="Update Information">
                                                        </div>
                                                    </li>
                                                    <li class="weight-500 col-md-6">
                                                        <h4 class="text-blue h5 mb-20">Edit Social Media links</h4>
                                                        <div class="form-group">
                                                            <label>Facebook URL:</label>
                                                            <input class="form-control form-control-lg" type="text"
                                                                placeholder="Paste your link here">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Twitter URL:</label>
                                                            <input class="form-control form-control-lg" type="text"
                                                                placeholder="Paste your link here">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Linkedin URL:</label>
                                                            <input class="form-control form-control-lg" type="text"
                                                                placeholder="Paste your link here">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Instagram URL:</label>
                                                            <input class="form-control form-control-lg" type="text"
                                                                placeholder="Paste your link here">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Dribbble URL:</label>
                                                            <input class="form-control form-control-lg" type="text"
                                                                placeholder="Paste your link here">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Dropbox URL:</label>
                                                            <input class="form-control form-control-lg" type="text"
                                                                placeholder="Paste your link here">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Google-plus URL:</label>
                                                            <input class="form-control form-control-lg" type="text"
                                                                placeholder="Paste your link here">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Pinterest URL:</label>
                                                            <input class="form-control form-control-lg" type="text"
                                                                placeholder="Paste your link here">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Skype URL:</label>
                                                            <input class="form-control form-control-lg" type="text"
                                                                placeholder="Paste your link here">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Vine URL:</label>
                                                            <input class="form-control form-control-lg" type="text"
                                                                placeholder="Paste your link here">
                                                        </div>
                                                        <div class="form-group mb-0">
                                                            <input type="submit" class="btn btn-primary"
                                                                value="Save & Update">
                                                        </div>
                                                    </li>
                                                </ul>
                                            </form>
                                        </div>
                                    </div>
                                    <!-- Setting Tab End -->
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- js -->
    <?php require("templates/_js_link.php") ?>
    <!-- buttons for Export datatable -->
    <script src="src/plugins/datatables/js/dataTables.buttons.min.js"></script>
    <script src="src/plugins/datatables/js/buttons.bootstrap4.min.js"></script>
    <script src="src/plugins/datatables/js/buttons.print.min.js"></script>
    <script src="src/plugins/datatables/js/buttons.html5.min.js"></script>
    <script src="src/plugins/datatables/js/buttons.flash.min.js"></script>
    <script src="src/plugins/datatables/js/pdfmake.min.js"></script>
    <script src="src/plugins/datatables/js/vfs_fonts.js"></script>
    <!-- Datatable Setting js -->
    <script src="vendors/scripts/datatable-setting.js"></script>

</body>

</html>