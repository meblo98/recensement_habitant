<?php


require_once 'database.php';
require_once 'member.php';
require_once 'status.php';
require_once 'agegroup.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);
// Vérifier si l'ID du membre est passé en paramètre
if (isset($_GET['id']) && !empty($_GET['id'])) {
    // Création d'une instance de la classe Database pour la connexion à la base de données
    $database = new Database();
    $db = $database->getConnection();

    // Création d'une instance de la classe Member pour gérer les membres
    $member = new Member($db);

    // Récupération de l'ID du membre à partir de la requête GET
    $member->id = $_GET['id'];
    $status = new Status($db);
    $status_options = $status->getStatusOptions();
    $age_group = new AgeGroup($db);
    $age_group_options = $age_group->getAgeGroupOptions();
    // Récupération des informations du membre à partir de l'ID
    $stmt = $member->readOne();

    // Vérifier s'il y a des informations à afficher
    if ($stmt->rowCount() > 0) {
        // Récupération de la ligne de résultat
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Extraire les valeurs
        extract($row);

        // Affichage du formulaire de modification
        ?>

        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Modifier un membre</title>
            <!-- Bootstrap CSS -->
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
            <link rel="stylesheet" href="style.css">
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        </head>
        <body>
            <div class="container mt-5">
                <h1>Modifier un membre</h1>
                <form action="update_member_process.php" method="post">
                <div>
                <input type="hidden" value="<?php echo $id; ?>" name="id" id="id"  required>

            <label for="matricule">Matricule:</label>
            <input type="text" value="<?php echo $matricule; ?>" name="matricule" id="matricule" readonly required>
        </div>
        <div>
            <label for="nom">Nom:</label>
            <input type="text" name="nom" value="<?php echo $nom; ?>" id="nom" required>
        </div>
        <div>
            <label for="prenom">Prénom:</label>
            <input type="text" value="<?php echo $prenom; ?>" name="prenom" id="prenom" required>
        </div>
        <div class="form-group">
                <label for="age_group_id">Tranche d'âge :</label>
                <select name="age_group_id" id="age_group_id" value="<?php echo $tranche_age_id; ?>" class="form-control" required>
                    <?php
                    // Parcours des options de la balise select pour la tranche d'âge
                    foreach ($age_group_options as $option) {
                        // Vérifier si l'option correspond à la valeur actuelle du membre
                        if ($option['id'] == $tranche_age_id) {
                            // Ajouter l'attribut selected si l'option correspond à la valeur actuelle
                            echo "<option value=\"" . $option['id'] . "\" selected>" . $option['tranche'] . "</option>";
                        } else {
                            // Sinon, afficher l'option normalement
                            echo "<option value=\"" . $option['id'] . "\">" . $option['tranche'] . "</option>";
                        }
                    }
                    ?>
                </select>
            </div>
        <div>
            <label for="sexe">Sexe:</label>
            <select name="sexe" id="sexe" value = "<?php echo $sexe; ?>" required>
                <option value="Masculin">Masculin</option>
                <option value="Féminin">Féminin</option>
            </select>
        </div>
        <div>
        <label for="situation_matrimoniale">Situation matrimoniale:</label>
            <select name="situation_matrimoniale" value = "<?php echo $situaion_matrimoniale; ?>" id="situation_matrimoniale" required>
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
                    <!-- Les champs de formulaire seront remplis avec les valeurs actuelles -->
                    <!-- Utilisez les valeurs PHP pour pré-remplir les champs de formulaire -->
                    <!-- Exemple : <input type="text" name="matricule" value="<?php echo $matricule; ?>"> -->
                    <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
                </form>
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
