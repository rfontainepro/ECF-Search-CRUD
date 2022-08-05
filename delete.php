<?php

require_once "connexion.php";

$id = $_GET['id'];

//$del = $pdo->query("DELETE FROM etudiants WHERE id_etudiant = '$id'");
// La manière dégueulasse :-)

if(isset($_GET['id'])) {
    $del = $pdo->prepare("DELETE etudiant, examen FROM examens AS examen INNER JOIN etudiants AS etudiant ON examen.id_etudiant = etudiant.id_etudiant WHERE etudiant.id_etudiant = :id");
    $del->bindParam(':id', $id);
    $del->execute();
}

if($del) {
    header('Location: ./?search=');
} else {
    echo "AH PAS MARCHE !";
};