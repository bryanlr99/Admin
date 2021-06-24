<?php

//Define your host here.
$HostName = "byvy7ymxwe3qqrkixqxa-mysql.services.clever-cloud.com";
$DatabaseName = "byvy7ymxwe3qqrkixqxa";
$HostUser = "uwjgvncqzgkbvoiv";
$HostPass = 'uwjgvncqzgkbvoiv';

$conexion = mysqli_connect($HostName, $HostUser, $HostPass, $DatabaseName);

mysqli_set_charset($conexion, "utf8");
