<?php

require("../includes/_config.php");
require('../includes/_functions.php');


if (isset($_POST['edit'])) {

    $lessonid = $_POST['lessonid'];

    ?>



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
                        <select name="lessontype" class="form-control"
                            onchange="setInputForLessonTypeUpdated(this.options[this.selectedIndex])">
                            <?php
                            $lessonType = _getSingleLesson($lessonid, '_lessontype');

                            if ($lessonType == 'live') {
                                ?>
                                <option selected value="live">Live</option>
                                <option value="recorded">Recorded</option>

                                <?php
                            } else {
                                ?>
                                <option value="live">Live</option>
                                <option selected value="recorded">Recorded</option>
                                <?php
                            }

                            ?>
                        </select>
                    </div>
                </div>


                <?php

                $lessonType = _getSingleLesson($lessonid, '_lessontype');

                if ($lessonType == 'live') {
                    ?>
                    <div class="col-6" id="lessonurlUpdated">
                        <div class="form-group">
                            <label>Lesson Url</label>
                            <input type="text" placeholder="Lesson Url" name="lessonurl"
                                value="<?php echo _getSingleLesson($lessonid, '_lessonurl') ?>" class="form-control" />
                        </div>
                    </div>
                    <div class="col-6" id="lessonFileUpdated" style="display: none;">
                        <div class="form-group">
                            <label>Upload Lesson</label>
                            <input type="file" name="lessonfile" id="lessonfile"
                                class="form-control-file form-control height-auto">
                            <a href="uploads/recordedlesson/<?php echo _getSingleLesson($lessonid, '_recordedfilename'); ?>"
                                target="_blank">Open Recorder Video &nbsp;<svg xmlns="http://www.w3.org/2000/svg"
                                    style="width: 15px;" viewBox="0 0 512 512">
                                    <!-- Font Awesome Pro 5.15.4 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) -->
                                    <path
                                        d="M326.612 185.391c59.747 59.809 58.927 155.698.36 214.59-.11.12-.24.25-.36.37l-67.2 67.2c-59.27 59.27-155.699 59.262-214.96 0-59.27-59.26-59.27-155.7 0-214.96l37.106-37.106c9.84-9.84 26.786-3.3 27.294 10.606.648 17.722 3.826 35.527 9.69 52.721 1.986 5.822.567 12.262-3.783 16.612l-13.087 13.087c-28.026 28.026-28.905 73.66-1.155 101.96 28.024 28.579 74.086 28.749 102.325.51l67.2-67.19c28.191-28.191 28.073-73.757 0-101.83-3.701-3.694-7.429-6.564-10.341-8.569a16.037 16.037 0 0 1-6.947-12.606c-.396-10.567 3.348-21.456 11.698-29.806l21.054-21.055c5.521-5.521 14.182-6.199 20.584-1.731a152.482 152.482 0 0 1 20.522 17.197zM467.547 44.449c-59.261-59.262-155.69-59.27-214.96 0l-67.2 67.2c-.12.12-.25.25-.36.37-58.566 58.892-59.387 154.781.36 214.59a152.454 152.454 0 0 0 20.521 17.196c6.402 4.468 15.064 3.789 20.584-1.731l21.054-21.055c8.35-8.35 12.094-19.239 11.698-29.806a16.037 16.037 0 0 0-6.947-12.606c-2.912-2.005-6.64-4.875-10.341-8.569-28.073-28.073-28.191-73.639 0-101.83l67.2-67.19c28.239-28.239 74.3-28.069 102.325.51 27.75 28.3 26.872 73.934-1.155 101.96l-13.087 13.087c-4.35 4.35-5.769 10.79-3.783 16.612 5.864 17.194 9.042 34.999 9.69 52.721.509 13.906 17.454 20.446 27.294 10.606l37.106-37.106c59.271-59.259 59.271-155.699.001-214.959z" />
                                </svg></a>
                        </div>
                    </div>
                    <?php
                } else {
                    ?>
                    <div class="col-6" id="lessonurlUpdated" style="display: none;">
                        <div class="form-group">
                            <label>Lesson Url</label>
                            <input type="text" placeholder="Lesson Url" name="lessonurl"
                                value="<?php echo _getSingleLesson($lessonid, '_lessonurl') ?>" class="form-control" />
                        </div>
                    </div>
                    <div class="col-6" id="lessonFileUpdated">
                        <div class="form-group">
                            <label>Upload Lesson</label>
                            <input type="file" name="lessonfile" id="lessonfile"
                                class="form-control-file form-control height-auto">
                            <a href="uploads/recordedlesson/<?php echo _getSingleLesson($lessonid, '_recordedfilename'); ?>"
                                target="_blank">Open Recorder Video &nbsp;<svg xmlns="http://www.w3.org/2000/svg"
                                    style="width: 15px;" viewBox="0 0 512 512">
                                    <!-- Font Awesome Pro 5.15.4 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) -->
                                    <path
                                        d="M326.612 185.391c59.747 59.809 58.927 155.698.36 214.59-.11.12-.24.25-.36.37l-67.2 67.2c-59.27 59.27-155.699 59.262-214.96 0-59.27-59.26-59.27-155.7 0-214.96l37.106-37.106c9.84-9.84 26.786-3.3 27.294 10.606.648 17.722 3.826 35.527 9.69 52.721 1.986 5.822.567 12.262-3.783 16.612l-13.087 13.087c-28.026 28.026-28.905 73.66-1.155 101.96 28.024 28.579 74.086 28.749 102.325.51l67.2-67.19c28.191-28.191 28.073-73.757 0-101.83-3.701-3.694-7.429-6.564-10.341-8.569a16.037 16.037 0 0 1-6.947-12.606c-.396-10.567 3.348-21.456 11.698-29.806l21.054-21.055c5.521-5.521 14.182-6.199 20.584-1.731a152.482 152.482 0 0 1 20.522 17.197zM467.547 44.449c-59.261-59.262-155.69-59.27-214.96 0l-67.2 67.2c-.12.12-.25.25-.36.37-58.566 58.892-59.387 154.781.36 214.59a152.454 152.454 0 0 0 20.521 17.196c6.402 4.468 15.064 3.789 20.584-1.731l21.054-21.055c8.35-8.35 12.094-19.239 11.698-29.806a16.037 16.037 0 0 0-6.947-12.606c-2.912-2.005-6.64-4.875-10.341-8.569-28.073-28.073-28.191-73.639 0-101.83l67.2-67.19c28.239-28.239 74.3-28.069 102.325.51 27.75 28.3 26.872 73.934-1.155 101.96l-13.087 13.087c-4.35 4.35-5.769 10.79-3.783 16.612 5.864 17.194 9.042 34.999 9.69 52.721.509 13.906 17.454 20.446 27.294 10.606l37.106-37.106c59.271-59.259 59.271-155.699.001-214.959z" />
                                </svg></a>
                        </div>
                    </div>
                    <?php
                }

                ?>




            </div>

            <?php
            if ($lessonType == 'live') {
                ?>

                <div class="row" id="datesUpdated">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Date</label>
                            <input class="form-control" name="lessondate"
                                value="<?php echo _getSingleLesson($lessonid, '_lessondate') ?>" type="date">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Time</label>
                            <input class="form-control " name="lessontime"
                                value="<?php echo _getSingleLesson($lessonid, '_lessontime') ?>" type="time">
                        </div>
                    </div>
                </div>
                <?php

            } else {
                ?>

                <div class="row" id="datesUpdated" style="display: none;">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Date</label>
                            <input class="form-control" name="lessondate"
                                value="<?php echo _getSingleLesson($lessonid, '_lessondate') ?>" type="date">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Time</label>
                            <input class="form-control" name="lessontime"
                                value="<?php echo _getSingleLesson($lessonid, '_lessontime') ?>" type="time">
                        </div>
                    </div>
                </div>
                <?php
            }

            ?>


            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label>Lesson Name</label>
                        <input type="text" placeholder="Lesson Name" name="lessonname"
                            value="<?php echo _getSingleLesson($lessonid, '_lessonname') ?>" class="form-control" />
                        <input type="text" name="lessonid" value="<?php echo $lessonid ?>" class="form-control"
                            style="display: none;" />
                    </div>

                </div>
            </div>

            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label>Availablity (In Days)</label>
                        <input type="text" placeholder="Availablity" name="availablity"
                            value="<?php echo _getSingleLesson($lessonid, '_availablity') ?>" class="form-control" />
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <?php

                        $status = _getSingleLesson($lessonid, '_status');
                        if ($status == true) {
                            ?>
                            <input type="checkbox" checked data-size="small" value="true" name="isactive" class="switch-btn"
                                data-color="#f56767">
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
                <div class="col">
                    <div class="form-group">
                        <label>Lesson Description</label>
                        <textarea name="lessondescription"
                            class="form-control"><?php echo _getSingleLesson($lessonid, '_lessondescription') ?></textarea>
                    </div>
                </div>
            </div>

        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" name="updatelesson" class="btn btn-primary">Update</button>
        </div>
    </form>


    <?php




}





?>