<?php
require_once "./connection.php";
if (isset($_GET["vkey"])) {
    $vkey = $_GET['vkey'];
    $sql = "UPDATE `korisnik` SET `verifikovano`=1 WHERE `vkey`='" . $vkey . "'";
    if ($mysqli->query($sql)) {
        echo "Email adresa je uspjesno verifikovana\n";
        echo "<a href='http://localhost/project/index.php'>Pocetna stranica</a>";
    }
} else {
    echo "Greska";
}
