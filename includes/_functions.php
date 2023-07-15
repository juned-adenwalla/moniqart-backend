<?php


/* Auth Functions */
// function _login($userpassword, $useremail)
// {
//     require('_config.php');
//     require('_alert.php');
//     if ($userpassword && $useremail != '') {
//         $enc_password = md5($userpassword);
//         $sql = "SELECT * FROM `tblusers` WHERE `_userstatus` = 'true' AND `_userpassword` = '$enc_password' AND `_useremail` = '$useremail' AND `_usertype`=2 ";
//         $query = mysqli_query($conn, $sql);
//         if ($query) {
//             $count = mysqli_num_rows($query);
//             if ($count >= 1) {
//                 foreach ($query as $data) {
//                     $usertype = $data['_usertype'];
//                     $userverify = $data['_userverify'];
//                     $userid = $data['_id'];
//                     $useremail = $data['_useremail'];
//                     $userphone = $data['_userphone'];
//                     $userpass = $data['_userpassword'];
//                 }
//                 $_SESSION['isLoggedIn'] = true;
//                 $_SESSION['userEmailId'] = $useremail;
//                 $_SESSION['userPhoneNo'] = $userphone;
//                 $_SESSION['userPassword'] = $userpass;
//                 $_SESSION['userType'] = $usertype;
//                 $_SESSION['userVerify'] = $userverify;
//                 $_SESSION['userId'] = $userid;
//                 $alert = new PHPAlert();
//                 $alert->success("Login Successfull");
//                 echo "<script>";
//                 echo "window.location.href = ''";
//                 echo "</script>";
//             } else {
//                 $alert = new PHPAlert();
//                 $alert->warn("User Type Not Supported");
//             }
//         } else {
//             $alert = new PHPAlert();
//             $alert->warn("Something Went Wrong");
//         }
//     } else {
//         $alert = new PHPAlert();
//         $alert->warn("All Feilds are Required");
//     }
// }

function _login($userpassword,$useremail){
    require('_config.php');
    require('_alert.php');
    // Prepare and bind the SELECT statement with prepared statements
    $query = "SELECT * FROM `tblusers` WHERE `_useremail` = ? LIMIT 1";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $useremail);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Check if the user exists
    if ($row = mysqli_fetch_assoc($result)) {
        // Verify the password
        if (password_verify($userpassword, $row['_userpassword'])) {
            // Check if the user status is 2 (active user)
            if ($row['_userstatus'] == 'true' && $row['_usertype'] == 2) {
                // Start a session for the user
                session_start();
                $_SESSION['isLoggedIn'] = true;
                $_SESSION['userEmailId'] = $row['_useremail'];
                $_SESSION['userPhoneNo'] = $row['_userphone'];
                $_SESSION['userPassword'] = $row['_userpassword'];
                $_SESSION['userType'] = $row['_usertype'];
                $_SESSION['userVerify'] = $row['_userverify'];
                $_SESSION['userId'] = $row['_id'];
                $alert = new PHPAlert();
                $alert->success("Login Successfull");
                echo "<script>";
                echo "window.location.href = ''";
                echo "</script>";
            } else {
                // User status is not 2 (inactive user)
                $alert = new PHPAlert();
                $alert->warn("Not Allowed, Contact Administrator");
            }
        } else {
            // Invalid password
            $alert = new PHPAlert();
            $alert->warn("Invalid password");
        }
    } else {
        // User does not exist
        $alert = new PHPAlert();
        $alert->warn("User Not Found");
    }
}

function _logout()
{
    // Initialize the session
    session_start();

    // Unset all of the session variables
    $_SESSION = array();

    // Destroy the session.
    session_destroy();

    // Redirect to login page
    header("location:login.php");
    exit;
}

// Function to get single detail 
function singleDetail($tableName, $columnName, $columnValue, $returnColumn){
    require('_config.php');
    // Prepare the SQL query
    $query = "SELECT * FROM `$tableName` WHERE `$columnName` = '$columnValue'";

    // Execute the query
    $result = mysqli_query($conn, $query);

    // Check if any rows were found
    if (mysqli_num_rows($result) > 0) {
        // Fetch the data and return it as an associative array
        while ($row = mysqli_fetch_assoc($result)){
            return $row[$returnColumn];
        }
    } else {
        return null;
    }
}

// Function limit text 
function limitText($text, $limit) {
    if (strlen($text) > $limit) {
        $text = substr($text, 0, $limit) . "...";
    }
    return $text;
}

function _install($dbhost, $dbname, $dbpass, $dbuser, $siteurl, $username, $userpassword, $useremail)
{
    require('_alert.php');
    ini_set('display_errors', 1);
    $temp_conn = new mysqli($dbhost, $dbuser, $dbpass);
    $enc_password = password_hash($userpassword, PASSWORD_DEFAULT);
    if ($temp_conn->connect_errno) {
        $alert = new PHPAlert();
        $alert->warn("Database Connection Failed");
        exit();
    } else {
        $db_tables = array(
            'db_server' => $dbhost,
            'db_username' => $dbuser,
            'db_password' => $dbpass,
            'db_name' => $dbname,
            'site_url' => $siteurl
        );

        $db = "CREATE DATABASE IF NOT EXISTS $dbname";

        if ($temp_conn->query($db)) {
            $temp_conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

            $user_table = "CREATE TABLE IF NOT EXISTS `tblusers` (
                `_id` INT UNSIGNED PRIMARY KEY AUTO_INCREMENT NOT NULL,
                `_username` varchar(255) NULL,
                `_useremail` varchar(255) NULL,
                `_userphone` varchar(255) NULL,
                `_usersite` varchar(255) NULL,
                `_usermembership` varchar(255) NULL,
                `_usermemstart` datetime NULL,
                `_usermemsleft` varchar(255) NULL,
                `_userlongitude` varchar(50) NULL,
                `_userlatitude` varchar(50) NULL,
                `_userbio` varchar(500) NULL,
                `_userage` varchar(10) NULL,
                `_userlocation` varchar(100) NULL,
                `_userstate` varchar(50) NULL,
                `_userpin` varchar(50) NULL,
                `_userdp` varchar(50) NULL,
                `_usertype` int(11) NULL,
                `_userstatus` varchar(50) NULL,
                `_userpassword` varchar(255) NULL,
                `_userotp` int(100) NULL,
                `_userverify` varchar(50) NULL,
                `_usercurrency` varchar(50) NULL ,
                `Creation_at_Date` date NOT NULL DEFAULT current_timestamp(),
                `CreationDate` datetime NOT NULL DEFAULT current_timestamp(),
                `UpdationDate` datetime NULL ON UPDATE current_timestamp()
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

            $course_table = "CREATE TABLE IF NOT EXISTS `tblcourse` (
                `_id` INT UNSIGNED PRIMARY KEY AUTO_INCREMENT NOT NULL,
                `_coursename` text NOT NULL,
                `_parmalink` text NOT NULL,
                `_coursedescription` text NOT NULL,
                `_detaileddescription` text NOT NULL,
                `_whatlearn` text NOT NULL,
                `_requirements` text NOT NULL,
                `_eligibilitycriteria` text NOT NULL,
                `_enrollstatus` varchar(50) NOT NULL,
                `_thumbnail` varchar(200) NOT NULL,
                `_banner` varchar(200) NOT NULL,
                `_pricing` int(100) NOT NULL,
                `_status` varchar(50) NOT NULL,
                `_teacheremailid` varchar(50) NOT NULL,
                `_categoryid` varchar(50) NOT NULL,
                `_subcategoryid` varchar(50) NOT NULL,
                `_coursetype` varchar(50) NOT NULL,
                `_coursechannel` varchar(50) NOT NULL,
                `_startdate` varchar(255)  NOT NULL,
                `_enddate` varchar(255)  NOT NULL,
                `_previewurl` varchar(255)  NOT NULL,
                `_discountprice` varchar(50)  NOT NULL,
                `Creation_at_Date` date NOT NULL DEFAULT current_timestamp(),
                `CreationDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                `UpdationDate` datetime NULL ON UPDATE current_timestamp()
            )  ENGINE=InnoDB DEFAULT CHARSET=utf8;";

            $lessondb = "CREATE TABLE IF NOT EXISTS `tbllessons` (
                `_id` INT UNSIGNED PRIMARY KEY AUTO_INCREMENT NOT NULL,
                `_courseid` varchar(55) NOT NULL,
                `_lessonname` text NOT NULL,
                `_lessontype` varchar(55) NOT NULL,
                `_lessonurl` text NOT NULL,
                `_lessondate` varchar(55) NOT NULL,
                `_lessontime` varchar(55) NOT NULL,
                `_recordedfilename` varchar(255) NOT NULL,
                `_lessondescription` text NOT NULL,
                `_status` varchar(55) NOT NULL,
                `_availablity` varchar(55) NOT NULL,
                `Creation_at_Date` date NOT NULL DEFAULT current_timestamp(),
                `CreationDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                `UpdationDate` datetime NULL ON UPDATE current_timestamp()
            )  ENGINE=InnoDB DEFAULT CHARSET=utf8;";

            $category_table = "CREATE TABLE IF NOT EXISTS `tblcategory` (
                `_id` INT UNSIGNED PRIMARY KEY AUTO_INCREMENT NOT NULL,
                `_categoryname` varchar(50) NOT NULL,
                `_categoryDescription` varchar(100) NOT NULL,
                `_categorytype` varchar(100) NOT NULL,
                `_categoryimg` varchar(100) NOT NULL,
                `_status` varchar(20) NOT NULL,
                `CreationDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                `UpdationDate` datetime NULL ON UPDATE current_timestamp()
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

            $subcategory_table = "CREATE TABLE IF NOT EXISTS `tblsubcategory` (
                `_id` INT UNSIGNED PRIMARY KEY AUTO_INCREMENT NOT NULL,
                `_subcategoryname` varchar(50) NOT NULL,
                `_categoryid` varchar(20) NOT NULL,
                `_subcategorydesc` varchar(100) NOT NULL,
                `_status` varchar(20) NOT NULL,
                `CreationDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                `UpdationDate` datetime NULL ON UPDATE current_timestamp()
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

            $blog_table = "CREATE TABLE IF NOT EXISTS `tblblog` (
                `_id` INT UNSIGNED PRIMARY KEY AUTO_INCREMENT NOT NULL,
                `_blogtitle` varchar(255) NOT NULL,
                `_parmalink` varchar(255) NOT NULL,
                `_blogdesc` text NOT NULL,
                `_blogcategory` varchar(50) NOT NULL,
                `_blogsubcategory` varchar(50) NOT NULL,
                `_blogmetadesc` varchar(250) NOT NULL,
                `_blogimg` varchar(100) NOT NULL,
                `_userid` varchar(50) NOT NULL,
                `_status` varchar(20) NOT NULL,
                `Creation_at_Date` date NOT NULL DEFAULT current_timestamp(),
                `CreationDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                `UpdationDate` datetime NULL ON UPDATE current_timestamp()
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

            $sms_config = "CREATE TABLE IF NOT EXISTS `tblsmsconfig` (
                `_id` INT UNSIGNED PRIMARY KEY AUTO_INCREMENT NOT NULL,
                `_suppliername` varchar(50) NOT NULL,
                `_apikey` varchar(100) NOT NULL,
                `_baseurl` varchar(100) NOT NULL,
                `_supplierstatus` varchar(50) NOT NULL,
                `CreationDate` datetime NOT NULL DEFAULT current_timestamp(),
                `UpdationDate` datetime NULL ON UPDATE current_timestamp()
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

            $email_config = "CREATE TABLE IF NOT EXISTS `tblemailconfig` (
                `_id` INT UNSIGNED PRIMARY KEY AUTO_INCREMENT NOT NULL,
                `_hostname` varchar(50) NOT NULL,
                `_hostport` varchar(50) NOT NULL,
                `_smtpauth` varchar(50) NOT NULL,
                `_emailaddress` varchar(100) NOT NULL,
                `_emailpassword` varchar(100) NOT NULL,
                `_sendername` varchar(100) NOT NULL,
                `_supplierstatus` varchar(50) NOT NULL,
                `CreationDate` datetime NOT NULL DEFAULT current_timestamp(),
                `UpdationDate` datetime NULL ON UPDATE current_timestamp()
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

            $site_config = "CREATE TABLE IF NOT EXISTS `tblsiteconfig` (
                `_id` INT UNSIGNED PRIMARY KEY AUTO_INCREMENT NOT NULL,
                `_sitetitle` varchar(50) NULL,
                `_siteemail` varchar(50) NULL,
                `_sitephone` varchar(50) NULL,
                `_sitecurrency` varchar(50) NULL,
                `_timezone` varchar(50) NULL,
                `_customheader` text NULL,
                `_customfooter` text NULL,
                `_customcss` text NULL,
                `_sitelogo` varchar(100) NULL,
                `_sitereslogo` varchar(100) NULL,
                `_favicon` varchar(100) NULL,
                `CreationDate` datetime NOT NULL DEFAULT current_timestamp(),
                `UpdationDate` datetime NULL ON UPDATE current_timestamp()
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

            $payment_config = "CREATE TABLE IF NOT EXISTS `tblpaymentconfig` (
                `_id` INT UNSIGNED PRIMARY KEY AUTO_INCREMENT NOT NULL,
                `_suppliername` varchar(50) NOT NULL,
                `_apikey` varchar(100) NOT NULL,
                `_secretkey` varchar(100) NOT NULL,
                `_companyname` varchar(100) NOT NULL,
                `_supplierstatus` varchar(50) NOT NULL,
                `CreationDate` datetime NOT NULL DEFAULT current_timestamp(),
                `UpdationDate` datetime NULL ON UPDATE current_timestamp()
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

            $templates = "CREATE TABLE IF NOT EXISTS `tblemailtemplates` (
                `_id` INT UNSIGNED PRIMARY KEY AUTO_INCREMENT NOT NULL,
                `_purchasetemplate` text NOT NULL,
                `_remindertemplate` text NOT NULL,
                `_lecturetemplate` text NOT NULL,
                `_signuptemplate` text NOT NULL,
                `_canceltemplate` text NOT NULL,
                `_paymenttemplate` text NOT NULL,
                `CreationDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                `UpdationDate` datetime NULL ON UPDATE current_timestamp()
            )  ENGINE=InnoDB DEFAULT CHARSET=utf8;";

            $currency_table = "CREATE TABLE IF NOT EXISTS `tblcurrency` (
                `_id` INT UNSIGNED PRIMARY KEY AUTO_INCREMENT NOT NULL,
                `_conversioncurrency` text NOT NULL,
                `_price` varchar(255) NULL,
                `_status` varchar(50) NOT NULL DEFAULT 'open',
                `CreationDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                `UpdationDate` datetime NULL ON UPDATE current_timestamp()
            )  ENGINE=InnoDB DEFAULT CHARSET=utf8;";

            $tax_table = "CREATE TABLE IF NOT EXISTS `tbltaxes` (
                `_id` INT UNSIGNED PRIMARY KEY AUTO_INCREMENT NOT NULL,
                `_taxname` varchar(255) NOT NULL,
                `_taxtype` text NOT NULL,
                `_taxamount` varchar(255) NULL,
                `_status` varchar(50) NOT NULL DEFAULT 'true',
                `CreationDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                `UpdationDate` datetime NULL ON UPDATE current_timestamp()
            )  ENGINE=InnoDB DEFAULT CHARSET=utf8;";

            $payment_trans = "CREATE TABLE IF NOT EXISTS `tblpayment` (
                `_id` INT UNSIGNED PRIMARY KEY AUTO_INCREMENT NOT NULL,
                `_razorpayid` varchar(100) NOT NULL,
                `_useremail` varchar(255) NOT NULL,
                `_amount` varchar(255) NULL,
                `_currency` varchar(255) NOT NULL,
                `_status` varchar(255) NOT NULL,
                `_producttitle` varchar(100) NOT NULL,
                `_productid` varchar(55) NOT NULL,
                `_producttype` varchar(55) NOT NULL,
                `_couponcode` varchar(255) NOT NULL,
                `CreationDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                `UpdationDate` datetime NULL ON UPDATE current_timestamp()
            )  ENGINE=InnoDB DEFAULT CHARSET=utf8;";

            $coupon_table = "CREATE TABLE IF NOT EXISTS `tblcoupon` (
                `_id` INT UNSIGNED PRIMARY KEY AUTO_INCREMENT NOT NULL,
                `_couponname` varchar(255) NOT NULL,
                `_coupontype` text NOT NULL,
                `_couponamount` varchar(255) NULL,
                `_couponcondition` varchar(255) NULL,
                `_couponprod` varchar(255) NULL,
                `_conamount` varchar(255) NULL,
                `_maxusage` varchar(255) NOT NULL,
                `_totaluse` varchar(255) NOT NULL,
                `CreationDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                `UpdationDate` datetime NULL ON UPDATE current_timestamp()
            )  ENGINE=InnoDB DEFAULT CHARSET=utf8;";

            $coupon_trans = "CREATE TABLE IF NOT EXISTS `tblcoupontrans` (
                `_id` INT UNSIGNED PRIMARY KEY AUTO_INCREMENT NOT NULL,
                `_couponname` varchar(255) NOT NULL,
                `_couponamount` varchar(255) NULL,
                `_couponcurrency` varchar(255) NULL,
                `_couponstatus` varchar(255) NULL,
                `_useremail` varchar(255) NOT NULL,
                `CreationDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                `UpdationDate` datetime NULL ON UPDATE current_timestamp()
            )  ENGINE=InnoDB DEFAULT CHARSET=utf8;";

            $purchasecoursedb = "CREATE TABLE IF NOT EXISTS `tblpurchasedcourses` (
                `_id` INT UNSIGNED PRIMARY KEY AUTO_INCREMENT NOT NULL,
                `_courseid` varchar(55) NOT NULL, 
                `_userid` varchar(55) NOT NULL, 
                `_coursestatus` varchar(100) NOT NULL,
                `CreationDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                `UpdationDate` datetime NULL ON UPDATE current_timestamp()
            )  ENGINE=InnoDB DEFAULT CHARSET=utf8;";

            $pendingCetificatedDB = "CREATE TABLE IF NOT EXISTS `tblpendingcertificate` (
                `_id` INT UNSIGNED PRIMARY KEY AUTO_INCREMENT NOT NULL,
                `_userid` varchar(255) NOT NULL,
                `_courseid` varchar(255) NULL,
                `_emailid` varchar(255) NULL,
                `_status` varchar(255) NOT NULL DEFAULT 'onprogress' ,
                `CreationDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                `UpdationDate` datetime NULL ON UPDATE current_timestamp()
            )  ENGINE=InnoDB DEFAULT CHARSET=utf8;";


            $membership_table = "CREATE TABLE IF NOT EXISTS `tblmembership` (
                `_id` INT UNSIGNED PRIMARY KEY AUTO_INCREMENT NOT NULL,
                `_membershipname` varchar(100) NOT NULL,
                `_membershippermalink` varchar(200) NOT NULL,
                `_membershipdesc` text NOT NULL,
                `_img` varchar(55) NOT NULL,
                `_price` varchar(55) NOT NULL,
                `_benefit` varchar(55) NOT NULL, 
                `_benefittype` varchar(55) NOT NULL, 
                `_duration` varchar(55) NOT NULL,
                `_status` varchar(255) NOT NULL,
                `CreationDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                `UpdationDate` datetime NULL ON UPDATE current_timestamp()
            )  ENGINE=InnoDB DEFAULT CHARSET=utf8;";

            $tables = [$user_table, $course_table, $category_table, $subcategory_table, $blog_table, $sms_config, $email_config, $site_config, $payment_config, $templates, $lessondb, $currency_table, $tax_table, $payment_trans, $coupon_table, $coupon_trans, $purchasecoursedb, $pendingCetificatedDB, $membership_table];

            foreach ($tables as $k => $sql) {
                $query = @$temp_conn->query($sql);

                if (!$query) {
                    $errors[] = "Table $k : Creation failed ($temp_conn->error)";
                } else {
                    $errors[] = "Table $k : Creation done";
                    $creation_done = true;
                }
            }
            if ($creation_done) {
                $user_data = "INSERT INTO `tblusers` (`_username`, `_useremail`,  `_userphone`, `_usertype`, `_userstatus`, `_userpassword`,`_userverify`,`_usercurrency`) VALUES ('$username', '$useremail', '', 2, 'true', '$enc_password','true','INR');";

                $sms_data = "INSERT INTO `tblsmsconfig`(`_suppliername`, `_apikey`, `_baseurl`, `_supplierstatus`) VALUES ('Fast2SMS','maeS4bc5gM17qo0FwszOEAx62JND3IiHdfQBtl8XWLZ9rCjVTYOJlgtFLzNqZ7uYj830XWm6sQbM2KIR', 'https://www.fast2sms.com/dev/bulkV2', 'true')";

                $email_data = "INSERT INTO `tblemailconfig`(`_hostname`, `_hostport`, `_smtpauth`, `_emailaddress`, `_emailpassword`, `_sendername`, `_supplierstatus`) VALUES ('mail.adenwalla.in', '465', 'true', 'no-reply@adenwalla.in', 'Juned@786juned', 'Adenwalla Infotech', 'true')";

                $site_data = "INSERT INTO `tblsiteconfig`(`_sitetitle`, `_siteemail`, `_timezone`, `_sitelogo`, `_sitereslogo`, `_favicon`) VALUES ('Site Title', 'info@yoursite.com', 'Asia/Calcutta', 'uploadimage.png', 'uploadimage.png', 'uploadimage.png')";

                $payment_data = "INSERT INTO `tblpaymentconfig`(`_suppliername`, `_apikey`,`_secretkey`, `_companyname`, `_supplierstatus`) VALUES ('Razorpay','api key','secret key','Adenwalla & Co.','true')";


                $template_data = "INSERT INTO `tblemailtemplates`(`_purchasetemplate`, `_remindertemplate`, `_lecturetemplate`, `_signuptemplate`, `_canceltemplate`, `_paymenttemplate`) VALUES ('Your Html Code','Your Html Code','Your Html Code','Your Html Code','Your Html Code','Your Html Code')";


                $data = [$user_data, $sms_data, $email_data, $site_data, $payment_data, $template_data];

                foreach ($data as $k => $sql) {
                    $query = @$temp_conn->query($sql);

                    if (!$query) {
                        $errors[] = "Table $k : Creation failed ($temp_conn->error)";
                        echo 'falied';
                    } else {
                        $errors[] = "Table $k : Creation done";
                        $creation_done = true;
                    }
                }
                if ($creation_done) {
                    $json = file_put_contents(__DIR__ . '/../_config.json', json_encode($db_tables));
                    if (!file_exists('.htaccess')) {
                        $content = "RewriteEngine On" . "\n";
                        $content .= "RewriteRule ^([^/\.]+)/([^/\.]+)?$ post.php?type=$1&post=$2" . "\n";
                        $content .= "RewriteCond %{REQUEST_FILENAME} !-f" . "\n";
                        $content .= "RewriteRule ^([^\.]+)$ $1.php [NC,L]" . "\n";
                        $content .= "ErrorDocument 404 /404.php" . "\n";
                        file_put_contents(__DIR__ . '/../.htaccess', $content);
                    }
                    // $delete_install = unlink(__DIR__.'/../install.php');
                    if ($json) {
                        $alert = new PHPAlert();
                        $alert->success("Installation Success");
                    }
                }
            } else {
                $alert = new PHPAlert();
                $alert->warn("Installation Failed");
            }
        }
    }
}


/* User Functions */

function _createuser($username, $useremail, $usertype, $userphone, $isactive, $isverified, $notify)
{
    require('_config.php');
    require('_alert.php');
    if ($useremail != '' && $username != '' && $usertype != '' && $userphone != '') {

        $userotp = rand(1111, 9999);
        $subject = "Account Created";
        $message = "Account Created Successfully";
        $sql = "SELECT * FROM `tblusers` WHERE `_useremail` = '$useremail' OR `_userphone` = '$userphone'";
        $query = mysqli_query($conn, $sql);
        if ($query) {
            $count = mysqli_num_rows($query);
            if ($count > 0) {
                $alert = new PHPAlert();
                $alert->warn("User Already Exists");
            } else {
                $sql = "INSERT INTO `tblusers`(`_username`, `_useremail`, `_userphone`, `_usertype`, `_userstatus`, `_userotp`, `_userverify`, `_usercurrency`) VALUES ('$username','$useremail', '$userphone', '$usertype', '$isactive', '$userotp', '$isverified', 'INR')";

                $query = mysqli_query($conn, $sql);
                if ($query) {
                    if ($notify) {
                        // $sql = "SELECT * FROM `tblemailtemplates`";
                        // $query = mysqli_query($conn, $sql);
                        // foreach ($query as $data) {
                        //     $template = $data['_signuptemplate'];
                        // }
                        // $variables = array();
                        // $variables['name'] = $username;
                        // $variables['companyname'] = _siteconfig('_sitetitle');
                        // $sendmail = _usetemplate($template, $variables);
                        // $message = 'Thank you for creating account with ' . _siteconfig('_sitetitle') . '. Kindy Login to Continue';
                        // _notifyuser($useremail, $userphone, $sendmail, $message, $subject);
                        $alert = new PHPAlert();
                        $alert->success("User Created");
                    } else {
                        $alert = new PHPAlert();
                        $alert->success("User Created");
                    }
                }
            }
        }
    } else {
        $alert = new PHPAlert();
        $alert->warn("All Feilds are Required");
    }
}



function _getuser()
{


    require('_config.php');
    $sql = "SELECT * FROM `tblusers` ORDER BY CreationDate DESC";
    $query = mysqli_query($conn, $sql);
    if ($query) {
        foreach ($query as $data) { ?>
            <tr>
                <td>
                    <?php echo date("F j, Y", strtotime($data['CreationDate'])); ?>
                </td>
                <td class="table-plus">
                    <?php echo $data['_username']; ?>
                </td>
                <td>
                    <?php echo $data['_useremail']; ?>
                </td>
                <td>
                    <?php echo $data['_userphone']; ?>
                </td>
                <td>

                    <?php
                    if ($data['_usertype'] == 0) { ?>
                        <span>Student</span>
                    <?php }
                    if ($data['_usertype'] == 1) { ?>
                        <span>Teacher</span>
                    <?php }
                    if ($data['_usertype'] == 2) { ?>
                        <span>Site Admin</span>
                    <?php } ?>
                </td>

                <td>
                    <div>
                        <?php

                        $status = $data['_userstatus'];
                        if ($status == true) {
                            ?>
                            <input type="checkbox" checked disabled data-size="small" value="true" name="isactive" class="switch-btn" data-color="#f56767">
                        <?php
                        } else {
                            ?>
                            <input type="checkbox" disabled data-size="small" value="true" name="isactive" class="switch-btn" data-color="#f56767">
                        <?php
                        }
                        ?>
                    </div>
                </td>

                <td>
                    <div>
                        <?php

                        $status = $data['_userverify'];
                        if ($status == true) {
                            ?>
                            <input type="checkbox" checked disabled data-size="small" value="true" name="isactive" class="switch-btn" data-color="#f56767">
                        <?php
                        } else {
                            ?>
                            <input type="checkbox" disabled data-size="small" value="true" name="isactive" class="switch-btn" data-color="#f56767">
                        <?php
                        }
                        ?>
                    </div>
                </td>
                <td>
                    <?php
                    if (strtotime($data['UpdationDate']) == '') {
                        echo "Not Updated Yet";
                    } else {
                        echo date("M j, Y", strtotime($data['UpdationDate']));
                    }
                    ?>
                </td>

                <td>
                    <div class="dropdown">
                        <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                            <i class="dw dw-more"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                            <a class="dropdown-item" href="edit-user?id=<?php echo $data['_id']; ?>"><i class="dw dw-edit2"></i>
                                Edit</a>
                            <a class="dropdown-item" href='manage-users?id=<?php echo $data['_id']; ?>&del=true'><i class="dw dw-delete-3"></i>
                                Delete</a>
                        </div>
                    </div>
                </td>

            </tr>
        <?php }
    }
}


function _getsingleuser($id, $param)
{
    require('_config.php');
    $sql = "SELECT * FROM `tblusers` WHERE `_id` = $id";
    $query = mysqli_query($conn, $sql);
    if ($query) {
        foreach ($query as $data) {
            return $data[$param];
        }
    }
}

function _deleteuser($id)
{
    require('_config.php');
    require('_alert.php');
    $sql = "DELETE FROM `tblusers` WHERE `_id` = $id";
    $query = mysqli_query($conn, $sql);
    if ($query) {
        $alert = new PHPAlert();
        $alert->error("User Deleted Permanently");
    }
}

function _updateuser($username, $useremail, $userpassword, $usertype, $userphone, $isactive, $isverified, $_id)
{
    require('_config.php');
    require('_alert.php');

    if(!password_verify( _getsingleuser($_id,'_userpassword'), $userpassword)){
        $encpassword = password_hash($userpassword, PASSWORD_DEFAULT);
    }else{
        $encpassword = $userpassword;
    }

    $sql = "UPDATE `tblusers` SET `_username`='$username' , `_useremail`='$useremail', `_userpassword`='$encpassword' , `_userphone`='$userphone' 
    , `_usertype`='$usertype' , `_userstatus`='$isactive' , `_userverify`='$isverified' WHERE `_id` = $_id";
    $query = mysqli_query($conn, $sql);
    if ($query) {
        $alert = new PHPAlert();
        $alert->success("User Updated");
    } else {
        $alert = new PHPAlert();
        $alert->warn("Something went wrong");
    }
}



// Course //

function _createCourse($coursename, $previewurl, $courseDesc, $detaileddescription, $whatlearn, $requirements, $eligibitycriteria, $enrollstatus, $thumbnail, $banner, $pricing, $status, $teacheremailid, $categoryid, $subcategoryid, $coursetype, $coursechannel, $startdate, $enddate, $discountprice)
{

    require('_config.php');
    require('_alert.php');

    $courselink = strtolower(str_replace(array(' ', '.', '&'), '-', $coursename));


    $stmt = $conn->prepare("INSERT INTO `tblcourse` (`_coursename`,`_previewurl`, `_parmalink`,`_coursedescription`,`_detaileddescription`,`_whatlearn`,`_requirements`,`_eligibilitycriteria`,`_enrollstatus`,`_thumbnail`,`_banner`,`_pricing`,`_status`,`_teacheremailid`,`_categoryid`,`_subcategoryid`,`_coursechannel`,`_coursetype`,`_startdate`,`_enddate`,`_discountprice`) VALUES (?, ?,?, ?, ?, ?, ?, ?, ? , ? , ?, ?, ?, ?, ?, ?, ?,?, ?, ?,?)");
    // echo $stmt;
    $stmt->bind_param("sssssssssssssssssssss", $coursename, $previewurl, $courselink, $courseDesc, $detaileddescription, $whatlearn, $requirements, $eligibitycriteria, $enrollstatus, $thumbnail, $banner, $pricing, $status, $teacheremailid, $categoryid, $subcategoryid, $coursechannel, $coursetype, $startdate, $enddate, $discountprice);

    if ($stmt->execute()) {
        $_SESSION['course_success'] = true;
        $alert = new PHPAlert();
        $alert->success("Course Created");
    }

    $stmt->close();
    $conn->close();
}



function _getSingleCourse($id, $param)
{

    require('_config.php');
    $sql = "SELECT * FROM `tblcourse` WHERE `_id`='$id' ";
    $query = mysqli_query($conn, $sql);
    if ($query) {
        foreach ($query as $data) {
            return $data[$param];
        }
    }
}


function _getSingleCourseByPermalink($link, $param)
{

    require('_config.php');
    $sql = "SELECT * FROM `tblcourse` WHERE `_parmalink`='$link' ";
    $query = mysqli_query($conn, $sql);
    if ($query) {
        foreach ($query as $data) {
            return $data[$param];
        }
    }
}


function _showCourses($_courseid = '')
{

    require('_config.php');


    if ($_courseid != '') {

        $sql = "SELECT * FROM `tblcourse` ORDER BY CreationDate DESC";

        $query = mysqli_query($conn, $sql);
        if ($query) {
            ?>
            <label for="courseid" class="form-label">Select Course</label>
            <select style="height: 40px;" id="courseid" name="courseid" class="form-control form-control-lg" required>


                <?php
                foreach ($query as $data) {

                    $currentId = $data['_id'];

                    if ($_courseid == $currentId) {
                        ?>
                        <option value="<?php echo $data['_id']; ?>" selected> <?php echo $data['_coursename']; ?> </option>
                    <?php
                    } else {
                        ?>
                        <option value="<?php echo $data['_id']; ?>"> <?php echo $data['_coursename']; ?> </option>
                <?php
                    }
                }
                ?>

            </select>
            <div class="invalid-feedback">Please select proper course</div>
        <?php


        }
    } else {
        $sql = "SELECT * FROM `tblcourse`";
        $query = mysqli_query($conn, $sql);
        if ($query) { ?>
            <label for="courseid" class="form-label">Select Course</label>
            <select style="height: 46px;" id="courseid" name="courseid" class="form-control form-control-lg" required>
                <option selected disabled value="">Course</option>
                <?php
                foreach ($query as $data) {
                    ?>
                    <option value="<?php echo $data['_id']; ?>"> <?php echo $data['_coursename']; ?> </option>
                <?php
                }
                ?>

            </select>
            <div class="invalid-feedback">Please select proper course</div>
        <?php
        }
    }
}

function _getAllCourses()
{


    require('_config.php');
    $sql = "SELECT * FROM `tblcourse` ORDER BY CreationDate DESC";
    $query = mysqli_query($conn, $sql);
    if ($query) {
        foreach ($query as $data) { ?>
            <tr>
                <td>
                    <?php echo date("F j, Y", strtotime($data['CreationDate'])); ?>
                </td>
                <td>
                    <?php echo $data['_coursename']; ?>
                </td>
                <td>
                    <?php
                    $teacherid = $data['_teacheremailid'];
                    echo _getSingleUser($teacherid, '_useremail');
                    ?>
                </td>
                <td>
                    <?php echo $data['_coursetype']; ?>
                </td>

                <td>
                    <div>
                        <?php

                        $status = $data['_status'];
                        if ($status == true) {
                            ?>
                            <input type="checkbox" checked disabled data-size="small" value="true" name="isactive" class="switch-btn" data-color="#f56767">
                        <?php
                        } else {
                            ?>
                            <input type="checkbox" disabled data-size="small" value="true" name="isactive" class="switch-btn" data-color="#f56767">
                        <?php
                        }
                        ?>
                    </div>
                </td>


                <td>
                    <?php
                    if (strtotime($data['UpdationDate']) == '') {
                        echo "Not Updated Yet";
                    } else {
                        echo date("M j, Y", strtotime($data['UpdationDate']));
                    }
                    ?>
                </td>

                <td>
                    <div class="dropdown">
                        <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                            <i class="dw dw-more"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                            <a class="dropdown-item" href="edit-course?id=<?php echo $data['_id']; ?>"><i class="dw dw-edit2"></i>
                                Edit</a>
                            <a class="dropdown-item" href='manage-course?id=<?php echo $data['_id']; ?>&del=true'><i class="dw dw-delete-3"></i>
                                Delete</a>
                        </div>
                    </div>
                </td>

            </tr>
            <?php }
    }
}



function _updateCourse($id, $coursename, $detaileddescription, $previewurl, $courseDesc, $whatlearn, $requirements, $eligibitycriteria, $enrollstatus, $thumbnail, $banner, $pricing, $isactive, $teacheremailid, $categoryid, $subcategoryid, $coursechannel, $coursetype, $startdate, $enddate, $discountprice)
{

    require('_config.php');
    require('_alert.php');

    $courselink = strtolower(str_replace(array(' ', '.', '&'), '-', $coursename));

    $stmt = $conn->prepare("UPDATE `tblcourse` SET `_coursename`=?,`_detaileddescription`=?,`_previewurl`=?, `_parmalink`=? ,`_coursedescription`=?  , `_whatlearn`=? ,`_requirements`=?  ,`_eligibilitycriteria`=?  , `_enrollstatus`=? ,`_thumbnail`=?  ,`_banner`=?  , `_pricing`=? ,`_status`=?  ,`_teacheremailid`=?  , `_categoryid`=? ,`_subcategoryid`=?  , `_coursechannel`=?  , `_coursetype`=? , `_startdate`=?  , `_enddate`=?  , `_discountprice`=?  WHERE `_id`=?  ");

    $stmt->bind_param("ssssssssssssssssssssss", $coursename, $detaileddescription, $previewurl, $courselink, $courseDesc, $whatlearn, $requirements, $eligibitycriteria, $enrollstatus, $thumbnail, $banner, $pricing, $isactive, $teacheremailid, $categoryid, $subcategoryid, $coursechannel, $coursetype, $startdate, $enddate, $discountprice, $id);
    $stmt->execute();

    if ($stmt) {
        $_SESSION['course_success'] = true;
        $alert = new PHPAlert();
        $alert->success("Course Updated");
    } else {
        $_SESSION['course_error'] = false;
        $alert = new PHPAlert();
        $alert->success("Updation Failed");
    }

    $stmt->close();
    $conn->close();
}

function _deleteCourse($id)
{
    require('_config.php');
    require('_alert.php');

    $sql = "DELETE FROM `tblcourse` WHERE `_id`='$id' ";
    $query = mysqli_query($conn, $sql);

    if ($query) {
        $alert = new PHPAlert();
        $alert->success("Course Delete");
    } else {
        $alert = new PHPAlert();
        $alert->warn("Deletion Failed");
    }
}




// Get Teachers

function _getTeachers($id = '')
{

    include("_config.php");


    if ($id != '') {

        $query = mysqli_query($conn, "SELECT * FROM tblusers WHERE _usertype='1' ");

        while ($row = mysqli_fetch_array($query)) {

            $rowId = $row['_id'];

            if ($id == $rowId) {
                ?>
                    <option value="<?php echo htmlentities($row['_id']); ?>" selected><?php echo htmlentities($row['_useremail']); ?>
                    </option>
                <?php
            } else {
                ?>
                    <option value="<?php echo htmlentities($row['_id']); ?>"><?php echo htmlentities($row['_useremail']); ?></option>
                <?php
            }
        }
    } else {
        $query = mysqli_query($conn, "SELECT * FROM tblusers WHERE _usertype='1' ");

        while ($row = mysqli_fetch_array($query)) {
            ?>
            <option value="<?php echo htmlentities($row['_id']); ?>"><?php echo htmlentities($row['_useremail']); ?></option>
        <?php
        }
    }
}



// Category Functions

function _createCategory($categoryname, $categoryDesc, $categoryimg, $isactive, $_categorytype)
{

    require('_config.php');
    require('_alert.php');

    if ($categoryname != '') {

        $sql = "SELECT * FROM `tblcategory` WHERE `_categoryname` = '$categoryname'";
        $query = mysqli_query($conn, $sql);
        if ($query) {
            $count = mysqli_num_rows($query);
            if ($count > 0) {
                $alert = new PHPAlert();
                $alert->warn("Category Already Exists");
            } else {

                $sql = "INSERT INTO `tblcategory`(`_categoryname`, `_categoryDescription`, `_categoryimg`, `_status` , `_categorytype`) VALUES ('$categoryname','$categoryDesc','$categoryimg ','$isactive','$_categorytype')";


                $query = mysqli_query($conn, $sql);
                if ($query) {

                    $alert = new PHPAlert();
                    $alert->success("Category Created");
                }
            }
        }
    } else {
        $alert = new PHPAlert();
        $alert->warn("All Feilds are Required");
    }
}

function _getCategory()
{
    require('_config.php');

    $sql = "SELECT * FROM `tblcategory` ORDER BY CreationDate DESC";

    $query = mysqli_query($conn, $sql);
    if ($query) {
        foreach ($query as $data) {
            ?>
            <tr>
                <td>
                    <?php echo date("M j, Y", strtotime($data['CreationDate'])); ?>
                </td>
                <td>
                    <?php echo $data['_categoryname']; ?>
                </td>
                <td>
                    <?php echo $data['_categorytype']; ?>
                </td>
                <td>
                    <?php
                    $img = $data['_categoryimg'];
                    if (strlen($img) > 1) {
                        ?>
                        <a href="uploads/categoryimages/<?php echo $img ?>" target="_blank"><i class="icon-copy dw dw-eye"></i></a>
                    <?php
                    } else {
                        ?><i class="icon-copy dw dw-warning"></i><?php
                    }

                    ?>
                </td>
                <td>
                    <div>
                        <?php

                        $status = $data['_status'];
                        if ($status == true) {
                            ?>
                            <input type="checkbox" checked disabled data-size="small" value="true" name="isactive" class="switch-btn" data-color="#f56767">
                        <?php
                        } else {
                            ?>
                            <input type="checkbox" disabled data-size="small" value="true" name="isactive" class="switch-btn" data-color="#f56767">
                        <?php
                        }
                        ?>
                    </div>
                </td>

                <td>
                    <?php
                    if (strtotime($data['UpdationDate']) == '') {
                        echo "Not Updated Yet";
                    } else {
                        echo date("M j, Y", strtotime($data['UpdationDate']));
                    }
                    ?>
                </td>

                <td>
                    <div class="dropdown">
                        <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                            <i class="dw dw-more"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                            <a class="dropdown-item" href='manage-category?id=<?php echo $data['_id']; ?>&del=true'><i class="dw dw-delete-3"></i>
                                Delete</a>
                        </div>
                    </div>
                </td>



            </tr>
        <?php }
    }
}

function _getSingleCategory($id, $param)
{
    require('_config.php');
    $sql = "SELECT * FROM `tblcategory` WHERE `_id` = $id";
    $query = mysqli_query($conn, $sql);
    if ($query) {
        foreach ($query as $data) {
            return $data[$param];
        }
    }
}



function _deleteCategory($id)
{

    require('_config.php');
    require('_alert.php');
    $sql = "DELETE FROM `tblcategory` WHERE `_id` = $id";
    $query = mysqli_query($conn, $sql);
    if ($query) {
        $alert = new PHPAlert();
        $alert->error("Category Deleted Permanently");
    }
}

function _createSubCategory($subCategoryname, $categoryId, $subCategoryDesc, $isactive)
{

    require('_config.php');
    require('_alert.php');

    if ($subCategoryname != '') {

        $sql = "SELECT * FROM `tblsubcategory` WHERE `_subcategoryname` = '$subCategoryname'";
        $query = mysqli_query($conn, $sql);
        if ($query) {
            $count = mysqli_num_rows($query);
            if ($count > 0) {
                $alert = new PHPAlert();
                $alert->warn("Sub Category Already Exists");
            } else {

                $sql = "INSERT INTO `tblsubcategory`( `_subcategoryname` , `_categoryid` , `_subcategorydesc`, `_status`) VALUES ('$subCategoryname','$categoryId','$subCategoryDesc','$isactive')";


                $query = mysqli_query($conn, $sql);
                if ($query) {

                    $alert = new PHPAlert();
                    $alert->success("Sub Category Created");
                }
            }
        }
    } else {
        $alert = new PHPAlert();
        $alert->warn("All Feilds are Required");
    }
}

function _getSubCategory()
{
    require('_config.php');

    $sql = "SELECT * FROM `tblsubcategory` ORDER BY `CreationDate` ASC  ";

    $query = mysqli_query($conn, $sql);
    if ($query) {
        foreach ($query as $data) { ?>
            <tr>
                <td>
                    <?php echo date("M j, Y", strtotime($data['CreationDate'])); ?>
                </td>
                <td>
                    <?php echo $data['_subcategoryname']; ?>
                </td>
                <td>
                    <?php
                    $catid = $data['_categoryid'];
                    $sql = "SELECT * FROM `tblcategory` WHERE `_id` = $catid";
                    $query = mysqli_query($conn, $sql);
                    if ($query) {
                        foreach ($query as $cat_data) {
                            echo $cat_data['_categoryname'];
                        }
                    }
                    ?>
                </td>
                <td>
                    <div>
                        <?php

                        $status = $data['_status'];
                        if ($status == true) {
                            ?>
                            <input type="checkbox" checked disabled data-size="small" value="true" name="isactive" class="switch-btn" data-color="#f56767">
                        <?php
                        } else {
                            ?>
                            <input type="checkbox" disabled data-size="small" value="true" name="isactive" class="switch-btn" data-color="#f56767">
                        <?php
                        }
                        ?>
                    </div>
                </td>
                <td>
                    <?php
                    if (strtotime($data['UpdationDate']) == '') {
                        echo "Not Updated Yet";
                    } else {
                        echo date("M j, Y", strtotime($data['UpdationDate']));
                    }
                    ?>
                </td>

                <td>
                    <div class="dropdown">
                        <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                            <i class="dw dw-more"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                            <a class="dropdown-item" href="edit-category?id=<?php echo $data['_id']; ?>"><i class="dw dw-edit2"></i>
                                Edit</a>
                            <a class="dropdown-item" href='manage-category?id=<?php echo $data['_id']; ?>&del=true'><i class="dw dw-delete-3"></i>
                                Delete</a>
                        </div>
                    </div>
                </td>

            </tr>
        <?php }
    }
}

function _getSingleSubCategory($id, $param)
{
    require('_config.php');
    $sql = "SELECT * FROM `tblsubcategory` WHERE `_id` = $id";
    $query = mysqli_query($conn, $sql);
    if ($query) {
        foreach ($query as $data) {
            return $data[$param];
        }
    }
}


function _deleteSubCategory($id)
{

    require('_config.php');
    require('_alert.php');
    $sql = "DELETE FROM `tblsubcategory` WHERE `_id` = $id";
    $query = mysqli_query($conn, $sql);
    if ($query) {
        $alert = new PHPAlert();
        $alert->error("Sub Category Deleted Permanently");
    }
}

function _showCategoryOptions($_categoryID = '', $categoryType = '')
{

    require('_config.php');

    if ($categoryType != '' && $_categoryID != '') {


        $sql = "SELECT * FROM `tblcategory`  where `_categorytype`='$categoryType'  ";

        $query = mysqli_query($conn, $sql);
        if ($query) {
            ?>
            <label for="categoryId" class="form-label">Select Category</label>
            <select style="height: 40px;" id="categoryId" name="categoryId" onClick="getSubCategory(this.options[this.selectedIndex].value)" class="form-control form-control-lg" required>

                <option selected disabled value="">Category</option>

                <?php
                foreach ($query as $data) {

                    $currentId = $data['_id'];

                    if ($_categoryID == $currentId) {
                        ?>
                        <option value="<?php echo $data['_id']; ?>" selected> <?php echo $data['_categoryname']; ?> </option>
                    <?php
                    } else {
                        ?>
                        <option value="<?php echo $data['_id']; ?>"> <?php echo $data['_categoryname']; ?> </option>
                <?php
                    }
                }
                ?>

            </select>
            <div class="invalid-feedback">Please select proper category</div>
        <?php


        }
    } else if ($_categoryID != '') {

        $sql = "SELECT * FROM `tblcategory`  ";

        $query = mysqli_query($conn, $sql);
        if ($query) {
            ?>
                <label for="categoryId" class="form-label">Select Category</label>
                <select style="height: 40px;" id="categoryId" name="categoryId" onClick="getSubCategory(this.options[this.selectedIndex].value)" class="form-control form-control-lg" required>

                    <option selected disabled value="">Category</option>

                    <?php
                    foreach ($query as $data) {

                        $currentId = $data['_id'];

                        if ($_categoryID == $currentId) {
                            ?>
                            <option value="<?php echo $data['_id']; ?>" selected> <?php echo $data['_categoryname']; ?> </option>
                        <?php
                        } else {
                            ?>
                            <option value="<?php echo $data['_id']; ?>"> <?php echo $data['_categoryname']; ?> </option>
                    <?php
                        }
                    }
                    ?>

                </select>
                <div class="invalid-feedback">Please select proper category</div>
            <?php


        }
    } else if ($categoryType != '') {

        $sql = "SELECT * FROM `tblcategory` where `_categorytype`='$categoryType' ";
        $query = mysqli_query($conn, $sql);
        if ($query) {
            ?>
                    <label for="categoryId" class="form-label">Select Category</label>
                    <select style="height: 46px;" id="categoryId" name="categoryId" onClick="getSubCategory(this.options[this.selectedIndex].value)" class="form-control form-control-lg" required>
                        <option selected disabled value="">Select Category</option>
                        <?php
                        foreach ($query as $data) {
                            ?>
                            <option value="<?php echo $data['_id']; ?>"> <?php echo $data['_categoryname']; ?> </option>
                        <?php
                        }
                        ?>

                    </select>
                    <div class="invalid-feedback">Please select proper category</div>
                <?php
        }
    } else {
        $sql = "SELECT * FROM `tblcategory`";
        $query = mysqli_query($conn, $sql);
        if ($query) {
            ?>
                    <label for="categoryId" class="form-label">Select Category</label>
                    <select style="height: 46px;" id="categoryId" name="categoryId" onClick="getSubCategory(this.options[this.selectedIndex].value)" class="form-control form-control-lg" required>
                        <option selected disabled value="">Select Category</option>
                        <?php
                        foreach ($query as $data) {
                            ?>
                            <option value="<?php echo $data['_id']; ?>"> <?php echo $data['_categoryname']; ?> </option>
                        <?php
                        }
                        ?>

                    </select>
                    <div class="invalid-feedback">Please select proper category</div>
                <?php
        }
    }
}

function _showSubCategoryOptions($_subcategoryID = '')
{

    require('_config.php');


    if ($_subcategoryID != '') {

        $sql = "SELECT * FROM `tblsubcategory` where `_id`=$_subcategoryID  ";

        $query = mysqli_query($conn, $sql);
        if ($query) {



            ?>
            <label for="subcategoryId" class="form-label">Select Sub-Category</label>
            <select style="height: 40px;" id="subcategoryId" name="subcategoryId" id="subcategory" class="form-control form-control-lg" required>

                <?php

                foreach ($query as $data) {
                    ?>
                    <option value="<?php echo $data['_id']; ?>" selected> <?php echo $data['_subcategoryname']; ?> </option>
                <?php
                }

                ?>

            </select>
        <?php


        }
    } else {
        $sql = "SELECT * FROM `tblsubcategory`";

        $query = mysqli_query($conn, $sql);
        if ($query) {

            ?>
            <label for="subcategoryId" class="form-label">Select Sub-Category</label>
            <select style="height: 46px;" id="subcategoryId" name="subcategoryId" id="subcategory" class="form-control form-control-lg" required>


            </select>
        <?php


        }
    }
}



// All Blog Function 

function _createBlog($_blogtitle, $_blogdesc, $_blogcategory, $_blogsubcategory, $_blogmetadesc, $_blogimg, $_userid, $_status)
{
    require('_config.php');
    require('_alert.php');

    $bloglink = strtolower(str_replace(' ', '-', $_blogtitle));

    $stmt = $conn->prepare("INSERT INTO `tblblog` (`_blogtitle`, `_parmalink`, `_blogdesc`, `_blogcategory`, `_blogsubcategory`, `_blogmetadesc`,`_blogimg`, `_userid`, `_status`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param("sssssssss", $_blogtitle, $bloglink, $_blogdesc, $_blogcategory, $_blogsubcategory, $_blogmetadesc, $_blogimg, $_userid, $_status);

    $stmt->execute();

    if ($stmt) {
        $_SESSION['blog_success'] = true;
        $alert = new PHPAlert();
        $alert->success("Blog Created");
    }

    $stmt->close();
    $conn->close();
}

function _getBlogs()
{
    require('_config.php');

    $sql = "SELECT * FROM `tblblog` ORDER BY CreationDate DESC";
    $query = mysqli_query($conn, $sql);
    if ($query) {

        foreach ($query as $data) {
            ?>
            <tr>
                <td>
                    <?php echo date("M j, Y", strtotime($data['CreationDate'])); ?>
                </td>
                <td>
                    <?php echo $data['_blogtitle']; ?>
                </td>
                <td>
                    <div>
                        <?php

                        $status = $data['_status'];
                        if ($status == true) {
                            ?>
                            <input type="checkbox" checked disabled data-size="small" value="true" name="isactive" class="switch-btn" data-color="#f56767">
                        <?php
                        } else {
                            ?>
                            <input type="checkbox" disabled data-size="small" value="true" name="isactive" class="switch-btn" data-color="#f56767">
                        <?php
                        }
                        ?>
                    </div>
                </td>
                <td>
                    <?php
                    $catid = $data['_blogcategory'];
                    $sql = "SELECT * FROM `tblcategory` WHERE `_id` = $catid";
                    $query = mysqli_query($conn, $sql);
                    if ($query) {
                        foreach ($query as $result) {
                            echo $result['_categoryname'];
                        }
                    }
                    ?>
                </td>

                <td>
                    <?php
                    if (strtotime($data['UpdationDate']) == '') {
                        echo "Not Updated Yet";
                    } else {
                        echo date("M j, Y", strtotime($data['UpdationDate']));
                    }
                    ?>
                </td>

                <td>
                    <div class="dropdown">
                        <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                            <i class="dw dw-more"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                            <a class="dropdown-item" href="edit-blog?id=<?php echo $data['_id']; ?>"><i class="dw dw-edit2"></i>
                                Edit</a>
                            <a class="dropdown-item" href='manage-blog?id=<?php echo $data['_id']; ?>&del=true'><i class="dw dw-delete-3"></i>
                                Delete</a>
                        </div>
                    </div>
                </td>

            </tr>

        <?php

        }
    }
}

function updateBlog($_blogtitle, $_blogdesc, $_blogcategory, $_blogsubcategory, $_blogmetadesc, $_blogimg, $_status, $_id)
{
    require('_config.php');
    require('_alert.php');

    $bloglink = strtolower(str_replace(' ', '-', $_blogtitle));

    $stmt = $conn->prepare("UPDATE `tblblog` SET `_blogtitle`= ? , `_parmalink`= ? , `_blogdesc`= ? , `_blogcategory`= ? , `_blogsubcategory`= ? , `_blogmetadesc`= ? , `_blogimg`= ? , `_status`= ? WHERE `_id`=? ");

    $stmt->bind_param("sssssssss", $_blogtitle, $bloglink, $_blogdesc, $_blogcategory, $_blogsubcategory, $_blogmetadesc, $_blogimg, $_status, $_id);
    $stmt->execute();

    if ($stmt) {
        $_SESSION['blog_success'] = true;
        $alert = new PHPAlert();
        $alert->success("Blog Updates");
    }

    $stmt->close();
    $conn->close();
}


function _getSingleBlog($id, $param)
{
    require('_config.php');
    $sql = "SELECT * FROM `tblblog` WHERE `_id`=$id";
    $query = mysqli_query($conn, $sql);
    if ($query) {

        foreach ($query as $data) {
            return $data[$param];
        }
    }
}

function _deleteBlog($id)
{

    require('_config.php');
    require('_alert.php');
    $sql = "DELETE FROM `tblblog` WHERE `_id` = $id";
    $query = mysqli_query($conn, $sql);
    if ($query) {
        $alert = new PHPAlert();
        $alert->error("Blog Deleted Permanently");
    }
}


// Notify User


use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function _notifyuser($useremail = '', $userphone = '', $sendmail = '', $message = '', $subject = '')
{
    require('_config.php');
    if ($userphone != '') {
        $sql = "SELECT * FROM `tblsmsconfig` WHERE `_supplierstatus` = 'true'";
        $query = mysqli_query($conn, $sql);
        $count = mysqli_num_rows($query);
        if ($count > 0) {
            foreach ($query as $data) {
                $baseurl = $data['_baseurl'];
                $apikey = $data['_apikey'];
            }

            $fields = array(
                "message" => $message,
                "sender_id" => "FSTSMS",
                "language" => "english",
                "route" => "v3",
                "numbers" => $userphone,
            );

            $curl = curl_init();

            curl_setopt_array(
                $curl,
                array(
                    CURLOPT_URL => $baseurl,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_SSL_VERIFYHOST => 0,
                    CURLOPT_SSL_VERIFYPEER => 0,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "POST",
                    CURLOPT_POSTFIELDS => json_encode($fields),
                    CURLOPT_HTTPHEADER => array(
                        "authorization: $apikey",
                        "accept: */*",
                        "cache-control: no-cache",
                        "content-type: application/json"
                    ),
                )
            );

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            if ($err) {
                $alert = new PHPAlert();
                $alert->warn("SMS not sent");
            } else {
                $_SESSION['template_success'] = true;
            }
        }
    }
    if ($useremail != '') {
        $sql = "SELECT * FROM `tblemailconfig` WHERE `_supplierstatus` = 'true'";
        $query = mysqli_query($conn, $sql);
        $count = mysqli_num_rows($query);
        if ($count == 1) {
            require_once "vendor-php/autoload.php";
            $mail = new PHPMailer(true); //Argument true in constructor enables exceptions
            //Set PHPMailer to use SMTP.
            $mail->isSMTP();
            foreach ($query as $data) {
                //Enable SMTP debugging.
                // $mail->SMTPDebug = 10;                                       
                //Set SMTP host name                          
                $mail->Host = $data['_hostname'];
                //Set this to true if SMTP host requires authentication to send email
                $mail->SMTPAuth = $data['_smtpauth'];
                //Provide username and password     
                $mail->Username = $data['_emailaddress'];
                $mail->Password = $data['_emailpassword'];
                //If SMTP requires TLS encryption then set it
                $mail->SMTPSecure = "ssl";
                //Set TCP port to connect to
                $mail->Port = $data['_hostport'];

                $mail->From = $data['_emailaddress'];
                $mail->FromName = $data['_sendername'];
                //Address to which recipient will reply
                $mail->addReplyTo($data['_emailaddress'], "Reply");
            }
            //To address and namS
            $mail->addAddress($useremail); //Recipient name is optional

            $mail->isHTML(true);

            $mail->Subject = $subject;
            $mail->Body = $sendmail;
            $mail->IsHTML(true);
            if ($mail->send()) {
                $_SESSION['send_mail'] = true;
            } else {
                echo 'Mailer Error: ' . $mail->ErrorInfo;
            }
        }
    }
}


// Settings

function _smsconfig($param)
{
    require('_config.php');
    $sql = "SELECT * FROM `tblsmsconfig`";
    $query = mysqli_query($conn, $sql);
    if ($query) {
        foreach ($query as $data) {
            return $data[$param];
        }
    }
}
function _savesmsconfig($suppliername, $apikey, $baseurl, $isactive)
{
    require('_config.php');
    require('_alert.php');
    $sql = "UPDATE `tblsmsconfig` SET `_suppliername`='$suppliername',`_apikey`='$apikey',`_baseurl`='$baseurl',`_supplierstatus`='$isactive' WHERE `_id` = 1";
    $query = mysqli_query($conn, $sql);
    if ($query) {
        $alert = new PHPAlert();
        $alert->success("Settings Saved");
    } else {
        $alert = new PHPAlert();
        $alert->warn("Something went wrong");
    }
}

function _emailconfig($param)
{
    require('_config.php');
    $sql = "SELECT * FROM `tblemailconfig`";
    $query = mysqli_query($conn, $sql);
    if ($query) {
        foreach ($query as $data) {
            return $data[$param];
        }
    }
}

function _saveemailconfig($hostname, $hostport, $smtpauth, $emailid, $password, $sendername, $status)
{
    require('_config.php');
    require('_alert.php');
    $sql = "UPDATE `tblemailconfig` SET `_hostname`='$hostname',`_hostport`='$hostport',`_smtpauth`='$smtpauth',`_emailaddress`='$emailid',`_emailpassword`='$password',`_sendername`='$sendername',`_supplierstatus`='$status' WHERE `_id` = 1";
    $query = mysqli_query($conn, $sql);
    if ($query) {
        $alert = new PHPAlert();
        $alert->success("Settings Saved");
    } else {
        $alert = new PHPAlert();
        $alert->warn("Something went wrong");
    }
}

function _siteconfig($param)
{
    require('_config.php');
    $sql = "SELECT * FROM `tblsiteconfig`";
    $query = mysqli_query($conn, $sql);
    if ($query) {
        foreach ($query as $data) {
            return $data[$param];
        }
    }
}
function _savesiteconfig($sitetitle, $siteemail, $sitephone, $sitecurrency, $timezone, $header, $footer, $css, $logo = '', $reslogo = '', $favicon = '')
{
    require('_config.php');
    require('_alert.php');
    if ($logo && $reslogo && $favicon) {
        $sql = "UPDATE `tblsiteconfig` SET `_sitetitle`='$sitetitle',`_siteemail`='$siteemail',`_sitephone`='$sitephone',`_sitecurrency`='$sitecurrency',`_timezone`='$timezone', `_customheader`='$header', `_customfooter`='$footer',  `_customcss`='$css', `_sitelogo`='$logo',`_sitereslogo`='$reslogo',`_favicon`='$favicon' WHERE `_id` = 00000000000000000001";
    }
    if ($logo && $reslogo) {
        $sql = "UPDATE `tblsiteconfig` SET `_sitetitle`='$sitetitle',`_siteemail`='$siteemail',`_sitephone`='$sitephone',`_sitecurrency`='$sitecurrency',`_timezone`='$timezone',`_customheader`='$header', `_customfooter`='$footer',  `_customcss`='$css', `_sitelogo`='$logo',`_sitereslogo`='$reslogo' WHERE `_id` = 00000000000000000001";
    }
    if ($reslogo && $favicon) {
        $sql = "UPDATE `tblsiteconfig` SET `_sitetitle`='$sitetitle',`_siteemail`='$siteemail',`_sitephone`='$sitephone',`_sitecurrency`='$sitecurrency',`_timezone`='$timezone',`_customheader`='$header', `_customfooter`='$footer',  `_customcss`='$css', `_sitereslogo`='$reslogo',`_favicon`='$favicon' WHERE `_id` = 00000000000000000001";
    }
    if ($logo && $favicon) {
        $sql = "UPDATE `tblsiteconfig` SET `_sitetitle`='$sitetitle',`_siteemail`='$siteemail',`_sitephone`='$sitephone',`_sitecurrency`='$sitecurrency',`_timezone`='$timezone',`_customheader`='$header', `_customfooter`='$footer',  `_customcss`='$css', `_sitelogo`='$logo',`_favicon`='$favicon' WHERE `_id` = 00000000000000000001";
    }
    if ($logo) {
        $sql = "UPDATE `tblsiteconfig` SET `_sitetitle`='$sitetitle',`_siteemail`='$siteemail',`_sitephone`='$sitephone',`_sitecurrency`='$sitecurrency',`_timezone`='$timezone', `_customheader`='$header', `_customfooter`='$footer',  `_customcss`='$css', `_sitelogo`='$logo' WHERE `_id` = 00000000000000000001";
    }
    if ($reslogo) {
        $sql = "UPDATE `tblsiteconfig` SET `_sitetitle`='$sitetitle',`_siteemail`='$siteemail',`_sitephone`='$sitephone',`_sitecurrency`='$sitecurrency',`_timezone`='$timezone', `_customheader`='$header', `_customfooter`='$footer',  `_customcss`='$css', `_sitereslogo`='$reslogo' WHERE `_id` = 00000000000000000001";
    }
    if ($favicon) {
        $sql = "UPDATE `tblsiteconfig` SET `_sitetitle`='$sitetitle',`_siteemail`='$siteemail',`_sitephone`='$sitephone',`_sitecurrency`='$sitecurrency',`_timezone`='$timezone', `_customheader`='$header', `_customfooter`='$footer',  `_customcss`='$css', `_favicon`='$favicon' WHERE `_id` = 00000000000000000001";
    }
    if (!$logo && !$reslogo && !$favicon) {
        $sql = "UPDATE `tblsiteconfig` SET `_sitetitle`='$sitetitle',`_siteemail`='$siteemail',`_sitephone`='$sitephone',`_sitecurrency`='$sitecurrency',`_timezone`='$timezone', `_customheader`='$header', `_customfooter`='$footer',  `_customcss`='$css'  WHERE `_id` = 00000000000000000001";
    }
    $query = mysqli_query($conn, $sql);
    if ($query) {
        $alert = new PHPAlert();
        $alert->success("Settings Saved");
    } else {
        $alert = new PHPAlert();
        $alert->warn("Something went wrong");
    }
}


function _paymentconfig($param)
{
    require('_config.php');
    $sql = "SELECT * FROM `tblpaymentconfig`";
    $query = mysqli_query($conn, $sql);
    if ($query) {
        foreach ($query as $data) {
            return $data[$param];
        }
    }
}

function _savepaymentconfig($suppliername, $apikey, $secretkey, $companyname, $isactive)
{
    require('_config.php');
    require('_alert.php');
    $sql = "UPDATE `tblpaymentconfig` SET `_suppliername`='$suppliername',`_apikey`='$apikey',`_secretkey`='$secretkey',`_companyname`='$companyname',`_supplierstatus`='$isactive' WHERE `_id` = 1";
    $query = mysqli_query($conn, $sql);
    if ($query) {
        $alert = new PHPAlert();
        $alert->success("Settings Saved");
    } else {
        $alert = new PHPAlert();
        $alert->warn("Something went wrong");
    }
}





// Email Templates

function _updateEmailTemplate($templateName, $templateCode)
{

    require('_config.php');

    $emailtemp = $conn->real_escape_string($templateCode);
    $sql = "UPDATE `tblemailtemplates` SET `$templateName`='" . $emailtemp . "' WHERE `_id` = 1 ";

    $query = mysqli_query($conn, $sql);
    if ($query) {
        $_SESSION['template_success'] = true;
        header("location:");
    } else {
        $_SESSION['template_error'] = true;
        header("location:");
    }
}

function _getSingleEmailTemplate($templateName)
{
    require('_config.php');
    $sql = "SELECT * FROM `tblemailtemplates` WHERE `_id` = 1 ";
    $query = mysqli_query($conn, $sql);
    if ($query) {
        foreach ($query as $data) {
            return $data[$templateName];
        }
    }
}



// Lessons //
function _createLesson($_courseid, $_lessonname, $_lessontype, $_lessonurl, $lessondate, $lessontime, $_recordedfilename, $_lessondescription, $_status, $_availablity)
{


    require('_config.php');

    $stmt = $conn->prepare("INSERT INTO `tbllessons` (`_courseid`,`_lessonname`,`_lessontype`,`_lessonurl`,`_lessondate`,`_lessontime`,`_recordedfilename`,`_lessondescription`,`_status`,`_availablity`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssss", $_courseid, $_lessonname, $_lessontype, $_lessonurl, $lessondate, $lessontime, $_recordedfilename, $_lessondescription, $_status, $_availablity);

    $stmt->execute();

    if ($stmt) {
        $_SESSION['course_success'] = true;
        header("location:");
    } else {
        $_SESSION['course_error'] = false;
        header("location:");
    }

    $stmt->close();
    $conn->close();
}


function _getSingleLesson($id, $param)
{

    require('_config.php');
    $sql = "SELECT * FROM `tbllessons` WHERE `_id`='$id' ";
    $query = mysqli_query($conn, $sql);
    if ($query) {
        foreach ($query as $data) {
            return $data[$param];
        }
    }
}



function _getLessons($courseid)
{

    require('_config.php');

    $sql = "SELECT * FROM `tbllessons` where `_courseid`='$courseid' ORDER BY CreationDate DESC";

    $query = mysqli_query($conn, $sql);

    if ($query) {
        foreach ($query as $data) {
            ?>
            <tr>
                <td>
                    <?php echo date("M j, Y", strtotime($data['CreationDate'])); ?>
                </td>
                <td>
                    <?php echo $data['_id']; ?>
                </td>

                <td>
                    <?php echo $data['_lessonname']; ?>
                </td>

                <td>
                    <div>
                        <?php

                        $status = $data['_status'];
                        if ($status == true) {
                            ?>
                            <input type="checkbox" class="custom-control-input" checked>
                            <label class="custom-control-label" for="isactive<?php echo $data['_id']; ?>"></label>
                        <?php
                        } else {
                            ?>
                            <input type="checkbox" class="custom-control-input">
                            <label class="custom-control-label" for="isactive<?php echo $data['_id']; ?>"></label>
                        <?php
                        }
                        ?>
                    </div>
                </td>

                <td>
                    <?php echo $data['_lessontype']; ?>
                </td>

                <td>
                    <?php
                    if (strtotime($data['UpdationDate']) == '') {
                        echo "Not Updated Yet";
                    } else {
                        echo date("M j, Y", strtotime($data['UpdationDate']));
                    }
                    ?>
                </td>
                <td>
                    <div class="dropdown">
                        <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                            <i class="dw dw-more"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                            <a class="dropdown-item" onclick="getSingleLesson(<?php echo $data['_id']; ?>)"><i class="dw dw-edit2"></i>
                                Edit</a>
                            <a class="dropdown-item" href='edit-course?id=<?php echo $courseid ?>&lessonid=<?php echo $data['_id']; ?>&del=true'><i class="dw dw-delete-3"></i>
                                Delete</a>
                        </div>
                    </div>
                </td>
            </tr>
        <?php
        }
    }
}

function _updateLesson($_id, $_courseid, $_lessonname, $_lessontype, $_lessonurl, $_lessondate, $_lessontime, $_recordedfilename, $_lessondescription, $_status, $_availablity)
{

    require('_config.php');
    require('_alert.php');

    $stmt = $conn->prepare("UPDATE `tbllessons` SET `_courseid`= ? ,`_lessonname`= ? ,`_lessondescription`= ? , `_status`= ?,`_availablity`= ?,`_lessontype`= ?,`_lessonurl`= ?,`_lessondate`= ?,`_lessontime`= ?,`_recordedfilename`= ?  WHERE `_id` =  ? ");

    $stmt->bind_param("sssssssssss", $_courseid, $_lessonname, $_lessondescription, $_status, $_availablity, $_lessontype, $_lessonurl, $_lessondate, $_lessontime, $_recordedfilename, $_id);
    echo 'donecccc';

    if ($stmt->execute()) {
        echo 'done';
        $alert = new PHPAlert();
        $alert->success("Lesson Edited");
    } else {
        echo "Error inserting record: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}



function _deleteLesson($id)
{
    require('_config.php');
    require('_alert.php');

    $sql = "DELETE FROM `tbllessons` WHERE `_id`='$id' ";
    $query = mysqli_query($conn, $sql);

    if ($query) {
        $alert = new PHPAlert();
        $alert->success("Lesson Delete");
    } else {
        $alert = new PHPAlert();
        $alert->warn("Deletion Failed");
    }
}


// Profile


function _updateProfile($username, $useremail, $userpassword, $userphone, $userage, $userbio, $location, $userpin, $country, $usercurrency)
{
    require('_config.php');
    require('_alert.php');
    $email = $_SESSION['userEmailId'];
    $phone = $_SESSION['userPhoneNo'];
    $id = $_SESSION['userId'];
    if ($phone != $userphone && $email != $useremail) {
        $sql = "SELECT * FROM `tblusers` WHERE`_useremail` = '$useremail' AND `_userphone` = '$userphone'";
        $run = true;
    }
    if ($phone != $userphone) {
        $sql = "SELECT * FROM `tblusers` WHERE `_userphone` = '$userphone'";
        $run = true;
    }
    if ($email != $useremail) {
        $sql = "SELECT * FROM `tblusers` WHERE `_useremail` = '$useremail'";
        $run = true;
    }
    if ($phone == $userphone && $email == $useremail) {
        $run = false;
    }
    if ($run) {
        $query = mysqli_query($conn, $sql);
        if ($query) {
            $count = mysqli_num_rows($query);
            if ($count > 0) {
                $alert = new PHPAlert();
                $alert->warn("Credential Already in use");
            } else {
                $password = $_SESSION['userPassword'];
                if ($userpassword == $password) {
                    $encpassword = $userpassword;
                    $sql = "UPDATE `tblusers` SET `_username`='$username',`_useremail`='$useremail',`_userphone`='$userphone',`_userbio`='$userbio',`_userage`='$userage',`_userlocation`='$location',`_userstate`='$country',`_userpin`='$userpin',`_usercurrency`='$usercurrency' WHERE `_id` = $id";
                } else {
                    $encpassword = md5($userpassword);
                    $sql = "UPDATE `tblusers` SET `_username`='$username',`_useremail`='$useremail',`_userphone`='$userphone',`_userbio`='$userbio',`_userage`='$userage',`_userlocation`='$location',`_userstate`='$country',`_userpin`='$userpin',`_userpassword`='$encpassword',`_usercurrency`='$usercurrency' WHERE `_id` = $id";
                }

                $query = mysqli_query($conn, $sql);
                if ($query) {
                    $alert = new PHPAlert();
                    $alert->success("Profile Updated");
                    $_SESSION['userEmailId'] = $useremail;
                    $_SESSION['userPhoneNo'] = $userphone;
                    $_SESSION['userPassword'] = $encpassword;
                } else {
                    $alert = new PHPAlert();
                    $alert->warn("Something went wrong");
                }
            }
        }
    } else {
        $password = $_SESSION['userPassword'];
        if ($userpassword == $password) {
            $encpassword = $userpassword;
            $sql = "UPDATE `tblusers` SET `_username`='$username',`_userbio`='$userbio',`_userage`='$userage',`_userlocation`='$location',`_userstate`='$country',`_userpin`='$userpin',`_usercurrency`='$usercurrency' WHERE `_id` = $id";
        } else {
            $encpassword = md5($userpassword);
            $sql = "UPDATE `tblusers` SET `_username`='$username',`_userbio`='$userbio',`_userage`='$userage',`_userlocation`='$location',`_userstate`='$country',`_userpin`='$userpin',`_userpassword`='$encpassword',`_usercurrency`='$usercurrency' WHERE `_id` = $id";
        }

        $query = mysqli_query($conn, $sql);
        if ($query) {
            $alert = new PHPAlert();
            $alert->success("Profile Updated");
            $_SESSION['userPassword'] = $encpassword;
        } else {
            $alert = new PHPAlert();
            $alert->warn("Something went wrong");
        }
    }
}

function _updatedb($newfile)
{
    require('_config.php');
    require('_alert.php');
    $id = $_SESSION['userId'];
    $sql = "UPDATE `tblusers` SET `_userdp`='$newfile' WHERE `_id` = $id";
    $query = mysqli_query($conn, $sql);
    if ($query) {
        $alert = new PHPAlert();
        $alert->success("Profile Updated");
    } else {
        $alert = new PHPAlert();
        $alert->warn("Something went wrong");
    }
}


// All Markups


function _createmarkup($conversion, $price, $status)
{
    require('_config.php');
    require('_alert.php');
    $sql = "INSERT INTO `tblcurrency`( `_conversioncurrency`, `_price`, `_status`) VALUES ('$conversion','$price','$status')";
    $query = mysqli_query($conn, $sql);
    if ($query) {
        $alert = new PHPAlert();
        $alert->success("Markup Created");
    } else {
        $alert = new PHPAlert();
        $alert->warn("Markup Failed");
    }
}

function _getmarkup()
{
    require('_config.php');

    $sql = "SELECT * FROM `tblcurrency` ORDER BY CreationDate DESC";
    $query = mysqli_query($conn, $sql);
    if ($query) {
        foreach ($query as $data) { ?>
            <tr>
                <td>
                    <?php echo date("M j, Y", strtotime($data['CreationDate'])); ?>
                </td>
                <td>
                    <?php echo $data['_conversioncurrency']; ?>
                </td>
                <td>
                    <?php echo $data['_price']; ?>
                </td>
                <td>
                    <div>
                        <?php

                        $status = $data['_status'];
                        if ($status == true) {
                            ?>
                            <input type="checkbox" class="custom-control-input" checked>
                            <label class="custom-control-label" for="isactive<?php echo $data['_id']; ?>"></label>
                        <?php
                        } else {
                            ?>
                            <input type="checkbox" class="custom-control-input">
                            <label class="custom-control-label" for="isactive<?php echo $data['_id']; ?>"></label>
                        <?php
                        }
                        ?>
                    </div>
                </td>

                <td>
                    <div class="dropdown">
                        <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                            <i class="dw dw-more"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                            <a class="dropdown-item" href='manage-currency?id=<?php echo $data['_id'] ?>&del=true'><i class="dw dw-delete-3"></i>
                                Delete</a>
                        </div>
                    </div>
                </td>
            </tr>
        <?php }
    }
}

function _getmarkupOnlyCurrency()
{

    require('_config.php');


    $sql = "SELECT * FROM `tblcurrency` ";

    $query = mysqli_query($conn, $sql);

    if ($query) {


        foreach ($query as $data) {
            ?>
            <option value="<?php echo $data['_conversioncurrency']; ?>"><?php echo $data['_conversioncurrency']; ?></option>
        <?php
        }
    }
}

function _conversion($amount, $currency)
{
    require('_config.php');
    $sql = "SELECT * FROM `tblcurrency` WHERE `_conversioncurrency` = '$currency'";
    $query = mysqli_query($conn, $sql);
    if ($query) {
        foreach ($query as $data) {
            $price = $data['_price'];
        }
        return $amount * $price;
    }
}

function _deletemarkup($id)
{

    require('_config.php');
    require('_alert.php');
    $sql = "DELETE FROM `tblcurrency` WHERE `_id` = $id";
    $query = mysqli_query($conn, $sql);
    if ($query) {
        $alert = new PHPAlert();
        $alert->error("Markup Deleted Permanently");
    }
}


// Tax Functions

function _createtaxmarkup($name, $type, $amount, $status)
{
    require('_config.php');
    require('_alert.php');
    $sql = "INSERT INTO `tbltaxes`(`_taxname`, `_taxtype`, `_taxamount`, `_status`) VALUES ('$name','$type','$amount','$status')";
    $query = mysqli_query($conn, $sql);
    if ($query) {
        $alert = new PHPAlert();
        $alert->success("Markup Created");
    } else {
        $alert = new PHPAlert();
        $alert->warn("Markup Failed");
    }
}

function _gettaxmarkup()
{
    require('_config.php');

    $sql = "SELECT * FROM `tbltaxes` ORDER BY CreationDate DESC";

    $query = mysqli_query($conn, $sql);
    if ($query) {
        foreach ($query as $data) { ?>
            <tr>
                <td>
                    <?php echo date("M j, Y", strtotime($data['CreationDate'])); ?>
                </td>
                <td>
                    <?php echo $data['_taxname']; ?>
                </td>
                <td>
                    <?php echo $data['_taxtype']; ?>
                </td>
                <td>
                    <?php echo $data['_taxamount']; ?>
                </td>
                <td>
                    <div>
                        <?php

                        $status = $data['_status'];
                        if ($status == true) {
                            ?>
                            <input type="checkbox" class="custom-control-input" checked>
                            <label class="custom-control-label" for="isactive<?php echo $data['_id']; ?>"></label>
                        <?php
                        } else {
                            ?>
                            <input type="checkbox" class="custom-control-input">
                            <label class="custom-control-label" for="isactive<?php echo $data['_id']; ?>"></label>
                        <?php
                        }
                        ?>
                    </div>
                </td>

                <td>
                    <div class="dropdown">
                        <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                            <i class="dw dw-more"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                            <a class="dropdown-item" href='manage-tax?id=<?php echo $data['_id'] ?>&del=true'><i class="dw dw-delete-3"></i>
                                Delete</a>
                        </div>
                    </div>
                </td>
            </tr>
        <?php }
    }
}

function _deletetax($id)
{
    require('_config.php');
    require('_alert.php');
    $sql = "DELETE FROM `tbltaxes` WHERE `_id` = $id";
    $query = mysqli_query($conn, $sql);
    if ($query) {
        $alert = new PHPAlert();
        $alert->error("Tax Deleted Permanently");
    }
}

function _gettaxes()
{
    require('_config.php');
    $sql = "SELECT * FROM `tbltaxes` WHERE `_status` = 'true'";
    $query = mysqli_query($conn, $sql);
    if ($query) {
        foreach ($query as $data) { ?>
            <h5 style="margin-top:10px">
                <?php echo $data['_taxname']; ?>
            </h5>
            <?php if ($data['_taxtype'] == 'Variable') { ?>
                <input class="form-control" name="amount" type="text" readonly value="<?php echo $data['_taxamount']; ?>%">
            <?php } else {
                ?><input class="form-control" name="amount" type="text" readonly value="<?php echo $data['_taxcurrency']; ?>&nbsp;<?php echo $data['_taxamount']; ?>">
                                                                                                                                                                                                            <?php } ?>

        <?php }
    }
}



// Coupon Functions 

function _createcoupon($name, $type, $amount, $condition, $conamount, $validity, $couponprod)
{
    require('_config.php');
    require('_alert.php');
    $sql = "INSERT INTO `tblcoupon`(`_couponname`, `_coupontype`, `_couponamount`,`_couponcondition`, `_couponprod`, `_conamount`, `_maxusage`, `_totaluse`) VALUES ('$name','$type','$amount','$condition', '$couponprod','$conamount','$validity',0)";
    $query = mysqli_query($conn, $sql);
    if ($query) {
        $alert = new PHPAlert();
        $alert->success("Coupon Created");
    } else {
        $alert = new PHPAlert();
        $alert->warn("Coupon Failed");
    }
}

function _getcoupon()
{
    require('_config.php');

    $sql = "SELECT * FROM `tblcoupon` ORDER BY CreationDate DESC";
    $query = mysqli_query($conn, $sql);
    if ($query) {
        foreach ($query as $data) { ?>
            <tr>
                <td>
                    <?php echo date("M j, Y", strtotime($data['CreationDate'])); ?>
                </td>
                <td>
                    <?php echo $data['_couponname']; ?>
                </td>
                <td>
                    <?php echo $data['_coupontype']; ?>
                </td>
                <td>
                    <?php echo $data['_couponamount']; ?>
                </td>
                <td>
                    <?php echo $data['_couponcondition']; ?>
                </td>
                <td>
                    <?php echo $data['_conamount']; ?>
                </td>
                <td>
                    <?php echo $data['_maxusage']; ?>
                </td>
                <td>
                    <?php echo $data['_totaluse']; ?>
                </td>

                <td>
                    <div class="dropdown">
                        <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                            <i class="dw dw-more"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                            <a class="dropdown-item" href='manage-coupon?id=<?php echo $data['_id'] ?>&del=true'><i class="dw dw-delete-3"></i>
                                Delete</a>
                        </div>
                    </div>
                </td>
            </tr>
        <?php }
    }
}

function _deletecoupon($id)
{
    require('_config.php');
    require('_alert.php');
    $sql = "DELETE FROM `tblcoupon` WHERE `_id` = $id";
    $query = mysqli_query($conn, $sql);
    if ($query) {
        $alert = new PHPAlert();
        $alert->error("Tax Deleted Permanently");
    }
}

function _updatecoupon($id, $status)
{
    require('_config.php');
    $sql = "UPDATE `tblcoupontrans` SET `_couponstatus`='$status' WHERE `_id` = $id";
    $query = mysqli_query($conn, $sql);
    if ($query) {
        if ($status == 'success') {
            $sql = "SELECT * FROM `tblcoupontrans` WHERE `_id` = $id";
            $query = mysqli_query($conn, $sql);
            foreach ($query as $data) {
                $couponname = $data['_couponname'];
            }
            $sql = "UPDATE `tblcoupon` SET `_totaluse`= _totaluse + 1 WHERE `_couponname` = '$couponname'";
            echo $sql;
            $query = mysqli_query($conn, $sql);
        }
    }
}


// Transcations


function _getTranscations()
{

    require('_config.php');

    $sql = "SELECT * FROM `tblpayment` ORDER BY CreationDate DESC";
    $query = mysqli_query($conn, $sql);
    if ($query) {
        foreach ($query as $data) {
            ?>
            <tr style="margin-bottom:-25px">

                <td>
                    <?php echo date("M j, Y (H:i:s)", strtotime($data['CreationDate'])); ?>
                </td>

                <td><?php echo $data['_razorpayid']; ?></td>
                <td><a target="_blank" href="edit-user?id=<?php echo singleDetail('tblusers', '_userphone', $data['_useremail'], '_id'); ?>"><?php echo singleDetail('tblusers', '_userphone', $data['_useremail'], '_username'); ?></a></td>
                <td><?php
                  if($data['_producttype'] == 'membership'){ ?>
                    <a target="_blank" href="edit-membership?id=<?php echo $data['_productid']; ?>"><?php echo limitText(singleDetail('tblmembership', '_id', $data['_productid'], '_membershipname'),50); ?></a>
                  <?php } else{ ?>
                    <a target="_blank" href="edit-course?id=<?php echo $data['_productid']; ?>"><?php echo limitText(singleDetail('tblcourse', '_id', $data['_productid'], '_coursename'),50); ?></a>
                  <?php } 
                ?></td>
                <td><?php echo $data['_amount']; ?></td>
                <td><?php echo $data['_currency']; ?></td>

                <td>
                    <div>
                        <?php
                        $status = $data['_status'];
                        if ($status == 'success') {?>
                          <span class="badge bg-success">Success</span>  
                        <?php } else {?>
                            <span class="badge bg-danger">Failed</span>  
                        <?php } ?>
                    </div>
                </td>

                <td><?php echo $data['_couponcode']; ?></td>

            </tr>
        <?php
        } ?> <br> <?php
    }
}

function _getTranscationsForUser($useremail)
{

    require('_config.php');

    $sql = "SELECT * FROM `tblpayment` where `_useremail`='$useremail' ORDER BY CreationDate DESC";
    $query = mysqli_query($conn, $sql);
    if ($query) {
        foreach ($query as $data) {
            ?>
                  <tr style="margin-bottom:-25px">

                      <td>
                          <?php echo date("M j, Y (H:i:s)", strtotime($data['CreationDate'])); ?>
                      </td>

                      <td><?php echo $data['_razorpayid']; ?></td>
                      <td><?php echo $data['_amount']; ?></td>
                      <td><?php echo $data['_currency']; ?></td>
                      <td><?php
                        if($data['_producttype'] == 'membership'){ ?>
                            <a target="_blank" href="edit-membership?id=<?php echo $data['_productid']; ?>"><?php echo limitText(singleDetail('tblmembership', '_id', $data['_productid'], '_membershipname'),50); ?></a>
                        <?php } else{ ?>
                            <a target="_blank" href="edit-course?id=<?php echo $data['_productid']; ?>"><?php echo limitText(singleDetail('tblcourse', '_id', $data['_productid'], '_coursename'),50); ?></a>
                        <?php } 
                       ?></td>
                      <td>
                        <div>
                            <?php
                            $status = $data['_status'];
                            if ($status == 'success') {?>
                            <span class="badge bg-success">Success</span>  
                            <?php } else {?>
                                <span class="badge bg-danger">Failed</span>  
                            <?php } ?>
                        </div>
                     </td>

                      <td><?php echo $data['_couponcode']; ?></td>

                  </tr>
              <?php
        } ?> <br> <?php
    }
}

function _getCouponTranscation()
{

    require('_config.php');


    $sql = "SELECT * FROM `tblcoupontrans` ORDER BY CreationDate DESC";
    $query = mysqli_query($conn, $sql);

    if ($query) {
        foreach ($query as $data) {
            ?>
                  <tr>

                      <td>
                          <?php echo date("M j, Y", strtotime($data['CreationDate'])); ?>
                      </td>
                      <td><?php echo $data['_couponname']; ?></td>
                      <td><?php echo $data['_couponamount']; ?></td>
                      <td><?php echo $data['_couponcurrency']; ?></td>
                      <td><?php echo $data['_useremail']; ?></td>
                      <td><?php echo $data['_couponstatus']; ?></td>
                  </tr>
              <?php
        }
    }
}

function _updateCouponTranscation($_id, $couponname, $couponamount, $useremail)
{

    require('_config.php');
    require('_alert.php');


    $sql = "UPDATE `tblcoupontrans` SET `_couponname`='$couponname' , `_couponamount`='$couponamount' , `_useremail`='$useremail' WHERE `_id` = '$_id'";

    $query = mysqli_query($conn, $sql);
    if ($query) {
        $alert = new PHPAlert();
        $alert->success("Coupon Transcation Updated");
    } else {
        $alert = new PHPAlert();
        $alert->warn("Something went wrong");
    }
}

function _updatepayment($id, $status)
{
    require('_config.php');
    $sql = "UPDATE `tblpayment` SET `_status`='$status' WHERE `_id` = $id";
    $query = mysqli_query($conn, $sql);
    if ($query) {
        2 + 2;
    }
}


// Purchased Courses



function _getUserCourses($id)
{
    require('_config.php');

    $sql = "SELECT * FROM `tblpurchasedcourses` where `_userid`='$id' ORDER BY CreationDate DESC";
    $query = mysqli_query($conn, $sql);
    if ($query) {
        while ($data = mysqli_fetch_assoc($query)) {
            $courseid = $data['_courseid'];
            $coursename = _getSingleCourse($courseid, '_coursename');
            $status = $data['_coursestatus'];
            ?>
    
            <form action="" method="post">
                <tr>
                    <td><?php echo date("M j, Y", strtotime($data['CreationDate'])); ?></td>
                    <td><?php echo $coursename ?></td>
                    <td>
                        <div>
                            <input type="hidden" name="courseid" value="<?php echo $courseid ?>">
                            <select onchange="this.form.submit()" name="status" class="form-control">
                                <?php if ($status == 'active') { ?>
                                    <option value="inactive">In-Active</option>
                                    <option value="active" selected>Active</option>
                                <?php } else { ?>
                                    <option value="inactive" selected>In-Active</option>
                                    <option value="active">Active</option>
                                <?php } ?>
                            </select>
                        </div>
                    </td>
                </tr>
            </form>
    
        <?php }
    }
}


function _updateCourseStatus($status, $courseid, $userid)
{

    require('_config.php');
    $sql = "UPDATE `tblpurchasedcourses` SET `_coursestatus`='$status' WHERE `_courseid`='$courseid' AND `_userid`='$userid' ";
    $query = mysqli_query($conn, $sql);
    if ($query) {
        2 + 2;
    }

}


// Membership


function _createMembership($membershipname, $img, $membershipdesc, $duration, $discount, $discounttype, $price, $isactive)
{
    require('_config.php');
    require('_alert.php');
    $memlink = strtolower(str_replace(array(' ', '.', '&'), '-', $membershipname));

    $stmt = $conn->prepare("INSERT INTO `tblmembership` (`_membershipname`, `_membershippermalink`, `_img`,`_membershipdesc`, `_price`, `_benefit`, `_benefittype`, `_duration`, `_status`) VALUES (?, ?, ?,?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssss", $membershipname, $memlink, $img, $membershipdesc, $price, $discount, $discounttype, $duration, $isactive);

    $stmt->execute();

    if ($stmt) {
        $_SESSION['membership_success'] = true;
        $alert = new PHPAlert();
        $alert->success("Membership Created");
    }

    $stmt->close();
    $conn->close();
}


function _getMembership()
{
    require('_config.php');

    $sql = "SELECT * FROM `tblmembership` ORDER BY CreationDate DESC";
    $query = mysqli_query($conn, $sql);
    if ($query) {
        foreach ($query as $data) { ?>
                  <tr>
                  <td>
                          <?php echo date("M j, Y", strtotime($data['CreationDate'])); ?>
                      </td>
                      <td><?php echo $data['_id']; ?></td>
                      <td><?php echo $data['_membershipname']; ?></td>
                      <td>
                          <div>
                              <?php

                              $status = $data['_status'];
                              if ($status == true) {
                                  ?>
                                      <input type="checkbox" disabled checked data-size="small"  class="switch-btn" data-color="#f56767">
                                 <?php
                              } else {
                                  ?>
                                      <input type="checkbox" disabled data-size="small"  class="switch-btn" data-color="#f56767">      
                                <?php
                              }
                              ?>
                          </div>
                      </td>
                      
                      <td>
                          <?php
                          if (strtotime($data['UpdationDate']) == '') {
                              echo "Not Updated Yet";
                          } else {
                              echo date("M j, Y", strtotime($data['UpdationDate']));
                          }
                          ?>
                      </td>
                     
                      <td>
                    <div class="dropdown">
                        <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                            <i class="dw dw-more"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                            <a href="edit-membership?id=<?php echo $data['_id'] ?>" class="dropdown-item"><i class="dw dw-edit2"></i>
                                Edit</a>
                            <a class="dropdown-item" href='manage-membership?id=<?php echo $data['_id'] ?>&del=true'><i class="dw dw-delete-3"></i>
                                Delete</a>
                        </div>
                    </div>
                </td>
                  </tr>
          <?php }
    }
}


function _getSingleMembership($id, $param)
{
    require('_config.php');
    $sql = "SELECT * FROM `tblmembership` WHERE `_id` = $id";
    $query = mysqli_query($conn, $sql);
    if ($query) {
        foreach ($query as $data) {
            return $data[$param];
        }
    }
}


function _updateMembership($_id, $membershipname, $img, $membershipdesc, $duration, $discount, $discounttype, $price, $isactive)
{

    require('_config.php');
    require('_alert.php');
    $stmt = $conn->prepare("UPDATE `tblmembership` SET `_membershipname`= ? , `_img`= ?, `_membershipdesc`= ? , `_duration`= ? , `_benefit`= ? , `_benefittype`= ? , `_price`= ? , `_status`= ? WHERE `_id`=? ");

    $stmt->bind_param("sssssssss", $membershipname, $img, $membershipdesc, $duration, $discount, $discounttype, $price, $isactive, $_id);
    $stmt->execute();

    if ($stmt) {
        $_SESSION['membership_success'] = true;
        $alert = new PHPAlert();
        $alert->success("Membership Updated");
    }

    $stmt->close();
    $conn->close();
}

function _deleteMembership($id)
{
    require('_config.php');
    require('_alert.php');

    $sql = "DELETE FROM `tblmembership` WHERE `_id` = '$id'";
    $query = mysqli_query($conn, $sql);
    if ($query) {
        $alert = new PHPAlert();
        $alert->error("Membership Deleted Permanently");
    }
}

function checkmembership($amount, $currency)
{
    require('_config.php');
    $useremail = $_SESSION['userEmailId'];
    $sql = "SELECT * FROM `tblusers` WHERE `_useremail` = '$useremail'";
    $query = mysqli_query($conn, $sql);
    foreach ($query as $data) {
        $membership = $data['_usermembership'];
    }
    if ($membership) {
        $sql = "SELECT * FROM `tblmembership` WHERE `_id` = $membership";
        $query = mysqli_query($conn, $sql);
        if ($query) {
            foreach ($query as $data) {
                $type = $data['_benefittype'];
                $benifit = $data['_benefit'];
            }
            if ($type == 'Variable') {
                $discount = ($benifit / 100) * $amount;
                return $discount;
            } else {
                return _conversion($benifit, $currency);
            }
        }
    } else {
        return false;
    }
}

function _purchasememebership($userid, $memberid)
{
    require('_config.php');
    $duration = _getSingleMembership($memberid, '_duration');
    date_default_timezone_set('Asia/Kolkata');
    $date = strtotime(date('Y-m-d H:i:s'));
    $today = date('Y-m-d H:i:s');
    $enddata = date("Y-m-d", strtotime("+$duration month", $date));
    $sql = "UPDATE `tblusers` SET `_usermembership`='$memberid',`_usermemstart`='$today',`_usermemsleft`='$enddata' WHERE `_id` = $userid";
    $query = mysqli_query($conn, $sql);
    if ($query) {
        $sql = "SELECT * FROM `tblemailtemplates`";
        $query = mysqli_query($conn, $sql);
        foreach ($query as $data) {
            $template = $data['_purchasetemplate'];
        }
        $variables = array();
        $variables['name'] = _getsingleuser($userid, '_username');
        $variables['price'] = _getSingleMembership($memberid, '_price');
        $variables['product'] = _getSingleMembership($memberid, '_membershipname');
        $variables['date'] = date('M j, Y');
        $variables['companyname'] = _siteconfig('_sitetitle');
        $variables['paymentid'] = $_SESSION['transid'];
        $sendmail = _usetemplate($template, $variables);
        $message = 'Thank you for your purchase with ' . _siteconfig('_sitetitle') . '. We have mailed your order details on ' . _getsingleuser($userid, '_useremail') . '';
        _notifyuser(_getsingleuser($userid, '_useremail'), _getsingleuser($userid, '_userphone'), $sendmail, $message, 'Purchase Completed');
    }
}

function _usetemplate($template, $data)
{
    foreach ($data as $key => $value) {
        $template = str_replace('{{ ' . $key . ' }}', $value, $template);
    }

    return $template;
}

?>