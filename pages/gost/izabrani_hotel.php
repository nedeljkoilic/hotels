<?php
//provjeriti ovu stranu sto se tice preuzetih podataka
session_start();
require_once "../../connection.php";
if(isset($_SESSION['hotel']))
{
  $hotel=$_SESSION['hotel'];
  $sql = "SELECT ID_HOTEL FROM `hotel` where NAZIV='".$hotel."'";
  $result=$mysqli->query($sql);
  $row = $result->fetch_assoc();
  $id_hotela=$row['ID_HOTEL'];
}
if (isset($_SESSION['email'])) {
  $email = $_SESSION['email'];

  $sql = "SELECT * FROM `korisnik` WHERE EMAIL = '$email';";

  if ($result = $mysqli->query($sql)) {
      $row = $result->fetch_row();
      $id=$row[0];
      $ime = $row[1];
      $prezime = $row[2];
      $tel = $row[3];
      $result->free_result();

  }
}
else{
header("Location: http://localhost/project/index.php");
exit();
}

if(isset($_SESSION['hotel']) && isset($_SESSION['adresa']) && isset($_SESSION['wifi_izabr']) && isset($_SESSION['dorucak_izabr']) && isset($_SESSION['parking_izabr']) && isset($_SESSION['grad'])&&isset($_SESSION['zvjezdice'])&&isset($_SESSION['opis']))
{

 /* $_SESSION['grad']=$_GET['grad'];
  $_SESSION['hotel']=$_GET['hotel'];
  $_SESSION['zvjezdice']=$_GET['zvjezdice'];
  $_SESSION['adresa']=$_GET['adresa'];
  $_SESSION['opis']=$_GET['opis'];*/

  $hotel=$_SESSION['hotel'];
  $adresa=$_SESSION['adresa'];
  $wifi=$_SESSION['wifi_izabr'];
  $dorucak=$_SESSION['dorucak_izabr'];
  $parking=$_SESSION['parking_izabr'];
  $grad=$_SESSION['grad'];
  $zvjezdice=$_SESSION['zvjezdice'];
  $opis=$_SESSION['opis'];


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Izabrani hotel</title>
  <link rel="stylesheet" href="style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>

  <!-- Prijava hotela  ne radi iz nekog razloga-->
  <div id="div_za_prijave" hidden>
    <div id="prijava_hotela" class="bg-secondary">
      <div class="row">
        <h5 class="col col-12"> Prijava hotela</h3>
      </div>
      <div class="row">
        <label class="text-body col col-12 me-2">Unesite komentar o prijavi hotela</label>
      </div>
      <div class="row mt-1 mb-1 me-1 ms-1" style="align-items: center;">
        <textarea name="tekst_prijave" id="komentar_prijava_hotela" cols="30" rows="3" style="height: 10%;"></textarea>
      </div>
      <div class="row mt-2 mb-1 me-1 ms-1">
        <button onclick="prijaviHotel()" class="btn btn-sm btn-success col me-1">Prijavi</button>
        <button onclick="otkaziPrijavu()" class="btn btn-sm btn-danger col ms-1">Otkazi</button>
      </div>
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
                href="moje_rezervacije.php" style="text-decoration: none; color:white;">Moje rezervacije</a></button>
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
            <button class="btn text-light" type="submit" style="background: cadetblue; " onclick="logout()">Log
              out</button>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <!--Moj nav -->

  <div class="container">
    <h2 style="text-align:center; font-family: Verdana, Geneva, Tahoma, sans-serif; font-weight: bold;" class="mt-3">
      <?php echo $hotel?></h2>
    <div class="row mt-3" id="adresa_karta">
      <div class="col-6 text-center mb-2" style="font-weight: bold; color:black; font-style: italic;">
        <p><?php echo $adresa ?></p>
        <a href="mapa">Karta</a>
      </div>
      <div class="col-6 text-center mb-2">
        <button class="btn btn-primary text-dark btn-sg"
          onclick="prikaziPrijavuHotela(<?php echo $id?>,<?php echo $id_hotela ?>)">Prijavi</button>


      </div>
    </div>
  </div>
  <!-- Galerija -->
  <!-- Page Content -->
  <div class="container" id="galerija">
    <h3 class=" text-center  mt-1 mb-0" style="font-weight: bold; color:black;">Galerija</h3>
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
            src="https://images.unsplash.com/flagged/photo-1556438758-8d49568ce18e?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxzZWFyY2h8N3x8aG90ZWwlMjByb29tfGVufDB8fDB8fA%3D%3D&auto=format&fit=crop&w=500&q=60"
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
    </div>
  </div>
  <!--Opis hotela-->
  <div class="container">
    <hr class="mt-2 mb-2">
    <h3 style="text-align: center;" style="font-weight: bold; color:black;"><?php echo $opis?></h3>
    <hr class="mt-2 mb-2">
  </div>
  <!--Posebne karakteristike-->
  <div class="container">
    <h3 style="text-align: center;" style="font-weight: bold; color:black;">Posebne karakteristike</h3><br>
    <div class="row">

      <?php
      
      if($wifi==1 && $dorucak==1 && $parking==1)
      {?>
      <div class="col col-4" style="text-align: center;">
        <p style="font-weight: bold; color:black;">WiFi <img src="wifi.png" style="width: 10%;"></p>
      </div>
      <div class="col col-4" style="text-align: center;">
        <p style="font-weight: bold; color:black;">Restoran <img src="restoran.png" style="width: 10%;"></p>
      </div>
      <div class="col col-4" style="text-align: center;">
        <p style="font-weight: bold; color:black;">Parking <img src="parking.png" style="width: 10%;"></p>
      </div>

      <?php
      }
      if($wifi==1 && $dorucak==1 && $parking==0)
      {
          ?>
      <div class="col col-6" style="text-align: center;">
        <p style="font-weight: bold; color:black;">WiFi <img src="wifi.png" style="width: 10%;"></p>
      </div>

      <div class="col col-6" style="text-align: center;">
        <p style="font-weight: bold; color:black;">Restoran <img src="restoran.png" style="width: 10%;"></p>
      </div>

      <?php
      }
      if($wifi==1 && $dorucak==0 && $parking==1)
      {
          ?>
      <div class="col col-6" style="text-align: center;">
        <p style="font-weight: bold; color:black;">WiFi <img src="wifi.png" style="width: 10%;"></p>
      </div>
      <div class="col col-6" style="text-align: center;">
        <p style="font-weight: bold; color:black;">Parking <img src="parking.png" style="width: 10%;"></p>
      </div>

      <?php
      }
      if($wifi==0 && $dorucak==1 && $parking==1)
      {
          ?>
      <div class="col col-6" style="text-align: center;">
        <p style="font-weight: bold; color:black;">Restoran <img src="restoran.png" style="width: 10%;"></p>
      </div>
      <div class="col col-6" style="text-align: center;">
        <p style="font-weight: bold; color:black;">Parking <img src="parking.png" style="width: 10%;"></p>
      </div>
      <?php
      }
      ?>
    </div>
    <hr class="mt-2 mb-2">
  </div>

  <!--Dostupnost-->
  <div class="container">
    <h3 style="text-align: center;" style="font-weight: bold; color:black;">Dostupnost</h3>
  </div>
  <div class="container pb-4" style="width: 80%; height:25%; background: #8080807a;border-radius: 20px;">
    <p style="font-weight: bold; color:black;margin-left:5%">Kada želite da boravite u hotelu?</p>
    <form action="sobe.php" method="$_GET">

      <div class="row" style="width: 70%; margin-left:5%;margin-right:5%;">
        <div class="col col-8 col-sm-3" style="margin-top: 5px;">
          <label for="dolazak" style="font-weight: bold; color:black;">Dolazak</label><br>
          <input required class="form-control mt-2" id="dolazak" name="dolazak" type="date">
        </div>
        <div class="col col-8 col-sm-3" style="margin-top: 5px;">
          <label for="odlazak" style="font-weight: bold; color:black;">Odlazak</label><br>
          <input required class="form-control mt-2" id="odlazak" name="odlazak" type="date">
        </div>
        <div class="col col-8 col-sm-3" style="margin-top: 5px;">
          <label style="font-weight: bold; color:black;">Sobe</label>
          <select class="form-select mt-2" name="tip_sobe" id="tip_sobe">
            <option selected>Tip sobe</option>
            <option value="1">Jednokrevetna</option>
            <option value="2">Dvokrevetna</option>
            <option value="3">Trokrevetna</option>
            <option value="4">Četverokrevetna</option>
          </select>
        </div>
        <div class="col col-4 col-sm-2" style="margin-top: 5px; text-align: center;">
          <label style="font-weight: bold; color:black;">Osobe</label>
          <select class="form-select mt-2" name="broj_osoba" id="broj_osoba">
            <option selected>Broj osoba</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
          </select>
        </div>

        <div class="col col-2 col-sm-1 mt-2" style="margin-top: 20px;">
          <button type="submit" class="btn btn-secondary btn-sm">Pretraži</button>
        </div>


      </div>
    </form>

  </div>
  <div class="container">
    <hr class=" mt-5 mb-3 col-12">
    <p class="text-dark" style="font-weight: bold; color:black; text-align:center;">Nije potrebna kreditna kartica za
      rezervaciju. Poslaćemo Vam email za potvrdu rezervacije!</p>
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
      © 2021 Copyright: Andja&Nedjo
    </div>
    <!-- Copyright -->
  </footer>
  <!-- Footer -->

  <script src="./funkcije.js"></script>
  <script src="./js.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
    integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
    integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
  </script>
</body>

</html>
<?php
}
else  header("Location: http://localhost/project/pages/gost/korisnik.php");
  exit();
?>