<?php

require_once 'database.php';
require_once 'member.php';

// Vérifier si l'ID du membre est passé en paramètre
if (isset($_GET['id']) && !empty($_GET['id'])) {
    // Création d'une instance de la classe Database pour la connexion à la base de données
    $database = new Database();
    $db = $database->getConnection();

    // Création d'une instance de la classe Member pour gérer les membres
    $member = new Member($db);

    // Récupération de l'ID du membre à partir de la requête GET
    $member->id = $_GET['id'];

    // Lecture des informations du membre avec les jointures
    $stmt = $member->readOne();

    // Vérifier s'il y a des informations à afficher
    if ($stmt->rowCount() > 0) {
        // Récupération de la ligne de résultat
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Extraire les valeurs
        extract($row);

        // Affichage des informations du membre avec du code HTML et Bootstrap
        ?>

        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Informations du membre</title>
            <!-- Bootstrap CSS -->
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        </head>
        <body>
            <div class="container mt-5">
                <h1>Informations du membre</h1>
                <p><strong>Matricule :</strong> <?php echo $matricule; ?></p>
                <p><strong>Nom :</strong> <?php echo $nom; ?></p>
                <p><strong>Prénom :</strong> <?php echo $prenom; ?></p>
                <p><strong>Tranche d'âge :</strong> <?php echo $tranche; ?></p>
                <p><strong>Sexe :</strong> <?php echo $sexe; ?></p>
                <p><strong>Situation matrimoniale :</strong> <?php echo $situation_matrimonial; ?></p>
                <p><strong>Activité :</strong> <?php echo $activite; ?></p>
                <p><strong>Statut :</strong> <?php echo $status; ?></p>
                <a href="index.php" class="btn btn-primary">Retour</a>
                <a href="update_member.php?id=<?php echo $id; ?>" class="btn btn-success">Modifier</a>
            </div>
        </body>
        </html>

        <?php
    } else {
        // Si aucun membre trouvé avec cet ID
        echo "<h1>Aucun membre trouvé.</h1>";
    }
} else {
    // Si aucun ID de membre n'est passé en paramètre
    echo "<h1>Erreur : Aucun ID de membre spécifié.</h1>";
}

?>
