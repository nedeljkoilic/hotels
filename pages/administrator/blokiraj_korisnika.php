<?php
require_once "../../connection.php";
if (isset($_GET['korisnik'])) {
    $id_kor = $_GET['korisnik'];
    $sql = "UPDATE `korisnik` SET `BLOKIRAN` = '1' WHERE `korisnik`.`ID_KORISNIK` = " . $id_kor . ";";
    $mysqli->query($sql);
    header("Location: ./administrator.php");
    exit();
}
if (isset($_GET['odobreno']) && isset($_GET['id_menadzera'])) {
    if ($_GET['odobreno'] == '1') {
        $sql = "UPDATE `menadzer` SET `odobreno` = '1' WHERE `menadzer`.`ID_MENADZER` = " . $_GET['id_menadzera'];
    } else {
        $sql1 = "DELETE FROM `menadzeri_hotela` WHERE  `menadzeri_hotela`.`ID_MENADZER` = " . $_GET['id_menadzera'];
        $sql = "DELETE FROM `menadzer` WHERE `menadzer`.`ID_MENADZER` = " . $_GET['id_menadzera'];
        $mysqli->query($sql1);
    }
    $mysqli->query($sql);
    header("Location: ./administrator.php");
    exit();
}
