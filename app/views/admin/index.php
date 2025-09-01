<?php
session_start();

// Redirection vers le tableau de bord si connecté, sinon vers la page de connexion
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header('Location: dashboard.php');
} else {
    header('Location: login.php');
}
exit();
?>
