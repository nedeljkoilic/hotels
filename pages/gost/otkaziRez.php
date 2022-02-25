<?php

session_start();
if (isset($_GET['id_rez'])) {
    $id = $_GET['id_rez'];
}

echo $id;
require_once "./connection.php";
$sql = "DELETE FROM rezervacija WHERE ID_REZERVACIJA=" . $id;
$result = $mysqli->query($sql);

header("Location: http://localhost/project/pages/gost/moje_rezervacije.php");
