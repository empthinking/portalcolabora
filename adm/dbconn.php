<?php

$serverName = "127.0.0.1";
$dBUsername = "u871226378_colabora";
$dBPassword = "F7k|MYhYf>";
$dBName = "u871226378_portalcolabora";

$conn = mysqli_connect($serverName, $dBUsername, $dBPassword, $dBName, 3306);

if (!$conn)
{
    die("Connection failed: ". mysqli_connect_error());
}
