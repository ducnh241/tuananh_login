<?php
session_start();
include "config.php";
// session_destroy();
if (!isset($_SESSION['username'])) {
    header("Location:login.php");
}

include "data/template.html";
?>

