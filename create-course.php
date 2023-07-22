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
if (isset($_SESSION['course_success']) || !isset($_SESSION['course_success'])) {
    $_SESSION['course_success'] = false;
}
if (isset($_SESSION['course_error']) || !isset($_SESSION['course_error'])) {
    $_SESSION['course_error'] = false;
}


require('includes/_functions.php');

if (isset($_POST['submit'])) {

    $coursename = $_POST['coursename'];

    $categoryid = $_POST['categoryId'];
    $subcategoryid = $_POST['subcategoryId'];

    $courseDesc = $_POST['courseDesc'];

    if ($_FILES["thumbnail"]["name"] != '') {
        $thumbnail = $_FILES["thumbnail"]["name"];
        $extension = substr($thumbnail, strlen($thumbnail) - 4, strlen($thumbnail));
        $allowed_extensions = array(".jpg", ".jpeg", ".png", ".gif", ".webp", ".svg");
        if (!in_array($extension, $allowed_extensions)) {
            echo "<script>alert('Invalid format. Only jpg / jpeg/ png /gif / Webp/ Svg format allowed for Thumbnail');</script>";
            echo "<script>windows.reload()<script>";
        } else {
            $thumbnailimg = md5($thumbnail) . $extension;
            move_uploaded_file($_FILES["thumbnail"]["tmp_name"], "uploads/coursethumbnail/" . $thumbnailimg);
        }
    }

    if ($_FILES["banner"]["name"] != '') {
        $banner = $_FILES["banner"]["name"];
        $extension = substr($banner, strlen($banner) - 4, strlen($banner));
        $allowed_extensions = array(".jpg", ".jpeg", ".png", ".gif", ".webp", ".svg");
        if (!in_array($extension, $allowed_extensions)) {
            echo "<script>alert('Invalid format. Only jpg / jpeg/ png /gif / Webp/ Svg format allowed for Banner');</script>";
            echo "<script>windows.reload()<script>";
        } else {
            $bannerimg = md5($banner) . $extension;
            move_uploaded_file($_FILES["banner"]["tmp_name"], "uploads/coursebanner/" . $bannerimg);
        }
    }


    if (isset($_POST['isactive'])) {
        $isactive = 'true';
    } else {
        $isactive = 'false';
    }

    if (isset($_POST['enrollstatus'])) {
        $enrollstatus = 'true';
    } else {
        $enrollstatus = 'false';
    }

    $startdate = $_POST['startdate'];
    $enddate = $_POST['enddate'];

    $teacheremailid = $_POST['teacheremailid'];
    $coursetype = $_POST['coursetype'];
    $pricing = $_POST['pricing'];
    $discountprice = $_POST['discountprice'];

    $coursechannel = $_POST['coursechannel'];
    $previewurl = $_POST['previewurl'];


    $detaileddescription = $_POST['detaileddescription'];
    $whatlearn = $_POST['whatlearn'];
    $requirements = $_POST['requirements'];
    $eligibitycriteria = $_POST['eligibitycriteria'];






    _createCourse($coursename, $previewurl, $courseDesc, $detaileddescription, $whatlearn, $requirements, $eligibitycriteria, $enrollstatus, $thumbnailimg, $bannerimg, $pricing, $isactive, $teacheremailid, $categoryid, $subcategoryid, $coursetype, $coursechannel, $startdate, $enddate, $discountprice);
}

?>

<!DOCTYPE html>
<html>

<head>
    <!-- Basic Page Info -->
    <meta charset="utf-8">
    <title>Dashboard</title>


    <?php require("templates/_css_link.php") ?>
    <link rel="stylesheet" type="text/css" href="src/plugins/jquery-steps/jquery.steps.css">

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
                        <h4>Create Course</h4>
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

            <div class="wizard-content">
                <form method="POST" enctype="multipart/form-data" action="#"
                    class="tab-wizard wizard-circle wizard vertical">
                    <h5>Basic Details</h5>

                    <section>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label>Course Name :</label>
                                    <input type="text" class="form-control" name="coursename">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <?php _showCategoryOptions("", "courses") ?>

                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <?php _showSubCategoryOptions() ?>

                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label>Course Description (2-3 lines):</label>
                                    <textarea name="courseDesc" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>


                    </section>
                    <!-- Step 2 -->
                    <h5>Files and Dates</h5>
                    <section>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Banner</label>
                                    <input type="file" name="banner" id="banner"
                                        class="form-control-file form-control height-auto">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Thumbnail</label>
                                    <input type="file" name="thumbnail" id="thumbnail"
                                        class="form-control-file form-control height-auto">
                                </div>
                            </div>
                        </div>
                        <div class="row my-2 ">
                            <div class="col-md-6">
                                <div class="custom-control custom-checkbox mb-5">
                                    <input type="checkbox" class="custom-control-input" name="enrollstatus"
                                        id="isenroll">
                                    <label class="custom-control-label" for="isenroll">Enroll Status</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="custom-control custom-checkbox mb-5">
                                    <input type="checkbox" class="custom-control-input" name="isactive" id="isactive">
                                    <label class="custom-control-label" for="isactive">Is Active</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Start Date</label>
                                    <input class="form-control date-picker" placeholder="Select Date" name="startdate"
                                        type="date">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>End Date</label>
                                    <input class="form-control date-picker" placeholder="Select Date" name="enddate"
                                        type="date">
                                </div>
                            </div>
                        </div>
                    </section>
                    <!-- Step 3 -->
                    <h5>Pricing</h5>
                    <section>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Teacher Mail Id</label>
                                    <select class="custom-select2 form-control" name="teacheremailid"
                                        style="width: 100%; height: 38px;">
                                        <option>Select Teacher</option>
                                        <?php _getTeachers() ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Course Type</label>
                                    <select name="coursetype" class="form-control">
                                        <option>Select</option>
                                        <option value="Beginner">Beginner</option>
                                        <option value="Intermediate">Intermediate</option>
                                        <option value="Advanced">Advanced</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label>Price </label>
                                    <input type="number" name="pricing" class="form-control">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label>Discount Price</label>
                                    <input type="number" name="discountprice" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label>Course Channel</label>
                                    <select name="coursechannel" class="form-control">
                                        <option>Select</option>
                                        <option value="online">Online</option>
                                        <option value="offline">Offline</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label>Preview Url</label>
                                    <input type="text" name="previewurl" class="form-control">
                                </div>
                            </div>
                        </div>
                    </section>
                    <!-- Step 4 -->
                    <h5>Descriptions</h5>
                    <section>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <h4 class="h4 text-dark">Detailed Description</h4>
                                    <textarea id="mytextarea" name="detaileddescription"
                                        class="form-control border-radius-0" placeholder="Enter text ..."></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <h4 class="h4 text-dark">What you will learn</h4>
                                    <textarea id="mytextarea" name="whatlearn" class="form-control border-radius-0"
                                        placeholder="Enter text ..."></textarea>
                                </div>
                            </div>
                        </div>
                    </section>
                    <!-- Step 5 -->
                    <h5>Requirements</h5>
                    <section>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <h4 class="h4 text-dark">Requirements</h4>
                                    <textarea id="mytextarea" name="requirements" class="form-control border-radius-0"
                                        placeholder="Enter text ..."></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <h4 class="h4 text-dark">Eligibility Criteria</h4>
                                    <textarea id="mytextarea" name="eligibitycriteria"
                                        class="form-control border-radius-0" placeholder="Enter text ..."></textarea>
                                </div>
                            </div>
                        </div>
                    </section>

                    <div class="modal fade" id="success-modal" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-body text-center font-18">
                                    <h3 class="mb-20">Click to create course</h3>
                                    <div class="mb-30 text-center"><img src="vendors/images/success.png"></div>
                                </div>
                                <div class="modal-footer justify-content-center">
                                    <button type="submit" class="btn btn-primary" name="submit">Create
                                        Course</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>
            </div>

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
    <!-- Wizard -->
    <script src="src/plugins/jquery-steps/jquery.steps.js"></script>
    <script src="vendors/scripts/steps-setting.js"></script>


</body>

</html>