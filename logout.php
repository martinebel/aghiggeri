<?php
 session_start();
 //Vaciar sesión
 $_SESSION = array();
 //Destruir Sesión
 session_destroy();
header("Location:index.php");
?>