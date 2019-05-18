<?php
session_start();
include "config.php";
include "includes/validate.php";
// session_destroy();
if (!isset($_SESSION['username'])) {
    header("Location:login.php");
}

include "data/" . LICENSE . ".txt";
?>

