<?php
/* Lidhja me databazen */
const DB_SERVER = 'localhost';
const DB_USERNAME = 'root';
const DB_PASSWORD = '';
const DB_NAME = 'lavazho';

/* Provo lidhjen me MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Kontrollo lidhjen
if ($link === false) {
    die("ERROR: Nuk u lidhem dot. " . mysqli_connect_error());
}
