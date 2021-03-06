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
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Drugi korisnici</title>
  <link rel="stylesheet" href="style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>

<body>
  <div id='div_prijave' hidden>
    <div id="prijava" class="container bg-secondary">

      <div class="row  mt-2">
        <h5 class="col"> Prijava korisnika</h5>
      </div>
      <div class="row ">
        <label class="text-body col ">Unesite komentar o prijavi korisnika</label>
      </div>
      <div class="row mt-1 mb-1 me-1 ms-1" style="align-items: center;">
        <textarea name="tekst_prijave" id="kom_o_prijavi" cols="30" rows="3" style="height: 10%;"></textarea>
      </div>
      <div class="row mt-2 mb-1 me-1 ms-1">
        <button class="btn btn-sm btn-success col me-1" onclick="prijavi()">Prijavi</button>
        <button class="btn btn-sm btn-danger col ms-1" onclick="zatvori_prijavu()">Zatvori</button>
      </div>
    </div>
  </div>
  <div id='div_za_blur' style="min-height: 333px; margin-bottom: 10px;">
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
                  href="./izabrani_hotel.php" style="text-decoration: none; color:white;">Hotel</a></button>
            </li>
            <li class="nav-item">
              <button class="btn text-light" style="background: cadetblue; margin-right: 3px;"> <a
                  href="./moje_rezervacije.php" style="text-decoration: none; color:white;">Moje
                  rezervacije</a></button>
            </li>
            <li class="nav-item">
              <button class="btn text-light" style="background: cadetblue; margin-right: 3px;"> <a href="./korisnik.php"
                  style="text-decoration: none; color:white;">Pocetna</a></button>
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

    <?php

$sql = "SELECT ID_KORISNIK,IME,PREZIME FROM `korisnik` WHERE REGISTROVAN=1 AND ID_KORISNIK!=" . $id;
$result = $mysqli->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {

        $id_korisnika = $row['ID_KORISNIK'];
        $ime_korisnika = $row['IME'];
        $prezime_korisnika = $row['PREZIME'];
        ?>
    <div class="container" id="kartice_korisnika">
      <div class="row mt-3">
        <div class="card " style="background-color:#dee2e6 ;">
          <div class="card-body ">
            <div class="row ">
              <div class="col col-4 mt-2">
                <label><?php echo $ime_korisnika ?></label>
              </div>
              <div class="col col-4 mt-2">
                <label><?php echo $prezime_korisnika ?></label>
              </div>
              <div class="col col-4 mt-2">
                <button onclick="prikaziPrijavu(<?php echo $id ?>, <?php echo $id_korisnika ?>)"
                  id="dugme_prijava">Prijavi</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <?php

    }}

?>
  </div>

  <!--footer-->

  <footer class="text-center text-lg-start bg-dark text-muted text-light pt-1 " id="kontakt">
    <section>
      <div class="container text-center text-md-start mt-5">
        <!-- Grid row -->
        <div class="row mt-3">
          <!-- Grid column -->
          <div class="col-xl-3 col-md-6 mx-auto">
            <!-- Content -->
            <a href="#"><img src="../../PNG/crown.png" alt="king"></a>
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
              <a href="https://www.instagram.com/" class="text-reset"><img src="../../social/instagram.png"
                  alt="insta"></a>
            </p>
            <p>
              <a href="https://www.facebook.com/" target="_blank" class="text-reset"><img
                  src="../../social/facebook.png" alt="fb"></a>
            </p>
          </div>

          <div class="col-xl-3 col-md-6 mx-auto">
            <!-- Links -->
            <h6 class="text-uppercase fw-bold mb-4">
              Kontakti
            </h6>
            <p><i class="fas fa-home me-3"></i> Vuka Karad??i??a 30, Lukavica 71123</p>
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
      ?? 2021 Copyright: Andja&Nedjo
    </div>
    <!-- Copyright -->
  </footer>

  <!-- Footer -->
  <script src="./funkcije.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
    integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
    integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
  </script>
</body>

</html>