<?php

require_once 'database.php';

class AgeGroup {
    private $conn;
    private $table_name = 'tranche_age';

    public function __construct($db) {
        $this->conn = $db;
    }

    // Méthode pour récupérer les options de tranche d'âge depuis la base de données
    public function getAgeGroupOptions() {
        $query = 'SELECT * FROM ' . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>
