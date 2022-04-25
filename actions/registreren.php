<?php
session_start();
require_once ("../db/dbconfig.php");
$con = new Dbh();
$con = $con->connect(); //hier zorg ik ervoor dat mijn object connect

if (!empty($_POST["email"]) && !empty($_POST["wachtwoord"]) && !empty($_POST["ledenNmr"])) { //als de formulieren ingevuld zijn komt alles bij de querys
   $email = $_POST["email"];
   $wachtwoord = $_POST["wachtwoord"];
   $ledenNmr = $_POST["ledenNmr"];

   $wachtwoordMetSaltEncrypt = password_hash($wachtwoord . "examen", PASSWORD_DEFAULT); //wachtwoord met 'examen' als salt

   //checkt of lid ingeschreven door ons doormiddel van hun Email-adres én ledennummer
   $checkOfLidIsIngeschrevenSql = $con->prepare("SELECT lid_email, lid_nr FROM lid WHERE lid_email = :lidEmail AND lid_nr = :lidNmr");
   $checkOfLidIsIngeschrevenSql->bindParam(":lidEmail", $email);
   $checkOfLidIsIngeschrevenSql->bindParam(":lidNmr", $ledenNmr);
   $checkOfLidIsIngeschrevenSql->execute();

   $checkOfLidIsIngeschreven = $checkOfLidIsIngeschrevenSql->rowCount();

   //checkt of er al een wachtwoord aanwezig is, zo ja is hij al lid bij ons en kan er geen gebruiker aangemaakt worden met deze gegevens
    $checkOfGegevensZijnGebruiktSql = $con->prepare("SELECT lid_wachtwoord FROM lid WHERE lid_email = :lidEmail AND lid_nr = :lidNmr");
    $checkOfGegevensZijnGebruiktSql->bindParam(":lidEmail", $email);
    $checkOfGegevensZijnGebruiktSql->bindParam(":lidNmr", $ledenNmr);
    $checkOfGegevensZijnGebruiktSql->execute();

    $checkOfGegevensZijnGebruikt = $checkOfGegevensZijnGebruiktSql->fetch();

    if ($checkOfLidIsIngeschreven === 1 && $checkOfGegevensZijnGebruikt["lid_wachtwoord"] == null) {
       $registreerGebruikerSql = $con->prepare("UPDATE lid SET lid_wachtwoord = :lidWachtwoord WHERE lid_nr = :lidNmr");
       $registreerGebruikerSql->bindParam(":lidWachtwoord", $wachtwoordMetSaltEncrypt);
       $registreerGebruikerSql->bindParam(":lidNmr", $ledenNmr);
       $registreerGebruikerSql->execute();

       $_SESSION["status"] = "Gefeliciteerd je account is aangemaakt! Log je nu in om verder te gaan.";
       $_SESSION["statusCode"] = "success";
       header ("Location: ../login.php");
   } else {
       $_SESSION["status"] = "Je bent helaas nog geen lid bij ons, je bent al geregistreerd of je hebt je gegevens niet goed ingevuld.";
       $_SESSION["statusCode"] = "error";
       header ("Location: ../login.php");
   }


}