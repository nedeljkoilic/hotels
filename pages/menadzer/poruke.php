<?php
require_once "../../connection.php";
if (isset($_GET["id_korisnika"]) && isset($_GET["id_menadzera"])) {
    $id_korisnika = $_GET["id_korisnika"];
    $id_menadzera = $_GET["id_menadzera"];

    $sql = "SELECT * FROM poruke p JOIN korisnik k on p.ID_KORISNIK=k.ID_KORISNIK WHERE p.ID_KORISNIK=" . $id_korisnika . " and p.id_menadzer=" . $id_menadzera . ";";
    if ($result = $mysqli->query($sql)) {
        while ($row = $result->fetch_row()) {
            $id_poruke = $row[0];
            $poruka = $row[4];
            $datum = $row[5];
            $vrijeme = $row[6];
            $poslao_korisnik = $row[7];
            $procitano = $row[8];
            $ime_korisnika = $row[10];
            $prezime_korisnika = $row[11];
            if ($poslao_korisnik) {

                echo '<label style="margin-left:5%;margin-bottom: 0;margin-top: 2%;">' . $ime_korisnika . " " . $prezime_korisnika . '</label><div class="container " style="text-align: end; background-color: slategrey;border-radius: 45px;margin-top: 0;margin-right: 27%;margin-left: 3%;width: 70%;;text-align: center; ">
                            <p>' . $poruka . '</p>
                            <span class="time-right" style="margin-bottom:2%;">' . $datum . "   " . $vrijeme . '</span>
                          </div>';
                if (!$procitano) {
                    $sql1 = "UPDATE `poruke` SET `procitano` = '1' WHERE `poruke`.`ID_PORUKE` =" . $id_poruke;
                    if (mysqli_query($mysqli, $sql1)) {
                    } else {
                        echo "Error updating record: " . mysqli_error($conn);
                    }
                }
            } else {
                echo '<label style="margin-left: 29%;margin-bottom: 0;margin-top: 2%;">Ja</label><div class="container darker" style="background: cadetblue;border-radius: 45px;text-align: center;margin-top: 0;margin-right: 3%;margin-left: 27%;width: 70%;">
      <p>' . $poruka . '</p>
      <span class="time-left" style="margin-bottom:2%;">' . $datum . "   " . $vrijeme . '</span>
    </div>';
            }

        }

    }
}
if (isset($_GET["id_korisnika"]) && isset($_GET["id_menadzera"]) && isset($_GET["tekst_poruke"])) {
    $id_korisnika = $_GET["id_korisnika"];
    $id_menadzera = $_GET["id_menadzera"];
    $tekst_poruke = $_GET["tekst_poruke"];
    $sql = "SELECT MAX(ID_PORUKE) FROM `poruke` WHERE 1;";
    $result = $mysqli->query($sql);
    $row = $result->fetch_row();
    $max_id = $row[0];
    $max_id++;
    $datum = date("Y-m-d");
    $vrijeme = date("h:i:sa");
    $sql = "INSERT INTO `poruke`(`ID_PORUKE`, `ID_HOTEL`, `ID_KORISNIK`, `id_menadzer`, `TEKST_PORUKE`, `datum`, `vrijeme`, `poslao_korisnik`, `procitano`) VALUES (" . $max_id . ",1," . $id_korisnika . "," . $id_menadzera . ",'" . $tekst_poruke . "','" . $datum . "','" . $vrijeme . "',0,0)";
    $mysqli->query($sql);

}
