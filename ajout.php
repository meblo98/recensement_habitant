<?php

require_once 'database.php';
require_once 'member.php';
require_once 'status.php';
require_once 'agegroup.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Création d'une instance de la classe Database pour la connexion à la base de données
$database = new Database();
$db = $database->getConnection();

// Création d'une instance de la classe Member pour gérer les membres
$member = new Member($db);
// Création d'une instance de la classe Status pour gérer les statuts
$status = new Status($db);
$status_options = $status->getStatusOptions();

// Création d'une instance de la classe AgeGroup pour gérer les tranches d'âge
$age_group = new AgeGroup($db);
$age_group_options = $age_group->getAgeGroupOptions();
$matricule = "PO_001";
// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération des données du formulaire
    $member->matricule = $_POST['matricule'];
    $member->nom = $_POST['nom'];
    $member->prenom = $_POST['prenom'];
    $member->tranche_age_id = $_POST['age_group_id'];
    $member->sexe = $_POST['sexe'];
    $member->activite = $_POST['activite'];
    $member->situation_matrimoniale = $_POST['situation_matrimoniale'];
    $member->status_id = $_POST['status_id'];

    // Créer un nouveau membre dans la base de données
    if ($member->create()) {
        echo "<div>Le membre a été créé avec succès.</div>";
    } else {
        echo "<div>Une erreur s'est produite lors de la création du membre.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un nouveau membre</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>
<body>
<div class="container">
    <div class="row d-flex justify-content-center">
        <div class="col_md-7"><script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
            <div class="card shadow">
    <h1>Ajouter un nouveau membre</h1>
    <div class="card-body">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div>
            <label for="matricule">Matricule:</label>
            <input type="text" name="matricule" id="matricule" class="form-control" <?php if(isset($matricule)) echo 'value="' . $matricule . '"'; ?>readonly>
        </div>
        <div>
            <label for="nom">Nom:</label>
            <input type="text" name="nom" id="nom" required>
        </div>
        <div>
            <label for="prenom">Prénom:</label>
            <input type="text" name="prenom" id="prenom" required>
        </div>
        <div>
            <label for="age_group_id">Tranche d'âge:</label>
            <select name="age_group_id" id="age_group_id" required>
                <?php foreach ($age_group_options as $option) : ?>
                    <option value="<?php echo $option['id']; ?>"><?php echo $option['tranche']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label for="sexe">Sexe:</label>
            <select name="sexe" id="sexe" required>
                <option value="Masculin">Masculin</option>
                <option value="Féminin">Féminin</option>
            </select>
        </div>
        <div>
        <label for="situation_matrimoniale">Situation matrimoniale:</label>
            <select name="situation_matrimoniale" id="situation_matrimoniale" required>
                <option value="Célibataire">Célibataire</option>
                <option value="Marié(e)">Marié(e)</option>
                <option value="Veuf/Veuve">Veuf/Veuve</option>
                <option value="Divorcé(e)">Divorcé(e)</option>
            </select>
        </div>
        <div>
        <label for="activite">Activité:</label>
            <select name="activite" id="activite" required>
                <option value="chomeur">Chômeur</option>
                <option value="eleve">Elève</option>
                <option value="etudiant">Étudiant</option>
                <option value="travailleur">Travailleur</option>
            </select>
        </div>
        <div>
            <label for="status_id">Statut:</label>
            <select name="status_id" id="status_id" required>
                <?php foreach ($status_options as $option) : ?>
                    <option value="<?php echo $option['id']; ?>"><?php echo $option['libelle']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mt-2">
            <label for="">  </label>
            <input class="btn btn-success mr-2 " type="submit" value="Ajouter membre">
            <!-- <a href='index.php' type="submit" class='btn btn-primary mr-2'>Ajouter membre</a> -->
            <a href='index.php' class='btn btn-primary mr-2'>Retour</a>

        </div>
    </form>
    </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
