<?php

//Define your host here.
$HostName = "sql10.freesqldatabase.com";
$DatabaseName = "sql10419797";
$HostUser = "sql10419797";
$HostPass = 'YEHh27ieuL';

$conexion = mysqli_connect($HostName, $HostUser, $HostPass, $DatabaseName);

mysqli_set_charset($conexion, "utf8");
