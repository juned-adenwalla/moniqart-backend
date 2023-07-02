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
require('includes/_config.php');

if (isset($_GET['del'])) {
    $_id = $_GET['id'];
    _deletemarkup($_id);
}


if (isset($_POST['submit'])) {
    $conversion = $_POST['conversion'];
    $price = $_POST['amount'];
    if (isset($_POST['status'])) {
        $status = 'true';
    } else {
        $status = false;
    }
    _createmarkup($conversion, $price, $status);
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
        <div class="pd-ltr-20 xs-pd-20-10">
            <div class="min-height-200px">

                <div class="card-box mb-30">
                    <div class="pd-20">
                        <div class="row">
                            <div class="col">
                                <h4 class="text-black h4">Manage Coupon (Add Offers)</h4>
                                <p class="mb-0">
                                    Web Help Desk uses tickets to manage service requests. These tickets can be
                                    initiated
                                    through email, created in the application, and imported from another application.
                                    Techs,
                                    admins, and clients can also manage tickets through email or through the application
                                    in
                                    a
                                    web browser.
                                </p>
                                
                            </div>
                        </div>

                        <div class="row" style="margin-top: 30px;">
                            <div class="col">
                                <a href="#" data-toggle="modal" data-target="#modal" class="btn btn-dark"
                                    style="float: right;">
                                    Add Markup
                                </a>
                            </div>

                            <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <form method="post" action="#" enctype="multipart/form-data" class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="myLargeModalLabel">Add Markup</h4>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-hidden="true">×</button>
                                        </div>
                                        <div class="modal-body pd-5" style="padding: 15px;">
                                            <div class="row">
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label>Conversion Currency</label>
                                                        <select class="form-control" name="conversion"
                                                            style="width: 100%;">
                                                            <option selected value="">Select currency</option>
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
                                                        <label>Conversion Price</label>
                                                        <input type="text" name="amount" placeholder="Price"
                                                            class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col" style="margin-top: 30px;">
                                                    <div class="form-group">
                                                        <input type="checkbox" data-size="small" value="true"
                                                            name="status" class="switch-btn" data-color="#f56767">
                                                        <label>is Active</label>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="modal-footer">
                                            <input type="submit" value="Add" name="submit" class="btn btn-primary">
                                            <button type="button" class="btn btn-default"
                                                data-dismiss="modal">Close</button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="pb-20" style="margin-top: 30px;">
                        <table class="data-table table stripe hover nowrap">
                            <thead>
                                <tr>
                                    <th>Created At</th>
                                    <th>Conversion Currency</th>
                                    <th>Conversion Price</th>
                                    <th>Status</th>
                                    <th class="datatable-nosort">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php _getmarkup(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        $('.select2').select2();

    </script>

    <!-- js -->
    <?php include("templates/_js_link.php") ?>
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