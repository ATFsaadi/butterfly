<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/* nettoyage session */
$_SESSION = [];

/* destruction session */
session_destroy();

/* redirection */
header('Location: ../index.php?page=home');
exit();
