<?php
require_once 'constants.php';

$mysqli = new mysqli(HOST, NAME, PASSWORD, DATABASE);

if($mysqli->connect_error)
    exit('Falha na conexão');
