<?php
// Inicializo sesionin
session_start();

// Unset variablat e sesionit
$_SESSION = array();

// Shkaterro sesionin.
session_destroy();

// Redirect te login 
header("location: login.php");
exit;
?>