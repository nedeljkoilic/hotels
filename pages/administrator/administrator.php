<?php
session_start();
require_once "../../connection.php";
if (isset($_SESSION['emailAdministrator'])) {
    $email= $_SESSION['emailAdministrator'];

    $sql = "SELECT * FROM `administrator` WHERE EMAIL = '$email';";

    if ($result = $mysqli->query($sql)) {
        $row = $result->fetch_row();
        $ime = $row[1];
        $prezime = $row[2];

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
    <title>Admin</title>
    <link rel="stylesheet" href="./css_admin.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
    <nav class="navbar navbar-dark navbar-expand-sm bg-dark text-light">
        <div class="container-fluid">

            <h1 class="navbar-brand"> <?php echo $ime." ".$prezime ?> </h1>
            <div class="mx-auto ">
            </div>
            <button class="btn btn-primary"><a href="./odjava_administrator.php"
                    style="text-decoration: none; color: white;">Odjava</a> </button>
    </nav>

    <div class="container  mt-2" style="background: none; border: none;">
        <h1>Prituzbe</h1>
        <?php
                $sql="SELECT p.ID_PRITUZBE, p.TEKST_PRITUZBE, k.IME, k.PREZIME,k1.IME, k1.PREZIME, h.NAZIV, k1.ID_KORISNIK, k1.BLOKIRAN FROM `prituzbe` p LEFT JOIN korisnik k on p.ID_KORISNIK=k.ID_KORISNIK LEFT JOIN korisnik k1 on k1.ID_KORISNIK=p.KOR_ID_KORISNIK LEFT JOIN hotel h ON h.ID_HOTEL = p.ID_HOTEL;";
                if($result=$mysqli->query($sql))
                {
                        while($row=$result->fetch_row())
                        {
                            $id_prituzbe=$row[0];
                            $tekst=$row[1];
                            $ime_podnosioca=$row[2];
                            $prezime_podnosioca=$row[3];
                            $ime_kor2=$row[4];
                            $prezime_kor2=$row[5];
                            $naziv_hotela=$row[6];
                            $id_kor2 = $row[7];
                            $blokiran = $row[8];
                            if ($naziv_hotela==null && !$blokiran) {
                               echo '<div class="row bg-secondary mt-2 container rounded_transparent" style="background-color: hsl(78deg 18% 35%)!important;" id="'.$id_prituzbe.'">

                                    <div class="col-4 ">
                                        <h3>Podnosilac prituzbe</h3>
                                        <h3> '.$ime_podnosioca.' '.$prezime_podnosioca.' </h3>
                                        <p>'.$tekst.'</p>
                                    </div>
                                    <div class="col-4">
                                        <h3>Protiv: '.$ime_kor2.' '.$prezime_kor2.'</h3>
                                    </div>
                                    <div class="col-4" style="text-align: center;">
                                        <div class="dropdown">
                                            <button class="btn btn-secondary dropdown-toggle text-dark" type="button" 
                                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Akcija
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item" href="./blokiraj_korisnika.php?korisnik='.$id_kor2.'" >Blokiraj korisnika</a>
                                            <a class="dropdown-item" href="#" name="'.$id_prituzbe.'" onclick="uklanjanje_prituzbe(this.name)">Skloni prituzbu</a>
                                        </div>
                                        </div>
                                    </div>

                                </div>';
                            }
                            else if($naziv_hotela!=null){
                                echo '<div class="row bg-secondary mt-2 container rounded_transparent" id="'.$id_prituzbe.'">

                                <div class="col-4">
                                    <h3>Podnosilac prituzbe</h3>
                                    <h3> '.$ime_podnosioca.' '.$prezime_podnosioca.' </h3>
                                    <p>'.$tekst.'</p>
                                </div>
                                <div class="col-4">
                                    <h3>Protiv:  '.$naziv_hotela.'</h3>
                                </div>
                                <div class="col-4" style="text-align: center;">
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle text-dark" type="button"  
                                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background: #606949;">
                                            Akcija
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item" href="#" name="'.$id_prituzbe.'" onclick="uklanjanje_prituzbe(this.name)">Skloni prituzbu</a>
                                        </div>
                                    </div>
                                </div>

                            </div>';
                            }
                        }                    
                }
                 ?>

    </div>

    <div class="container  mt-2" style="background: none; border: none;">
        <h1>Zahtjev za registraciju menadzera</h1>
        <?php 
        $sql = "SELECT m.IME, m.PREZIME, m.EMAIL,h.NAZIV, h.ADRRESA, m.ID_MENADZER FROM `menadzer` m join menadzeri_hotela mh on mh.ID_MENADZER=m.ID_MENADZER join hotel h on h.ID_HOTEL = mh.ID_HOTEL WHERE m.odobreno=0;";

        if($result=$mysqli->query($sql))
                {
                        while($row=$result->fetch_row())
                        {
                            $ime_menadzera = $row[0];
                            $prezime_menadzera = $row[1];
                            $email_menadzera = $row[2];
                            $naziv_hotela = $row[3];
                            $adresa_hotela = $row[4];
                            $id_menadzera = $row[5];
                            echo '<div class="row bg-secondary mt-2 container rounded_transparent">

                            <div class="col-4">
                                <h3>'.$ime_menadzera.' '.$prezime_menadzera.'</h3>
                                <p>'.$email_menadzera.'</p>
                            </div>
                            <div class="col-4">
                                <h3>'.$naziv_hotela.'</h3>
                                <p>'.$adresa_hotela.'</p>
                            </div>
                            <div class="col-4" style="text-align: center;">
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle text-dark" type="button" id="dropdownMenuButton"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background: #606949;">
                                        Akcija
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="./blokiraj_korisnika.php?odobreno=1&id_menadzera='.$id_menadzera.'">Odobri</a>
                                        <a class="dropdown-item" href="./blokiraj_korisnika.php?odobreno=0&id_menadzera='.$id_menadzera.'">Odbiji</a>
                                    </div>
                                </div>
                            </div>
                
                        </div>';
                        }
                }
        ?>

    </div>



    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.debug.js"></script>
    <script src="./js_admin.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</body>

</html>