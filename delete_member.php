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

    // Appel de la fonction delete() pour supprimer le membre de la base de données
    if ($member->delete()) {
        // Si la suppression réussit, redirigez vers la page d'accueil avec un message de succès
        header("Location: index.php?success=delete");
        exit();
    } else {
        // Si la suppression échoue, redirigez vers la page d'accueil avec un message d'erreur
        header("Location: index.php?error=delete");
        exit();
    }
} else {
    // Si aucun ID de membre n'est passé en paramètre
    echo "<h1>Erreur : Aucun ID de membre spécifié.</h1>";
}

?>
