<?php

require_once 'database.php';

class Member {
    private $conn;
    private $table_name = 'Habitant';

    public $id;
    public $matricule;
    public $nom;
    public $prenom;
    public $sexe;
    public $situation_matrimoniale;
    public $activite;
    public $status_id;
    public $tranche_age_id;

    public function __construct($db) {
        $this->conn = $db;
    }
        // Fonction pour obtenir le prochain ID auto-incrémenté
    function getNextAutoIncrementID() {
        $query = "SHOW TABLE STATUS LIKE '" . $this->table_name . "'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['Auto_increment'];
    }
        // Fonction pour créer un nouveau membre
    public function create() {
        // Requête SQL pour insérer un nouveau membre dans la base de données
        $query = "INSERT INTO " . $this->table_name . "
        SET matricule=:matricule, nom=:nom, prenom=:prenom,
            sexe=:sexe, situation_matrimonial   =:situation_matrimoniale, activite=:activite,
            status_id=:status_id, tranche_age_id=:tranche_age_id";

            // Préparer la requête
            $stmt = $this->conn->prepare($query);
            
            // Nettoyer les données
            // $this->matricule = htmlspecialchars(strip_tags($this->matricule));
            // $this->nom = htmlspecialchars(strip_tags($this->nom));
            // $this->prenom = htmlspecialchars(strip_tags($this->prenom));
            // $this->sexe = ($this->sexe == 'Masculin' || $this->sexe == 'Féminin') ? $this->sexe : null; // Assurez-vous que le sexe est valide
            // $this->situation_matrimoniale = htmlspecialchars(strip_tags($this->situation_matrimoniale));
            // $this->activite = htmlspecialchars(strip_tags($this->activite));
            // $this->status_id = htmlspecialchars(strip_tags($this->status_id));
            // $this->tranche_age_id = htmlspecialchars(strip_tags($this->tranche_age_id));
            // Générer la matricule avec l'initial "PO_" et l'ID auto-incrémenté
            $matricule = "PO_" . $this->getNextAutoIncrementID();
                    // Liage des valeurs
            $stmt->bindParam(":matricule", $matricule);
            $stmt->bindParam(":nom", $this->nom);
            $stmt->bindParam(":prenom", $this->prenom);
            $stmt->bindParam(":sexe", $this->sexe);
            $stmt->bindParam(":situation_matrimoniale", $this->situation_matrimoniale);
            $stmt->bindParam(":activite", $this->activite);
            $stmt->bindParam(":status_id", $this->status_id);
            $stmt->bindParam(":tranche_age_id", $this->tranche_age_id);

                    

        // Exécuter la requête
        if ($stmt->execute()) {
            header('Location:index.php');
            exit();
            return true;
        }

        return false;
    }

      // Fonction pour lire tous les membres
      public function read() {
        $query = "SELECT * FROM " . $this->table_name;

        // Préparer la requête
        $stmt = $this->conn->prepare($query);

        // Exécuter la requête
        $stmt->execute();

        return $stmt;
    }
      // Fonction pour lire un seul membre avec les informations de statut et de tranche d'âge
      public function readOne() {
        $query = "SELECT m.id, m.matricule, m.nom, m.prenom, m.sexe, m.situation_matrimonial, m.activite,
                         s.libelle AS status, a.tranche AS tranche
                  FROM " . $this->table_name . " m
                  LEFT JOIN status s ON m.status_id = s.id
                  LEFT JOIN tranche_age a ON m.tranche_age_id = a.id
                  WHERE m.id = ?
                  LIMIT 0,1";

        // Préparer la requête
        $stmt = $this->conn->prepare($query);

        // Lier l'ID du membre à la requête
        $stmt->bindParam(1, $this->id);

        // Exécuter la requête
        $stmt->execute();

        return $stmt;
    }
      // Fonction pour mettre à jour les informations d'un membre
      public function update() {
        // Requête SQL pour mettre à jour les informations du membre
        $query = "UPDATE " . $this->table_name . "
                  SET matricule = :matricule,
                      nom = :nom,
                      prenom = :prenom,
                      tranche_age_id = :age_group_id,
                      sexe = :sexe,
                      situation_matrimonial = :situation_matrimonial,
                      activite = :activite,
                      status_id = :status_id
                  WHERE id = :id";

        // Préparer la requête
        $stmt = $this->conn->prepare($query);

        // Nettoyer les données
        $this->matricule = htmlspecialchars(strip_tags($this->matricule));
        $this->nom = htmlspecialchars(strip_tags($this->nom));
        $this->prenom = htmlspecialchars(strip_tags($this->prenom));
        $this->sexe = htmlspecialchars(strip_tags($this->sexe));
        $this->tranche_age_id = htmlspecialchars(strip_tags($this->tranche_age_id));
        $this->situation_matrimoniale = htmlspecialchars(strip_tags($this->situation_matrimoniale));
        $this->activite = htmlspecialchars(strip_tags($this->activite));
        $this->status_id = htmlspecialchars(strip_tags($this->status_id));
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Lier les valeurs
        $stmt->bindParam(':matricule', $this->matricule);
        $stmt->bindParam(':nom', $this->nom);
        $stmt->bindParam(':prenom', $this->prenom);
        $stmt->bindParam(':age_group_id', $this->tranche_age_id);
        $stmt->bindParam(':sexe', $this->sexe);
        $stmt->bindParam(':situation_matrimonial', $this->situation_matrimoniale);
        $stmt->bindParam(':activite', $this->activite);
        $stmt->bindParam(':status_id', $this->status_id);
        $stmt->bindParam(':id', $this->id);

        // Exécuter la requête
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
    // Fonction pour supprimer un membre de la base de données
    function delete() {
        // Requête de suppression SQL
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";

        // Préparation de la requête
        $stmt = $this->conn->prepare($query);

        // Liaison des paramètres
        $stmt->bindParam(':id', $this->id);

        // Exécution de la requête
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}

?>
