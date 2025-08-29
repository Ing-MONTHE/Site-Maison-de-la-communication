<?php
namespace App\Controllers;

use App\Models\Module;
use Core\AuthMiddleware;

class ModuleController {

    // Liste accessible à tout le monde
    public function index() {
        $modules = Module::all();
        require __DIR__ . "/../Views/modules/index.php";
    }

    // Création réservée à admin
    public function create() {
        AuthMiddleware::requireRole('admin');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $module = new Module();
            $module->name = $_POST['name'];
            $module->description = $_POST['description'];
            $module->save();
            header("Location: index.php?controller=module&action=index");
            exit;
        }

        require __DIR__ . "/../Views/modules/create.php";
    }

    // Suppression réservée à admin
    public function delete() {
        AuthMiddleware::requireRole('admin');

        if (isset($_GET['id'])) {
            Module::delete((int)$_GET['id']);
        }
        header("Location: index.php?controller=module&action=index");
        exit;
    }
}
