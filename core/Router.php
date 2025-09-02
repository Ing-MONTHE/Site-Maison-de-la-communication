<?php
namespace Core;

class Router {
    public static function run() {
        // Récupération du contrôleur et de l’action dans l’URL
        $controllerName = isset($_GET['controller']) ? ucfirst($_GET['controller']) . "Controller" : "HomeController";
        $action = $_GET['action'] ?? "index";

        // Namespace de base
        $controllerClass = "App\\Controllers\\" . $controllerName;

        // Vérifie si le contrôleur existe
        if (class_exists($controllerClass)) {
            $controller = new $controllerClass();

            // Vérifie si la méthode existe dans le contrôleur
            if (method_exists($controller, $action)) {
                call_user_func([$controller, $action]);
            } else {
                self::error("L’action <b>$action</b> n’existe pas dans $controllerName.");
            }
        } else {
            self::error("Le contrôleur <b>$controllerClass</b> est introuvable.");
        }
    }

    private static function error($message) {
        http_response_code(404);
        echo "<h1>Erreur 404</h1>";
        echo "<p>$message</p>";
        exit;
    }
}
