<?php

//Define your host here.
$HostName = "localhost";
$DatabaseName = "db_admin";
$HostUser = "root";
$HostPass = '';

$conexion = mysqli_connect($HostName, $HostUser, $HostPass, $DatabaseName);

mysqli_set_charset($conexion, "utf8");
