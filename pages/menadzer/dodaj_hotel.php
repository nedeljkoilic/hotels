<?php
require_once "../../connection.php";

if (isset($_GET["id_menadzera"]) && isset($_GET["id_dodatog_hotela"]) ) {
    $sql = "INSERT INTO `menadzeri_hotela`(`ID_HOTEL`, `ID_MENADZER`) VALUES (".$_GET["id_dodatog_hotela"].",".$_GET["id_menadzera"].")";
    $mysqli-> query($sql);
    header("Location: http://localhost/project/pages/menadzer/menadzer.php");
    exit();
}