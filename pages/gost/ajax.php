<?php
require_once "../../connection.php";
session_start();
//provjera da li su setovani podaci za pretragu hotela
if (isset($_GET['br_osoba']) || isset($_GET['grad_drzava']) || isset($_GET['broj_zvjezdica']) || isset($_GET['dnevna_cijena']) || isset($_GET['wifi']) || isset($_GET['parking']) || isset($_GET['dorucak'])) {
    /*$sql="SELECT h.naziv as hotel,h.opis as opis,h.slika as slika, h.adrresa as adresa,h.br_zvjezdica,
    h.dnevna_cijena,g.naziv as grad FROM `hotel` h JOIN grad g ON h.id_grad=g.ID_GRAD where
    g.ID_GRAD=".$grad_drzava." and h.br_zvjezdica=".$broj_zvjezdica." and DNEVNA_CIJENA ".$cijena.
    " and PARKING=".$parking." and INTERNET=".$wifi." and DORUCAK=".$dorucak;*/
    $sql = "SELECT h.naziv as hotel,h.PARKING as parking_izabr,h.INTERNET as wifi_izabr,h.DORUCAK as dorucak_izabr,h.ID_HOTEL as id_hotela,h.opis as opis,h.slika as slika, h.adrresa as adresa,h.br_zvjezdica,h.dnevna_cijena,g.naziv as grad FROM `hotel` h JOIN grad g ON h.id_grad=g.ID_GRAD where ";
    /*if(isset($_GET['br_osoba']))
    {
    $br_osoba=$_GET['br_osoba'];
    $sgl=$sql."";
    }*/
    if (isset($_GET['grad_drzava'])) {
        $grad_drzava = $_GET['grad_drzava'];
        $sql = $sql . "g.ID_GRAD=" . $grad_drzava;
    }
    if (isset($_GET['broj_zvjezdica'])) {
        $broj_zvjezdica = $_GET['broj_zvjezdica'];
        $sql = $sql . " and h.br_zvjezdica=" . $broj_zvjezdica;
    }

    if (isset($_GET['wifi'])) {
        if ($_GET['wifi'] == 'true') {
            $wifi = $_GET['wifi'];
            $sql = $sql . " and INTERNET=" . $wifi;
        }

        // $_SESSION['wifi']= $_GET['wifi'];

    }

    if (isset($_GET['parking'])) {
        if ($_GET['parking'] == 'true') {
            $parking = $_GET['parking'];
            $sql = $sql . " and PARKING=" . $parking;
        }
        //$_SESSION['parking']= $_GET['parking'];
    }

    if (isset($_GET['dorucak'])) {
        if ($_GET['dorucak'] == 'true') {
            $dorucak = $_GET['dorucak'];
            $sql = $sql . " and DORUCAK=" . $dorucak;
        }
        // $_SESSION['dorucak']= $_GET['dorucak'];
    }

    if (isset($_GET['dnevna_cijena'])) {
        $dnevna_cijena = $_GET['dnevna_cijena'];

        if ($dnevna_cijena == 0) {
            $cijena = "between 0 and 10";
        } else if ($dnevna_cijena == 1) {
            $cijena = "between 10 and 20";
        }
        if ($dnevna_cijena == 2) {
            $cijena = "between 20 and 30";
        } else if ($dnevna_cijena == 3) {
            $cijena = "between 30 and 40";
        } else if ($dnevna_cijena == 4) {
            $cijena = "between 40 and 50";
        }

        $sql = $sql . " and DNEVNA_CIJENA " . $cijena;
    }

    $result = $mysqli->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $id_hot = $row["id_hotela"];

            $sql_ocjena = "SELECT CAST(AVG(OCJENA) AS DECIMAL(10,2)) as ocjena FROM feedback WHERE ID_HOTEL=" . $id_hot;
            $result_ocjena = $mysqli->query($sql_ocjena);
            $row_ocjena = $result_ocjena->fetch_assoc();
            $ocjena_hotela = $row_ocjena['ocjena'];
            $_SESSION['ocjena_hotela'] = $ocjena_hotela;

            $grad = $row["grad"];
            $_SESSION['grad'] = $grad;

            $hotel = $row["hotel"];
            $_SESSION['hotel'] = $hotel;

            $wifi_izabr = $row["wifi_izabr"];
            $dorucak_izabr = $row["dorucak_izabr"];
            $parkink_izabr = $row["parking_izabr"];

            $_SESSION['wifi_izabr'] = $wifi_izabr;
            $_SESSION['dorucak_izabr'] = $dorucak_izabr;
            $_SESSION['parking_izabr'] = $parkink_izabr;

            $slika = $row["slika"];

            $dnevna_cijena = $row["dnevna_cijena"];

            $adresa = $row["adresa"];
            $_SESSION['adresa'] = $adresa;

            $opis = $row["opis"];
            $_SESSION['opis'] = $opis;

            if ($row['br_zvjezdica'] == 5) {
                $zvjezdice = "*****";
            }
            if ($row['br_zvjezdica'] == 4) {
                $zvjezdice = "****";
            }
            if ($row['br_zvjezdica'] == 3) {
                $zvjezdice = "***";
            }
            if ($row['br_zvjezdica'] == 2) {
                $zvjezdice = "**";
            }
            if ($row['br_zvjezdica'] == 1) {
                $zvjezdice = "*";
            }
            $_SESSION['zvjezdice'] = $zvjezdice;
            ?>

<div class="row mt-3" id="cardhotel" style="background: transparent;border-radius: 20px;">
  <div class="card " style="background: transparent;border:0">
    <div class="card-body " style="background: transparent;border:0;">
      <div class="row justify-content-md-center">
        <div class="col col-lg-4">
          <img src="<?php echo $slika ?>" class="img-thumbnail" id="slika_hotela">
        </div>
        <div class="col col-lg-4">
          <h5 class="card-title"><?php echo $hotel . $zvjezdice ?></h5>
          <p id="opis_hotela"><?php echo $opis ?></p>
        </div>
        <div class="col col-lg-4">
          <form id="prikazani_hotel">
            <label id="adresa_hotela"><?php echo $adresa ?></label><br>
            <label id="grad_hotela"><?php echo $grad ?></label><br>
            <label id="mapa">Mapa</label><br>
            <label id="ocjena">Ocjena</label><br>
            <label id="zvjezdice"><?php echo $ocjena_hotela ?></label><br>
            <button class="btn text-dark btn-sg" style="background: cadetblue;"><a
                style="text-decoration: none; color:black;"
                href="<?php echo "./izabrani_hotel.php" ?>">Pretraži</a></button>

          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<?php

        }} else {
        echo "nema u bazi!";
    }

} else {
    // echo "Nisu setovani podaci!";
    // header("Location: http://localhost/project/pages/gost/korisnik.php");
}

//Rezervacija hotela
if (isset($_GET['br_soba']) && isset($_GET['dolazak']) && isset($_GET['odlazak']) && isset($_GET['id_hotela']) && isset($_GET['id_korisnika']) && isset($_GET['id_tip_sobe'])) {
    $br_soba = $_GET['br_soba'];
    $dolazak = $_GET['dolazak'];
    $odlazak = $_GET['odlazak'];
    $id_hotela = $_GET['id_hotela'];
    $id_korisnika = $_GET['id_korisnika'];
    $id_tip_sobe = $_GET['id_tip_sobe'];

    $sql_max_id_rez = "SELECT MAX(ID_REZERVACIJA) as max_id_rez FROM `rezervacija`";
    $result = $mysqli->query($sql_max_id_rez);
    $row = $result->fetch_assoc();
    $max_id_rez = $row['max_id_rez'];
    echo $dolazak;
    echo $odlazak;
    $i = 0;
    for ($i = 1; $i <= $br_soba; $i++) {
        $id_nove_rez = $max_id_rez + $i;
        $sql = "INSERT INTO `rezervacija`(`ID_REZERVACIJA`, `ID_HOTEL`, `ID_TIP_SOBE`, `ID_KORISNIK`, `OD`, `DO`) VALUES (" . $id_nove_rez . "," . $id_hotela . "," . $id_tip_sobe . "," . $id_korisnika . ",'" . $dolazak . "','" . $odlazak . "')";
        echo $sql;
        $result = $mysqli->query($sql);
    }
    header("Location: http://localhost/project/pages/gost/sobe.php");
    exit();

} else if (isset($_GET['id_rez'])) {
    $id = $_GET['id_rez'];

    $sql_delete = "DELETE FROM rezervacija WHERE ID_REZERVACIJA=" . $id;
    $result = $mysqli->query($sql_delete);
    header("Location: http://localhost/project/pages/gost/moje_rezervacije.php");
} else {}

//Komentar i ocjena boravka
if (isset($_GET['ocjena']) && isset($_GET['id_korisnika']) && isset($_GET['id_hotela']) && isset($_GET['komentar'])) {
    $ocjena = $_GET['ocjena'];
    $komentar = $_GET['komentar'];
    $id_hotela = $_GET['id_hotela'];
    $id_korisnika = $_GET['id_korisnika'];

    $sgl_max_id_feedback = "SELECT MAX(ID_FEEDBACK) as max_id_feedback FROM `feedback`";
    $result = $mysqli->query($sgl_max_id_feedback);
    $row = $result->fetch_assoc();
    $max_id_feedback = $row['max_id_feedback'];
    $novi_id_feedback = $max_id_feedback + 1;

    $sql_feedback = "INSERT INTO `feedback`(`ID_FEEDBACK`, `ID_KORISNIK`, `ID_HOTEL`, `KOMENTAR`, `OCJENA`) VALUES (" . $novi_id_feedback . "," . $id_korisnika . "," . $id_hotela . ",'" . $komentar . "'," . $ocjena . ")";
    $result1 = $mysqli->query($sql_feedback);

    echo $sql_feedback;
    header("Location: http://localhost/project/pages/gost/moje_rezervacije.php");

}
//id nove prituzbe
$sql_max_id_prijave = "SELECT MAX(ID_PRITUZBE) as max_id_prijave FROM `prituzbe`";
$result = $mysqli->query($sql_max_id_prijave);
$row = $result->fetch_assoc();
$max_id_prijave = $row['max_id_prijave'];
$novi_id_prijave = $max_id_prijave + 1;
//Prijavljivanje nepouzdanih korisnika od strane korisnika
if (isset($_GET['id_korisnika_prij']) && isset($_GET['id_prijavljenog_kor']) && isset($_GET['komentar_prijava'])) {
    $id_prijavljujuceg = $_GET['id_korisnika_prij'];
    $id_prijavljenog = $_GET['id_prijavljenog_kor'];
    $komentar_prijava = $_GET['komentar_prijava'];

    $sql = "INSERT INTO `prituzbe`(`ID_PRITUZBE`, `ID_KORISNIK`, `KOR_ID_KORISNIK`, `ID_HOTEL`, `TEKST_PRITUZBE`) VALUES (" . $novi_id_prijave . "," . $id_prijavljujuceg . "," . $id_prijavljenog . ",NULL,'" . $komentar_prijava . "')";
    echo $sql;
    echo $id_prijavljujuceg . " " . $id_prijavljenog . " " . $komentar_prijava;
    $result1 = $mysqli->query($sql);
    header("Location: http://localhost/project/pages/gost/drugi_korisnici.php");

}
//Prijavljivanje hotela od strane korisnika
if (isset($_GET['id_kor_pri_hotel']) && isset($_GET['id_prijavljenog_hot']) && isset($_GET['komentar_prijava_hotela'])) {
    $id_kor_pri_hotel = $_GET['id_kor_pri_hotel'];
    $id_prijavljenog_hot = $_GET['id_prijavljenog_hot'];
    $komentar_prijava_hotela = $_GET['komentar_prijava_hotela'];

    $sql = "INSERT INTO `prituzbe`(`ID_PRITUZBE`, `ID_KORISNIK`, `KOR_ID_KORISNIK`, `ID_HOTEL`, `TEKST_PRITUZBE`) VALUES (" . $novi_id_prijave . "," . $id_kor_pri_hotel . ",NULL," . $id_prijavljenog_hot . ",'" . $komentar_prijava_hotela . "')";
    echo $sql;
    echo $id_kor_pri_hotel . " " . $id_prijavljenog_hot . " " . $komentar_prijava_hotela;
    $result1 = $mysqli->query($sql);
    //header("Location: http://localhost/project/pages/gost/izabrani_hotel.php");

}

//Poruke
if (isset($_GET['id_hotel_poruke'])) {
    $id_hotel_poruka = $_GET['id_hotel_poruke'];
    echo "<option>Izaberite menadzera</option>";
    $sql = "SELECT m.id_menadzer,m.ime,m.prezime FROM `menadzer` m JOIN menadzeri_hotela mh on mh.id_menadzer=m.id_menadzer JOIN hotel h on h.ID_HOTEL=mh.ID_HOTEL where h.ID_HOTEL=" . $id_hotel_poruka;

    $result = $mysqli->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {

            $id_menadzer = $row["id_menadzer"];
            $ime = $row["ime"];
            $prezime = $row["prezime"];

            echo "<option value=" . $id_menadzer . ">" . $ime . " " . $prezime . "</option>";

        }

    }
}

//Poruke korisnik-menadzer
if (isset($_GET['id_menadzer_poruke']) && isset($_SESSION['id_prijavljenog_korisnika']) && isset($_GET['id_hotela_poruke'])) {
    $id_menadzer_poruke = $_GET['id_menadzer_poruke'];
    $id_prijavljenog_korisnika = $_SESSION['id_prijavljenog_korisnika'];
    $id_hotel_poruke = $_GET['id_hotela_poruke'];
    $sql_ime_menadzera = "SELECT ime FROM `menadzer` where ID_MENADZER=" . $id_menadzer_poruke;
    $result_ime_menadzera = $mysqli->query($sql_ime_menadzera);
    $row = $result_ime_menadzera->fetch_assoc();
    $ime_menadzera = $row['ime'];

    $sql = "SELECT * FROM `poruke` where ID_HOTEL=" . $id_hotel_poruke . " AND ID_KORISNIK=" . $id_prijavljenog_korisnika . " AND id_menadzer=" . $id_menadzer_poruke;

    if ($result = $mysqli->query($sql)) {

        while ($row = $result->fetch_row()) {
            $id_poruke = $row[0];
            $poruka = $row[4];
            $datum = $row[5];
            $vrijeme = $row[6];
            $poslao_korisnik = $row[7];
            $procitano = $row[8];
            if ($poslao_korisnik) {
                echo '<label style="margin-left: 29%;margin-bottom: 0;margin-top: 2%;">Ja</label><div class="container darker" style="background: cadetblue;border-radius: 45px;text-align: center;margin-top: 0;margin-right: 3%;margin-left: 27%;width: 70%;">
            <p>' . $poruka . '</p>
            <span class="time-left" style="margin-bottom:2%;">' . $datum . "   " . $vrijeme . '</span>
          </div>';
                if (!$procitano) {
                    $sql1 = "UPDATE `poruke` SET `procitano` = '1' WHERE `poruke`.`ID_PORUKE` =" . $id_poruke;
                    if (mysqli_query($mysqli, $sql1)) {} else {
                        echo "Error updating record: " . mysqli_error($conn);
                    }
                }
            } else {
                echo '<label style="margin-left:5%;margin-bottom: 0;margin-top: 2%;">' . $ime_menadzera . '</label><div class="container " style="text-align: end; background-color: slategrey;border-radius: 45px;margin-top: 0;margin-right: 27%;margin-left: 3%;width: 70%;;text-align: center; ">
                            <p>' . $poruka . '</p>
                            <span class="time-right" style="margin-bottom:2%;">' . $datum . "   " . $vrijeme . '</span>
                          </div>';
            }

        }
    }
}

//Slanje poruka
if (isset($_GET['id_hotela_poruke']) && isset($_GET['id_menadzer_poruke']) && isset($_GET['poruka']) && isset($_SESSION['id_prijavljenog_korisnika'])) {

    $id_hotela_por = $_GET['id_hotela_poruke'];
    $id_menadzer_por = $_GET['id_menadzer_poruke'];
    $poruka = $_GET['poruka'];
    $id_kor = $_SESSION['id_prijavljenog_korisnika'];

    $sql_max_id_poruke = "SELECT MAX(ID_PORUKE) as max_id_por FROM `poruke`";
    $result = $mysqli->query($sql_max_id_poruke);
    $row = $result->fetch_assoc();
    $max_id_poruke = $row['max_id_por'];
    $novi_id_poruke = $max_id_poruke + 1;
    $datum = date("Y-m-d");
    $vrijeme = date("h:i:sa");
    $sql = "INSERT INTO `poruke`(`ID_PORUKE`, `ID_HOTEL`, `ID_KORISNIK`, `id_menadzer`, `TEKST_PORUKE`, `datum`, `vrijeme`, `poslao_korisnik`, `procitano`) VALUES (" . $novi_id_poruke . "," . $id_hotela_por . "," . $id_kor . "," . $id_menadzer_por . ",'" . $poruka . "','" . $datum . "','" . $vrijeme . "',1,0)";
    $result1 = $mysqli->query($sql);

    echo '<label style="margin-left: 29%;margin-bottom: 0;margin-top: 2%;">Ja</label><div class="container darker" style="background: cadetblue;border-radius: 45px;text-align: center;margin-top: 0;margin-right: 3%;margin-left: 27%;width: 70%;">
            <p>' . $poruka . '</p>
            <span class="time-left" style="margin-bottom:2%;">' . $datum . "   " . $vrijeme . '</span>
          </div>';

}