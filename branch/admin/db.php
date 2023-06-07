<?php

$serverName = "127.0.0.1";
$dBUsername = "u871226378_admin";
$dBPassword = "Xq*4^5^1";
$dBName = "u871226378_Colabora";

$conn = mysqli_connect($serverName, $dBUsername, $dBPassword, $dBName, 3306);

if (!$conn)
{
    die("Connection failed: ". mysqli_connect_error());
}


