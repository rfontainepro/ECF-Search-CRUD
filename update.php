<?php

require_once 'connexion.php';

// Sécurité modifications URL (ID inconnu / ID vide)
if(isset($_GET['id']) && !empty($_GET['id'])) {
}
    else {
        header('Location: ./?search=');
        echo "ID Inconnu !";
    }

//--------------------------------------------------

$id = $_GET['id'];

    $reqetudiant = $pdo->query("SELECT * FROM etudiants WHERE id_etudiant = '$id'");
    $reqnote = $pdo->query("SELECT matiere, note FROM examens WHERE id_etudiant = '$id'");

    $postetudiant = $reqetudiant->fetch(PDO::FETCH_ASSOC);
    $postnotes = $reqnote->fetchAll(PDO::FETCH_ASSOC);

?>
<!----------------------------------------------------------------------------------------->
<link rel="stylesheet" href="./style.css" />

<!----------------------------------- MODIFIER DATA DANS LA DB ---------------------------->
<div id="formulaire">
    
    <form action="dbupdate.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id_etudiant" id="id_etudiant" value="<?= $postetudiant['id_etudiant']?>">
        <h2>ID N&deg;<?= $postetudiant['id_etudiant'] ?></h2>

        <div>
            <textarea name="nom" id="nom" cols="50"><?= $postetudiant['nom'] ?></textarea>
        </div>
        <div>
            <textarea name="prenom" id="prenom" cols="50"><?= $postetudiant['prenom']?></textarea>
        </div>
<!----------------------------------------------------------------------------------------->

<?php
foreach($postnotes AS $postnote){
?>
        <div>
            <textarea name="matiere" id="matiere" cols="22"><?= $postnote['matiere']?></textarea>
            <textarea name="note" id="note" cols="22"><?= $postnote['note']?></textarea>
        </div>

<?php
}
?>
        <input type="submit" name="submit" value="Enregistrer" class='submit'>
        <a href="./?search=">Retour</a>
    </form>
</div>