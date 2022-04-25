<?php
session_start();
require_once ("../db/dbconfig.php");
$con = new Dbh();
$con = $con->connect(); //hier zorg ik ervoor dat mijn object connect

if (!empty($_POST["email"]) && !empty($_POST["wachtwoord"])) { //als de formulieren ingevuld zijn komt alles bij de querys
    //doormiddel van bindParam voorkom je SQL Injections
    $email = $_POST["email"];
    $wachtwoord = $_POST["wachtwoord"];

    $sql = $con->prepare("SELECT * FROM lid WHERE lid_email = :email");
    $sql->bindParam(":email", $email);
    $sql->execute(); //voert een prepared statement uit

    $lidResult = $sql->fetch(); //haalt de gegevens op van de gebruiker (user)
    $lidRow = $sql->rowCount(); //kijkt of er iemand is met de door hem ingevulde gebruikersnaam (username)

    //salt is examen, je mag trouwens geen - gebruiken bij je salt want dat zorgt voor problemen, let hier op!
    if ($lidRow === 1) {
        if (password_verify($wachtwoord . "examen", $lidResult["lid_wachtwoord"]) ) { //wachtwoord is welkom
            $_SESSION["lidID"] = $lidResult["lid_id"];
            $_SESSION["lidRol"] = $lidResult["lid_rol"];
            $_SESSION["lidName"] = $lidResult["lid_vnaam"];

            header ("Location: ../profiel-gegevens.php");
        } else {
            $_SESSION["status1"] = "Je wachtwoord is verkeerd!";
            $_SESSION["statusCode"] = "error";
            header ("Location: ../login.php");
        }
    } else {
        $_SESSION["status1"] = "sorry, je gegevens zijn verkeerd.";
        $_SESSION["statusCode"] = "error";
        header ("Location: ../login.php");
    }
} else {
    $_SESSION["status1"] = "sorry, je moet al je gegevens invullen";
    $_SESSION["statusCode"] = "error";
    header ("Location: ../login.php");
}