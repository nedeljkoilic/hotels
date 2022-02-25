<?php
session_start();
unset($_SESSION['email']);


unset($_SESSION['hotel']);
unset($_SESSION['adresa']);
unset($_SESSION['wifi_izabr']);
unset($_SESSION['dorucak_izabr']);
unset($_SESSION['parking_izabr']);
unset($_SESSION['grad']);
unset($_SESSION['zvjezdice']);
unset($_SESSION['opis']);


session_destroy();
header("Location: http://localhost/project/");