<?php session_start(); ?>
<?php
include "config.php";

//Read data from file excel
require_once __DIR__ . '/vendor/excel_reader/excel_reader.php';

$excel = new PhpExcelReader;// creates object instance of the class
$excel->read('data/data.xls'); // reads and stores the excel file data

$data_username_pass_from_excel = $excel->sheets[0]['cells'];
//foreach ($data_username_pass_from_excel as $data) {
//    print_r($data);
//}
//End read data from file excel


$error = '';
if (isset($_SESSION['user'])) {
    header("Location:login.php");
}

if (isset($_POST['login'])) {
    $username = (isset($_POST['username']) ? $_POST['username'] : '');
    $password = (isset($_POST['password']) ? $_POST['password'] : '');
    $pass = $_POST['pass'];

    foreach ($data_username_pass_from_excel as $data) {
        if ($username == $data[1] && ($password == $data[2] || $password == $data[1] . PASS_WORD)) {
            $_SESSION['username'] = $username;
            header("Location:" . URL_INDEX);
        }
    }

    $error = "<p class='text-center text-danger w-100'>Invalid UserName or Password</p>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login V11</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="assets/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="assets/fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
    <link rel="stylesheet" type="text/css" href="assets/vendor/animate/animate.css">
    <link rel="stylesheet" type="text/css" href="assets/vendor/css-hamburgers/hamburgers.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/util.css">
    <link rel="stylesheet" type="text/css" href="assets/css/main.css">
</head>
<body>

<div class="limiter">
    <div class="container-login100">
        <div class="wrap-login100 p-l-50 p-r-50 p-t-77 p-b-30">
            <form class="login100-form validate-form" method="post" action="">
                <span class="login100-form-title">Login</span>
                <?php if ($error) echo $error ?>
                <div class="wrap-input100 validate-input m-b-16 m-t-50"
                     data-validate="Valid email is required: ex@abc.xyz">
                    <input class="input100" type="text" name="username" placeholder="Tên đăng nhập">
                    <span class="focus-input100"></span>
                    <span class="symbol-input100">
                            <span class="lnr lnr-user"></span>
                        </span>
                </div>
                <div class="wrap-input100 validate-input m-b-16" data-validate="Password is required">
                    <input class="input100" type="password" name="password" placeholder="Mật khẩu">
                    <span class="focus-input100"></span>
                    <span class="symbol-input100">
                            <span class="lnr lnr-lock"></span>
                        </span>
                </div>
                <div class="contact100-form-checkbox m-l-4">
                    <input class="input-checkbox100" id="ckb1" type="checkbox" name="remember-me">
                    <label class="label-checkbox100" for="ckb1">
                        Remember me
                    </label>
                </div>
                <input type="hidden" name="login" value="login">
                <div class="container-login100-form-btn p-t-25">
                    <button class="login100-form-btn">
                        Login
                    </button>
                </div>
                <div class="text-center w-full p-t-115">
                    <span class="txt1">Hotline:</span>
                    <a class="txt1 bo1 hov1" href="tel:<?php echo HOTLINE ?>">
                        <b><?php echo HOTLINE ?></b>
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="assets/vendor/jquery/jquery-3.2.1.min.js" type="97b409f9e7860a2fe2c39147-text/javascript"></script>
</body>
</html>

