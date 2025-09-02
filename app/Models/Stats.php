<?php
namespace App\Models;

use Config\Database;
use PDO;

class Stats {
    public static function getCounts(): array {
        $db = Database::getConnection();
        $counts = [];
        $counts['totalPublications'] = (int)($db->query("SELECT COUNT(*) FROM publications")->fetchColumn());
        $counts['totalUsers'] = (int)($db->query("SELECT COUNT(*) FROM users")->fetchColumn());
        $counts['totalMedia'] = (int)($db->query("SELECT COUNT(*) FROM media")->fetchColumn());
        $counts['totalModules'] = (int)($db->query("SELECT COUNT(*) FROM modules")->fetchColumn());
        return $counts;
    }
}


