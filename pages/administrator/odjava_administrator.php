<?php
session_start();
unset($_SESSION['emailAdministrator']);
session_destroy();
header("Location: http://localhost/project/");