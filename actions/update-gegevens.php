<?php
session_start();
require '../db/dbconfig.php';
$con = new Dbh();
$con = $con->connect(); //hier zorg ik ervoor dat mijn object connect

$lidID = $_SESSION["lidID"];

$voornaam = $_POST["edit-naam"];
$tussenvoegsel = $_POST["edit-tusv"];
$achternaam = $_POST["edit-achternaam"];
$email = $_POST["edit-email"];
$telefoonnummer = $_POST["edit-tel"];
$wachtwoord = $_POST["edit-password"];

$wachtwoordMetSaltEncrypt = password_hash($wachtwoord . "examen", PASSWORD_DEFAULT); //wachtwoord met 'examen' als salt

//update hier de gebruiker met de gegevens uit de form
$sql = $con->prepare("UPDATE lid SET lid_vnaam = :voornaam, lid_anaam = :achternaam,
               lid_tel = :telefoonnummer, lid_email = :email WHERE lid_id = :lidID");
$sql->bindParam(":voornaam", $voornaam);
$sql->bindParam(":achternaam", $achternaam);
$sql->bindParam(":telefoonnummer", $telefoonnummer);
$sql->bindParam(":email", $email);
$sql->bindParam(":lidID", $lidID);
$sql->execute();

if (isset($tussenvoegsel)) {
    //als 'tussenvoegsel' gezet is dan mag die geupdate worden, zo niet? dan mag die dan niet doen
    $sql = $con->prepare("UPDATE lid SET lid_tvoegsel = :tussenvoegsel WHERE lid_id = :lidID");
    $sql->bindParam(":tussenvoegsel", $tussenvoegsel);
    $sql->bindParam(":lidID", $lidID);
    $sql->execute();
}

if (isset($wachtwoord)) {
    //als 'wachtwoord' gezet is dan mag die geupdate worden, zo niet? dan mag die dan niet doen
    $sql = $con->prepare("UPDATE lid SET lid_wachtwoord = :wachtwoord WHERE lid_id = :lidID");
    $sql->bindParam(":wachtwoord", $wachtwoordMetSaltEncrypt);
    $sql->bindParam(":lidID", $lidID);
    $sql->execute();
}

$_SESSION["status"] = "Je gegevens zijn ge-update";
$_SESSION["statusCode"] = "success";
header ("Location: ../profiel-gegevens.php");