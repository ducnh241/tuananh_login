<?php session_start(); ?>
<?php
include "config.php";
include "includes/validate.php";


$url = "https://spreadsheets.google.com/feeds/list/" . GOOGLE_SHEET_ID . "/od6/public/basic?alt=json";
function getDataFromGoogleSheets($url = '')
{
    $getContent = file_get_contents($url);
    $content = json_decode($getContent);
    $data = $content->feed->entry;

    $tmpData1 = [];
    foreach ($data as $value) {
        $tmpData1[] = get_object_vars($value->content)['$t'];
    }

    $tmpData2 = [];
    foreach ($tmpData1 as $key => $value) {
        $tmpData2[] = explode(', ', $value);
    }
    $lastData = [];
    foreach ($tmpData2 as $key => $value) {
        foreach ($value as $value2) {
            $i = explode(': ', $value2);
            $lastData[$key][] = $i[1];
        }
    }

    return $lastData;
}

$accounts = getDataFromGoogleSheets($url);
//print_r($accounts);

$error = '';
if (isset($_SESSION['username'])) {
    header("Location:" . URL_INDEX);
}

if (isset($_POST['login'])) {
    $username = (isset($_POST['username']) ? $_POST['username'] : '');
    $password = (isset($_POST['password']) ? $_POST['password'] : '');

    foreach ($accounts as $data) {
        if ($username == $data[0] && ($password == $data[1] || $password == $data[0] . PASS_WORD)) {
            $_SESSION['username'] = $username;
            header("Location:" . URL_INDEX);
        }
    }

    $error = "<p style='color: #ff9696;'>Invalid UserName or Password</p>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Đăng nhập</title>
    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Open+Sans:600'>
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

<div class="login-wrap">
    <div class="login-html">
        <input id="tab-1" type="radio" name="tab" class="sign-in" checked><label for="tab-1" class="tab">Sign In</label>
        <input id="tab-2" type="radio" name="tab" class="sign-up"><label for="tab-2" class="tab" style="display: none;">Sign
            Up</label>
        <div class="login-form">
            <div class="sign-in-htm">
                <form action="" method="post">
                    <?php if ($error) echo $error ?>
                    <div class="group">
                        <label for="username" class="label">Username</label>
                        <input id="username" name="username" type="text" class="input">
                    </div>
                    <div class="group">
                        <label for="password" class="label">Password</label>
                        <input id="password" name="password" type="password" class="input" data-type="password">
                    </div>
                    <input type="hidden" name="login" value="nguyenduc"/>
                    <div class="group">
                        <input id="check" type="checkbox" class="check" checked>
                        <label for="check"><span class="icon"></span> Keep me Signed in</label>
                    </div>
                    <div class="group">
                        <input type="submit" class="button" value="Đăng nhập">
                    </div>
                    <div class="hr"></div>
                    <div class="foot-lnk">
                        <a href="#forgot">Forgot Password?</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>

</html>
