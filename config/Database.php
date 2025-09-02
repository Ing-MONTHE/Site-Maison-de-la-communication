<?php
namespace Config;

use PDO;
use PDOException;

class Database {
    private static ?PDO $conn = null;

    public static function getConnection(): PDO {
        if (self::$conn === null) {
            try {
                $host = "localhost";       // ou 127.0.0.1
                $dbname = "projet_mcc";          // nom de ta BD
                $username = "root";       // utilisateur XAMPP
                $password = "";           // mot de passe XAMPP (vide par défaut)

                self::$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
                self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("❌ Erreur de connexion : " . $e->getMessage());
            }
        }
        return self::$conn;
    }
}
