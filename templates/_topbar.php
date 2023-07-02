<?php

$userid = $_SESSION['userId'];
$username = _getsingleuser($userid, '_username');
$userdp = _getsingleuser($userid, '_userdp');

?>
<div class="header">
    <div class="header-left">
        <div class="menu-icon dw dw-menu"></div>
    </div>
    <div class="header-right">
        <div class="dashboard-setting user-notification">
            <div class="dropdown">
                <a class="dropdown-toggle no-arrow" href="javascript:;" data-toggle="right-sidebar">
                    <i class="dw dw-settings2"></i>
                </a>
            </div>
        </div>

        <div class="user-info-dropdown">
            <div class="dropdown">
                <a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                    <span class="user-icon">
                        <img src="uploads/profile/<?php echo $userdp ?>"
                            style="width: 52px; height: 52px; border-radius: 50%; object-fit: cover;" alt="">
                    </span>
                    <span class="user-name">
                        <?php echo $username ?>
                    </span>
                </a>
                <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                    <a class="dropdown-item" href="user-profile"><i class="dw dw-user1"></i> Profile</a>
                    <!-- <a class="dropdown-item" href="faq.html"><i class="dw dw-help"></i> Help</a> -->
                    <a class="dropdown-item" href="logout"><i class="dw dw-logout"></i> Log Out</a>
                </div>
            </div>
        </div>
    </div>
</div>