<?php
// gestion.logout.php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Supprimer toutes les variables de session
$_SESSION = [];

// Détruire la session
session_destroy();

// Redirection vers la page d'accueil
header('Location: ../index.php?page=home');
exit();
