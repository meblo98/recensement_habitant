<?php

require_once 'database.php';

class Status {
    private $conn;
    private $table_name = 'status';

    public function __construct($db) {
        $this->conn = $db;
    }

    // Méthode pour récupérer les options de statut depuis la base de données
    public function getStatusOptions() {
        $query = 'SELECT id, libelle FROM ' . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>
