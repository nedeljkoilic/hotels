<?php
session_start();
require_once "./connection.php";
$message = $od = $do = $ime = $prezime = $tel = $tip_sobe = $hotel = "";
$curent_date = date("Y-m-d");
if (isset($_GET['brzaRezervacija'])) {
    $od = $_GET["dolazak"];
    $do = $_GET["odlazak"];
    $tip_sobe = $_GET["tipSobe"];
    $hotel = $_GET["hotel"];
    $ime = $_GET["ime"];
    $prezime = $_GET["prezime"];
    $tel = $_GET["tel"];
    if (!preg_match("/^[a-zA-Z]*$/", $ime)) {
        header("Location: http://localhost/project/index.php?greska=ime");
        exit();
    } elseif (!preg_match("/^[a-zA-Z]*$/", $prezime)) {
        header("Location: http://localhost/project/index.php?greska=prezime");
        exit();
    } elseif (!is_numeric($tel)) {
        header("Location: http://localhost/project/index.php?greska=tel");
        exit();
    } elseif ($curent_date > $od || $od > $do) {
        header("Location: http://localhost/project/index.php?greska=datum");
        exit();
    } else {

        $dan = $od;

        $sql = "SELECT * FROM `rezervacija` r WHERE r.ID_HOTEL=" . $hotel . " AND r.ID_TIP_SOBE=" . $tip_sobe;

        $sql1 = "SELECT bst.KOLICINA FROM `broj_soba_po_tipu` bst WHERE bst.ID_HOTEL=" . $hotel . " AND bst.ID_TIP_SOBE=" . $tip_sobe;
        $result = $mysqli->query($sql1);
        $row = $result->fetch_row();
        $dostupni_kapacitet = $row[0];
        $brojac_po_danu = 0;
        $br_dana = 0;
        while (strval($dan) != strval($do)) {
            $result = $mysqli->query($sql);
            while ($row = $result->fetch_row()) {
                $baza_od = $row[4];
                $baza_do = $row[5];

                if ($dan > $baza_od && $dan <= $baza_do) {
                    $brojac_po_danu++;
                    if ($brojac_po_danu == 10) {
                        header("Location: http://localhost/project/index.php?greska=kapacitet");
                        exit();
                    }
                }

            }
            $br_dana++;
            $brojac_po_danu = 0;
            $dan = strtotime("+1 day", strtotime($dan));
            $dan = date("Y-m-d", $dan);
        }
        $sql_get_max_id_korisnik = "SELECT MAX(k.ID_KORISNIK) FROM `korisnik` k;";
        $sql_get_max_id_rezervacija = "SELECT MAX(r.ID_REZERVACIJA) FROM `rezervacija` r";

        $result = $mysqli->query($sql_get_max_id_korisnik);
        $row = $result->fetch_row();
        $id_novi_korisnik = $row[0] + 1;

        $result = $mysqli->query($sql_get_max_id_rezervacija);
        $row = $result->fetch_row();
        $id_nova_rezervacija = $row[0] + 1;

        $sql_insert_korisnik = "INSERT INTO `korisnik` (`ID_KORISNIK`, `IME`, `PREZIME`, `BR_TEL`, `EMAIL`, `sifra`, `REGISTROVAN`, `BLOKIRAN`) VALUES (" . $id_novi_korisnik . ", '" . $ime . "', '" . $prezime . "', '" . $tel . "', NULL, NULL, '0', '0');";

        $sql_insert_rezervacija = "INSERT INTO `rezervacija`(`ID_REZERVACIJA`, `ID_HOTEL`, `ID_TIP_SOBE`, `ID_KORISNIK`, `OD`, `DO`) VALUES (" . $id_nova_rezervacija . "," . $hotel . "," . $tip_sobe . "," . $id_novi_korisnik . ",'" . $od . "','" . $do . "')";

        $sql_cijena = "SELECT h.DNEVNA_CIJENA FROM `hotel` h WHERE h.ID_HOTEL=" . $hotel;
        $result = $mysqli->query($sql_cijena);
        $row = $result->fetch_row();
        $cijena = $row[0];

        $sql_koef = "SELECT ts.koeficijent FROM `tip_sobe` ts WHERE ts.ID_TIP_SOBE=" . $tip_sobe;
        $result = $mysqli->query($sql_koef);
        $row = $result->fetch_row();
        $koef = $row[0];
        $ukupna_cijena = $br_dana * $cijena * $koef;

        $mysqli->query($sql_insert_korisnik);
        $mysqli->query($sql_insert_rezervacija);

        header("Location: http://localhost/project/index.php?greska=success&cijena=" . $ukupna_cijena);

    }

}
if (isset($_POST['submit_prijava'])) {
    $email = $_POST['email'];
    $pwd = $_POST['pwd'];

    $sql = "SELECT email, sifra, blokiran, verifikovano FROM `korisnik`";
    if ($result = $mysqli->query($sql)) {
        while ($row = $result->fetch_row()) {

            if ($row[0] == $email && $row[1] == $pwd) {
                if ($row[2]) {
                    header("Location: http://localhost/project/index.php?greskaLogin=blokiran");
                    exit();
                } elseif (!$row[3]) {
                    header("Location: http://localhost/project/index.php?greskaLogin=verifikacija");
                    exit();
                }
                header("Location: ./pages/gost/korisnik.php");
                $_SESSION['email'] = $email;
                exit();
            }
        }

    }
    $sql = "SELECT email, sifra, odobreno FROM `menadzer`";
    if ($result = $mysqli->query($sql)) {
        while ($row = $result->fetch_row()) {

            if ($row[0] == $email && $row[1] == $pwd) {
                if (!$row[2]) {
                    header("Location: http://localhost/project/index.php?greskaLogin=odobreno");
                    exit();
                }
                header("Location: http://localhost/project/pages/menadzer/menadzer.php");
                $_SESSION['emailMenadzer'] = $email;
                exit();
            }
        }

    }
    $sql = "SELECT email, sifra FROM `administrator`";
    if ($result = $mysqli->query($sql)) {
        while ($row = $result->fetch_row()) {

            if ($row[0] == $email && $row[1] == $pwd) {
                header("Location: http://localhost/project/pages/administrator/administrator.php");
                $_SESSION['emailAdministrator'] = $email;
                exit();
            }
        }

    }
    header("Location: http://localhost/project/index.php?greskaLogin=notFound");

}
if (isset($_POST['submit_registracija'])) {

    $vrsta_naloga = $_POST['vrsta_naloga'];
    if (isset($_POST['hotel_menadzer'])) {
        $hotel_menadzer = $_POST['hotel_menadzer'];
    } else {
        $hotel_menadzer = "false";
    }

    $prezime = $_POST['prezime'];
    $ime = $_POST['ime'];
    $email = $_POST['email'];
    $pwd = $_POST['pwd'];
    $tel = $_POST['tel'];
    $sql = "SELECT * FROM `korisnik` WHERE email='$email'";
    if ($result = $mysqli->query($sql)) {

        $data = $result->fetch_all();
        if ($data) {
            header("Location: http://localhost/project/index.php?greskaSign=email");
            exit();
        } elseif (!preg_match("/^[a-zA-Z]*$/", $ime)) {
            header("Location: http://localhost/project/index.php?greskaSign=ime");
            exit();
        } elseif (!preg_match("/^[a-zA-Z]*$/", $prezime)) {
            header("Location: http://localhost/project/index.php?greskaSign=prezime");
            exit();
        } elseif (!is_numeric($tel)) {
            header("Location: http://localhost/project/index.php?greskaSign=tel");
            exit();
        }
    }
    $sql = "SELECT ID_KORISNIK FROM `korisnik` ORDER BY ID_KORISNIK DESC;";
    $result = $mysqli->query($sql);
    $row = $result->fetch_row();
    $max_id_korisnik = $row[0];

    $sql = "SELECT ID_MENADZER FROM `menadzer` ORDER BY ID_MENADZER DESC;";
    $result = $mysqli->query($sql);
    $row = $result->fetch_row();
    $max_id_menadzer = $row[0];
    $vkey = md5(time() . $email);
    if ($vrsta_naloga == 1) {

        $sql = "INSERT INTO `korisnik`(`ID_KORISNIK`, `IME`, `PREZIME`, `BR_TEL`, `EMAIL`, `sifra`, `REGISTROVAN`, `BLOKIRAN`, `vkey`, `verifikovano`) VALUES (" . ($max_id_korisnik + 1) . ",'" . $ime . "','" . $prezime . "','" . $tel . "','" . $email . "','" . $pwd . "',1,0,'" . $vkey . "',0)";
        $mysqli->query($sql);

        $receiver = $email;
        $subject = "Verifikacija Email-a";
        $body = "Kliknite na link ispod za registraciju\n\n http://localhost/project/verifikacija.php?vkey=$vkey";
        $sender = "From:Menadzment hotela King";
        mail($receiver, $subject, $body, $sender);

    } else {

        $sql = "INSERT INTO `menadzer`(`ID_MENADZER`, `IME`, `PREZIME`, `BR_TEL`, `EMAIL`, `sifra`, `odobreno`) VALUES (" . ($max_id_menadzer + 1) . ",'" . $ime . "','" . $prezime . "','" . $tel . "','" . $email . "','" . $pwd . "',0)";
        $sql1 = "INSERT INTO `menadzeri_hotela`(`ID_HOTEL`, `ID_MENADZER`) VALUES (" . $hotel_menadzer . "," . ($max_id_menadzer + 1) . ")";
        $mysqli->query($sql);
        $mysqli->query($sql1);
    }

    header("Location: http://localhost/project/index.php?greskaSign=success");
}
