<?php

//Define your host here.
$HostName = "remotemysql.com";
$DatabaseName = "ynTEBiVJVS";
$HostUser = "ynTEBiVJVS";
$HostPass = 'KCoj2kUYrl';

$conexion = mysqli_connect($HostName, $HostUser, $HostPass, $DatabaseName);

mysqli_set_charset($conexion, "utf8");
