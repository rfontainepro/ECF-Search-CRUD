<?php

    include("connexion.php");

   //------------------------------------------------------------------------------

    // Récupération de l'input de la barre de recherche pour la stocker dans la variable $search
    $search = $_GET["search"];
    
    // Pour rechercher les élèves
    $request = $pdo->prepare("SELECT examen.id_etudiant, prenom, nom, GROUP_CONCAT(matiere,' ', note
    ORDER BY  matiere SEPARATOR ' - ' )
    AS matiere
    FROM etudiants
    AS etudiant INNER JOIN examens
    AS examen  ON etudiant.id_etudiant = examen.id_etudiant
    GROUP BY examen.id_etudiant HAVING prenom = '$search' OR nom = '$search'");
    // Recherche basée sur le prénom ou le nom

    $request->execute();
    $etudiants = $request->fetchAll(PDO::FETCH_ASSOC);

    // Afficher le nombre total d'élèves dans la DB
    $all = $pdo->prepare("SELECT COUNT(*) FROM etudiants");
    $all->execute();
    $result = $all->fetch();

    //------------------------------------------------------------------------------

    // Pour rechercher tous les élèves
    $requestall = $pdo->prepare("SELECT examen.id_etudiant, prenom, nom, GROUP_CONCAT(matiere,' ', note
    ORDER BY matiere SEPARATOR ' - ' )
    AS matiere
    FROM etudiants
    AS etudiant INNER JOIN examens
    AS examen  ON etudiant.id_etudiant = examen.id_etudiant
    GROUP BY examen.id_etudiant");
    // Ressort tous les étudiants avec leurs notes

    $requestall->execute();
    $etudiantsall = $requestall->fetchAll(PDO::FETCH_ASSOC);

    // Afficher le nombre total d'élèves dans la DB
    $all = $pdo->prepare("SELECT COUNT(*) FROM etudiants");
    $all->execute();
    $resultall = $all->fetch(PDO::FETCH_ASSOC);


    // Moyenne des 2 notes (BONUS)
    $reqmoyenne = $pdo->prepare("SELECT id_etudiant, AVG(note) AS moy FROM examens GROUP BY id_etudiant");
    $reqmoyenne->execute();
    $moysall = $reqmoyenne->fetchAll(PDO::FETCH_ASSOC);

    //print_r($moysall);

?>

<!-------------------------------------------------------------------------------------------------------------------->

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Search DB CRUD ECF</title>
        <link rel="stylesheet" href="./style.css" />
    </head>

    <body>

        <form method="GET" >
            <input maxlength=20 type="text" name="search" name="searchall" value="<?php echo $search ?>" placeholder="<?= date("H:i"); ?> - Rechercher parmis <?php echo($result['0']); ?> Elève(s)" />
            <input id="invisible" type="submit" value="search" />
        </form>

<?php
    if(count($etudiants) == 0) {
    } else { foreach($etudiants AS $etudiant){ 
?>
        <div id="resultats">
            <ol>
                    <div id="technical">
                        <div id="theone">
                            <div id="id_number" class="id_number"><p>ID N&deg;<?php echo $etudiant['id_etudiant'] ?> - <?php echo $etudiant['nom'] ?> <?php echo $etudiant['prenom'] ?></p>
                                <a href="update.php?id=<?=$etudiant['id_etudiant']?>" class="update">Update</a>
                                <a href="delete.php?id=<?=$etudiant['id_etudiant']?>" class="delete">Delete</a>
                            </div>
                            <div id="descg">
                                <?php echo $etudiant['matiere'] ?>
                            </div>
                        </div>
<?php }} ?>

<?php
foreach($etudiantsall AS $etudiantall){   
    foreach($moysall AS $moyall){
        if($moyall['id_etudiant'] == $etudiantall['id_etudiant']){
?>
                        <div id="id_number"><p>ID N&deg;<?php echo $etudiantall['id_etudiant'] ?> - <?php echo $etudiantall['nom'] ?> <?php echo $etudiantall['prenom'] ?> - (MOY=> <?php echo $moyall['moy'] ?>)</p>
                            <a href="update.php?id=<?=$etudiantall['id_etudiant']?>" class="update">Update</a>
                            <a href="delete.php?id=<?=$etudiantall['id_etudiant']?>" class="delete">Delete</a>
                        </div>
                        <div id="descg">
                            <?php echo $etudiantall['matiere'] ?>
                        </div>
<?php
}}}
?>
                    </div>
            <ol>
        </div>
    </body>
</html>