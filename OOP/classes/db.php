<?php
require_once 'constants.php';

$mysqli = new mysqli(HOST, USER, PASSWORD, DATABASE);

if($mysqli->connect_error)
    exit('Falha na conexão');
