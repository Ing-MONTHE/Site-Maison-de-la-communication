<?php
session_start();

// Supprimer les variables de session utilisateur (pas admin)
unset($_SESSION['user_id']);
unset($_SESSION['username']);
unset($_SESSION['user_role']);
unset($_SESSION['user_email']);

// Rediriger vers la page d'accueil
header('Location: ../../../index.php?success=Déconnexion réussie');
exit();
?>
