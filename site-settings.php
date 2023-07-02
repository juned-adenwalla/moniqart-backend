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
require('includes/_config.php');



if (isset($_POST['submit'])) {
    $sitetitle = $_POST['sitetitle'];
    $siteemail = $_POST['siteemail'];
    $sitephone = $_POST['sitephone'];
    $sitecurrency = $_POST['sitecurrency'];
    $timezone = $_POST['timezone'];
    $header = $_POST['header'];
    $footer = $_POST['footer'];
    $css = $_POST['css'];
    $logonewfile = null;
    $reslogonewfile = null;
    $faviconnewfile = null;

    if ($_FILES["logo"]["name"] != '') {
        $logofile = $_FILES["logo"]["name"];
        $extension = substr($logofile, strlen($logofile) - 4, strlen($logofile));
        $allowed_extensions = array(".jpg", ".jpeg", ".png", ".gif", ".webp", ".svg");
        if (!in_array($extension, $allowed_extensions)) {
            echo "<script>alert('Invalid format. Only jpg / jpeg/ png /gif format allowed');</script>";
        } else {
            $logonewfile = md5($logofile) . $extension;
            move_uploaded_file($_FILES["logo"]["tmp_name"], "uploads/images/" . $logonewfile);
        }
    }

    if ($_FILES["reslogo"]["name"] != '') {
        $reslogofile = $_FILES["reslogo"]["name"];
        $extension = substr($reslogofile, strlen($reslogofile) - 4, strlen($reslogofile));
        $allowed_extensions = array(".jpg", ".jpeg", ".png", ".gif", ".svg");
        if (!in_array($extension, $allowed_extensions)) {
            echo "<script>alert('Invalid format. Only jpg / jpeg/ png /gif format allowed');</script>";
        } else {
            $reslogonewfile = md5($reslogofile) . $extension;
            move_uploaded_file($_FILES["reslogo"]["tmp_name"], "uploads/images/" . $reslogonewfile);
        }
    }
    if ($_FILES["favicon"]["name"] != '') {
        $faviconfile = $_FILES["favicon"]["name"];
        $extension = substr($faviconfile, strlen($faviconfile) - 4, strlen($faviconfile));
        $allowed_extensions = array(".jpg", ".jpeg", ".png", ".gif", ".svg");
        if (!in_array($extension, $allowed_extensions)) {
            echo "<script>alert('Invalid format. Only jpg / jpeg/ png /gif format allowed');</script>";
        } else {
            $faviconnewfile = md5($faviconfile) . $extension;
            move_uploaded_file($_FILES["favicon"]["tmp_name"], "uploads/images/" . $faviconnewfile);
        }
    }
    _savesiteconfig($sitetitle, $siteemail, $sitephone, $sitecurrency, $timezone, $header, $footer, $css, $logonewfile, $reslogonewfile, $faviconnewfile);
}




// if (isset($_POST['addSocialMedia'])) {

//     $_name = $_POST['name'];
//     $_url = $_POST['url'];
//     $_indexing = $_POST['indexing'];

//     _createSocialMedia($_name, $_url, $_indexing);

// }


// if (isset($_GET['del'])) {

//     $menuid = $_GET['id'];

//     _deleteSocialMedia($menuid);
// }


// if (isset($_POST['editSocialMedia'])) {

//     $_id = $_POST['socialmediaid'];
//     $_name = $_POST['name'];
//     $_url = $_POST['url'];
//     $_indexing = $_POST['indexing'];

//     _updateSocialMedia($_id, $_name, $_url, $_indexing);

// }


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

        <form action="#" method="POST" enctype="multipart/form-data">


            <div class="pd-20 card-box mb-30">

                <div class="row">
                    <div class="col">
                        <div class="title">
                            <h4>Site Configuration (Base Setting)</h4>
                        </div>
                        <nav aria-label="breadcrumb" role="navigation">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    Site settings are the settings for a specific website within your Site. If you'd
                                    like to change settings for your Site overall, navigate to the Settings tab in the
                                    control panel. From site settings, you’ll be able to configure the default settings,
                                    edit your footer, add header and background images, and more.
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label>Site Title</label>
                            <input type="text" value="<?php echo _siteconfig('_sitetitle'); ?>" name="sitetitle"
                                placeholder="Site Title" class="form-control" />
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label>Site Email</label>
                            <input type="text" name="siteemail" value="<?php echo _siteconfig('_siteemail'); ?>"
                                placeholder="Site Email" class="form-control" />
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label>Site Phone</label>
                            <input type="text" name="sitephone" class="form-control" placeholder="Site Phone"
                                value="<?php echo _siteconfig('_sitephone'); ?>" />
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label>Site Currency</label>
                            <select class="custom-select2 form-control" name="sitecurrency"
                                style="width: 100%; height: 38px;">
                                <option disabled>Select currency</option>

                                <option selected value="<?php echo _siteconfig('_sitecurrency'); ?>"><?php echo _siteconfig('_sitecurrency'); ?></option>

                                <option value="USD">America (United States) Dollars – USD</option>
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
                                <option value="NLG">Dutch (Netherlands) Guilders – NLG</OPTION>

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
                                <option value="NLG">Holland (Netherlands) Guilders – NLG</OPTION>
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
                                <option value="XDR">Special Drawing Rights (IMF) – XDR</option>
                                <option value="LKR">Sri Lanka Rupees – LKR</option>

                                <option value="SDD">Sudan Dinars – SDD</option>
                                <option value="SEK">Sweden Kronor – SEK</option>
                                <option value="CHF">Switzerland Francs – CHF</option>
                                <option value="TWD">Taiwan New Dollars – TWD</option>
                                <option value="THB">Thailand Baht – THB</option>
                                <option value="TTD">Trinidad and Tobago Dollars – TTD</option>

                                <option value="TND">Tunisia Dinars – TND</option>
                                <option value="TRY">Turkey New Lira – TRY</option>
                                <option value="AED">United Arab Emirates Dirhams – AED</option>
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
                            <label>Select Timezone</label>
                            <select class="custom-select2 form-control" name="timezone"
                                style="width: 100%; height: 38px;">
                                <option>Select Timezone</option>
                                <option value="<?php echo _siteconfig('_timezone'); ?>" selected>
                                    <?php echo _siteconfig('_timezone'); ?></option>
                                <option value="Etc/GMT+12">(GMT-12:00) International Date Line West
                                </option>
                                <option value="Pacific/Midway">(GMT-11:00) Midway Island, Samoa</option>
                                <option value="Pacific/Honolulu">(GMT-10:00) Hawaii</option>
                                <option value="US/Alaska">(GMT-09:00) Alaska</option>
                                <option value="America/Los_Angeles">(GMT-08:00) Pacific Time (US &
                                    Canada)</option>
                                <option value="America/Tijuana">(GMT-08:00) Tijuana, Baja California
                                </option>
                                <option value="US/Arizona">(GMT-07:00) Arizona</option>
                                <option value="America/Chihuahua">(GMT-07:00) Chihuahua, La Paz,
                                    Mazatlan</option>
                                <option value="US/Mountain">(GMT-07:00) Mountain Time (US & Canada)
                                </option>
                                <option value="America/Managua">(GMT-06:00) Central America</option>
                                <option value="US/Central">(GMT-06:00) Central Time (US & Canada)
                                </option>
                                <option value="America/Mexico_City">(GMT-06:00) Guadalajara, Mexico
                                    City, Monterrey</option>
                                <option value="Canada/Saskatchewan">(GMT-06:00) Saskatchewan</option>
                                <option value="America/Bogota">(GMT-05:00) Bogota, Lima, Quito, Rio
                                    Branco</option>
                                <option value="US/Eastern">(GMT-05:00) Eastern Time (US & Canada)
                                </option>
                                <option value="US/East-Indiana">(GMT-05:00) Indiana (East)</option>
                                <option value="Canada/Atlantic">(GMT-04:00) Atlantic Time (Canada)
                                </option>
                                <option value="America/Caracas">(GMT-04:00) Caracas, La Paz</option>
                                <option value="America/Manaus">(GMT-04:00) Manaus</option>
                                <option value="America/Santiago">(GMT-04:00) Santiago</option>
                                <option value="Canada/Newfoundland">(GMT-03:30) Newfoundland</option>
                                <option value="America/Sao_Paulo">(GMT-03:00) Brasilia</option>
                                <option value="America/Argentina/Buenos_Aires">(GMT-03:00) Buenos Aires,
                                    Georgetown</option>
                                <option value="America/Godthab">(GMT-03:00) Greenland</option>
                                <option value="America/Montevideo">(GMT-03:00) Montevideo</option>
                                <option value="America/Noronha">(GMT-02:00) Mid-Atlantic</option>
                                <option value="Atlantic/Cape_Verde">(GMT-01:00) Cape Verde Is.</option>
                                <option value="Atlantic/Azores">(GMT-01:00) Azores</option>
                                <option value="Africa/Casablanca">(GMT+00:00) Casablanca, Monrovia,
                                    Reykjavik</option>
                                <option value="Etc/Greenwich">(GMT+00:00) Greenwich Mean Time : Dublin,
                                    Edinburgh, Lisbon, London</option>
                                <option value="Europe/Amsterdam">(GMT+01:00) Amsterdam, Berlin, Bern,
                                    Rome, Stockholm, Vienna</option>
                                <option value="Europe/Belgrade">(GMT+01:00) Belgrade, Bratislava,
                                    Budapest, Ljubljana, Prague</option>
                                <option value="Europe/Brussels">(GMT+01:00) Brussels, Copenhagen,
                                    Madrid, Paris</option>
                                <option value="Europe/Sarajevo">(GMT+01:00) Sarajevo, Skopje, Warsaw,
                                    Zagreb</option>
                                <option value="Africa/Lagos">(GMT+01:00) West Central Africa</option>
                                <option value="Asia/Amman">(GMT+02:00) Amman</option>
                                <option value="Europe/Athens">(GMT+02:00) Athens, Bucharest, Istanbul
                                </option>
                                <option value="Asia/Beirut">(GMT+02:00) Beirut</option>
                                <option value="Africa/Cairo">(GMT+02:00) Cairo</option>
                                <option value="Africa/Harare">(GMT+02:00) Harare, Pretoria</option>
                                <option value="Europe/Helsinki">(GMT+02:00) Helsinki, Kyiv, Riga, Sofia,
                                    Tallinn, Vilnius</option>
                                <option value="Asia/Jerusalem">(GMT+02:00) Jerusalem</option>
                                <option value="Europe/Minsk">(GMT+02:00) Minsk</option>
                                <option value="Africa/Windhoek">(GMT+02:00) Windhoek</option>
                                <option value="Asia/Kuwait">(GMT+03:00) Kuwait, Riyadh, Baghdad</option>
                                <option value="Europe/Moscow">(GMT+03:00) Moscow, St. Petersburg,
                                    Volgograd</option>
                                <option value="Africa/Nairobi">(GMT+03:00) Nairobi</option>
                                <option value="Asia/Tbilisi">(GMT+03:00) Tbilisi</option>
                                <option value="Asia/Tehran">(GMT+03:30) Tehran</option>
                                <option value="Asia/Muscat">(GMT+04:00) Abu Dhabi, Muscat</option>
                                <option value="Asia/Baku">(GMT+04:00) Baku</option>
                                <option value="Asia/Yerevan">(GMT+04:00) Yerevan</option>
                                <option value="Asia/Kabul">(GMT+04:30) Kabul</option>
                                <option value="Asia/Yekaterinburg">(GMT+05:00) Yekaterinburg</option>
                                <option value="Asia/Karachi">(GMT+05:00) Islamabad, Karachi, Tashkent
                                </option>
                                <option value="Asia/Calcutta">(GMT+05:30) Chennai, Kolkata, Mumbai, New
                                    Delhi</option>
                                <option value="Asia/Calcutta">(GMT+05:30) Sri Jayawardenapura</option>
                                <option value="Asia/Katmandu">(GMT+05:45) Kathmandu</option>
                                <option value="Asia/Almaty">(GMT+06:00) Almaty, Novosibirsk</option>
                                <option value="Asia/Dhaka">(GMT+06:00) Astana, Dhaka</option>
                                <option value="Asia/Rangoon">(GMT+06:30) Yangon (Rangoon)</option>
                                <option value="Asia/Bangkok">(GMT+07:00) Bangkok, Hanoi, Jakarta
                                </option>
                                <option value="Asia/Krasnoyarsk">(GMT+07:00) Krasnoyarsk</option>
                                <option value="Asia/Hong_Kong">(GMT+08:00) Beijing, Chongqing, Hong
                                    Kong, Urumqi</option>
                                <option value="Asia/Kuala_Lumpur">(GMT+08:00) Kuala Lumpur, Singapore
                                </option>
                                <option value="Asia/Irkutsk">(GMT+08:00) Irkutsk, Ulaan Bataar</option>
                                <option value="Australia/Perth">(GMT+08:00) Perth</option>
                                <option value="Asia/Taipei">(GMT+08:00) Taipei</option>
                                <option value="Asia/Tokyo">(GMT+09:00) Osaka, Sapporo, Tokyo</option>
                                <option value="Asia/Seoul">(GMT+09:00) Seoul</option>
                                <option value="Asia/Yakutsk">(GMT+09:00) Yakutsk</option>
                                <option value="Australia/Adelaide">(GMT+09:30) Adelaide</option>
                                <option value="Australia/Darwin">(GMT+09:30) Darwin</option>
                                <option value="Australia/Brisbane">(GMT+10:00) Brisbane</option>
                                <option value="Australia/Canberra">(GMT+10:00) Canberra, Melbourne,
                                    Sydney</option>
                                <option value="Australia/Hobart">(GMT+10:00) Hobart</option>
                                <option value="Pacific/Guam">(GMT+10:00) Guam, Port Moresby</option>
                                <option value="Asia/Vladivostok">(GMT+10:00) Vladivostok</option>
                                <option value="Asia/Magadan">(GMT+11:00) Magadan, Solomon Is., New
                                    Caledonia</option>
                                <option value="Pacific/Auckland">(GMT+12:00) Auckland, Wellington
                                </option>
                                <option value="Pacific/Fiji">(GMT+12:00) Fiji, Kamchatka, Marshall Is.
                                </option>
                                <option value="Pacific/Tongatapu">(GMT+13:00) Nuku'alofa</option>
                            </select>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label>Site Logo</label>
                            <input type="file" name="logo" id="logo" class="form-control-file form-control height-auto">
                            <a href="uploads/images/<?php echo _siteconfig('_sitelogo'); ?>" target="_blank">Open

                                Featured Image &nbsp;<svg xmlns="http://www.w3.org/2000/svg" style="width: 15px;"
                                    viewBox="0 0 512 512">
                                    <!-- Font Awesome Pro 5.15.4 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) -->
                                    <path
                                        d="M326.612 185.391c59.747 59.809 58.927 155.698.36 214.59-.11.12-.24.25-.36.37l-67.2 67.2c-59.27 59.27-155.699 59.262-214.96 0-59.27-59.26-59.27-155.7 0-214.96l37.106-37.106c9.84-9.84 26.786-3.3 27.294 10.606.648 17.722 3.826 35.527 9.69 52.721 1.986 5.822.567 12.262-3.783 16.612l-13.087 13.087c-28.026 28.026-28.905 73.66-1.155 101.96 28.024 28.579 74.086 28.749 102.325.51l67.2-67.19c28.191-28.191 28.073-73.757 0-101.83-3.701-3.694-7.429-6.564-10.341-8.569a16.037 16.037 0 0 1-6.947-12.606c-.396-10.567 3.348-21.456 11.698-29.806l21.054-21.055c5.521-5.521 14.182-6.199 20.584-1.731a152.482 152.482 0 0 1 20.522 17.197zM467.547 44.449c-59.261-59.262-155.69-59.27-214.96 0l-67.2 67.2c-.12.12-.25.25-.36.37-58.566 58.892-59.387 154.781.36 214.59a152.454 152.454 0 0 0 20.521 17.196c6.402 4.468 15.064 3.789 20.584-1.731l21.054-21.055c8.35-8.35 12.094-19.239 11.698-29.806a16.037 16.037 0 0 0-6.947-12.606c-2.912-2.005-6.64-4.875-10.341-8.569-28.073-28.073-28.191-73.639 0-101.83l67.2-67.19c28.239-28.239 74.3-28.069 102.325.51 27.75 28.3 26.872 73.934-1.155 101.96l-13.087 13.087c-4.35 4.35-5.769 10.79-3.783 16.612 5.864 17.194 9.042 34.999 9.69 52.721.509 13.906 17.454 20.446 27.294 10.606l37.106-37.106c59.271-59.259 59.271-155.699.001-214.959z" />
                                </svg></a>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label>Site Logo (Responsive)</label>
                            <input type="file" name="reslogo" id="reslogo"
                                class="form-control-file form-control height-auto">
                            <a href="uploads/images/<?php echo _siteconfig('_sitereslogo'); ?>" target="_blank">Open
                                Featured Image &nbsp;<svg xmlns="http://www.w3.org/2000/svg" style="width: 15px;"
                                    viewBox="0 0 512 512">
                                    <!-- Font Awesome Pro 5.15.4 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) -->
                                    <path
                                        d="M326.612 185.391c59.747 59.809 58.927 155.698.36 214.59-.11.12-.24.25-.36.37l-67.2 67.2c-59.27 59.27-155.699 59.262-214.96 0-59.27-59.26-59.27-155.7 0-214.96l37.106-37.106c9.84-9.84 26.786-3.3 27.294 10.606.648 17.722 3.826 35.527 9.69 52.721 1.986 5.822.567 12.262-3.783 16.612l-13.087 13.087c-28.026 28.026-28.905 73.66-1.155 101.96 28.024 28.579 74.086 28.749 102.325.51l67.2-67.19c28.191-28.191 28.073-73.757 0-101.83-3.701-3.694-7.429-6.564-10.341-8.569a16.037 16.037 0 0 1-6.947-12.606c-.396-10.567 3.348-21.456 11.698-29.806l21.054-21.055c5.521-5.521 14.182-6.199 20.584-1.731a152.482 152.482 0 0 1 20.522 17.197zM467.547 44.449c-59.261-59.262-155.69-59.27-214.96 0l-67.2 67.2c-.12.12-.25.25-.36.37-58.566 58.892-59.387 154.781.36 214.59a152.454 152.454 0 0 0 20.521 17.196c6.402 4.468 15.064 3.789 20.584-1.731l21.054-21.055c8.35-8.35 12.094-19.239 11.698-29.806a16.037 16.037 0 0 0-6.947-12.606c-2.912-2.005-6.64-4.875-10.341-8.569-28.073-28.073-28.191-73.639 0-101.83l67.2-67.19c28.239-28.239 74.3-28.069 102.325.51 27.75 28.3 26.872 73.934-1.155 101.96l-13.087 13.087c-4.35 4.35-5.769 10.79-3.783 16.612 5.864 17.194 9.042 34.999 9.69 52.721.509 13.906 17.454 20.446 27.294 10.606l37.106-37.106c59.271-59.259 59.271-155.699.001-214.959z" />
                                </svg></a>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label>Site Favicon</label>
                            <input type="file" name="favicon" id="favicon"
                                class="form-control-file form-control height-auto">
                            <a href="uploads/images/<?php echo _siteconfig('_favicon'); ?>" target="_blank">Open
                                Featured Image &nbsp;<svg xmlns="http://www.w3.org/2000/svg" style="width: 15px;"
                                    viewBox="0 0 512 512">
                                    <!-- Font Awesome Pro 5.15.4 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) -->
                                    <path
                                        d="M326.612 185.391c59.747 59.809 58.927 155.698.36 214.59-.11.12-.24.25-.36.37l-67.2 67.2c-59.27 59.27-155.699 59.262-214.96 0-59.27-59.26-59.27-155.7 0-214.96l37.106-37.106c9.84-9.84 26.786-3.3 27.294 10.606.648 17.722 3.826 35.527 9.69 52.721 1.986 5.822.567 12.262-3.783 16.612l-13.087 13.087c-28.026 28.026-28.905 73.66-1.155 101.96 28.024 28.579 74.086 28.749 102.325.51l67.2-67.19c28.191-28.191 28.073-73.757 0-101.83-3.701-3.694-7.429-6.564-10.341-8.569a16.037 16.037 0 0 1-6.947-12.606c-.396-10.567 3.348-21.456 11.698-29.806l21.054-21.055c5.521-5.521 14.182-6.199 20.584-1.731a152.482 152.482 0 0 1 20.522 17.197zM467.547 44.449c-59.261-59.262-155.69-59.27-214.96 0l-67.2 67.2c-.12.12-.25.25-.36.37-58.566 58.892-59.387 154.781.36 214.59a152.454 152.454 0 0 0 20.521 17.196c6.402 4.468 15.064 3.789 20.584-1.731l21.054-21.055c8.35-8.35 12.094-19.239 11.698-29.806a16.037 16.037 0 0 0-6.947-12.606c-2.912-2.005-6.64-4.875-10.341-8.569-28.073-28.073-28.191-73.639 0-101.83l67.2-67.19c28.239-28.239 74.3-28.069 102.325.51 27.75 28.3 26.872 73.934-1.155 101.96l-13.087 13.087c-4.35 4.35-5.769 10.79-3.783 16.612 5.864 17.194 9.042 34.999 9.69 52.721.509 13.906 17.454 20.446 27.294 10.606l37.106-37.106c59.271-59.259 59.271-155.699.001-214.959z" />
                                </svg></a>
                        </div>
                    </div>
                </div>

            </div>

            <div class="pd-20 card-box mb-30">

                <div class="row">
                    <div class="col">
                        <div class="title">
                            <h4>Site Configuration (Header Setting)</h4>
                        </div>
                        <nav aria-label="breadcrumb" role="navigation">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    Site settings are the settings for a specific website within your Site. If you'd
                                    like to change settings for your Site overall, navigate to the Settings tab in the
                                    control panel. From site settings, you’ll be able to configure the default settings,
                                    edit your footer, add header and background images, and more.
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label>Header Codes</label>
                            <textarea name="header"
                                class="form-control"><?php echo _siteconfig('_customheader'); ?></textarea>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label>Custom Css</label>
                            <textarea name="css"
                                class="form-control"><?php echo _siteconfig('_customcss'); ?></textarea>
                        </div>
                    </div>
                </div>

            </div>



            <div class="pd-20 card-box mb-30">

                <div class="row">
                    <div class="col">
                        <div class="title">
                            <h4>Site Configuration (Footers Setting)</h4>
                        </div>
                        <nav aria-label="breadcrumb" role="navigation">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    Site settings are the settings for a specific website within your Site. If you'd
                                    like to change settings for your Site overall, navigate to the Settings tab in the
                                    control panel. From site settings, you’ll be able to configure the default settings,
                                    edit your footer, add header and background images, and more.
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>


                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label>Footer Codes</label>
                            <textarea name="footer"
                                class="form-control"><?php echo _siteconfig('_customfooter'); ?></textarea>
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
            </div>

        </form>

    </div>
    </div>

    </div>
    <!-- js -->
    <?php require("templates/_js_link.php") ?>



</body>

</html>