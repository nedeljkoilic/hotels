<link rel="stylesheet" href="style.css">

<?php
session_start();
require_once "../../connection.php";
if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];

    $sql = "SELECT * FROM `korisnik` WHERE EMAIL = '$email';";

    if ($result = $mysqli->query($sql)) {
        $row = $result->fetch_row();
        $id = $row[0];
        $ime = $row[1];
        $prezime = $row[2];
        $tel = $row[3];
        $result->free_result();

    }
} else {
    header("Location: http://localhost/project/index.php");
    exit();
}
if (isset($_SESSION['grad']) && isset($_SESSION['hotel']) && isset($_SESSION['opis']) && isset($_SESSION['zvjezdice']) && isset($_SESSION['adresa'])) {
    $grad = $_SESSION['grad'];
    $hotel = $_SESSION['hotel'];
    $opis = $_SESSION['opis'];
    $zvjezdice = $_SESSION['zvjezdice'];
    $adresa = $_SESSION['adresa'];

    $sql2 = "SELECT id_hotel from hotel where NAZIV='" . $hotel . "'";
    $result = $mysqli->query($sql2);
    $row = $result->fetch_assoc();
    $id_hotela = $row['id_hotel'];

} /*
else
{
header("Location: http://localhost/project/pages/gost/korisnik.php");
exit();
}*/

//podaci za pretragu soba
if (isset($_GET['dolazak']) && isset($_GET['odlazak']) && isset($_GET['tip_sobe']) && isset($_GET['broj_osoba']) && $_GET['dolazak'] != "" && $_GET['odlazak'] != "" && $_GET['tip_sobe'] != "" && $_GET['broj_osoba'] != "") {
    $dolazak = $_GET['dolazak'];
    $odlazak = $_GET['odlazak'];
    $tip_sobe = $_GET['tip_sobe'];
    $broj_osoba = $_GET['broj_osoba'];

    if ($dolazak < date("Y-m-d") || $odlazak < date("Y-m-d") || $dolazak == $odlazak) {
        header("Location: http://localhost/project/pages/gost/izabrani_hotel.php");
        echo "Unesite ispravne datume";
        exit();
    } else {
        ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sobe</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>

<body>

  <div id="levitationRez">
    <div class="container bg-dark text-light" id="levitationForm">
      <label for="">Datum dolaska </label> <label for=""><?php echo $dolazak ?></label> <br>
      <label for="">Datum odlaska </label> <label for=""><?php echo $odlazak ?></label> <br>
      <label for="">Cijena po danu: </label> <label for="" id="cijena_po_danu"></label> <br>
      <label for="" style=" margin-bottom: 13px">Ukupna cijena: </label> <label for="" id="ukupna_cijena"></label><br>
      <button type="button" class="btn btn-success" style="margin-right: 25px;"
        onclick="rezervisi_rez('<?php echo $dolazak ?>','<?php echo $odlazak ?>' ,<?php echo $id_hotela ?>,<?php echo $id ?>)">
        Rezervisi</button>
      <button type="button" class="btn btn-danger" id="btn_zatvori_rezervaciju" onclick="zatvori_rez()">
        Zatvori</button>
    </div>
  </div>

  <!--Moj nav -->
  <nav class="navbar navbar-dark navbar-expand-sm bg-dark text-light">
    <div class="container-fluid">

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navigacija">
        <img src="../../PNG/menu.png" alt="menu">
      </button>
      <div class="collapse navbar-collapse" style="align-items: start;" id="navigacija">

        <span class="navbar-text bg-dark text-muted text-light ">
          <?php
echo $ime . " " . $prezime;
        ?>
        </span>
        <div class="mx-auto ">

        </div>
        <ul class="navbar-nav" style="line-height: 38px; font-size: 20px;">
          <li class="nav-item">
            <button class="btn text-light" style="background: cadetblue; margin-right: 3px;"> <a
                href="izabrani_hotel.php" style="text-decoration: none; color:white;">Hotel</a></button>
          </li>
          <li class="nav-item">
            <button class="btn text-light" style="background: cadetblue; margin-right: 3px;"> <a
                href="drugi_korisnici.php" style="text-decoration: none; color:white;">Drugi korisnici</a></button>
          </li>
          <li class="nav-item">
            <button class="btn text-light" style="background: cadetblue; margin-right: 3px;"> <a href="korisnik.php"
                style="text-decoration: none; color:white;">Pocetna</a></button>
          </li>
          <li class="nav-item">
            <button class="btn text-light" style="background: cadetblue; margin-right: 3px;"> <a
                href="moje_rezervacije.php" style="text-decoration: none; color:white;">Moje rezervacije</a></button>
          </li>
          <li class="nav-item">
            <button class="btn text-light" type="submit" style="background: cadetblue; " onclick="logout()">Log
              out</button>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <!--Moj nav -->

  <div class="container">
    <div class="row mt-3 " id="cardsobe">
      <div class="card " style="background: #8080807a;border-radius: 20px; color:black;">
        <div class="card-body ">
          <div class="row ">
            <div class="col col-7">
              <h5 class="card-title" style="font-weight: bold;"><?php echo $hotel . " " . $zvjezdice ?></h5>
              <p><?php echo $grad . "," . $adresa ?></p>
              <p id="opis_hotela"><?php echo $opis ?><a href="#" style="color: darkblue;">Vise</a></p>
            </div>
            <div class="col col-2"><a href="#" style="color: #0666c5;">Mapa</a></div>
            <div class="col col-3">
              <img src="./slika4.jpg" class="img-thumbnail">
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="container">
    <div style="background: #8080807a;border-radius: 10px; color:black; margin-top:30px; position: relative;">
      <div class="bg-secondary"
        style="width:max-content; position: absolute;top:-10px; font-weight: bold; padding-right:5px;padding-left:5px;">
        Pregled rezervacije</div>
      <div class="row">
        <div class="col col-3 mt-3">
          <label>Datum dolaska</label><br>
          <label><?php echo $_GET['dolazak'] ?></label>
        </div>
        <div class="col col-3 mt-3">
          <label>Datum odlaska</label><br>
          <label><?php echo $_GET['odlazak'] ?></label>
        </div>
      </div>
    </div>

  </div>


  <?php
require_once "../../connection.php";

        $dan = $dolazak;

        if ($broj_osoba >= 1) {
            //select za jednokrevetne sobe
            $sql = "SELECT * FROM `rezervacija` r WHERE r.ID_HOTEL=" . $id_hotela . " AND r.ID_TIP_SOBE=1";

            $sql1 = "SELECT bst.KOLICINA FROM `broj_soba_po_tipu` bst WHERE bst.ID_HOTEL=" . $id_hotela . " AND bst.ID_TIP_SOBE=1";
            $result = $mysqli->query($sql1);
            $row = $result->fetch_row();
            $dostupni_kapacitet = $row[0];
            $brojac_po_danu = 0;
            $br_dana = 0;
            $max_soba_dan = 0;
            while (strval($dan) != strval($odlazak)) {
                $result = $mysqli->query($sql);
                while ($row = $result->fetch_row()) {
                    $baza_od = $row[4];
                    $baza_do = $row[5];

                    if ($dan > $baza_od && $dan <= $baza_do) {
                        $brojac_po_danu++;
                        if ($brojac_po_danu == $dostupni_kapacitet) {
                            header("Location: http://localhost/project/index.php?greska=kapacitet");
                            exit();
                        }
                    }

                }
                if ($max_soba_dan <= $brojac_po_danu) {
                    $max_soba_dan = $brojac_po_danu;
                }
                $br_dana++;
                $brojac_po_danu = 0;
                $dan = strtotime("+1 day", strtotime($dan));
                $dan = date("Y-m-d", $dan);
            }

            $br_slobodnih_soba = $dostupni_kapacitet - $max_soba_dan;

            $sql_cijena = "SELECT h.DNEVNA_CIJENA FROM `hotel` h WHERE h.ID_HOTEL=" . $id_hotela;
            $result = $mysqli->query($sql_cijena);
            $row = $result->fetch_row();
            $cijena = $row[0];

            $sql_koef = "SELECT ts.koeficijent FROM `tip_sobe` ts WHERE ts.ID_TIP_SOBE=1";
            $result = $mysqli->query($sql_koef);
            $row = $result->fetch_row();
            $koef = $row[0];
            $ukupna_cijena = $br_dana * $cijena * $koef;
            $cijena_sa_doruckom = $ukupna_cijena * 0.3 + $ukupna_cijena;

            ?>
  <div class="container mt-3" style="background: #8080807a;border-radius:20px; color:black;">
    <p style="font-weight: bold; padding-top: 5px;margin-bottom: 0;">Jednokrevetne sobe</p>
    <hr style="margin-top: 0;">
    <div class="row  text-center">
      <div class="col col-3">
        <div id="carousel1" class="carousel slide" data-bs-ride="carousel">
          <div class="carousel-indicators">
            <button type="button" data-bs-target="#carousel1" data-bs-slide-to="0" class="active"
              aria-current="true"></button>
            <button type="button" data-bs-target="#carousel1" data-bs-slide-to="1"></button>
            <button type="button" data-bs-target="#carousel1" data-bs-slide-to="2"></button>
          </div>
          <div class="carousel-inner">
            <div class="carousel-item active">
              <img src="soba.jpg" class="d-block w-100">
            </div>
            <div class="carousel-item">
              <img src="./soba1.jpg" class="d-block w-100">
            </div>
            <div class="carousel-item">
              <img src="./soba2.jpg" class="d-block w-100">
            </div>
          </div>

          <button class="carousel-control-prev" type="button" data-bs-target="#carousel1" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
          </button>
          <button class="carousel-control-next" type="button" data-bs-target="#carousel1" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
          </button>

        </div>
      </div>
      <div class="col col-9 ">
        <div class="row mt-3 text-center">
          <div class="col col-3 mb-1">
            <label>Nocenje</label><br>
          </div>
          <div class="col col-2 mb-1">
            <label id="cijena_bez_dor"><?php echo $ukupna_cijena ?></label><br>
          </div>
          <div class="col col-1 mb-1">
            <label>Sobe</label>
          </div>
          <div class="col col-2">
            <select class="form-select form-select-sm" aria-label="Default select example" id="1">
              <option selected>Br soba</option>
              <?php for ($i = 1; $i <= $br_slobodnih_soba; $i++) {?>
              <option value="<?php echo $i ?>"><?php echo $i ?></option>
              <?php }?>
            </select>
          </div>
          <div class="col col-1 mb-1">

            <button type="submit" class="btn btn-secondary  btn-sm" class="open-button"
              onclick="showform(<?php echo $cijena ?>,<?php echo $ukupna_cijena ?>,1)">Rezervisi</button>
          </div>
        </div>
        <hr class="mt-3">
        <div class="row mt-4">
          <div class="col col-3 mb-1">
            <label>Nocenje sa doruckom</label><br>
          </div>
          <div class="col col-2 mb-1">
            <label id="cijena_bez_dor"><?php echo ($ukupna_cijena + $ukupna_cijena * 0.3) ?></label><br>
          </div>
          <div class="col col-1 mb-1">
            <label>Sobe</label>
          </div>
          <div class="col col-2">
            <select class="form-select btn-sm" aria-label="Default select example" id="11">
              <option selected>Br soba</option>
              <?php for ($i = 1; $i <= $br_slobodnih_soba; $i++) {?>
              <option value="<?php echo $i ?>"><?php echo $i ?></option>
              <?php }?>
            </select>
          </div>
          <div class="col col-1 mb-1">
            <?php ?>
            <button type="submit" class="btn btn-secondary  btn-sm" class="open-button"
              onclick="showform(<?php echo $cijena ?>,<?php echo $cijena_sa_doruckom ?>,11)">Rezervisi</button>
          </div>
        </div>

      </div>
    </div>
    <hr class="container mt-3">
  </div>
  <?php
}

        if ($broj_osoba >= 2) {
            $dan = $dolazak;
            //select za dvokrevetne sobe
            $sql = "SELECT * FROM `rezervacija` r WHERE r.ID_HOTEL=" . $id_hotela . " AND r.ID_TIP_SOBE=2";

            $sql1 = "SELECT bst.KOLICINA FROM `broj_soba_po_tipu` bst WHERE bst.ID_HOTEL=" . $id_hotela . " AND bst.ID_TIP_SOBE=2";
            $result = $mysqli->query($sql1);
            $row = $result->fetch_row();
            $dostupni_kapacitet = $row[0];
            $brojac_po_danu = 0;
            $br_dana = 0;
            $dan = $dolazak;
            $max_soba_dan = 0;
            while (strval($dan) != strval($odlazak)) {
                $result = $mysqli->query($sql);
                while ($row = $result->fetch_row()) {
                    $baza_od = $row[4];
                    $baza_do = $row[5];

                    if ($dan > $baza_od && $dan <= $baza_do) {
                        $brojac_po_danu++;
                        if ($brojac_po_danu == $dostupni_kapacitet) {
                            header("Location: http://localhost/project/index.php?greska=kapacitet");
                            exit();
                        }
                    }

                }
                if ($max_soba_dan <= $brojac_po_danu) {
                    $max_soba_dan = $brojac_po_danu;
                }
                $br_dana++;

                $brojac_po_danu = 0;
                $dan = strtotime("+1 day", strtotime($dan));
                $dan = date("Y-m-d", $dan);
            }

            $br_slobodnih_soba = $dostupni_kapacitet - $max_soba_dan;

            $sql_cijena = "SELECT h.DNEVNA_CIJENA FROM `hotel` h WHERE h.ID_HOTEL=" . $id_hotela;
            $result = $mysqli->query($sql_cijena);
            $row = $result->fetch_row();
            $cijena = $row[0];

            $sql_koef = "SELECT ts.koeficijent FROM `tip_sobe` ts WHERE ts.ID_TIP_SOBE=2";
            $result = $mysqli->query($sql_koef);
            $row = $result->fetch_row();
            $koef = $row[0];
            $ukupna_cijena = $br_dana * $cijena * $koef;
            $cijena_sa_doruckom = $ukupna_cijena * 0.3 + $ukupna_cijena;

            ?>
  <div class="container mt-3" style="background: #8080807a;border-radius: 20px; color:black;">
    <p style="font-weight: bold; padding-top: 5px;margin-bottom: 0;">Dvokrevetne sobe</p>
    <hr style="margin-top: 0;">
    <div class="row  text-center">
      <div class="col col-3">
        <div id="carousel1" class="carousel slide" data-bs-ride="carousel">
          <div class="carousel-indicators">
            <button type="button" data-bs-target="#carousel1" data-bs-slide-to="0" class="active"
              aria-current="true"></button>
            <button type="button" data-bs-target="#carousel1" data-bs-slide-to="1"></button>
            <button type="button" data-bs-target="#carousel1" data-bs-slide-to="2"></button>
          </div>
          <div class="carousel-inner">
            <div class="carousel-item active">
              <img src="soba.jpg" class="d-block w-100">
            </div>
            <div class="carousel-item">
              <img src="./soba1.jpg" class="d-block w-100">
            </div>
            <div class="carousel-item">
              <img src="./soba2.jpg" class="d-block w-100">
            </div>
          </div>

          <button class="carousel-control-prev" type="button" data-bs-target="#carousel1" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
          </button>
          <button class="carousel-control-next" type="button" data-bs-target="#carousel1" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
          </button>

        </div>
      </div>
      <div class="col col-9 ">
        <div class="row mt-3 text-center">
          <div class="col col-3 mb-1">
            <label>Nocenje</label><br>
          </div>
          <div class="col col-2 mb-1">
            <label id="cijena_bez_dor"><?php echo $ukupna_cijena ?></label><br>
          </div>
          <div class="col col-1 mb-1">
            <label>Sobe</label>
          </div>
          <div class="col col-2">
            <select class="form-select btn-sm" aria-label="Default select example" id="2">
              <option selected>Br soba</option>
              <?php for ($i = 1; $i <= $br_slobodnih_soba; $i++) {?>
              <option value="<?php echo $i ?>"><?php echo $i ?></option>
              <?php }?>
            </select>
          </div>
          <div class="col col-1 mb-1">
            <button type="submit" class="btn btn-secondary  btn-sm" class="open-button"
              onclick="showform(<?php echo $cijena ?>,<?php echo $ukupna_cijena ?>,2)">Rezervisi</button>
          </div>
        </div>
        <hr class="mt-3">
        <div class="row mt-4">
          <div class="col col-3 mb-1">
            <label>Nocenje sa doruckom</label><br>
          </div>
          <div class="col col-2 mb-1">
            <label id="cijena_bez_dor"><?php echo ($ukupna_cijena + $ukupna_cijena * 0.3) ?></label><br>
          </div>
          <div class="col col-1 mb-1">
            <label>Sobe</label>
          </div>
          <div class="col col-2">
            <select class="form-select btn-sm" aria-label="Default select example" id="21">
              <option selected>Br soba</option>
              <?php for ($i = 1; $i <= $br_slobodnih_soba; $i++) {?>
              <option value="<?php echo $i ?>"><?php echo $i ?></option>
              <?php }?>
            </select>
          </div>
          <div class="col col-1 mb-1">
            <button type="submit" class="btn btn-secondary  btn-sm" class="open-button"
              onclick="showform(<?php echo $cijena ?>,<?php echo $cijena_sa_doruckom ?>,21)">Rezervisi</button>
          </div>
        </div>

      </div>
    </div>
    <hr class="container mt-3">
  </div>
  <?php
}

        if ($broj_osoba >= 3) {$dan = $dolazak;

            //select za trokrevetne sobe
            $sql = "SELECT * FROM `rezervacija` r WHERE r.ID_HOTEL=" . $id_hotela . " AND r.ID_TIP_SOBE=3";

            $sql1 = "SELECT bst.KOLICINA FROM `broj_soba_po_tipu` bst WHERE bst.ID_HOTEL=" . $id_hotela . " AND bst.ID_TIP_SOBE=3";
            $result = $mysqli->query($sql1);
            $row = $result->fetch_row();
            $dostupni_kapacitet = $row[0];
            $brojac_po_danu = 0;
            $br_dana = 0;
            $max_soba_dan = 0;
            while (strval($dan) != strval($odlazak)) {
                $result = $mysqli->query($sql);
                while ($row = $result->fetch_row()) {
                    $baza_od = $row[4];
                    $baza_do = $row[5];

                    if ($dan > $baza_od && $dan <= $baza_do) {
                        $brojac_po_danu++;
                        if ($brojac_po_danu == $dostupni_kapacitet) {
                            header("Location: http://localhost/project/index.php?greska=kapacitet");
                            exit();
                        }
                    }

                }
                if ($max_soba_dan <= $brojac_po_danu) {
                    $max_soba_dan = $brojac_po_danu;
                }
                $br_dana++;
                $brojac_po_danu = 0;
                $dan = strtotime("+1 day", strtotime($dan));
                $dan = date("Y-m-d", $dan);
            }

            $br_slobodnih_soba = $dostupni_kapacitet - $max_soba_dan;

            $sql_cijena = "SELECT h.DNEVNA_CIJENA FROM `hotel` h WHERE h.ID_HOTEL=" . $id_hotela;
            $result = $mysqli->query($sql_cijena);
            $row = $result->fetch_row();
            $cijena = $row[0];

            $sql_koef = "SELECT ts.koeficijent FROM `tip_sobe` ts WHERE ts.ID_TIP_SOBE=3";
            $result = $mysqli->query($sql_koef);
            $row = $result->fetch_row();
            $koef = $row[0];
            $ukupna_cijena = $br_dana * $cijena * $koef;
            $cijena_sa_doruckom = $ukupna_cijena * 0.3 + $ukupna_cijena;

            ?>
  <div class="container mt-3" style="background: #8080807a;border-radius: 20px; color:black;">
    <p style="font-weight: bold;padding-top: 5px;margin-bottom: 0;">Trokrevetne sobe</p>
    <hr style="margin-top: 0;">
    <div class="row  text-center">
      <div class="col col-3">
        <div id="carousel1" class="carousel slide" data-bs-ride="carousel">
          <div class="carousel-indicators">
            <button type="button" data-bs-target="#carousel1" data-bs-slide-to="0" class="active"
              aria-current="true"></button>
            <button type="button" data-bs-target="#carousel1" data-bs-slide-to="1"></button>
            <button type="button" data-bs-target="#carousel1" data-bs-slide-to="2"></button>
          </div>
          <div class="carousel-inner">
            <div class="carousel-item active">
              <img src="soba.jpg" class="d-block w-100">
            </div>
            <div class="carousel-item">
              <img src="./soba1.jpg" class="d-block w-100">
            </div>
            <div class="carousel-item">
              <img src="./soba2.jpg" class="d-block w-100">
            </div>
          </div>

          <button class="carousel-control-prev" type="button" data-bs-target="#carousel1" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
          </button>
          <button class="carousel-control-next" type="button" data-bs-target="#carousel1" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
          </button>

        </div>
      </div>
      <div class="col col-9 ">
        <div class="row mt-3 text-center">
          <div class="col col-3 mb-1">
            <label>Nocenje</label><br>
          </div>
          <div class="col col-2 mb-1">
            <label id="cijena_bez_dor"><?php echo $ukupna_cijena ?></label><br>
          </div>
          <div class="col col-1 mb-1">
            <label>Sobe</label>
          </div>
          <div class="col col-2">
            <select class="form-select btn-sm" aria-label="Default select example" id="3">
              <option selected>Br soba</option>
              <?php for ($i = 1; $i <= $br_slobodnih_soba; $i++) {?>
              <option value="<?php echo $i ?>"><?php echo $i ?></option>
              <?php }?>
            </select>
          </div>
          <div class="col col-1 mb-1">
            <button type="submit" class="btn btn-secondary  btn-sm" class="open-button"
              onclick="showform(<?php echo $cijena ?>,<?php echo $ukupna_cijena ?>,3)">Rezervisi</button>
          </div>
        </div>
        <hr class="mt-3">
        <div class="row mt-4">
          <div class="col col-3 mb-1">
            <label>Nocenje sa doruckom</label><br>
          </div>
          <div class="col col-2 mb-1">
            <label id="cijena_bez_dor"><?php echo $cijena_sa_doruckom ?></label><br>
          </div>
          <div class="col col-1 mb-1">
            <label>Sobe</label>
          </div>
          <div class="col col-2">
            <select class="form-select btn-sm" aria-label="Default select example" id="31">
              <option selected>Br soba</option>
              <?php for ($i = 1; $i <= $br_slobodnih_soba; $i++) {?>
              <option value="<?php echo $i ?>"><?php echo $i ?></option>
              <?php }?>
            </select>
          </div>
          <div class="col col-1 mb-1">
            <button type="submit" class="btn btn-secondary  btn-sm" class="open-button"
              onclick="showform(<?php echo $cijena ?>,<?php echo $cijena_sa_doruckom ?>,31)">Rezervisi</button>
          </div>
        </div>

      </div>
    </div>
    <hr class="container mt-3">
  </div>
  <?php
}

        if ($broj_osoba >= 4) {$dan = $dolazak;
            //select za cetverokrevetne sobe
            $sql = "SELECT * FROM `rezervacija` r WHERE r.ID_HOTEL=" . $id_hotela . " AND r.ID_TIP_SOBE=4";

            $sql1 = "SELECT bst.KOLICINA FROM `broj_soba_po_tipu` bst WHERE bst.ID_HOTEL=" . $id_hotela . " AND bst.ID_TIP_SOBE=4";
            $result = $mysqli->query($sql1);
            $row = $result->fetch_row();
            $dostupni_kapacitet = $row[0];
            $brojac_po_danu = 0;
            $br_dana = 0;
            $max_soba_dan = 0;
            while (strval($dan) != strval($odlazak)) {
                $result = $mysqli->query($sql);
                while ($row = $result->fetch_row()) {
                    $baza_od = $row[4];
                    $baza_do = $row[5];

                    if ($dan > $baza_od && $dan <= $baza_do) {
                        $brojac_po_danu++;
                        if ($brojac_po_danu == $dostupni_kapacitet) {
                            header("Location: http://localhost/project/index.php?greska=kapacitet");
                            exit();
                        }
                    }

                }
                if ($max_soba_dan <= $brojac_po_danu) {
                    $max_soba_dan = $brojac_po_danu;
                }
                $br_dana++;
                $brojac_po_danu = 0;
                $dan = strtotime("+1 day", strtotime($dan));
                $dan = date("Y-m-d", $dan);
            }

            $br_slobodnih_soba = $dostupni_kapacitet - $max_soba_dan;

            $sql_cijena = "SELECT h.DNEVNA_CIJENA FROM `hotel` h WHERE h.ID_HOTEL=" . $id_hotela;
            $result = $mysqli->query($sql_cijena);
            $row = $result->fetch_row();
            $cijena = $row[0];

            $sql_koef = "SELECT ts.koeficijent FROM `tip_sobe` ts WHERE ts.ID_TIP_SOBE=4";
            $result = $mysqli->query($sql_koef);
            $row = $result->fetch_row();
            $koef = $row[0];
            $ukupna_cijena = $br_dana * $cijena * $koef;
            $cijena_sa_doruckom = $ukupna_cijena * 0.3 + $ukupna_cijena;

            ?>
  <div class="container mt-3" style="background: #8080807a;border-radius: 20px; color:black;">
    <p style="font-weight: bold;padding-top: 5px;margin-bottom: 0;">Cetverokrevetne sobe</p>
    <hr style="margin-top: 0;">
    <div class="row  text-center">
      <div class="col col-3">
        <div id="carousel1" class="carousel slide" data-bs-ride="carousel">
          <div class="carousel-indicators">
            <button type="button" data-bs-target="#carousel1" data-bs-slide-to="0" class="active"
              aria-current="true"></button>
            <button type="button" data-bs-target="#carousel1" data-bs-slide-to="1"></button>
            <button type="button" data-bs-target="#carousel1" data-bs-slide-to="2"></button>
          </div>
          <div class="carousel-inner">
            <div class="carousel-item active">
              <img src="soba.jpg" class="d-block w-100">
            </div>
            <div class="carousel-item">
              <img src="./soba1.jpg" class="d-block w-100">
            </div>
            <div class="carousel-item">
              <img src="./soba2.jpg" class="d-block w-100">
            </div>
          </div>

          <button class="carousel-control-prev" type="button" data-bs-target="#carousel1" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
          </button>
          <button class="carousel-control-next" type="button" data-bs-target="#carousel1" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
          </button>

        </div>
      </div>
      <div class="col col-9 ">
        <div class="row mt-3 text-center">
          <div class="col col-3 mb-1">
            <label>Nocenje</label><br>
          </div>
          <div class="col col-2 mb-1">
            <label id="cijena_bez_dor"><?php echo $ukupna_cijena ?></label><br>
          </div>
          <div class="col col-1 mb-1">
            <label>Sobe</label>
          </div>
          <div class="col col-2">
            <select class="form-select btn-sm" aria-label="Default select example" id="4">
              <option selected>Br soba</option>
              <?php for ($i = 1; $i <= $br_slobodnih_soba; $i++) {?>
              <option value="<?php echo $i ?>"><?php echo $i ?></option>
              <?php }?>
            </select>
          </div>
          <div class="col col-1 mb-1">
            <button type="submit" class="btn btn-secondary  btn-sm" class="open-button"
              onclick="showform(<?php echo $cijena ?>,<?php echo $ukupna_cijena ?>,4)">Rezervisi</button>
          </div>
        </div>
        <hr class="mt-3">
        <div class="row mt-4">
          <div class="col col-3 mb-1">
            <label>Nocenje sa doruckom</label><br>
          </div>
          <div class="col col-2 mb-1">
            <label id="cijena_bez_dor"><?php echo $cijena_sa_doruckom ?></label><br>
          </div>
          <div class="col col-1 mb-1">
            <label>Sobe</label>
          </div>
          <div class="col col-2">
            <select class="form-select btn-sm" aria-label="Default select example" id="41">
              <option selected>Br soba</option>
              <?php for ($i = 1; $i <= $br_slobodnih_soba; $i++) {?>
              <option value="<?php echo $i ?>"><?php echo $i ?></option>
              <?php }?>
            </select>
          </div>
          <div class="col col-1 mb-1">
            <button type="submit" class="btn btn-secondary  btn-sm" class="open-button"
              onclick="showform(<?php echo $cijena ?>,<?php echo $cijena_sa_doruckom ?>,41)">Rezervisi</button>
          </div>
        </div>

      </div>
    </div>
    <hr class="container mt-3">
  </div>
  <?php
}
    }
} else {
    header("Location: http://localhost/project/pages/gost/izabrani_hotel.php");

    exit();
}

$sql_get_max_id_korisnik = "SELECT MAX(k.ID_KORISNIK) FROM `korisnik` k;";
$sql_get_max_id_rezervacija = "SELECT MAX(r.ID_REZERVACIJA) FROM `rezervacija` r";

$result = $mysqli->query($sql_get_max_id_korisnik);
$row = $result->fetch_row();
$id_novi_korisnik = $row[0] + 1;

$result = $mysqli->query($sql_get_max_id_rezervacija);
$row = $result->fetch_row();
$id_nova_rezervacija = $row[0] + 1;

?>











  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
    integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
    integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
  </script>
  <script src="funkcije.js"></script>
</body>

</html>