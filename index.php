<?php
session_start();
require_once "./connection.php";

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="./css.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body class="">
  <!-- Forma za rezervaciju-->
  <div id="levitationRez">
    <div class=" container text-light bg-dark mt-5 p-1" id="levitationForm" style="border-radius: 7px; width: 60%;">
      <form action="./form_validation.php" method="get" style="margin: 15px; margin-bottom: 20px">
        <div class="form-group">
          <label for="tipSobe" style="color: white;" hidden>Tip sobe</label>
          <select required class="form-control" name="tipSobe" id="tipSobe1" hidden>
            <option value="1">Jednokrevetna</option>
            <option value="2">Dvokreventa</option>
            <option value="3">Trokrevetna</option>
            <option value="4">Cetvorokrevetna</option>
          </select>

        </div>
        <div class="form-group ">
          <label for="dolazak" style="color: white;">Dolazak</label>
          <input required class="form-control" id="dolazak1" type="date" name="dolazak">
        </div>
        <div class="form-group ">
          <label for="odlazak" style="color: white;">Odlazak</label>
          <input required class="form-control" id="odlazak1" type="date" name="odlazak">
        </div>
        <div class="form-group ">
          <label for="hotel" style="color: white;">Odaberite hotel</label>
          <select required class="form-control" name="hotel" id="hotel1">
            <?php
$sql = "SELECT NAZIV FROM `hotel`";
$i = 0;
if ($result = $mysqli->query($sql)) {
    while ($row = $result->fetch_row()) {
        $i++;
        echo "<option value=" . $i . ">" . $row[0] . "</option>";
    }
    $result->free_result();

}
?>
          </select>
        </div>
        <div class="form-group  mt-1">
          <input required class="form-control" type="text" id="ime1" placeholder="Ime" name="ime">
        </div>
        <div class="form-group  mt-1">
          <input required class="form-control" type="text" id="prezime1" placeholder="Prezime" name="prezime">
        </div>
        <div class="form-group  mt-1">
          <input required class="form-control mt-1" type="text" id="telefon1" placeholder="Kontakt telefon" name="tel">
        </div>
        <input class="form-group  mt-1 btn btn-info " type="submit" value="Rezervisi" name="brzaRezervacija"
          id="brzaRezervacija1">

      </form>
    </div>
  </div>
  <!-- navigacijski linkovi-->
  <nav class="navbar navbar-dark navbar-expand-sm bg-dark text-light">
    <div class="container-fluid">
      <img src="./PNG/crown.png" alt="logo" class="navbar-brand" style="align-self: start; height: 55px;">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navigacija">
        <img src="./PNG/menu.png" alt="menu">
      </button>
      <div class="collapse navbar-collapse" style="align-items: start;" id="navigacija">

        <ul class="navbar-nav" style="line-height: 38px; font-size: 20px;">
          <li class="nav-item h-100">
            <a href="#kontakt" class="nav-link">Kontakt</a>
          </li>
          <li class="nav-item h-100">
            <a href="#oNama" class="nav-link">O nama</a>
          </li>
          <li class="nav-item h-100">
            <a href="#galerija" class="nav-link">Galerija</a>
          </li>
        </ul>
        <div class="mx-auto ">

        </div>

        <!--forme za login i sign in-->
        <div class="accordion accordion-flush" id="accordionFlushExample">
          <div class="accordion-item">
            <h2 class="accordion-header" id="flush-headingOne">
              <button class="accordion-button collapsed  bg-dark text-light" type="button" data-bs-toggle="collapse"
                data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                Prijava
              </button>
            </h2>
            <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne"
              data-bs-parent="#accordionFlushExample">
              <div class="accordion-body bg-dark text-secondary">
                <form action="./form_validation.php" method="post">
                  <div class="form-group">
                    <label for="email">Email adresa:</label>
                    <input required type="email" class="form-control" id="email" name="email">
                  </div>
                  <div class="form-group">
                    <label for="pwd">Lozinka:</label>
                    <input required type="password" class="form-control" id="pwd" name="pwd">
                  </div>
                  <button type="submit" class="btn btn-success mt-2" name="submit_prijava">Prijava</button>
                </form>
              </div>
            </div>
          </div>
          <div class="accordion-item">
            <h2 class="accordion-header" id="flush-headingTwo">
              <button class="accordion-button collapsed bg-dark text-light" type="button" data-bs-toggle="collapse"
                data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo"
                style="border-radius: 0;">
                Registracija
              </button>
            </h2>
            <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo"
              data-bs-parent="#accordionFlushExample">
              <div class="accordion-body bg-dark text-secondary">
                <form action="./form_validation.php" method="post" onsubmit="return validateForm()">
                  <div class="form-group">
                    <select class="form-control" id="vrstaNaloga" onchange="sakriji_select()" name="vrsta_naloga">
                      <option value="1">Gost</option>
                      <option value="2">Menadzer</option>
                    </select>
                  </div>
                  <div class="form-group" id="sakrivanje" style="display: none;">
                    <label for="hotel2">Odaberite hotel</label>
                    <select class="form-control" id="hotel2" name="hotel_menadzer">
                      <?php
$sql = "SELECT NAZIV FROM `hotel`";
$i = 0;
if ($result = $mysqli->query($sql)) {
    while ($row = $result->fetch_row()) {
        $i++;
        echo "<option value=" . $i . ">" . $row[0] . "</option>";
    }
    $result->free_result();

}
?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="name">Ime</label>
                    <input required type="text" class="form-control" id="name" name="ime">
                  </div>
                  <div class="form-group">
                    <label for="subname">Prezime</label>
                    <input required type="text" class="form-control" id="subname" name="prezime">
                  </div>
                  <div class="form-group">
                    <label for="tel">Telefon</label>
                    <input required type="text" class="form-control" id="tel" name="tel">
                  </div>
                  <div class="form-group">
                    <label for="emailSign">Email adresa:</label>
                    <input required type="email" class="form-control" id="emailSign" name="email">
                  </div>
                  <div class="form-group">
                    <label for="pwdSign">Lozinka:</label>
                    <input required type="password" class="form-control" id="pwdSign" name="pwd">
                  </div>
                  <div class="form-group">
                    <label for="pwdConfirm">Potvrda lozinke:</label>
                    <input required type="password" class="form-control" id="pwdConfirm" name="pwdConf">
                  </div>
                  <button type="submit" class="btn btn-success mt-2" name="submit_registracija">Registracija</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </nav>
  <!-- rezervacija-->
  <div id="pozadina">
    <div class="container">
      <form action="./form_validation.php" method="get">
        <div class="row bg-secondary align-items-end pb-3">
          <div class="col-xxl" style="margin-top: 5px;">
            <label for="dolazak" style="color: white;">Dolazak</label>
            <input required class="form-control" id="dolazak" type="date" name="dolazak">
          </div>
          <div class="col-xxl" style="margin-top: 5px;">
            <label for="odlazak" style="color: white;">Odlazak</label>
            <input required class="form-control" id="odlazak" type="date" name="odlazak">
          </div>
          <div class="col-xxl" style="margin-top: 5px;">
            <label for="tipSobe" style="color: white;">Tip sobe</label>
            <select required class="form-control" name="tipSobe" id="tipSobe">
              <option value="1">Jednokrevetna</option>
              <option value="2">Dvokreventa</option>
              <option value="3">Trokrevetna</option>
              <option value="4">Cetvorokrevetna</option>
            </select>
          </div>
          <div class="col-xxl" style="margin-top: 5px;">
            <label for="hotel" style="color: white;">Odaberite hotel</label>
            <select required class="form-control" name="hotel" id="hotel">
              <?php
$sql = "SELECT NAZIV FROM `hotel`";
$i = 0;
if ($result = $mysqli->query($sql)) {
    while ($row = $result->fetch_row()) {
        $i++;
        echo "<option value=" . $i . ">" . $row[0] . "</option>";
    }
    $result->free_result();
}
?>
            </select>
          </div>
          <div class="col-xxl" style="margin-top: 5px;">
            <input required class="form-control" type="text" id="ime" placeholder="Ime" name="ime">
          </div>
          <div class="col-xxl" style="margin-top: 5px;">
            <input required class="form-control" type="text" id="prezime" placeholder="Prezime" name="prezime">
          </div>
          <div class="col-xxl" style="margin-top: 5px;">
            <input required class="form-control" type="text" id="telefon" placeholder="Kontakt telefon" name="tel">
          </div>
          <div class="col-xxl" style="margin-top: 5px;">
            <input class="form-control btn btn-info" type="submit" value="Rezervisi" name="brzaRezervacija">
          </div>
      </form>
    </div>
  </div>
  <div style="text-align: center;" class="container bg-dark text-light">
    <p><?php
if (isset($_GET["greska"])) {
    $greska = $_GET["greska"];

    if ($greska == 'ime') {
        echo "Neispravan unos imena! Dozvoljeno unositi samo slova";
    }
    if ($greska == 'prezime') {
        echo "Neispravan unos prezimena! Dozvoljeno unositi samo slova";
    }
    if ($greska == 'tel') {
        echo "Neispravan unos broja! Dozvoljeno unositi samo brojeve";
    }
    if ($greska == 'datum') {
        echo "Neispravan unos datuma!";
    }
    if ($greska == 'success') {
        echo "Uspjesno ste rezervisali! Ukupna cijena je: " . $_GET["cijena"] . " EUR";

    }
    if ($greska == 'kapacitet') {
        echo "Smjestajni kapaciteti su popunjeni";
    }

}

if (isset($_GET["greskaSign"])) {
    $greskaSign = $_GET["greskaSign"];

    if ($greskaSign == 'email') {
        echo "Uneseni email vec postoji!";
    }
    if ($greskaSign == 'ime') {
        echo "Ime nije ispravno uneseno!";
    }
    if ($greskaSign == 'prezime') {
        echo "Prezime nije ispravno uneseno!";
    }
    if ($greskaSign == 'tel') {
        echo "Telefon nije ispravno unesen!";
    }
    if ($greskaSign == 'success') {
        echo "uspjesno dodat nalog!";
    }

}
if (isset($_GET["greskaLogin"])) {
    $greskaLogin = $_GET["greskaLogin"];

    if ($greskaLogin == 'notFound') {
        echo "Korisnik nije pronadjen!";
    }
    if ($greskaLogin == 'blokiran') {
        echo "Korisnik je blokiran!";
    }
    if ($greskaLogin == 'odobreno') {
        echo "Ceka se odobrenje administracije!";
    }
    if ($greskaLogin == 'verifikacija') {
        echo "Nije verifikovan email!";
    }
}
?>
    </p>
  </div>
  </div>
  <!-- natpis-->
  <div class="container" id="oNama" style="text-align: center;">
    <img src="./PNG/crown.png" alt="logo">
    <h1 class="mx-auto">Dobrodosli u hotel KING</h1>
    <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Ullam atque quas velit id nostrum, quasi officiis
      cupiditate amet modi porro dignissimos assumenda cum et. Molestiae accusamus magnam placeat voluptate nesciunt?
    </p>
  </div>
  <!-- Galerija -->
  <div class="container" id="galerija">

    <h1 class="fw-light text-center text-lg-start mt-4 mb-0">Galerija</h1>

    <hr class="mt-2 mb-5">

    <div class="row text-center text-lg-start mb-4">

      <div class="col-lg-3 col-md-4 col-6 zoom">
        <a href="#" class="d-block mb-4 h-100">
          <img class="img-fluid img-thumbnail"
            src="https://images.unsplash.com/photo-1590073242678-70ee3fc28e8e?ixlib=rb-1.2.1&ixid=MnwxMjA3fDF8MHxzZWFyY2h8OHx8aG90ZWx8ZW58MHx8MHx8&auto=format&fit=crop&w=500&q=60"
            alt="">
        </a>
      </div>
      <div class="col-lg-3 col-md-4 col-6 zoom">
        <a href="#" class="d-block mb-4 h-100">
          <img class="img-fluid img-thumbnail"
            src="https://images.unsplash.com/photo-1568495248636-6432b97bd949?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxzZWFyY2h8Mnx8aG90ZWwlMjByb29tfGVufDB8fDB8fA%3D%3D&auto=format&fit=crop&w=500&q=60"
            alt="">
        </a>
      </div>
      <div class="col-lg-3 col-md-4 col-6 zoom">
        <a href="#" class="d-block mb-4 h-100">
          <img class="img-fluid img-thumbnail"
            src="https://images.unsplash.com/photo-1611892440504-42a792e24d32?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxzZWFyY2h8M3x8aG90ZWwlMjByb29tfGVufDB8fDB8fA%3D%3D&auto=format&fit=crop&w=500&q=60"
            alt="">
        </a>
      </div>
      <div class="col-lg-3 col-md-4 col-6 zoom">
        <a href="#" class="d-block mb-4 h-100">
          <img class="img-fluid img-thumbnail"
            src="https://images.unsplash.com/flagged/photo-1556438758-8d49568ce18e?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxzZWFyY2h8N3x8aG90ZWwlMjByb29tfGVufDB8fDB8fA%3D%3D&auto=format&fit=crop&w=500&q=60"
            alt="">
        </a>
      </div>
      <div class="col-lg-3 col-md-4 col-6 zoom">
        <a href="#" class="d-block mb-4 h-100">
          <img class="img-fluid img-thumbnail"
            src="https://images.unsplash.com/photo-1631049552057-403cdb8f0658?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxzZWFyY2h8MjZ8fGhvdGVsJTIwcm9vbXxlbnwwfHwwfHw%3D&auto=format&fit=crop&w=500&q=60"
            alt="">
        </a>
      </div>
      <div class="col-lg-3 col-md-4 col-6 zoom">
        <a href="#" class="d-block mb-4 h-100">
          <img class="img-fluid img-thumbnail"
            src="https://images.unsplash.com/photo-1595161695996-f746349f4945?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxzZWFyY2h8MTd8fGhvdGVsJTIwcm9vbXxlbnwwfHwwfHw%3D&auto=format&fit=crop&w=500&q=60"
            alt="">
        </a>
      </div>
      <div class="col-lg-3 col-md-4 col-6 zoom">
        <a href="#" class="d-block mb-4 h-100">
          <img class="img-fluid img-thumbnail"
            src="https://images.unsplash.com/photo-1595576508898-0ad5c879a061?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxzZWFyY2h8Mjd8fGhvdGVsJTIwcm9vbXxlbnwwfHwwfHw%3D&auto=format&fit=crop&w=500&q=60"
            alt="">
        </a>
      </div>
      <div class="col-lg-3 col-md-4 col-6 zoom">
        <a href="#" class="d-block mb-4 h-100">
          <img class="img-fluid img-thumbnail"
            src="https://images.unsplash.com/photo-1631049421450-348ccd7f8949?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxzZWFyY2h8MzB8fGhvdGVsJTIwcm9vbXxlbnwwfHwwfHw%3D&auto=format&fit=crop&w=500&q=60"
            alt="">
        </a>
      </div>
      <div class="col-lg-3 col-md-4 col-6 zoom">
        <a href="#" class="d-block mb-4 h-100">
          <img class="img-fluid img-thumbnail"
            src="https://images.unsplash.com/photo-1630660664869-c9d3cc676880?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxzZWFyY2h8MzR8fGhvdGVsJTIwcm9vbXxlbnwwfHwwfHw%3D&auto=format&fit=crop&w=500&q=60"
            alt="">
        </a>
      </div>
      <div class="col-lg-3 col-md-4 col-6 zoom">
        <a href="#" class="d-block mb-4 h-100">
          <img class="img-fluid img-thumbnail"
            src="https://images.unsplash.com/photo-1618221823713-ca8c0e6c9992?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxzZWFyY2h8Mzh8fGhvdGVsJTIwcm9vbXxlbnwwfHwwfHw%3D&auto=format&fit=crop&w=500&q=60"
            alt="">
        </a>
      </div>
      <div class="col-lg-3 col-md-4 col-6 zoom">
        <a href="#" class="d-block mb-4 h-100">
          <img class="img-fluid img-thumbnail"
            src="https://images.unsplash.com/photo-1605346487646-c73353b2fec2?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxzZWFyY2h8NTF8fGhvdGVsJTIwcm9vbXxlbnwwfHwwfHw%3D&auto=format&fit=crop&w=500&q=60"
            alt="">
        </a>
      </div>
      <div class="col-lg-3 col-md-4 col-6 zoom">
        <a href="#" class="d-block mb-4 h-100">
          <img class="img-fluid img-thumbnail"
            src="https://images.unsplash.com/photo-1592229505678-cf99a9908e03?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxzZWFyY2h8NTN8fGhvdGVsJTIwcm9vbXxlbnwwfHwwfHw%3D&auto=format&fit=crop&w=500&q=60"
            alt="">
        </a>
      </div>
    </div>

  </div>
  <div class="container">
    <h1 class="fw-light text-center text-lg-start mt-4 mb-0">Osnovna ponuda</h1>

    <hr class="mt-2 mb-5">
    <div class="row">
      <div class="col-sm-3">
        <div class="card kartica">
          <img class="card-img-top" src="./sobe/s1.jpg" alt="Card image cap">
          <div class="card-body">
            <h5 class="card-title">Jenokrevetna soba</h5>
            <p class="card-text"> <?php
$sql = "SELECT MIN(DNEVNA_CIJENA) FROM `hotel`";
$i = 0;
if ($result = $mysqli->query($sql)) {
    while ($row = $result->fetch_row()) {
        $i++;
        echo "Cijena: " . $row[0] . "-";
    }
    $result->free_result();
}
$sql = "SELECT MAX(DNEVNA_CIJENA) FROM `hotel`";
$i = 0;
if ($result = $mysqli->query($sql)) {
    while ($row = $result->fetch_row()) {
        $i++;
        echo $row[0] . " EUR";
    }
    $result->free_result();
}?> </p>
            <button class="btn btn-primary" onclick="prikazLevitation('1')">Rezervisi</button>
          </div>
        </div>
      </div>
      <div class="col-sm-3">
        <div class="card kartica">
          <img class="card-img-top" src="./sobe/s2.jpg" alt="Card image cap">
          <div class="card-body">
            <h5 class="card-title">Dvokrevetna soba</h5>
            <p class="card-text"><?php
$sql = "SELECT MIN(DNEVNA_CIJENA) FROM `hotel`";
$i = 0;
if ($result = $mysqli->query($sql)) {
    while ($row = $result->fetch_row()) {
        $i++;
        echo "Cijena: " . ($row[0] * 1.85) . "-";
    }
    $result->free_result();
}
$sql = "SELECT MAX(DNEVNA_CIJENA) FROM `hotel`";
$i = 0;
if ($result = $mysqli->query($sql)) {
    while ($row = $result->fetch_row()) {
        $i++;
        echo ($row[0] * 1.85) . " EUR";
    }
    $result->free_result();
}?></p>
            <button class="btn btn-primary" onclick="prikazLevitation('2')">Rezervisi</button>
          </div>
        </div>
      </div>
      <div class="col-sm-3">
        <div class="card kartica">
          <img class="card-img-top" src="./sobe/s3.jpg" alt="Card image cap">
          <div class="card-body">
            <h5 class="card-title">Trokrevetna soba</h5>
            <p class="card-text"><?php
$sql = "SELECT MIN(DNEVNA_CIJENA) FROM `hotel`";
$i = 0;
if ($result = $mysqli->query($sql)) {
    while ($row = $result->fetch_row()) {
        $i++;
        echo "Cijena: " . ($row[0] * 2.75) . "-";
    }
    $result->free_result();
}
$sql = "SELECT MAX(DNEVNA_CIJENA) FROM `hotel`";
$i = 0;
if ($result = $mysqli->query($sql)) {
    while ($row = $result->fetch_row()) {
        $i++;
        echo ($row[0] * 2.75) . " EUR";
    }
    $result->free_result();
}?></p>
            <button class="btn btn-primary" onclick="prikazLevitation('3')">Rezervisi</button>
          </div>
        </div>
      </div>
      <div class="col-sm-3">
        <div class="card kartica">
          <img class="card-img-top" src="./sobe/s4.jpg" alt="Card image cap">
          <div class="card-body">
            <h5 class="card-title">Cetvorokrevetna soba</h5>
            <p class="card-text"><?php
$sql = "SELECT MIN(DNEVNA_CIJENA) FROM `hotel`";
$i = 0;
if ($result = $mysqli->query($sql)) {
    while ($row = $result->fetch_row()) {
        $i++;
        echo "Cijena: " . ($row[0] * 3.65) . "-";
    }
    $result->free_result();
}
$sql = "SELECT MAX(DNEVNA_CIJENA) FROM `hotel`";
$i = 0;
if ($result = $mysqli->query($sql)) {
    while ($row = $result->fetch_row()) {
        $i++;
        echo ($row[0] * 3.65) . " EUR";
    }
    $result->free_result();
}?></p>
            <button class="btn btn-primary" onclick="prikazLevitation('4')">Rezervisi</button>
          </div>
        </div>
      </div>
    </div>

  </div>
  <!-- kartice-->

  <!--footer-->

  <footer class="text-center text-lg-start bg-dark text-muted text-light pt-1 mt-5" id="kontakt">
    <section>
      <div class="container text-center text-md-start mt-5">
        <!-- Grid row -->
        <div class="row mt-3">
          <!-- Grid column -->
          <div class="col-xl-3 col-md-6 mx-auto">
            <!-- Content -->
            <a href="#"><img src="./PNG/crown.png" alt="king"></a>
            <h6 class="text-uppercase fw-bold mb-4">
              <i class="fas fa-gem"></i>Hotel KING
            </h6>

            <p>
              Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ex dolorum, distinctio corporis quos architecto
              aspernatur consectetur ut in illo cupiditate doloremque nihil vero eaque rerum accusantium, magnam
              nesciunt eum! Earum!

            </p>
          </div>

          <div class=" col-xl-3  col-md-6 mx-auto">
            <!-- Links -->
            <h6 class="text-uppercase fw-bold mb-4">
              Drustvene mreze
            </h6>
            <p>
              <a href="https://www.instagram.com/" class="text-reset"><img src="./social/instagram.png" alt="insta"></a>
            </p>
            <p>
              <a href="https://www.facebook.com/" target="_blank" class="text-reset"><img src="./social/facebook.png"
                  alt="insta"></a>
            </p>
          </div>

          <div class="col-xl-3 col-md-6 mx-auto">
            <!-- Links -->
            <h6 class="text-uppercase fw-bold mb-4">
              Kontakti
            </h6>
            <p><i class="fas fa-home me-3"></i> Vuka Karadžića 30, Lukavica 71123</p>
            <p>
              <i class="fas fa-envelope me-3"></i>
              info@example.com
            </p>
            <p><i class="fas fa-phone me-3"></i> + 387 65 225 225 </p>
            <p><i class="fas fa-print me-3"></i> + 387 65 225 225 </p>
          </div>
          <div class="col-xl-3 col-md-6 mx-auto ">
            <div id="mapa">
              <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2878.5666482514293!2d18.372230515415847!3d43.823347449429704!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4758c9b6cf9dbc53%3A0x528ccd6928b807b8!2z0JXQu9C10LrRgtGA0L7RgtC10YXQvdC40YfQutC4INGE0LDQutGD0LvRgtC10YIg0KPQvdC40LLQtdGA0LfQuNGC0LXRgtCwINGDINCY0YHRgtC-0YfQvdC-0Lwg0KHQsNGA0LDRmNC10LLRgw!5e0!3m2!1ssr!2sba!4v1639605062693!5m2!1ssr!2sba"
                style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            </div>


          </div>

        </div>

      </div>
    </section>


    <!-- Copyright -->
    <div class="text-center p-4" style="background-color: rgba(0, 0, 0, 0.05);">
      © 2021 Copyright:
    </div>
    <!-- Copyright -->
  </footer>

  <script src="./js.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
    integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
    integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
  </script>

</body>

</html>