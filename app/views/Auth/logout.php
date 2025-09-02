<?php
session_start();

// Destroy all session data
session_destroy();

// Redirect to home page with logout message
header('Location: /Site-Maison-de-la-communication/index.php?success=Déconnexion réussie');
exit();
?>
