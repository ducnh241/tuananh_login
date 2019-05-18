<?php

$server_name = $_SERVER['SERVER_NAME'];
$license = file_get_contents('license.dat');

if ($license) {
    if (md5(md5($server_name)) == $license){
        //continue
    }else{
        die('Not permission');
    }
} else {
    die('Not permission');
}