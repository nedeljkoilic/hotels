<?php
session_start();
if (isset($_SESSION['dolazak'])) {
    $dolazak = $_SESSION['dolazak'];
}
if (isset($_SESSION['odlazak'])) {
    $odlazak = $_SESSION['odlazak'];
}
if (isset($_SESSION['cijena_dan'])) {
    $cijena_dan = $_SESSION['cijena_dan'];
}
if (isset($_SESSION['ukupna_cijena'])) {
    $ukupna_cijena = $_SESSION['ukupna_cijena'];
}
if (isset($_SESSION['id_korisnika'])) {
    $id_korisnika = $_SESSION['id_korisnika'];
}
if (isset($_SESSION['id_rezervacije'])) {
    $id_rezervacije = $_SESSION['id_rezervacije'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forma za rezervaciju</title>
</head>
<body>
<form id="forma za rezervaciju">
    <label>Dolazak: </label>
    <label id="dolazak"><?php echo $_GET['dolazak'] ?> </label><br>
    <label>Odlazak: </label>
    <label id="odlazak"> <?php echo $_GET['odlazak'] ?> </label><br>
    <label>Cijena po danu: </label>
    <label id="cijena_dan"><?php echo $_GET['cijena_dan'] ?>  </label><br>
    <label>Ukupna cijena:</label>
    <label id="ukupna_cijena"><?php echo $_GET['ukupna_cijena'] ?> </label><br>
    <button>Rezervisi</button>
</form>
</body>
</html>