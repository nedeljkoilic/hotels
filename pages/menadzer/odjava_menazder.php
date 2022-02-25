<?php
session_start();
unset($_SESSION['emailMenadzer']);
session_destroy();
header("Location: http://localhost/project/");