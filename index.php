<?php

require_once 'database.php';
require_once 'member.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);
// Création d'une instance de la classe Database pour la connexion à la base de données
$database = new Database();
$db = $database->getConnection();

// Création d'une instance de la classe Member pour gérer les membres
$member = new Member($db);

// Récupération des membres
$stmt = $member->read();
$num = $stmt->rowCount();

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des membres</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Liste des membres</h1>
        <div class="mb-4">
        <a href='ajout.php' class='btn btn-success mr-2'>Ajouter</a>
        </div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Matricule</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($num > 0) {
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        extract($row);
                        echo "<tr>";
                        echo "<td>{$matricule}</td>";
                        echo "<td>{$nom}</td>";
                        echo "<td>{$prenom}</td>";
                        echo "<td>
                                <a href='read_member.php?id={$id}' class='btn btn-primary mr-2'>Lire
                                <script src='https://cdn.lordicon.com/lordicon.js'></script>
                                <lord-icon
                                    src='https://cdn.lordicon.com/fkaukecx.json'
                                    trigger='hover'>
                                </lord-icon>
                                 </a>
                                <a href='delete_member.php?id={$id}' class='btn btn-danger mr-2'>Supprimer 
                                <script src='https://cdn.lordicon.com/lordicon.js'></script>
                                <lord-icon
                                    src='https://cdn.lordicon.com/skkahier.json'
                                    trigger='hover'
                                    >
                                </lord-icon></a>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>Aucun membre trouvé.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
