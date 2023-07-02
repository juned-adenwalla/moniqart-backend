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

if (isset($_SESSION['blog_success']) || !isset($_SESSION['blog_success'])) {
    $_SESSION['blog_success'] = false;
}

if (isset($_SESSION['blog_error']) || !isset($_SESSION['blog_error'])) {
    $_SESSION['blog_error'] = false;
}

require('includes/_functions.php');

$_id = $_SESSION['userId'];
$name = _getsingleuser($_id, '_username');
$email = _getsingleuser($_id, '_useremail');
$phone = _getsingleuser($_id, '_userphone');
$country = _getsingleuser($_id, '_userstate');
$address = _getsingleuser($_id, '_userlocation');

$membership = _getsingleuser($_id, '_usermembership');
if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $useremail = $_POST['useremail'];
    $userphone = $_POST['userphone'];
    $userpassword = $_POST['userpassword'];
    $userage = $_POST['userage'];
    $userbio = $_POST['userbio'];
    $location = $_POST['location'];
    $pincode = $_POST['pincode'];
    $usercountry = $_POST['usercountry'];
    $usercurrency = $_POST['usercurrency'];
    _updateProfile($username, $useremail, $userpassword, $userphone, $userage, $userbio, $location, $pincode, $usercountry, $usercurrency);
}

if (isset($_POST['update'])) {
    if ($_FILES["userdp"]["name"] != '') {
        $file = $_FILES["userdp"]["name"];
        $extension = substr($file, strlen($file) - 4, strlen($file));
        $allowed_extensions = array(".jpg", ".jpeg", ".png", ".gif");
        // Validation for allowed extensions .in_array() function searches an array for a specific value.
        if (!in_array($extension, $allowed_extensions)) {
            echo "<script>alert('Invalid format. Only jpg / jpeg/ png /gif format allowed');</script>";
        } else {
            $newfile = md5($file) . $extension;
            move_uploaded_file($_FILES["userdp"]["tmp_name"], "uploads/profile/" . $newfile);
            _updatedb($newfile);
        }
    }
}

?>


<!DOCTYPE html>
<html>

<head>
    <!-- Basic Page Info -->
    <meta charset="utf-8">
    <title>Dashboard</title>


    <?php require("templates/_css_link.php") ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.5.1/tinymce.min.js" integrity="sha512-UhysBLt7bspJ0yBkIxTrdubkLVd4qqE4Ek7k22ijq/ZAYe0aadTVXZzFSIwgC9VYnJabw7kg9UMBsiLC77LXyw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
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

        <div class="pd-ltr-20 xs-pd-20-10">
            <div class="min-height-200px">
                <div class="page-header">
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="title">
                                <h4>Profile</h4>
                            </div>
                            <nav aria-label="breadcrumb" role="navigation">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Profile</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-30">
                        <div class="pd-20 card-box height-100-p">
                            <div class="profile-photo">
                                <a href="modal" data-toggle="modal" data-target="#modal" class="edit-avatar"><i class="dw dw-pencil"></i></a>
                                <img src="uploads/profile/<?php echo _getsingleuser($_id, '_userdp') ?>" alt="" style="width: 150px;height:150px;object-fit:cover;" class="avatar-photo">
                                <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <form method="post" action="#" enctype="multipart/form-data" class="modal-content">
                                            <div class="modal-body pd-5">
                                                <div class="row">
                                                    <div class="col">
                                                        <label>Upload</label>
                                                        <input type="file" oncha name="userdp" type="file" id="userdp" class="form-control-file form-control height-auto">
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="modal-footer">
                                                <input type="submit" value="Update" name="update" class="btn btn-primary">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <h5 class="text-center h5 mb-0">
                                <?php echo $name ?>
                            </h5>
                            <div class="profile-info">
                                <h5 class="mb-20 h5 text-blue">Contact Information</h5>
                                <ul>
                                    <li>
                                        <span>Email Address:</span>
                                        <?php echo $email ?>
                                    </li>
                                    <li>
                                        <span>Phone Number:</span>
                                        <?php echo $phone ?>
                                    </li>
                                    <li>
                                        <span>Country:</span>
                                        <?php echo $country ?>
                                    </li>
                                    <li>
                                        <span>Address:</span>
                                        <?php echo $address ?>
                                    </li>
                                </ul>
                            </div>

                        </div>
                    </div>
                    <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 mb-30">
                        <div class="card-box height-100-p overflow-hidden">
                            <div class="profile-tab height-100-p">
                                <div class="tab height-100-p">
                                    <ul class="nav nav-tabs customtab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-toggle="tab" href="#setting" role="tab">Settings</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content">

                                        <!-- Setting Tab start -->
                                        <div class="tab-pane fade height-100-p show active" id="setting" role="tabpanel">
                                            <div class="profile-setting">
                                                <form action="#" method="post">
                                                    <ul class="profile-edit-list row">
                                                        <li class="weight-500 col">
                                                            <h4 class="text-blue h5 mb-20">Edit Your Personal Setting
                                                            </h4>
                                                            <div class="row">
                                                                <div class="col">
                                                                    <div class="form-group">
                                                                        <label>Full Name</label>
                                                                        <input class="form-control form-control-lg" value="<?php echo $name ?>" name="username" type="text">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col">
                                                                    <div class="form-group">
                                                                        <label>Phone Number</label>
                                                                        <input class="form-control form-control-lg" value="<?php echo $phone ?>" name="userphone" type="text">
                                                                    </div>
                                                                </div>

                                                                <div class="col">
                                                                    <div class="form-group">
                                                                        <label>Date of birth</label>
                                                                        <input class="form-control form-control-lg date-picker" value="<?php echo _getsingleuser($_id, '_userage') ?>" name="userage" type="text">
                                                                    </div>
                                                                </div>
                                                                <div class="col">
                                                                    <div class="form-group">
                                                                        <label>User Currency</label>
                                                                        <select class="custom-select2  form-control" data-style="btn-outline-secondary btn-lg" title="Not Chosen" name="usercurrency">
                                                                            <option value="<?php echo _getsingleuser($_id, '_usercurrency'); ?>">
                                                                                <?php echo _getsingleuser($_id, '_usercurrency'); ?>
                                                                            </option>
                                                                            <option value="USD">America (United States) Dollars – USD
                                                                            </option>
                                                                            <option value="AFN">Afghanistan Afghanis – AFN</option>
                                                                            <option value="ALL">Albania Leke – ALL</option>
                                                                            <option value="DZD">Algeria Dinars – DZD</option>
                                                                            <option value="ARS">Argentina Pesos – ARS</option>
                                                                            <option value="AUD">Australia Dollars – AUD</option>
                                                                            <option value="ATS">Austria Schillings – ATS</OPTION>

                                                                            <option value="BSD">Bahamas Dollars – BSD</option>
                                                                            <option value="BHD">Bahrain Dinars – BHD</option>
                                                                            <option value="BDT">Bangladesh Taka – BDT</option>
                                                                            <option value="BBD">Barbados Dollars – BBD</option>
                                                                            <option value="BEF">Belgium Francs – BEF</OPTION>
                                                                            <option value="BMD">Bermuda Dollars – BMD</option>

                                                                            <option value="BRL">Brazil Reais – BRL</option>
                                                                            <option value="BGN">Bulgaria Leva – BGN</option>
                                                                            <option value="CAD">Canada Dollars – CAD</option>
                                                                            <option value="XOF">CFA BCEAO Francs – XOF</option>
                                                                            <option value="XAF">CFA BEAC Francs – XAF</option>
                                                                            <option value="CLP">Chile Pesos – CLP</option>

                                                                            <option value="CNY">China Yuan Renminbi – CNY</option>
                                                                            <option value="CNY">RMB (China Yuan Renminbi) – CNY</option>
                                                                            <option value="COP">Colombia Pesos – COP</option>
                                                                            <option value="XPF">CFP Francs – XPF</option>
                                                                            <option value="CRC">Costa Rica Colones – CRC</option>
                                                                            <option value="HRK">Croatia Kuna – HRK</option>

                                                                            <option value="CYP">Cyprus Pounds – CYP</option>
                                                                            <option value="CZK">Czech Republic Koruny – CZK</option>
                                                                            <option value="DKK">Denmark Kroner – DKK</option>
                                                                            <option value="DEM">Deutsche (Germany) Marks – DEM</OPTION>
                                                                            <option value="DOP">Dominican Republic Pesos – DOP</option>
                                                                            <option value="NLG">Dutch (Netherlands) Guilders – NLG
                                                                            </OPTION>

                                                                            <option value="XCD">Eastern Caribbean Dollars – XCD</option>
                                                                            <option value="EGP">Egypt Pounds – EGP</option>
                                                                            <option value="EEK">Estonia Krooni – EEK</option>
                                                                            <option value="EUR">Euro – EUR</option>
                                                                            <option value="FJD">Fiji Dollars – FJD</option>
                                                                            <option value="FIM">Finland Markkaa – FIM</OPTION>

                                                                            <option value="FRF*">France Francs – FRF*</OPTION>
                                                                            <option value="DEM">Germany Deutsche Marks – DEM</OPTION>
                                                                            <option value="XAU">Gold Ounces – XAU</option>
                                                                            <option value="GRD">Greece Drachmae – GRD</OPTION>
                                                                            <option value="GTQ">Guatemalan Quetzal – GTQ</OPTION>
                                                                            <option value="NLG">Holland (Netherlands) Guilders – NLG
                                                                            </OPTION>
                                                                            <option value="HKD">Hong Kong Dollars – HKD</option>

                                                                            <option value="HUF">Hungary Forint – HUF</option>
                                                                            <option value="ISK">Iceland Kronur – ISK</option>
                                                                            <option value="XDR">IMF Special Drawing Right – XDR</option>
                                                                            <option value="INR">India Rupees – INR</option>
                                                                            <option value="IDR">Indonesia Rupiahs – IDR</option>
                                                                            <option value="IRR">Iran Rials – IRR</option>

                                                                            <option value="IQD">Iraq Dinars – IQD</option>
                                                                            <option value="IEP*">Ireland Pounds – IEP*</OPTION>
                                                                            <option value="ILS">Israel New Shekels – ILS</option>
                                                                            <option value="ITL*">Italy Lire – ITL*</OPTION>
                                                                            <option value="JMD">Jamaica Dollars – JMD</option>
                                                                            <option value="JPY">Japan Yen – JPY</option>

                                                                            <option value="JOD">Jordan Dinars – JOD</option>
                                                                            <option value="KES">Kenya Shillings – KES</option>
                                                                            <option value="KRW">Korea (South) Won – KRW</option>
                                                                            <option value="KWD">Kuwait Dinars – KWD</option>
                                                                            <option value="LBP">Lebanon Pounds – LBP</option>
                                                                            <option value="LUF">Luxembourg Francs – LUF</OPTION>

                                                                            <option value="MYR">Malaysia Ringgits – MYR</option>
                                                                            <option value="MTL">Malta Liri – MTL</option>
                                                                            <option value="MUR">Mauritius Rupees – MUR</option>
                                                                            <option value="MXN">Mexico Pesos – MXN</option>
                                                                            <option value="MAD">Morocco Dirhams – MAD</option>
                                                                            <option value="NLG">Netherlands Guilders – NLG</OPTION>

                                                                            <option value="NZD">New Zealand Dollars – NZD</option>
                                                                            <option value="NOK">Norway Kroner – NOK</option>
                                                                            <option value="OMR">Oman Rials – OMR</option>
                                                                            <option value="PKR">Pakistan Rupees – PKR</option>
                                                                            <option value="XPD">Palladium Ounces – XPD</option>
                                                                            <option value="PEN">Peru Nuevos Soles – PEN</option>

                                                                            <option value="PHP">Philippines Pesos – PHP</option>
                                                                            <option value="XPT">Platinum Ounces – XPT</option>
                                                                            <option value="PLN">Poland Zlotych – PLN</option>
                                                                            <option value="PTE">Portugal Escudos – PTE</OPTION>
                                                                            <option value="QAR">Qatar Riyals – QAR</option>
                                                                            <option value="RON">Romania New Lei – RON</option>

                                                                            <option value="ROL">Romania Lei – ROL</option>
                                                                            <option value="RUB">Russia Rubles – RUB</option>
                                                                            <option value="SAR">Saudi Arabia Riyals – SAR</option>
                                                                            <option value="XAG">Silver Ounces – XAG</option>
                                                                            <option value="SGD">Singapore Dollars – SGD</option>
                                                                            <option value="SKK">Slovakia Koruny – SKK</option>

                                                                            <option value="SIT">Slovenia Tolars – SIT</option>
                                                                            <option value="ZAR">South Africa Rand – ZAR</option>
                                                                            <option value="KRW">South Korea Won – KRW</option>
                                                                            <option value="ESP">Spain Pesetas – ESP</OPTION>
                                                                            <option value="XDR">Special Drawing Rights (IMF) – XDR
                                                                            </option>
                                                                            <option value="LKR">Sri Lanka Rupees – LKR</option>

                                                                            <option value="SDD">Sudan Dinars – SDD</option>
                                                                            <option value="SEK">Sweden Kronor – SEK</option>
                                                                            <option value="CHF">Switzerland Francs – CHF</option>
                                                                            <option value="TWD">Taiwan New Dollars – TWD</option>
                                                                            <option value="THB">Thailand Baht – THB</option>
                                                                            <option value="TTD">Trinidad and Tobago Dollars – TTD
                                                                            </option>

                                                                            <option value="TND">Tunisia Dinars – TND</option>
                                                                            <option value="TRY">Turkey New Lira – TRY</option>
                                                                            <option value="AED">United Arab Emirates Dirhams – AED
                                                                            </option>
                                                                            <option value="GBP">United Kingdom Pounds – GBP</option>
                                                                            <option value="USD">United States Dollars – USD</option>
                                                                            <option value="VEB">Venezuela Bolivares – VEB</option>

                                                                            <option value="VND">Vietnam Dong – VND</option>
                                                                            <option value="ZMK">Zambia Kwacha – ZMK</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col">
                                                                    <div class="form-group">
                                                                        <label>Email</label>
                                                                        <input class="form-control form-control-lg" value="<?php echo $email ?>" name="useremail" type="email">
                                                                    </div>
                                                                </div>
                                                                <div class="col">
                                                                    <div class="form-group">
                                                                        <label>Password</label>
                                                                        <input class="form-control form-control-lg" name="userpassword" value="<?php echo _getsingleuser($_id, '_userpassword') ?>" type="password">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col">
                                                                    <div class="form-group">
                                                                        <label>Country</label>
                                                                        <select class="custom-select2  form-control" data-style="btn-outline-secondary btn-lg" title="Not Chosen" name="usercountry">
                                                                            <option disabled value="">Choose Country</option>
                                                                            <option value="<?php echo _getsingleuser($_id, '_userstate'); ?>">
                                                                                <?php echo _getsingleuser($_id, '_userstate'); ?>
                                                                            </option>
                                                                            <option value="Afghanistan">Afghanistan</option>
                                                                            <option value="Åland Islands">Åland Islands</option>
                                                                            <option value="Albania">Albania</option>
                                                                            <option value="Algeria">Algeria</option>
                                                                            <option value="American Samoa">American Samoa</option>
                                                                            <option value="Andorra">Andorra</option>
                                                                            <option value="Angola">Angola</option>
                                                                            <option value="Anguilla">Anguilla</option>
                                                                            <option value="Antarctica">Antarctica</option>
                                                                            <option value="Antigua and Barbuda">Antigua and Barbuda
                                                                            </option>
                                                                            <option value="Argentina">Argentina</option>
                                                                            <option value="Armenia">Armenia</option>
                                                                            <option value="Aruba">Aruba</option>
                                                                            <option value="Australia">Australia</option>
                                                                            <option value="Austria">Austria</option>
                                                                            <option value="Azerbaijan">Azerbaijan</option>
                                                                            <option value="Bahamas">Bahamas</option>
                                                                            <option value="Bahrain">Bahrain</option>
                                                                            <option value="Bangladesh">Bangladesh</option>
                                                                            <option value="Barbados">Barbados</option>
                                                                            <option value="Belarus">Belarus</option>
                                                                            <option value="Belgium">Belgium</option>
                                                                            <option value="Belize">Belize</option>
                                                                            <option value="Benin">Benin</option>
                                                                            <option value="Bermuda">Bermuda</option>
                                                                            <option value="Bhutan">Bhutan</option>
                                                                            <option value="Bolivia">Bolivia</option>
                                                                            <option value="Bosnia and Herzegovina">Bosnia and
                                                                                Herzegovina</option>
                                                                            <option value="Botswana">Botswana</option>
                                                                            <option value="Bouvet Island">Bouvet Island</option>
                                                                            <option value="Brazil">Brazil</option>
                                                                            <option value="British Indian Ocean Territory">British
                                                                                Indian Ocean Territory</option>
                                                                            <option value="Brunei Darussalam">Brunei Darussalam
                                                                            </option>
                                                                            <option value="Bulgaria">Bulgaria</option>
                                                                            <option value="Burkina Faso">Burkina Faso</option>
                                                                            <option value="Burundi">Burundi</option>
                                                                            <option value="Cambodia">Cambodia</option>
                                                                            <option value="Cameroon">Cameroon</option>
                                                                            <option value="Canada">Canada</option>
                                                                            <option value="Cape Verde">Cape Verde</option>
                                                                            <option value="Cayman Islands">Cayman Islands</option>
                                                                            <option value="Central African Republic">Central African
                                                                                Republic</option>
                                                                            <option value="Chad">Chad</option>
                                                                            <option value="Chile">Chile</option>
                                                                            <option value="China">China</option>
                                                                            <option value="Christmas Island">Christmas Island
                                                                            </option>
                                                                            <option value="Cocos (Keeling) Islands">Cocos (Keeling)
                                                                                Islands</option>
                                                                            <option value="Colombia">Colombia</option>
                                                                            <option value="Comoros">Comoros</option>
                                                                            <option value="Congo">Congo</option>
                                                                            <option value="Congo, The Democratic Republic of The">
                                                                                Congo, The Democratic Republic of The</option>
                                                                            <option value="Cook Islands">Cook Islands</option>
                                                                            <option value="Costa Rica">Costa Rica</option>
                                                                            <option value="Cote D'ivoire">Cote D'ivoire</option>
                                                                            <option value="Croatia">Croatia</option>
                                                                            <option value="Cuba">Cuba</option>
                                                                            <option value="Cyprus">Cyprus</option>
                                                                            <option value="Czech Republic">Czech Republic</option>
                                                                            <option value="Denmark">Denmark</option>
                                                                            <option value="Djibouti">Djibouti</option>
                                                                            <option value="Dominica">Dominica</option>
                                                                            <option value="Dominican Republic">Dominican Republic
                                                                            </option>
                                                                            <option value="Ecuador">Ecuador</option>
                                                                            <option value="Egypt">Egypt</option>
                                                                            <option value="El Salvador">El Salvador</option>
                                                                            <option value="Equatorial Guinea">Equatorial Guinea
                                                                            </option>
                                                                            <option value="Eritrea">Eritrea</option>
                                                                            <option value="Estonia">Estonia</option>
                                                                            <option value="Ethiopia">Ethiopia</option>
                                                                            <option value="Falkland Islands (Malvinas)">Falkland
                                                                                Islands (Malvinas)</option>
                                                                            <option value="Faroe Islands">Faroe Islands</option>
                                                                            <option value="Fiji">Fiji</option>
                                                                            <option value="Finland">Finland</option>
                                                                            <option value="France">France</option>
                                                                            <option value="French Guiana">French Guiana</option>
                                                                            <option value="French Polynesia">French Polynesia
                                                                            </option>
                                                                            <option value="French Southern Territories">French
                                                                                Southern Territories</option>
                                                                            <option value="Gabon">Gabon</option>
                                                                            <option value="Gambia">Gambia</option>
                                                                            <option value="Georgia">Georgia</option>
                                                                            <option value="Germany">Germany</option>
                                                                            <option value="Ghana">Ghana</option>
                                                                            <option value="Gibraltar">Gibraltar</option>
                                                                            <option value="Greece">Greece</option>
                                                                            <option value="Greenland">Greenland</option>
                                                                            <option value="Grenada">Grenada</option>
                                                                            <option value="Guadeloupe">Guadeloupe</option>
                                                                            <option value="Guam">Guam</option>
                                                                            <option value="Guatemala">Guatemala</option>
                                                                            <option value="Guernsey">Guernsey</option>
                                                                            <option value="Guinea">Guinea</option>
                                                                            <option value="Guinea-bissau">Guinea-bissau</option>
                                                                            <option value="Guyana">Guyana</option>
                                                                            <option value="Haiti">Haiti</option>
                                                                            <option value="Heard Island and Mcdonald Islands">Heard
                                                                                Island and Mcdonald Islands</option>
                                                                            <option value="Holy See (Vatican City State)">Holy See
                                                                                (Vatican City State)</option>
                                                                            <option value="Honduras">Honduras</option>
                                                                            <option value="Hong Kong">Hong Kong</option>
                                                                            <option value="Hungary">Hungary</option>
                                                                            <option value="Iceland">Iceland</option>
                                                                            <option value="India">India</option>
                                                                            <option value="Indonesia">Indonesia</option>
                                                                            <option value="Iran, Islamic Republic of">Iran, Islamic
                                                                                Republic of</option>
                                                                            <option value="Iraq">Iraq</option>
                                                                            <option value="Ireland">Ireland</option>
                                                                            <option value="Isle of Man">Isle of Man</option>
                                                                            <option value="Israel">Israel</option>
                                                                            <option value="Italy">Italy</option>
                                                                            <option value="Jamaica">Jamaica</option>
                                                                            <option value="Japan">Japan</option>
                                                                            <option value="Jersey">Jersey</option>
                                                                            <option value="Jordan">Jordan</option>
                                                                            <option value="Kazakhstan">Kazakhstan</option>
                                                                            <option value="Kenya">Kenya</option>
                                                                            <option value="Kiribati">Kiribati</option>
                                                                            <option value="Korea, Democratic People's Republic of">
                                                                                Korea, Democratic People's Republic of</option>
                                                                            <option value="Korea, Republic of">Korea, Republic of
                                                                            </option>
                                                                            <option value="Kuwait">Kuwait</option>
                                                                            <option value="Kyrgyzstan">Kyrgyzstan</option>
                                                                            <option value="Lao People's Democratic Republic">Lao
                                                                                People's Democratic Republic</option>
                                                                            <option value="Latvia">Latvia</option>
                                                                            <option value="Lebanon">Lebanon</option>
                                                                            <option value="Lesotho">Lesotho</option>
                                                                            <option value="Liberia">Liberia</option>
                                                                            <option value="Libyan Arab Jamahiriya">Libyan Arab
                                                                                Jamahiriya</option>
                                                                            <option value="Liechtenstein">Liechtenstein</option>
                                                                            <option value="Lithuania">Lithuania</option>
                                                                            <option value="Luxembourg">Luxembourg</option>
                                                                            <option value="Macao">Macao</option>
                                                                            <option value="Macedonia, The Former Yugoslav Republic of">
                                                                                Macedonia, The Former Yugoslav Republic of</option>
                                                                            <option value="Madagascar">Madagascar</option>
                                                                            <option value="Malawi">Malawi</option>
                                                                            <option value="Malaysia">Malaysia</option>
                                                                            <option value="Maldives">Maldives</option>
                                                                            <option value="Mali">Mali</option>
                                                                            <option value="Malta">Malta</option>
                                                                            <option value="Marshall Islands">Marshall Islands
                                                                            </option>
                                                                            <option value="Martinique">Martinique</option>
                                                                            <option value="Mauritania">Mauritania</option>
                                                                            <option value="Mauritius">Mauritius</option>
                                                                            <option value="Mayotte">Mayotte</option>
                                                                            <option value="Mexico">Mexico</option>
                                                                            <option value="Micronesia, Federated States of">
                                                                                Micronesia, Federated States of</option>
                                                                            <option value="Moldova, Republic of">Moldova, Republic
                                                                                of</option>
                                                                            <option value="Monaco">Monaco</option>
                                                                            <option value="Mongolia">Mongolia</option>
                                                                            <option value="Montenegro">Montenegro</option>
                                                                            <option value="Montserrat">Montserrat</option>
                                                                            <option value="Morocco">Morocco</option>
                                                                            <option value="Mozambique">Mozambique</option>
                                                                            <option value="Myanmar">Myanmar</option>
                                                                            <option value="Namibia">Namibia</option>
                                                                            <option value="Nauru">Nauru</option>
                                                                            <option value="Nepal">Nepal</option>
                                                                            <option value="Netherlands">Netherlands</option>
                                                                            <option value="Netherlands Antilles">Netherlands
                                                                                Antilles</option>
                                                                            <option value="New Caledonia">New Caledonia</option>
                                                                            <option value="New Zealand">New Zealand</option>
                                                                            <option value="Nicaragua">Nicaragua</option>
                                                                            <option value="Niger">Niger</option>
                                                                            <option value="Nigeria">Nigeria</option>
                                                                            <option value="Niue">Niue</option>
                                                                            <option value="Norfolk Island">Norfolk Island</option>
                                                                            <option value="Northern Mariana Islands">Northern
                                                                                Mariana Islands</option>
                                                                            <option value="Norway">Norway</option>
                                                                            <option value="Oman">Oman</option>
                                                                            <option value="Pakistan">Pakistan</option>
                                                                            <option value="Palau">Palau</option>
                                                                            <option value="Palestinian Territory, Occupied">
                                                                                Palestinian Territory, Occupied</option>
                                                                            <option value="Panama">Panama</option>
                                                                            <option value="Papua New Guinea">Papua New Guinea
                                                                            </option>
                                                                            <option value="Paraguay">Paraguay</option>
                                                                            <option value="Peru">Peru</option>
                                                                            <option value="Philippines">Philippines</option>
                                                                            <option value="Pitcairn">Pitcairn</option>
                                                                            <option value="Poland">Poland</option>
                                                                            <option value="Portugal">Portugal</option>
                                                                            <option value="Puerto Rico">Puerto Rico</option>
                                                                            <option value="Qatar">Qatar</option>
                                                                            <option value="Reunion">Reunion</option>
                                                                            <option value="Romania">Romania</option>
                                                                            <option value="Russian Federation">Russian Federation
                                                                            </option>
                                                                            <option value="Rwanda">Rwanda</option>
                                                                            <option value="Saint Helena">Saint Helena</option>
                                                                            <option value="Saint Kitts and Nevis">Saint Kitts and
                                                                                Nevis</option>
                                                                            <option value="Saint Lucia">Saint Lucia</option>
                                                                            <option value="Saint Pierre and Miquelon">Saint Pierre
                                                                                and Miquelon</option>
                                                                            <option value="Saint Vincent and The Grenadines">Saint
                                                                                Vincent and The Grenadines</option>
                                                                            <option value="Samoa">Samoa</option>
                                                                            <option value="San Marino">San Marino</option>
                                                                            <option value="Sao Tome and Principe">Sao Tome and
                                                                                Principe</option>
                                                                            <option value="Saudi Arabia">Saudi Arabia</option>
                                                                            <option value="Senegal">Senegal</option>
                                                                            <option value="Serbia">Serbia</option>
                                                                            <option value="Seychelles">Seychelles</option>
                                                                            <option value="Sierra Leone">Sierra Leone</option>
                                                                            <option value="Singapore">Singapore</option>
                                                                            <option value="Slovakia">Slovakia</option>
                                                                            <option value="Slovenia">Slovenia</option>
                                                                            <option value="Solomon Islands">Solomon Islands</option>
                                                                            <option value="Somalia">Somalia</option>
                                                                            <option value="South Africa">South Africa</option>
                                                                            <option value="South Georgia and The South Sandwich Islands">
                                                                                South Georgia and The South Sandwich Islands
                                                                            </option>
                                                                            <option value="Spain">Spain</option>
                                                                            <option value="Sri Lanka">Sri Lanka</option>
                                                                            <option value="Sudan">Sudan</option>
                                                                            <option value="Suriname">Suriname</option>
                                                                            <option value="Svalbard and Jan Mayen">Svalbard and Jan
                                                                                Mayen</option>
                                                                            <option value="Swaziland">Swaziland</option>
                                                                            <option value="Sweden">Sweden</option>
                                                                            <option value="Switzerland">Switzerland</option>
                                                                            <option value="Syrian Arab Republic">Syrian Arab
                                                                                Republic</option>
                                                                            <option value="Taiwan">Taiwan</option>
                                                                            <option value="Tajikistan">Tajikistan</option>
                                                                            <option value="Tanzania, United Republic of">Tanzania,
                                                                                United Republic of</option>
                                                                            <option value="Thailand">Thailand</option>
                                                                            <option value="Timor-leste">Timor-leste</option>
                                                                            <option value="Togo">Togo</option>
                                                                            <option value="Tokelau">Tokelau</option>
                                                                            <option value="Tonga">Tonga</option>
                                                                            <option value="Trinidad and Tobago">Trinidad and Tobago
                                                                            </option>
                                                                            <option value="Tunisia">Tunisia</option>
                                                                            <option value="Turkey">Turkey</option>
                                                                            <option value="Turkmenistan">Turkmenistan</option>
                                                                            <option value="Turks and Caicos Islands">Turks and
                                                                                Caicos Islands</option>
                                                                            <option value="Tuvalu">Tuvalu</option>
                                                                            <option value="Uganda">Uganda</option>
                                                                            <option value="Ukraine">Ukraine</option>
                                                                            <option value="United Arab Emirates">United Arab
                                                                                Emirates</option>
                                                                            <option value="United Kingdom">United Kingdom</option>
                                                                            <option value="United States">United States</option>
                                                                            <option value="United States Minor Outlying Islands">
                                                                                United States Minor Outlying Islands</option>
                                                                            <option value="Uruguay">Uruguay</option>
                                                                            <option value="Uzbekistan">Uzbekistan</option>
                                                                            <option value="Vanuatu">Vanuatu</option>
                                                                            <option value="Venezuela">Venezuela</option>
                                                                            <option value="Viet Nam">Viet Nam</option>
                                                                            <option value="Virgin Islands, British">Virgin Islands,
                                                                                British</option>
                                                                            <option value="Virgin Islands, U.S.">Virgin Islands,
                                                                                U.S.</option>
                                                                            <option value="Wallis and Futuna">Wallis and Futuna
                                                                            </option>
                                                                            <option value="Western Sahara">Western Sahara</option>
                                                                            <option value="Yemen">Yemen</option>
                                                                            <option value="Zambia">Zambia</option>
                                                                            <option value="Zimbabwe">Zimbabwe</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col">
                                                                    <div class="form-group">
                                                                        <label>Postal Code</label>
                                                                        <input class="form-control form-control-lg" name="pincode" value="<?php echo _getsingleuser($_id, '_userpin') ?>" type="text">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col">
                                                                    <div class="form-group">
                                                                        <label>Address</label>
                                                                        <textarea name="location" class="form-control"><?php echo $address ?></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col">
                                                                    <div class="form-group">
                                                                        <label>Bio</label>
                                                                        <textarea name="userbio" class="form-control"><?php echo _getsingleuser($_id, '_userbio') ?></textarea>
                                                                    </div>
                                                                </div>

                                                            </div>



                                                            <div class="form-group mb-0">
                                                                <input type="submit" name="submit" class="btn btn-primary" value="Update Information">
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
    </div>

    <script>
        const getSubCategory = (val) => {
            $.ajax({
                type: "POST",
                url: "utils/getSubCategory.php",
                data: 'catid=' + val,
                success: function(data) {
                    $(`#subcategoryId`).html(data);
                }
            });
        }
        $('.select2').select2();
    </script>

    <!-- js -->
    <?php require("templates/_js_link.php") ?>





</body>

</html>