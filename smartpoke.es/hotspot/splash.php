<?php
$countrycode = "ESP";
$mobilephone = "";
$pin = "";<?php
$countrycode = "ESP";
$mobilephone = "";
$pin = "";

$lang = "es";
if (isset($_POST['lang'])) $lang = $_POST['lang'];

include('lang/es.conf.php');
if ($lang == 'en') include('lang/en.conf.php');

$errorPin = $configValues['CONFIG_SIGNUP_FAILURE_MSG_PIN'];
$errorEmail = $configValues['CONFIG_SIGNUP_FAILURE_MSG_FIELDEMAIL'];

// What is the request state?
$isLoginRequest = isset($_REQUEST['ap_mac']);
$isLoginError = isset($_REQUEST['error_message']);
$isLoggedIn = isset($_COOKIE['LogoutURL']);

// Lets get the values from the query parameters
$data = array();
$email = "";
$firstname = "";
$lastname = "";

$month = date('m');
$day = date('d');
$year = date('Y');
$birthdate = $year . '-' . $month . '-' . $day;

$gender = "X";
$zipcode = "";
$checkbox1 = "";
$checkbox2 = "";
$checkbox3 = "";

// Location of the splash
$data['rootUrl'] = "https://" . $_SERVER['SERVER_NAME'] . "/hotspot";

if ($isLoginRequest) {
    // URLs
    $data['loginUrl'] = urldecode($_REQUEST['login_url']);
    $data['nextUrl'] = urldecode($_REQUEST['continue']);

    // Access Point Info
    $data['ap']['mac'] = $_REQUEST['ap_mac'];
    $data['ap']['name'] = $_REQUEST['ap_name'];
    $data['ap']['tags'] = explode(" ", $_REQUEST['ap_tags']);
    $spot_id = $data['ap']['tags'][0];
    $sensorname = $data['ap']['tags'][1];
    $hotspot_name = 'eSmartIT';

    // Client Info
    $data['client']['mac'] = $_REQUEST['client_mac'];
    $data['client']['ip'] = $_REQUEST['client_ip'];
}

if ($isLoginError) {
    // Error Message
    $data['errorMessage'] = $_REQUEST['error_message'] . " " . $data['errorPhone'] ;
}

if ($isLoggedIn) {
    // Get the logout URL from the cookie
    $data['logoutUrl'] = urldecode($_COOKIE['LogoutURL']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo $title;?></title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="css/landing-page.css" rel="stylesheet">
    <!-- Custom Fonts -->
    <!-- <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css"> -->
    <script type="text/javascript" src="js/jquery-2.1.0.min.js"></script>
    <script type="text/javascript" src="js/jquery.js"></script>
    <!-- <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css"> -->

</head>
<body>
<div class="container body">
    <div class="main_container">
        <div class="right_col" role="main">
            <div class="">
                <div class="clearfix"></div>

                <div class="row">

                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="x_panel">
                            <div class="x_title">
                                <div class="x_content">
                                    <form id="login_form" class="form-signin" role="form" method="POST" enctype="multipart/form-data">
                                        <?php if ($isLoginRequest) { ?>
                                            <h2 class="form-signin-heading">Demo eSmartIT</h2>
                                            <h4><?= $hotspot_name; ?></h4>

                                            <div id="errorPhone" class="alert alert-danger"></div>
                                            <?php if ($isLoginError) { ?>
                                                <div id="errorPhone" class="alert alert-danger"><?= $data['errorMessage'] ?></div>
                                            <?php } ?>

                                            <input type="hidden" id="hotspotmac" name="hotspotmac" value="<?= $data['ap']['name'];?>">
                                            <input type="hidden" id="hotspot_name" name="hotspot_name" value="<?php echo $hotspot_name;?>">
                                            <input type="hidden" id="spot_id" name="spot_id" value="<?php echo $spot_id;?>">
                                            <input type="hidden" id="loginUrl" name="loginUrl" value="<?= $data['loginUrl'];?>">

                                            <input type="hidden" id="username" name="username" class="form-control" value="<?= $_REQUEST['username'] ?>">
                                            <input type="hidden" id="password" name="password" class="form-control">

                                            <div class="form-group">
                                                <div class="col-md-6 col-sm-6 col-xs-3"></div>
                                                <label class="control-label col-md-3 col-sm-3 col-xs-3"><?php echo $l_idioma;?></label>
                                                <div class="col-md-3 col-sm-3 col-xs-6">
                                                    <select name="lang" class="form-control" OnChange=this.form.submit()>
                                                        <option value="<?php echo $lang;?>" selected="selected"><?php echo $l_language;?></option>
                                                        <option value="es">Espa&ntilde;ol</option>
                                                        <option value="en">English</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <p>&nbsp;</p>
                                            <div class="form-group">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-2"><?php echo $l_mobilephone;?></label>
                                                <div class="col-md-3 col-sm-3 col-xs-4">
                                                    <select id="selCountryCode" name="countrycode" class="form-control">
                                                        <option value=<?php echo $countrycode;?> selected=<?php echo $selected;?>></option>

                                                        <?php

                                                        include('library/opendb.php');
                                                        $sqlcode = "SELECT country_phone_code, country_code_ISO3 FROM ".$configValues['TBL_RWCOUNTRY']." ".
                                                            "WHERE flag = 1 ORDER BY country_phone_code";
                                                        $retcode = pg_query($dbConnect, $sqlcode);

                                                        while ($rowcode = pg_fetch_row($retcode)) {
                                                            $row_country = $rowcode[0];
                                                            $selected = '';
                                                            if ($countrycode == $rowcode[1]) $selected = 'selected = $countrycode';
                                                            echo "<option value=$rowcode[1] $selected>$row_country</option>";
                                                            include('library/closedb.php');
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-3 col-sm-3 col-xs-6">
                                                    <input type="text" id="mobilephone" name="mobilephone" required autofocus class="form-control col-md-9 col-xs-6">
                                                </div>
                                            </div>

                                            <p>&nbsp;</p>
                                            <fieldset id="register">

                                                <div class="form-group">
                                                    <label class="control-label col-md-9 col-sm-9 col-xs-6"><?php echo $l_pin;?><span class="required">*</span></label>
                                                    <div class="col-md-9 col-sm-6 col-xs-6">
                                                        <input type="text" id="pin" name="pin" onblur="validPin()" required class="form-control col-md-9 col-xs-6">
                                                    </div>
                                                </div>
                                                <div id="resultPin" class="alert alert-danger"></div>
                                                </br>
                                                <div class="form-group">
                                                    <label class="control-label col-md-9 col-sm-9 col-xs-6"><?php echo $l_email;?><span class="required">*</span></label>
                                                    <div class="col-md-9 col-sm-6 col-xs-6">
                                                        <input type="text" id="email_cli" name="email_cli" onblur="validate()" required class="form-control col-md-9 col-xs-6">
                                                    </div>
                                                </div>
                                                <div id="resultEmail" class="alert alert-danger"></div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-9 col-sm-9 col-xs-6"><?php echo $l_firstname;?><span class="required">*</span></label>
                                                    <div class="col-md-9 col-sm-6 col-xs-6">
                                                        <input type="text" id="firstname" name="firstname" required class="form-control col-md-9 col-xs-6">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-9 col-sm-9 col-xs-6"><?php echo $l_lastname;?></label>
                                                    <div class="col-md-9 col-sm-6 col-xs-6">
                                                        <input type="text" id="lastname" name="lastname" class="form-control col-md-9 col-xs-6">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-9 col-sm-9 col-xs-6"><?php echo $l_birthdate;?></label>
                                                    <div class="col-md-9 col-sm-6 col-xs-6">
                                                        <input type="date" name="bdate" id="bdate" class="form-control" value="<?php echo $birthdate;?>">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-9 col-sm-9 col-xs-6"><?php echo $l_select_gender?></label>
                                                    <div class="col-md-9 col-sm-6 col-xs-6">
                                                        <select id="gender" name="gender" class="form-control">
                                                            <option value="H"><?php echo $l_man;?></option>
                                                            <option value="M"><?php echo $l_woman;?></option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-9 col-sm-9 col-xs-6"><?php echo $l_zipcode;?></label>
                                                    <div class="col-md-9 col-sm-6 col-xs-6">
                                                        <input type="text" id="zipcode" name="zipcode" class="form-control col-md-9 col-xs-6">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-md-6 col-sm-6 col-xs-6 form-group">
                                                        <input type="checkbox" class="form-control" id="checkbox1" name="checkbox1" required value="check">
                                                    </div>
                                                    <div class="col-md-6 col-sm-6 col-xs-6 form-group">
                                                        <a href="terminos_condiciones.pdf"><?php echo $l_termsconditions1;?></a>
                                                    </div>
                                                </div>
                                            </fieldset>

                                            <div class="clearfix"></div>
                                            <div class="form-group">
                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                    <button id="btnlogin" type="submit" name="btnlogin" class="btn btn-lg btn-primary btn-block" value="submitLog"><?php echo $l_login;?></button>
                                                    <button id="btnregister" type="submit" name="btnregister" class="btn btn-lg btn-primary btn-block" value="submitReg"><?php echo $l_regisbutton;?></button>
                                                </div>
                                            </div>
                                            <p>&nbsp;</p>

                                        <?php } else  if ($isLoggedIn) { ?>
                                            <div class="alert alert-info"> <?php echo $l_logged_in;?> <a href="/logout.php">Logout</a></div>
                                        <?php } else { ?>
                                            <div class="alert alert-danger"><?php echo $l_something_wrong;?></div>
                                        <?php } ?>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <!-- <script src="js/jquery.js"></script> -->

    <!-- Bootstrap Core JavaScript -->
    <!-- <script src="js/bootstrap.min.js"></script> -->

    <script>
        $( window ).load(function() {
            hide();
            document.getElementById("errorPhone").style.display = 'none';
            document.getElementById("resultPin").style.display = 'none';
            document.getElementById("resultEmail").style.display = 'none';
        });
    </script>

    <script>
        function show(){
            document.getElementById("selCountryCode").disabled = true;
            document.getElementById("mobilephone").disabled = true;
            document.getElementById("register").style.display = 'block';
            document.getElementById("pin").disabled = false;
            document.getElementById("email_cli").disabled = false;
            document.getElementById("firstname").disabled = false;
            document.getElementById("checkbox1").disabled = false;
            document.getElementById("btnlogin").style.display = 'none';
            document.getElementById("btnregister").style.display = 'block';
        }

        function hide(){
            document.getElementById("selCountryCode").disabled = false;
            document.getElementById("mobilephone").disabled = false;
            document.getElementById("register").style.display = 'none';
            document.getElementById("pin").disabled = true;
            document.getElementById("email_cli").disabled = true;
            document.getElementById("firstname").disabled = true;
            document.getElementById("checkbox1").disabled = true;
            document.getElementById("btnlogin").style.display = 'block';
            document.getElementById("btnregister").style.display = 'none';
        }
    </script>

    <script>
        $(function () {
            $("#login_form button").click(function (ev) {
                ev.preventDefault() // cancel form submission
                if ($(this).attr("value") == "submitLog") {
                    validUser();
                }
                if ($(this).attr("value") == "submitReg") {
                    registerUser();
                }
            });
        });
    </script>


    <script>
        function validUser() {
            var formStr = $('#login_form').serialize();
            $.ajax({
                url: 'validUser.php',
                type: 'POST',
                data: formStr,
                dataType: 'json',
                success:function(response) {

                    console.log(response);
                    var object = response[0];
                    var section = object['section'];
                    var data = object['data'];
                    var user = $("#selCountryCode").val()+$("#mobilephone").val();
                    var loginUrl = $("#loginUrl").val();

                    if (section == "error") {
                        $("#errorPhone").text(data);
                        document.getElementById("errorPhone").style.display = 'block';
                    } else {
                        setUser(user, data);
                        if (section == "go") {
                            document.getElementById("login_form").action = loginUrl;
                            document.getElementById("login_form").submit();
                        } else {
                            document.getElementById("errorPhone").style.display = 'none';
                            alert('<?php echo $l_pin3;?>'+': '+data);
                            show();
                        }
                    }
                }
            });
        }
    </script>

    <script>
        function registerUser() {
            document.getElementById("selCountryCode").disabled = false;
            document.getElementById("mobilephone").disabled = false;
            var formStr = $('#login_form').serialize();
            $.ajax({
                url: 'registerUser.php',
                type: 'POST',
                data: formStr,
                dataType: 'json',
                success:function(response) {

                    console.log(response);
                    var object = response[0];
                    var section = object['section'];
                    var data = object['data'];
                    var user = $("#selCountryCode").val()+$("#mobilephone").val();
                    var loginUrl = $("#loginUrl").val();

                    if (section == "error") {
                        $("#errorPhone").text(data);
                        document.getElementById("errorPhone").style.display = 'block';
                    } else {
                        setUser(user, data);
                        if (section == "go") {
                            document.getElementById("login_form").action = loginUrl;
                            document.getElementById("login_form").submit();
                        }
                    }
                }
            });
        }
    </script>

    <script>
        function setUser(username, password) {
            $('input[name=username]').val(username);
            $('input[name=password]').val(password);
        }
    </script>

    <script>
        function validPin(){
            var vpin = $("#pin").val();;
            var vpass = $("#password").val();;
            var result = $("#resultPin");
            result.text("");

            document.getElementById("resultPin").style.display = 'none';
            if (vpin != vpass) {
                result.text("<?php echo $errorPin;?>");
                document.getElementById("resultPin").style.display = 'block';

                document.getElementById("pin").focus();
                return false;
            }
        }
    </script>

    <script>
        function validateEmail(email) {
            var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return re.test(email);
        }

        function validate() {
            var result = $("#resultEmail");
            var email = $("#email_cli").val();
            result.text("");

            document.getElementById("resultEmail").style.display = 'none';
            if (!validateEmail(email)) {
                result.text("<?php echo $errorEmail;?>");
                document.getElementById("resultEmail").style.display = 'block';

                document.getElementById("email_cli").focus();
                return false;
            }
        }
    </script>

</div>
<!-- footer content -->
<div class="clearfix"></div>
<footer>
    <div class="pull-right">
        <?php echo $l_footer2;?>
    </div>
    <div class="clearfix"></div>
</footer>
<!-- /footer content -->
</body>
</html>


$lang = "es";
if (isset($_POST['lang'])) $lang = $_POST['lang'];

include('lang/es.conf.php');
if ($lang == 'en') include('lang/en.conf.php');

$errorPin = $configValues['CONFIG_SIGNUP_FAILURE_MSG_PIN'];
$errorEmail = $configValues['CONFIG_SIGNUP_FAILURE_MSG_FIELDEMAIL'];

// What is the request state?
$isLoginRequest = isset($_REQUEST['ap_mac']);
$isLoginError = isset($_REQUEST['error_message']);
$isLoggedIn = isset($_COOKIE['LogoutURL']);

// Lets get the values from the query parameters
$data = array();
$email = "";
$firstname = "";
$lastname = "";

$month = date('m');
$day = date('d');
$year = date('Y');
$birthdate = $year . '-' . $month . '-' . $day;

$gender = "X";
$zipcode = "";
$checkbox1 = "";
$checkbox2 = "";
$checkbox3 = "";

// Location of the splash
$data['rootUrl'] = "https://" . $_SERVER['SERVER_NAME'] . "/hotspot";

if ($isLoginRequest) {
    // URLs
    $data['loginUrl'] = urldecode($_REQUEST['login_url']);
    $data['nextUrl'] = urldecode($_REQUEST['continue']);

    // Access Point Info
    $data['ap']['mac'] = $_REQUEST['ap_mac'];
    $data['ap']['name'] = $_REQUEST['ap_name'];
    $data['ap']['tags'] = explode(" ", $_REQUEST['ap_tags']);
    $spot_id = $data['ap']['tags'][0];
    $sensorname = $data['ap']['tags'][1];
    $hotspot_name = 'eSmartIT';

    // Client Info
    $data['client']['mac'] = $_REQUEST['client_mac'];
    $data['client']['ip'] = $_REQUEST['client_ip'];
}

if ($isLoginError) {
    // Error Message
    $data['errorMessage'] = $_REQUEST['error_message'] . " " . $data['errorPhone'] ;
}

if ($isLoggedIn) {
    // Get the logout URL from the cookie
    $data['logoutUrl'] = urldecode($_COOKIE['LogoutURL']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo $title;?></title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="css/landing-page.css" rel="stylesheet">
    <!-- Custom Fonts -->
    <!-- <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css"> -->
    <script type="text/javascript" src="js/jquery-2.1.0.min.js"></script>
    <script type="text/javascript" src="js/jquery.js"></script>
    <!-- <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css"> -->

</head>
<body>
<div class="container body">
    <div class="main_container">
        <div class="right_col" role="main">
            <div class="">
                <div class="clearfix"></div>

                <div class="row">

                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="x_panel">
                            <div class="x_title">
                                <div class="x_content">
                                    <form id="login_form" class="form-signin" role="form" method="POST" enctype="multipart/form-data">
                                        <?php if ($isLoginRequest) { ?>
                                            <h2 class="form-signin-heading">Demo eSmartIT</h2>
                                            <h4><?= $hotspot_name; ?></h4>

                                            <div id="errorPhone" class="alert alert-danger"></div>
                                            <?php if ($isLoginError) { ?>
                                                <div id="errorPhone" class="alert alert-danger"><?= $data['errorMessage'] ?></div>
                                            <?php } ?>

                                            <input type="hidden" id="hotspotmac" name="hotspotmac" value="<?= $data['ap']['name'];?>">
                                            <input type="hidden" id="hotspot_name" name="hotspot_name" value="<?php echo $hotspot_name;?>">
                                            <input type="hidden" id="spot_id" name="spot_id" value="<?php echo $spot_id;?>">
                                            <input type="hidden" id="loginUrl" name="loginUrl" value="<?= $data['loginUrl'];?>">

                                            <input type="hidden" id="username" name="username" class="form-control" value="<?= $_REQUEST['username'] ?>">
                                            <input type="hidden" id="password" name="password" class="form-control">

                                            <div class="form-group">
                                                <div class="col-md-6 col-sm-6 col-xs-3"></div>
                                                <label class="control-label col-md-3 col-sm-3 col-xs-3"><?php echo $l_idioma;?></label>
                                                <div class="col-md-3 col-sm-3 col-xs-6">
                                                    <select name="lang" class="form-control">
                                                        <option value="<?php echo $lang;?>" selected="selected"><?php echo $l_language;?></option>
                                                        <option value="es">Espa&ntilde;ol</option>
                                                        <option value="en">English</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <p>&nbsp;</p>
                                            <div class="form-group">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-2"><?php echo $l_mobilephone;?></label>
                                                <div class="col-md-3 col-sm-3 col-xs-4">
                                                    <select id="selCountryCode" name="countrycode" class="form-control">
                                                        <option value=<?php echo $countrycode;?> selected=<?php echo $selected;?>></option>

                                                        <?php

                                                        include('library/opendb.php');
                                                        $sqlcode = "SELECT country_phone_code, country_code_ISO3 FROM ".$configValues['TBL_RWCOUNTRY']." ".
                                                            "WHERE flag = 1 ORDER BY country_phone_code";
                                                        $retcode = pg_query($dbConnect, $sqlcode);

                                                        while ($rowcode = pg_fetch_row($retcode)) {
                                                            $row_country = $rowcode[0];
                                                            $selected = '';
                                                            if ($countrycode == $rowcode[1]) $selected = 'selected = $countrycode';
                                                            echo "<option value=$rowcode[1] $selected>$row_country</option>";
                                                            include('library/closedb.php');
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-3 col-sm-3 col-xs-6">
                                                    <input type="text" id="mobilephone" name="mobilephone" required autofocus class="form-control col-md-9 col-xs-6">
                                                </div>
                                            </div>

                                            <p>&nbsp;</p>
                                            <fieldset id="register">

                                                <div class="form-group">
                                                    <label class="control-label col-md-9 col-sm-9 col-xs-6"><?php echo $l_pin;?><span class="required">*</span></label>
                                                    <div class="col-md-9 col-sm-6 col-xs-6">
                                                        <input type="text" id="pin" name="pin" onblur="validPin()" required class="form-control col-md-9 col-xs-6">
                                                    </div>
                                                    <div id='resultPin' class="alert alert-danger"></div>
                                                </div>
                                                </br>
                                                <div class="form-group">
                                                    <label class="control-label col-md-9 col-sm-9 col-xs-6"><?php echo $l_email;?><span class="required">*</span></label>
                                                    <div class="col-md-9 col-sm-6 col-xs-6">
                                                        <input type="text" id="email_cli" name="email_cli" onblur="validate()" required class="form-control col-md-9 col-xs-6">
                                                    </div>
                                                    <div id='resultEmail' class="alert alert-danger"></div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="control-label col-md-9 col-sm-9 col-xs-6"><?php echo $l_firstname;?><span class="required">*</span></label>
                                                    <div class="col-md-9 col-sm-6 col-xs-6">
                                                        <input type="text" id="firstname" name="firstname" required class="form-control col-md-9 col-xs-6">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-9 col-sm-9 col-xs-6"><?php echo $l_lastname;?></label>
                                                    <div class="col-md-9 col-sm-6 col-xs-6">
                                                        <input type="text" id="lastname" name="lastname" class="form-control col-md-9 col-xs-6">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-9 col-sm-9 col-xs-6"><?php echo $l_birthdate;?></label>
                                                    <div class="col-md-9 col-sm-6 col-xs-6">
                                                        <input type="date" name="bdate" id="bdate" class="form-control" value="<?php echo $birthdate;?>">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-9 col-sm-9 col-xs-6"><?php echo $l_gender?></label>
                                                    <div class="col-md-9 col-sm-6 col-xs-6">
                                                        <select id="gender" name="gender" class="form-control">
                                                            <option value="H"><?php echo $l_man;?></option>
                                                            <option value="M"><?php echo $l_woman;?></option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-9 col-sm-9 col-xs-6"><?php echo $l_zipcode;?></label>
                                                    <div class="col-md-9 col-sm-6 col-xs-6">
                                                        <input type="text" id="zipcode" name="zipcode" class="form-control col-md-9 col-xs-6">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-md-6 col-sm-6 col-xs-6 form-group">
                                                        <input type="checkbox" class="form-control" id="checkbox1" name="checkbox1" required value="check">
                                                    </div>
                                                    <div class="col-md-6 col-sm-6 col-xs-6 form-group">
                                                        <a href="terminos_condiciones.pdf"><?php echo $l_termsconditions1;?></a>
                                                    </div>
                                                </div>
                                            </fieldset>

                                            <div class="clearfix"></div>
                                            <div class="form-group">
                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                    <button id="btnlogin" type="submit" name="btnlogin" class="btn btn-lg btn-primary btn-block" value="submitLog"><?php echo $l_login;?></button>
                                                    <button id="btnregister" type="submit" name="btnregister" class="btn btn-lg btn-primary btn-block" value="submitReg"><?php echo $l_regisbutton;?></button>
                                                </div>
                                            </div>
                                            <p>&nbsp;</p>

                                        <?php } else  if ($isLoggedIn) { ?>
                                            <div class="alert alert-info"> <?php echo $l_logged_in;?> <a href="/logout.php">Logout</a></div>
                                        <?php } else { ?>
                                            <div class="alert alert-danger"><?php echo $l_something_wrong;?></div>
                                        <?php } ?>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <!-- <script src="js/jquery.js"></script> -->

    <!-- Bootstrap Core JavaScript -->
    <!-- <script src="js/bootstrap.min.js"></script> -->

    <script>
        $( window ).load(function() {
            hide();
            document.getElementById("errorPhone").style.display = 'none';
        });
    </script>

    <script>
        function show(){
            document.getElementById("selCountryCode").disabled = true;
            document.getElementById("mobilephone").disabled = true;
            document.getElementById("register").style.display = 'block';
            document.getElementById("pin").disabled = false;
            document.getElementById("email_cli").disabled = false;
            document.getElementById("firstname").disabled = false;
            document.getElementById("checkbox1").disabled = false;
            document.getElementById("btnlogin").style.display = 'none';
            document.getElementById("btnregister").style.display = 'block';
        }

        function hide(){
            document.getElementById("selCountryCode").disabled = false;
            document.getElementById("mobilephone").disabled = false;
            document.getElementById("register").style.display = 'none';
            document.getElementById("pin").disabled = true;
            document.getElementById("email_cli").disabled = true;
            document.getElementById("firstname").disabled = true;
            document.getElementById("checkbox1").disabled = true;
            document.getElementById("btnlogin").style.display = 'block';
            document.getElementById("btnregister").style.display = 'none';
        }
    </script>

    <script>
        $(function () {
            $("#login_form button").click(function (ev) {
                ev.preventDefault() // cancel form submission
                if ($(this).attr("value") == "submitLog") {
                    validUser();
                }
                if ($(this).attr("value") == "submitReg") {
                    registerUser();
                }
            });
        });
    </script>


    <script>
        function validUser() {
            var formStr = $('#login_form').serialize();
            $.ajax({
                url: 'validUser.php',
                type: 'POST',
                data: formStr,
                dataType: 'json',
                success:function(response) {

                    console.log(response);
                    var object = response[0];
                    var section = object['section'];
                    var data = object['data'];
                    var user = $("#selCountryCode").val()+$("#mobilephone").val();
                    var loginUrl = $("#loginUrl").val();

                    if (section == "error") {
                        $("#errorPhone").text(data);
                        document.getElementById("errorPhone").style.display = 'block';
                    } else {
                        setUser(user, data);
                        if (section == "go") {
                            document.getElementById("login_form").action = loginUrl;
                            document.getElementById("login_form").submit();
                        } else {
                            document.getElementById("errorPhone").style.display = 'none';
                            alert('<?php echo $l_pin3;?>'+': '+data);
                            show();
                        }
                    }
                }
            });
        }
    </script>

    <script>
        function registerUser() {
            document.getElementById("selCountryCode").disabled = false;
            document.getElementById("mobilephone").disabled = false;
            var formStr = $('#login_form').serialize();
            $.ajax({
                url: 'registerUser.php',
                type: 'POST',
                data: formStr,
                dataType: 'json',
                success:function(response) {

                    console.log(response);
                    var object = response[0];
                    var section = object['section'];
                    var data = object['data'];
                    var user = $("#selCountryCode").val()+$("#mobilephone").val();
                    var loginUrl = $("#loginUrl").val();

                    if (section == "error") {
                        $("#errorPhone").text(data);
                        document.getElementById("errorPhone").style.display = 'block';
                    } else {
                        setUser(user, data);
                        if (section == "go") {
                            document.getElementById("login_form").action = loginUrl;
                            document.getElementById("login_form").submit();
                        }
                    }
                }
            });
        }
    </script>

    <script>
        function setUser(username, password) {
            $('input[name=username]').val(username);
            $('input[name=password]').val(password);
        }
    </script>

    <script>
        function validPin(){
            var vpin = $("#pin").val();;
            var vpass = $("#password").val();;
            var result = $("#errorPhone");
            result.text("");

            document.getElementById("errorPhone").style.display = 'none';
            if (vpin != vpass) {
                result.text("<?php echo $errorPin;?>");
                document.getElementById("errorPhone").style.display = 'block';

                document.getElementById("pin").focus();
                return false;
            }
        }
    </script>

    <script>
        function validateEmail(email) {
            var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return re.test(email);
        }

        function validate() {
            var result = $("#errorPhone");
            var email = $("#email_cli").val();
            result.text("");

            document.getElementById("errorPhone").style.display = 'none';
            if (!validateEmail(email)) {
                result.text("<?php echo $errorEmail;?>");
                document.getElementById("errorPhone").style.display = 'block';

                document.getElementById("email_cli").focus();
                return false;
            }
        }
    </script>

</div>
<!-- footer content -->
<div class="clearfix"></div>
<footer>
    <div class="pull-right">
        <?php echo $l_footer2;?>
    </div>
    <div class="clearfix"></div>
</footer>
<!-- /footer content -->
</body>
</html>
