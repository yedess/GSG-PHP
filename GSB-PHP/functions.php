<?php
include('connection.php');

function register($tab)
{
    global $conn;
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "INSERT INTO visiteur (id, nom, prenom, login, email, mdp, adresse, cp, ville, dateEmbauche, Portrait) VALUES ('$tab[0]', '$tab[1]', '$tab[2]', '$tab[3]', '$tab[4]', '$tab[5]', '$tab[6]', '$tab[7]', '$tab[8]', '$tab[9]', '$tab[10]')";
    // use exec() because no results are returned
    $result = $conn->prepare($sql);
    $result->execute();
}
function deleteFrais($tab){
    global $conn;
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "UPDATE `lignefraisforfait` SET `quantite` = 0 WHERE `lignefraisforfait`.`idVisiteur` = '$tab[0]' AND `lignefraisforfait`.`mois` = '$tab[1]' AND `lignefraisforfait`.`idFraisForfait` = '$tab[2]'";
    // use exec() because no results are returned
    $result = $conn->prepare($sql);
    $result->execute();

}

function deleteFraishf($tab){
    global $conn;
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "DELETE FROM `lignefraishorsforfait` WHERE `lignefraishorsforfait`.`idVisiteur` = '$tab[0]' AND `lignefraishorsforfait`.`mois` = '$tab[1]' AND `lignefraishorsforfait`.`id` = '$tab[2]'";
    // use exec() because no results are returned
    $result = $conn->prepare($sql);
    $result->execute();
}