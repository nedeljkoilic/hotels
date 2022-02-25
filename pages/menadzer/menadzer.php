<?php
session_start();
require_once "../../connection.php";
if (isset($_SESSION['emailMenadzer'])) {
    $email = $_SESSION['emailMenadzer'];

    $sql = "SELECT * FROM `menadzer` WHERE EMAIL = '$email';";

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

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Menadzer</title>
  <link rel="stylesheet" href="./css_menadzer.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
  <nav class="navbar navbar-dark navbar-expand-sm bg-dark text-light">
    <div class="container-fluid">

      <h1 class="navbar-brand"> <?php echo $ime . " " . $prezime; ?> </h1>


      <div class="mx-auto ">

      </div>
      <button class="btn btn-primary"><a href="./odjava_menazder.php"
          style="text-decoration: none; color: white;">Odjava</a> </button>
  </nav>


  <div class="container rounded_transparent">

    <h1>rezervacije u mojim hotelima</h1>
    <div class="row align-items-end ">
      <div class="col-3">
        <div class="form-group mb-2">
          <label for="izbor_hotela">Izaberi hotel</label>
          <select class="form-control" id="izbor_hotela">
            <option>Default select</option>
            <?php
$sql = "SELECT h.NAZIV FROM `menadzeri_hotela` mh join hotel h on h.ID_HOTEL=mh.ID_HOTEL where mh.ID_MENADZER='$id'";
if ($result = $mysqli->query($sql)) {
    while ($row = $result->fetch_row()) {
        $imeHotela = $row[0];
        echo "<option>" . $imeHotela . "</option>";
    }

}

?>
          </select>
        </div>
      </div>
      <div class="col-3">
        <div class="form-group mb-2">
          <label for="od">Od</label>
          <input type="date" name="od" id="od" class="form-control">
        </div>
      </div>
      <div class="col-3">
        <div class="form-group mb-2">
          <label for="do">Do</label>
          <input type="date" name="do" id="do" class="form-control">
        </div>
      </div>
      <div class="col-3 pb-2">
        <button type="submit" class="btn btn-primary" onclick="rezervacije('izbor_hotela')">Pretrazi</button>
        <button type="button" class="btn btn-success" onclick="generatePDF()">Generisi PDF</button>
      </div>
    </div>
  </div>
  <div class="container rounded_transparent" id="test">


  </div>

  <div class="container" style="    background: none;
    border: none;">
    <div class="row">
      <div class="col-lg-6 col-md-12 rounded_transparent">
        <div class="row">
          <div class="col-6">
            <h1>Poruke </h1>
          </div>
          <div class="col-6">
            <select name="sagovornik" id="sagovornik" class="form-control" onchange="poruke(<?php echo $id; ?>)">
              <option value="0">Sagovornik</option>
              <?php
$sql = "SELECT DISTINCT p.ID_KORISNIK, k.IME, k.PREZIME FROM `poruke` p join korisnik k on k.ID_KORISNIK=p.ID_KORISNIK WHERE id_menadzer=" . $id;

if ($result = $mysqli->query($sql)) {
    while ($row = $result->fetch_row()) {
        $id_korisnika = $row[0];
        $ime_korisnika = $row[1];
        $prezime_korisnika = $row[2];
        $boja = "white";
        $sql1 = "SELECT * FROM `poruke` WHERE ID_KORISNIK=" . $id_korisnika . " and poslao_korisnik=1 and procitano=0;";
        if ($result1 = $mysqli->query($sql1)) {
            while ($row1 = $result1->fetch_row()) {
                $boja = "red";
            }
        }
        echo "<option value='" . $id_korisnika . "' style='background-color: " . $boja . ";' >" . $ime_korisnika . " " . $prezime_korisnika . "</option>";
    }
}

?>
            </select>
          </div>
        </div>

        <div id="poruke" style="height: 250px; overflow: scroll;">




        </div>


        <input type="text" class="form-control" name="poruka" id="nova_poruka" placeholder="unesite poruku" disabled>
        <button type="submit" class="btn btn-success" id="dugme_posalji" disabled
          onclick="posalji_poruku('nova_poruka','<?php echo $id; ?>')">Posalji</button>

      </div>
      <div class="col-lg-6 col-md-12 rounded_transparent">
        <h1>Dodaje novi hotel na listu</h1>
        <div class="form-group mb-2">
          <form action="./dodaj_hotel.php" method="get">
            <input type="text" name="id_menadzera" value="<?php echo $id ?>" hidden>
            <label for="izbor_hotela">Izaberi hotel</label>
            <select class="form-control" id="izbor_hotela" name="id_dodatog_hotela">
              <option>Default select</option>
              <?php

$niz_hotela = array();
$sql = "SELECT mh.ID_HOTEL FROM `menadzeri_hotela` mh where mh.ID_MENADZER=" . $id;
if ($result = $mysqli->query($sql)) {
    while ($row = $result->fetch_row()) {
        $id_hotela_menadzera = $row[0];
        array_push($niz_hotela, $id_hotela_menadzera);
    }

}
$sql = "SELECT h.NAZIV, h.ID_HOTEL FROM hotel h ";
if ($result = $mysqli->query($sql)) {
    while ($row = $result->fetch_row()) {
        $imeHotela = $row[0];
        $id_hot = $row[1];
        $indikator = 0;
        foreach ($niz_hotela as $value) {
            if ($value == $id_hot) {
                $indikator = 1;
            }
        }
        if ($indikator == 0) {
            echo "<option value='" . $id_hot . "' >" . $imeHotela . "</option>";
        }

    }

}

?>
            </select>

        </div>
        <button type="submit" class="btn btn-primary form-control" id="dodaj_hotel">Dodaj hotel</button>
        </form>
      </div>
    </div>
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.debug.js"></script>
  <script src="./skripta.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
  </script>
</body>

</html>