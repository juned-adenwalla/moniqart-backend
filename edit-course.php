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

if (isset($_SESSION['slide_success']) || !isset($_SESSION['slide_success'])) {
    $_SESSION['slide_success'] = false;
}
if (isset($_SESSION['slide_error']) || !isset($_SESSION['slide_error'])) {
    $_SESSION['slide_error'] = false;
}

if (isset($_SESSION['slide_update_success']) || !isset($_SESSION['slide_update_success'])) {
    $_SESSION['slide_update_success'] = false;
}
if (isset($_SESSION['slide_update_error']) || !isset($_SESSION['slide_update_error'])) {
    $_SESSION['slide_update_error'] = false;
}

if (isset($_SESSION['course_product_success']) || !isset($_SESSION['course_product_success'])) {
    $_SESSION['course_product_success'] = false;
}
if (isset($_SESSION['course_product_error']) || !isset($_SESSION['course_product_error'])) {
    $_SESSION['course_product_error'] = false;
}

if (isset($_SESSION['course_product_update_success']) || !isset($_SESSION['course_product_update_success'])) {
    $_SESSION['course_product_update_success'] = false;
}
if (isset($_SESSION['course_product_update_error']) || !isset($_SESSION['course_product_update_error'])) {
    $_SESSION['course_product_update_error'] = false;
}


$id = $_GET['id'];

require('includes/_functions.php');
require('includes/_config.php');


if (isset($_POST['submit'])) {

    $coursename = $_POST['coursename'];
    $detaileddescription = $_POST['detaileddescription'];
    $courseDesc = $_POST['courseDesc'];
    $whatlearn = $_POST['whatlearn'];
    $requirements = $_POST['requirements'];
    $eligibitycriteria = $_POST['eligibitycriteria'];
    $pricing = $_POST['pricing'];
    $teacheremailid = $_POST['teacheremailid'];
    $categoryid = $_POST['categoryId'];
    $subcategoryid = $_POST['subcategoryId'];

    $coursechannel = $_POST['coursechannel'];
    $coursetype = $_POST['coursetype'];
    $startdate = $_POST['startdate'];
    $enddate = $_POST['enddate'];
    $previewurl = $_POST['previewurl'];

    $discountprice = $_POST['discountprice'];

    if ($_FILES["thumbnail"]["name"] != '') {
        $thumbnail = $_FILES["thumbnail"]["name"];
        $extension = substr($thumbnail, strlen($thumbnail) - 4, strlen($thumbnail));
        $allowed_extensions = array(".jpg", ".jpeg", ".png", ".gif");
        if (!in_array($extension, $allowed_extensions)) {
            echo "<script>alert('Invalid format. Only jpg / jpeg/ png /gif format allowed');</script>";
        } else {
            $thumbnailimg = md5($thumbnail) . $extension;
            move_uploaded_file($_FILES["thumbnail"]["tmp_name"], "uploads/coursethumbnail/" . $thumbnailimg);
        }
    } else {
        $thumbnailimg = _getSingleCourse($id, '_thumbnail');
    }

    if ($_FILES["banner"]["name"] != '') {
        $banner = $_FILES["banner"]["name"];
        $extension = substr($banner, strlen($banner) - 4, strlen($banner));
        $allowed_extensions = array(".jpg", ".jpeg", ".png", ".gif");
        if (!in_array($extension, $allowed_extensions)) {
            echo "<script>alert('Invalid format. Only jpg / jpeg/ png /gif format allowed');</script>";
        } else {
            $bannerimg = md5($banner) . $extension;
            move_uploaded_file($_FILES["banner"]["tmp_name"], "uploads/coursebanner/" . $bannerimg);
        }
    } else {
        $bannerimg = _getSingleCourse($id, '_banner');
    }

    if (isset($_POST['isactive'])) {
        $isactive = 'true';
    }else{
        $isactive = 'false';
    }

    if (isset($_POST['enrollstatus'])) {
        $enrollstatus = 'true';
    }else{
        $enrollstatus = 'false';
    }

    _updateCourse($id, $coursename, $detaileddescription, $previewurl, $courseDesc, $whatlearn, $requirements, $eligibitycriteria, $enrollstatus, $thumbnailimg, $bannerimg, $pricing, $isactive, $teacheremailid, $categoryid, $subcategoryid, $coursechannel, $coursetype, $startdate, $enddate, $discountprice);
}


if (isset($_POST['addlesson'])) {

    $_courseid = $id;

    $_lessonname = $_POST['lessonname'];
    $_lessondescription = $_POST['lessonDescription'];
    $_availablity = $_POST['availablity'];

    $lessontype = $_POST['lessontype'];

    if (isset($_POST['isactive'])) {
        $isactive = $_POST['isactive'];
    } else {
        $isactive = false;
    }

    if ($_FILES["lessonfile"]["name"] != '') {
        $lessonfile = $_FILES["lessonfile"]["name"];
        $extension = substr($lessonfile, strlen($lessonfile) - 4, strlen($lessonfile));
        $allowed_extensions = array(".mp4", ".mkv", ".webm", ".avi");
        if (!in_array($extension, $allowed_extensions)) {
            echo "<script>alert('Invalid format. Only mp4 / mkv/ webm /avi format allowed');</script>";
        } else {
            $lessonurl = "No Url";
            $lessondate = "No Date";
            $lessontime = "No Time";
            $recorderfile = md5($lessonfile) . $extension;
            move_uploaded_file($_FILES["lessonfile"]["tmp_name"], "uploads/recordedlesson/" . $recorderfile);
        }
    } else {
        $recorderfile = "No File";
        $lessonurl = $_POST['lessonurl'];
        $lessondate = $_POST['lessondate'];
        $lessontime = $_POST['lessontime'];
    }

    _createLesson($_courseid, $_lessonname, $lessontype, $lessonurl, $lessondate, $lessontime, $recorderfile, $_lessondescription, $isactive, $_availablity);

}


if (isset($_GET['del'])) {
    $_id = $_GET['id'];
    $lessonid = $_GET['lessonid'];
    _deleteLesson($lessonid);
}


if (isset($_POST['updatelesson'])) {

    $_courseid = $id;
    $lessonid = $_POST['lessonid'];

    $_lessonname = $_POST['lessonname'];
    $_lessondescription = $_POST['lessondescription'];
    $_availablity = $_POST['availablity'];

    $lessontype = $_POST['lessontype'];



    if (isset($_POST['isactive'])) {
        $isactive = $_POST['isactive'];
    } else {
        $isactive = false;
    }

    if ($_FILES["lessonfile"]["name"] != '') {
        $lessonfile = $_FILES["lessonfile"]["name"];
        $extension = substr($lessonfile, strlen($lessonfile) - 4, strlen($lessonfile));
        $allowed_extensions = array(".mp4", ".mkv", ".webm", ".avi");
        if (!in_array($extension, $allowed_extensions)) {
            echo "<script>alert('Invalid format. Only mp4 / mkv/ webm /avi format allowed');</script>";
        } else {
            $lessonurl = null;
            $lessondate = null;
            $lessontime = null;
            $recorderfile = md5($lessonfile) . $extension;
            move_uploaded_file($_FILES["lessonfile"]["tmp_name"], "uploads/recordedlesson/" . $recorderfile);

        }
    } else {
        $recorderfile = _getSingleLesson($id, '_recordedfilename');
        $lessonurl = $_POST['lessonurl'];
        $lessondate = $_POST['lessondate'];
        $lessontime = $_POST['lessontime'];
    }


    _updateLesson($lessonid, $_courseid, $_lessonname, $lessontype, $lessonurl, $lessondate, $lessontime, $recorderfile, $_lessondescription, $isactive, $_availablity);


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

    <!-- Layout Sidebar -->

    <div class="main-container">



        <div class="pd-20 card-box mb-30">

            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <div class="title">
                        <h4>Update Course</h4>
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
            <div class="wizard-content">
                <form method="POST" enctype="multipart/form-data" action="#"
                    class="tab-wizard wizard-circle wizard vertical">
                    <h5>Basic Details</h5>

                    <section>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label>Course Name :</label>
                                    <input type="text" value="<?php echo _getSingleCourse($id, '_coursename') ?>"
                                        class="form-control" name="coursename">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <?php
                                    $categoryid = _getSingleCourse($id, '_categoryid');
                                    _showCategoryOptions($categoryid, "courses")
                                        ?>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label>Sub-Category</label>
                                    <?php
                                    $subcategoryid = _getSingleCourse($id, '_subcategoryid');
                                    _showSubCategoryOptions($subcategoryid)
                                        ?>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label>Course Description (2-3 lines):</label>
                                    <textarea name="courseDesc"
                                        class="form-control"><?php echo _getSingleCourse($id, '_coursedescription') ?></textarea>
                                </div>
                            </div>
                        </div>


                    </section>
                    <!-- Step 2 -->
                    <h5>Look</h5>
                    <section>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Banner</label>
                                    <input type="file" name="banner" id="banner"
                                        class="form-control-file form-control height-auto">
                                    <a href="uploads/coursebanner/<?php echo _getSingleCourse($id, '_banner'); ?>"
                                        target="_blank">Open Featured Image &nbsp;<svg
                                            xmlns="http://www.w3.org/2000/svg" style="width: 15px;"
                                            viewBox="0 0 512 512">
                                            <!-- Font Awesome Pro 5.15.4 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) -->
                                            <path
                                                d="M326.612 185.391c59.747 59.809 58.927 155.698.36 214.59-.11.12-.24.25-.36.37l-67.2 67.2c-59.27 59.27-155.699 59.262-214.96 0-59.27-59.26-59.27-155.7 0-214.96l37.106-37.106c9.84-9.84 26.786-3.3 27.294 10.606.648 17.722 3.826 35.527 9.69 52.721 1.986 5.822.567 12.262-3.783 16.612l-13.087 13.087c-28.026 28.026-28.905 73.66-1.155 101.96 28.024 28.579 74.086 28.749 102.325.51l67.2-67.19c28.191-28.191 28.073-73.757 0-101.83-3.701-3.694-7.429-6.564-10.341-8.569a16.037 16.037 0 0 1-6.947-12.606c-.396-10.567 3.348-21.456 11.698-29.806l21.054-21.055c5.521-5.521 14.182-6.199 20.584-1.731a152.482 152.482 0 0 1 20.522 17.197zM467.547 44.449c-59.261-59.262-155.69-59.27-214.96 0l-67.2 67.2c-.12.12-.25.25-.36.37-58.566 58.892-59.387 154.781.36 214.59a152.454 152.454 0 0 0 20.521 17.196c6.402 4.468 15.064 3.789 20.584-1.731l21.054-21.055c8.35-8.35 12.094-19.239 11.698-29.806a16.037 16.037 0 0 0-6.947-12.606c-2.912-2.005-6.64-4.875-10.341-8.569-28.073-28.073-28.191-73.639 0-101.83l67.2-67.19c28.239-28.239 74.3-28.069 102.325.51 27.75 28.3 26.872 73.934-1.155 101.96l-13.087 13.087c-4.35 4.35-5.769 10.79-3.783 16.612 5.864 17.194 9.042 34.999 9.69 52.721.509 13.906 17.454 20.446 27.294 10.606l37.106-37.106c59.271-59.259 59.271-155.699.001-214.959z" />
                                        </svg></a>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Thumbnail</label>
                                    <input type="file" name="thumbnail" id="thumbnail"
                                        class="form-control-file form-control height-auto">
                                    <a href="uploads/coursethumbnail/<?php echo _getSingleCourse($id, '_thumbnail'); ?>"
                                        target="_blank">Open Featured Image &nbsp;<svg
                                            xmlns="http://www.w3.org/2000/svg" style="width: 15px;"
                                            viewBox="0 0 512 512">
                                            <!-- Font Awesome Pro 5.15.4 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) -->
                                            <path
                                                d="M326.612 185.391c59.747 59.809 58.927 155.698.36 214.59-.11.12-.24.25-.36.37l-67.2 67.2c-59.27 59.27-155.699 59.262-214.96 0-59.27-59.26-59.27-155.7 0-214.96l37.106-37.106c9.84-9.84 26.786-3.3 27.294 10.606.648 17.722 3.826 35.527 9.69 52.721 1.986 5.822.567 12.262-3.783 16.612l-13.087 13.087c-28.026 28.026-28.905 73.66-1.155 101.96 28.024 28.579 74.086 28.749 102.325.51l67.2-67.19c28.191-28.191 28.073-73.757 0-101.83-3.701-3.694-7.429-6.564-10.341-8.569a16.037 16.037 0 0 1-6.947-12.606c-.396-10.567 3.348-21.456 11.698-29.806l21.054-21.055c5.521-5.521 14.182-6.199 20.584-1.731a152.482 152.482 0 0 1 20.522 17.197zM467.547 44.449c-59.261-59.262-155.69-59.27-214.96 0l-67.2 67.2c-.12.12-.25.25-.36.37-58.566 58.892-59.387 154.781.36 214.59a152.454 152.454 0 0 0 20.521 17.196c6.402 4.468 15.064 3.789 20.584-1.731l21.054-21.055c8.35-8.35 12.094-19.239 11.698-29.806a16.037 16.037 0 0 0-6.947-12.606c-2.912-2.005-6.64-4.875-10.341-8.569-28.073-28.073-28.191-73.639 0-101.83l67.2-67.19c28.239-28.239 74.3-28.069 102.325.51 27.75 28.3 26.872 73.934-1.155 101.96l-13.087 13.087c-4.35 4.35-5.769 10.79-3.783 16.612 5.864 17.194 9.042 34.999 9.69 52.721.509 13.906 17.454 20.446 27.294 10.606l37.106-37.106c59.271-59.259 59.271-155.699.001-214.959z" />
                                        </svg></a>
                                </div>
                            </div>
                        </div>
                        <div class="row my-2 ">
                            <div class="col-md-6">
                                <div class="custom-control custom-checkbox mb-5">

                                    <?php

                                    $status = _getSingleCourse($id, '_enrollstatus');
                                    if ($status == 'true') {
                                        ?>
                                        <input type="checkbox" checked class="custom-control-input" name="enrollstatus"
                                            id="isenroll">
                                        <label class="custom-control-label" for="isenroll">Enroll Status</label>
                                        <?php
                                    } else {
                                        ?>
                                        <input type="checkbox" class="custom-control-input" name="enrollstatus"
                                            id="isenroll">
                                        <label class="custom-control-label" for="isenroll">Enroll Status</label>
                                        <?php
                                    }
                                    ?>


                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="custom-control custom-checkbox mb-5">
                                    <?php

                                    $status = _getSingleCourse($id, '_status');
                                    if ($status == 'true') {
                                        ?>
                                        <input type="checkbox" value="true" checked class="custom-control-input" name="isactive"
                                            id="isactive">
                                        <label class="custom-control-label" for="isactive">is Active</label>
                                        <?php
                                    } else {
                                        ?>
                                        <input type="checkbox" value="true" class="custom-control-input" name="isactive"
                                            id="isactive">
                                        <label class="custom-control-label" for="isactive">is Active</label>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Start Date</label>
                                    <input class="form-control date-picker" placeholder="Select Date" name="startdate"
                                        value="<?php echo _getSingleCourse($id, '_startdate') ?>" type="text">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>End Date</label>
                                    <input class="form-control date-picker" placeholder="Select Date" name="enddate"
                                        value="<?php echo _getSingleCourse($id, '_enddate') ?>" type="text">
                                </div>
                            </div>
                        </div>
                    </section>
                    <!-- Step 3 -->
                    <h5>Interview</h5>
                    <section>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Teacher Mail Id</label>
                                    <select class="custom-select2 form-control" name="teacheremailid"
                                        style="width: 100%; height: 38px;">
                                        <?php
                                        $teacherid = _getSingleCourse($id, '_teacheremailid');
                                        _getTeachers($teacherid);
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Course Type</label>
                                    <select name="coursetype" class="form-control">
                                        <?php

                                        $level = _getSingleCourse($id, '_coursetype');

                                        if ($level == 'Beginner') {
                                            ?>
                                            <option selected value="Beginner">Beginner</option>
                                            <option value="Intermediate">Intermediate</option>
                                            <option value="Advanced">Advanced</option>
                                            <?php
                                        }
                                        if ($level == 'Intermediate') {
                                            ?>
                                            <option value="Beginner">Beginner</option>
                                            <option selected value="Intermediate">Intermediate</option>
                                            <option value="Advanced">Advanced</option>
                                            <?php
                                        }
                                        if ($level == 'Advanced') {
                                            ?>
                                            <option value="Beginner">Beginner</option>
                                            <option value="Intermediate">Intermediate</option>
                                            <option selected value="Advanced">Advanced</option>
                                            <?php
                                        }

                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label>Price </label>
                                    <input type="number" name="pricing"
                                        value="<?php echo _getSingleCourse($id, '_pricing') ?>" class="form-control">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label>Discount Price</label>
                                    <input type="number" name="discountprice"
                                        value="<?php echo _getSingleCourse($id, '_discountprice') ?>"
                                        class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label>Course Channel</label>
                                    <select name="coursechannel" class="form-control">
                                        <?php

                                        $coursechannel = _getSingleCourse($id, '_coursechannel');

                                        if ($coursechannel == "online") {
                                            ?>
                                            <option selected value="online">Online</option>
                                            <option value="offline">Offline</option>
                                            <?php
                                        } else {
                                            ?>
                                            <option value="online">Online</option>
                                            <option selected value="offline">Offline</option>
                                            <?php
                                        }

                                        ?>

                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label>Preview Url</label>
                                    <input type="text" name="previewurl"
                                        value="<?php echo _getSingleCourse($id, '_previewurl') ?>" class="form-control">
                                </div>
                            </div>
                        </div>
                    </section>
                    <!-- Step 4 -->
                    <h5>Remark</h5>
                    <section>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <h4 class="h4 text-dark">Detailed Description</h4>
                                    <textarea id="mytextarea" name="detaileddescription"
                                        class="form-control border-radius-0"
                                        placeholder="Enter text ..."><?php echo _getSingleCourse($id, '_detaileddescription') ?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <h4 class="h4 text-dark">What you will learn</h4>
                                    <textarea id="mytextarea" name="whatlearn" class="form-control border-radius-0"
                                        placeholder="Enter text ..."><?php echo _getSingleCourse($id, '_whatlearn') ?></textarea>
                                </div>
                            </div>
                        </div>
                    </section>
                    <!-- Step 5 -->
                    <h5>Last</h5>
                    <section>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <h4 class="h4 text-dark">Requirements</h4>
                                    <textarea id="mytextarea" name="requirements" class="form-control border-radius-0"
                                        placeholder="Enter text ..."><?php echo _getSingleCourse($id, '_requirements') ?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <h4 class="h4 text-dark">Eligibility Criteria</h4>
                                    <textarea id="mytextarea" name="eligibitycriteria"
                                        class="form-control border-radius-0"
                                        placeholder="Enter text ..."><?php echo _getSingleCourse($id, '_eligibilitycriteria') ?></textarea>
                                </div>
                            </div>
                        </div>
                    </section>

                    <div class="modal fade" id="success-modal" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-body text-center font-18">
                                    <h3 class="mb-20">Click to update course</h3>
                                    <div class="mb-30 text-center"><img src="vendors/images/success.png"></div>
                                </div>
                                <div class="modal-footer justify-content-center">
                                    <button type="submit" class="btn btn-primary" name="submit">Update
                                        Course</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>
            </div>

        </div>


        <div class="pd-20 card-box mb-30">
            <div class="min-height-200px">
                <div class="pd-20">
                    <h4 class="text-black h4">Manage Lesson Plans

                        <a href="#" class="btn btn-dark" style="float: right;" data-toggle="modal"
                            data-target="#Medium-modal" type="button">Add Lesson</a>
                    </h4>
                </div>
                <div class="pb-20">
                    <table class="data-table table stripe hover nowrap">
                        <thead>
                            <tr>
                                <th>Created At</th>
                                <th class="table-plus">Id</th>
                                <th>Lesson Name</th>
                                <th>Status</th>
                                <th>Lesson Type</th>
                                <th>Updated At</th>
                                <th class="datatable-nosort">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php _getLessons($id); ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>


    </div>
    </div>

    </div>

    <div class="modal fade" id="Medium-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form action="#" method="post" enctype="multipart/form-data" class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel">Add Lesson</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label>Lesson Type</label>
                                <select id="lessontype" name="lessontype" class="form-control"
                                    onchange="setInputForLessonType(this.options[this.selectedIndex])">
                                    <option selected disabled>Type</option>
                                    <option value="live">Live</option>
                                    <option value="recorded">Recorded</option>
                                </select>
                            </div>
                        </div>


                        <div class="col-6" id="lessonFile" style="display: none;">
                            <div class="form-group">
                                <label>Upload Lesson</label>
                                <input type="file" name="lessonfile" id="lessonfile"
                                    class="form-control-file form-control height-auto">
                            </div>
                        </div>

                        <div class="col-6" id="lessonurl" style="display: none;">
                            <div class="form-group">
                                <label>Lesson Url</label>
                                <input type="text" placeholder="Lesson Url" name="lessonurl" class="form-control" />
                            </div>
                        </div>

                    </div>

                    <div class="row" id="dates" style="display: none;">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Date</label>
                                <input class="form-control" name="lessondate" type="date">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Time</label>
                                <input class="form-control" name="lessontime" type="time">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label>Lesson Name</label>
                                <input type="text" placeholder="Lesson Name" name="lessonname" class="form-control" />
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label>Availablity (In Days)</label>
                                <input type="text" placeholder="Availablity" name="availablity" class="form-control" />
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <input type="checkbox" data-size="small" value="true" name="isactive" class="switch-btn"
                                    data-color="#f56767">
                                <label>is Active</label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label>Lesson Description</label>
                                <textarea name="lessonDescription" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" name="addlesson" class="btn btn-primary">Add</button>
                </div>
            </form>
        </div>
    </div>


    <div class="modal fade" id="editLesson" tabindex="-1" role="dialog" aria-labelledby="editLessonBody"
        aria-hidden="true">
        <div id="editLessonBody" class="modal-dialog modal-dialog-centered">

        </div>
    </div>




    <script>


        const getSingleLesson = (lessonid) => {

            $.ajax({
                type: "POST",
                url: `utils/editlesson.php`,
                data: {
                    "edit": true,
                    "lessonid": lessonid
                },
                success: function (data) {
                    $(`#editLessonBody`).html(data);
                    $(`#editLesson`).modal("show");
                }
            });

        }
    </script>


    <script>


        let lessontype = document.getElementById('lessontype');

        let lessonFile = document.getElementById('lessonFile');
        let lessonurl = document.getElementById('lessonurl');
        let dates = document.getElementById('dates');


        const setInputForLessonType = (value) => {


            let input = value.value;

            if (input == 'live') {
                lessonurl.style.display = "block"
                dates.style.display = "flex"
                lessonFile.style.display = "none"
            }
            else {
                lessonFile.style.display = "block"
                lessonurl.style.display = "none"
                dates.style.display = "none"
            }
        }




        const setInputForLessonTypeUpdated = (value) => {

            let lessonFileUpdated = document.getElementById('lessonFileUpdated');
            let lessonurlUpdated = document.getElementById('lessonurlUpdated');
            let datesUpdated = document.getElementById('datesUpdated');


            let input = value.value;

            if (input == 'live') {
                lessonurlUpdated.style.display = "block"
                datesUpdated.style.display = "flex"
                lessonFileUpdated.style.display = "none"
            }
            else {
                lessonFileUpdated.style.display = "block"
                lessonurlUpdated.style.display = "none"
                datesUpdated.style.display = "none"
            }
        }

    </script>

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