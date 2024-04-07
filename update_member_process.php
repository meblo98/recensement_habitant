<?php

require_once 'database.php';
require_once 'member.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);
// Vérifier si les données du formulaire ont été soumises via la méthode POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Création d'une instance de la classe Database pour la connexion à la base de données
    $database = new Database();
    $db = $database->getConnection();

    // Création d'une instance de la classe Member pour gérer les membres
    $member = new Member($db);

    // Récupération des données du formulaire
    $member->id = $_POST['id'];
    $member->matricule = $_POST['matricule'];
    $member->nom = $_POST['nom'];
    $member->prenom = $_POST['prenom'];
    $member->tranche_age_id = $_POST['age_group_id'];
    $member->sexe = $_POST['sexe'];
    $member->situation_matrimoniale = $_POST['situation_matrimoniale'];
    $member->activite = $_POST['activite'];
    $member->status_id = $_POST['status_id'];

    // Appel de la fonction update() pour mettre à jour les informations du membre
    if ($member->update()) {
        // Si la mise à jour réussit, redirigez vers la page de lecture du membre avec un message de succès
        header("Location: read_member.php?id=" . $member->id . "&success=1");
        exit();
    } else {
        // Si la mise à jour échoue, redirigez vers la page de lecture du membre avec un message d'erreur
        header("Location: read_member.php?id=" . $member->id . "&error=1");
        exit();
    }
} else {
    // Si les données du formulaire n'ont pas été soumises via POST, redirigez vers la page d'accueil
    header("Location: index.php");
    exit();
}

?>
