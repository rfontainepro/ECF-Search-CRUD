<?php

    require_once "connexion.php";

//------------------------------------------------------------------------------------------

    $id_etudiant = $_POST['id_etudiant'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];

    if(isset($_POST['submit'])) {
        $edited = $pdo->prepare("UPDATE etudiants SET nom = :nom,
                                                    prenom = :prenom

                                                    WHERE id_etudiant = :id_etudiant");
        $edited->execute([
            
            'id_etudiant' => $id_etudiant,
            'nom' => $nom,
            'prenom' => $prenom

        ]);
    }

    if($edited) {
        header('Location: ./?search=');
    } else {
        echo "AH PAS MARCHE...";
        var_dump($edited);
        print_r($edited);
    };


//------------------------------------------------------------------------------------------

    $id_etudiant = $_POST['id_etudiant'];
    $note = $_POST['note'];

    if(isset($_POST['submit'])) {
        $edited = $pdo->prepare("UPDATE examens SET note = :note 
        
                                                    WHERE id_etudiant = :id_etudiant");
        $edited->execute([

            'id_etudiant' => $id_etudiant,
            'note' => $note
        ]);
    }