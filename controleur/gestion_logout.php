<?php

// Controleur deconnexion : vide la session et renvoie vers l'accueil.

// démarrage de la session

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

// suppression des données de session

$_SESSION = [];

// suppression du cookie de session

if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();

    setcookie(
        session_name(),
        "",
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"] ?? false,
        $params["httponly"] ?? true
    );
}

// destruction de la session

session_destroy();

// redirection accueil

header("location: index.php?page=home");
exit();
