<?php

session_start();
unset($_COOKIE['tiempoUsuario']);
session_destroy();
header("location:index.php");
die();

?>