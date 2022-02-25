<?php
session_start();
require_once "../../connection.php";
if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];

    $sql = "SELECT * FROM `korisnik` WHERE EMAIL = '$email';";

    if ($result = $mysqli->query($sql)) {
        $row = $result->fetch_row();
        $id_prijavljenog_korisnika=$row[0];
        $_SESSION['id_prijavljenog_korisnika']=$row[0];
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


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Korisnik</title>
  <link rel="stylesheet" href="./style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>

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
            <button class="btn  text-light" type="submit" style="background: cadetblue;" onclick="logout()">Log
              out</button>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <!--Moj nav -->

  <!--Forma za pretragu -->
  <div class="container mt-3 mb-3 pb-3 ps-5" style="width: 80%; height:15%; background: #8080807a;border-radius: 20px;">
    <form id="forma_za_pretragu">
      <div class="form-group">
        <label for="grad_drzava" class="form-label mt-1 mb-1"
          style="color: black; font-weight: bold;">Grad/Drzava</label><br>
        <select id="grad_drzava" class="form-control">
          <option>Type to search...</option>
          <?php

              require_once "../../connection.php";
              $sql = "SELECT g.NAZIV as naziv_grada,d.NAZIV as naziv_drzave FROM `grad` g JOIN drzava d ON g.ID_DRZAVA=d.ID_DRZAVA";
              $result=$mysqli->query($sql);
              if($result->num_rows>0)
              {
              while ($row = $result->fetch_assoc()) {
                     
                      $grad = $row["naziv_grada"];
                      $drzava = $row["naziv_drzave"];
                      
                      ?>
          <option value=<?php echo $grad.",".$drzava?>><?php echo $grad.",".$drzava?> </option>
          <?php
                    
                  }}
                 

        ?>


        </select>
      </div>
      <div class="form-group">
        <label for="br_osoba" class="form-label mt-1 mb-1" style="color: black; font-weight: bold;">Broj osoba</label>
        <input type="text" class="form-control" id="br_osoba" placeholder="Unesite br osoba">
      </div>
      <div class="form-group">
        <label for="br_zvjezdica" class="form-label mt-1 mb-1" style="color: black; font-weight: bold;">Broj
          zvjezdica</label>
        <select class="form-control" id="br_zvjezdica">
          <option>1</option>
          <option>2</option>
          <option>3</option>
          <option>4</option>
          <option>5</option>
        </select>
      </div>
      <div class="form-group">
        <label for="dnevna_cijena" class="form-label mt-1 mb-1" style="color: black; font-weight: bold;">Dnevna
          cijena</label>
        <select class="form-control" id="dnevna_cijena">
          <option>0-10</option>
          <option>10-20</option>
          <option>20-30</option>
          <option>30-40</option>
          <option>40-50</option>
        </select>
      </div>
      <div class="form-group">
        <input class="form-check-input" type="checkbox" value="1" id="parking">
        <label class="form-check-label mt-1 mb-1" for="parking" style="color: black; font-weight: bold;">
          Parking
        </label>
      </div>
      <div class="form-group">
        <input class="form-check-input" type="checkbox" value="2" id="wifi">
        <label class="form-check-label mt-1 mb-1" for="wifi" style="color: black; font-weight: bold;">
          Wifi
        </label>
      </div>
      <div class="form-group">
        <input class="form-check-input" type="checkbox" value="3" id="dorucak">
        <label class="form-check-label mt-1 mb-1" for="dorucaK" style="color: black; font-weight: bold;">
          Doručak
        </label>
      </div>
      <button type="button" class="btn btn-sg form-group" style="background: cadetblue; color:white;"
        onclick="prikaziPretragu()">Pretraži</button>
    </form>
  </div>

  <!--Lista nadjenih hotela -->
  <div id="pronadjeni_hoteli" class="container" style="visibility:hidden; background: #8080807a;border-radius: 20px;">




  </div>

  <!--Poruke -->
  <div id="poruke_kor_menadzer" class="container pb-3 "
    style="width:40%; height:15%; margin-right:30%;margin-left:30%; margin-top:3%; padding-right:2%; padding-left:2%; background: #8080807a;border-radius: 20px; color:black; font-weight: bold;">
    <div class="row">
      <div class="col-6">
        <label class="mt-1 mb-1">Hotel</label>
        <select class="form-control" id="hotel_poruke" onchange="postaviMenadzere()">
          <option>Izaberite hotel </option>
          <?php
                    
                    require_once "../../connection.php";
                    $sql = "SELECT naziv,id_hotel FROM `hotel`";
                    $result=$mysqli->query($sql);
                    if($result->num_rows>0)
                    {
                    while ($row = $result->fetch_assoc()) {
                            
                            $naziv_hotela = $row["naziv"];
                            $id_hotela = $row["id_hotel"];
                            
                            ?>
          <option value="<?php echo $id_hotela?>"><?php echo $naziv_hotela?> </option>
          <?php
                          
                        }}
                        
                    
                    ?>
        </select>
      </div>
      <div class="col-6">
        <label class="mt-1 mb-1">Menadzer</label>
        <select id="menadzer_poruke" class="form-control" onchange="prikaziPoruke()">
          <option>Izaberite menadzera</option>


        </select>
      </div>
    </div>

    <div id="prikaz_poruka" style=" background: transparent; border-radius:20px; height:300px; border:0; margin-top:1%;"
      hidden>
      <div id="poruke" style="height: 250px; overflow: scroll; margin-top: 2%; ">




      </div>

      <form class="pt-1">
        <input type="text" style="margin-top: 1%;" class="form-control" name="poruka" id="nova_poruka"
          placeholder="unesite poruku" onchange="omoguciSlanje()">
        <button type="button" style="margin-top: 1%;" class="btn btn-success" id="dugme_posalji"
          onclick="posaljiPoruku()" disabled>Posalji</button>
      </form>
    </div>
  </div>

  <!--footer-->

  <footer class="text-center text-lg-start bg-dark text-muted text-light pt-1" id="kontakt" style="margin-top: 95px;">
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

  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
    integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
    integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
  </script>
</body>

</html>