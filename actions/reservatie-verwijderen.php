<?php
session_start();
require_once ("../db/dbconfig.php");

$con = new Dbh();
$con = $con->connect(); //hier zorg ik ervoor dat mijn object connect

$lidID = $_SESSION["lidID"];
$id = $_GET["id"];
$currentDate = date("Y-m-d"); //datum van vandaag

//selecteert hier alle gegevens van de door jouw gekozen reservering
$checkDateSql = $con->prepare("SELECT reserveer_datum FROM reservering WHERE reserveer_id = :reserveerID AND lid_id = :lidID");
$checkDateSql->bindParam(":reserveerID", $id);
$checkDateSql->bindParam("lidID", $lidID);
$checkDateSql->execute();
$checkDate = $checkDateSql->fetch();

//controlleert of de datum niet overeenkomt met die van vandaag, zo ja? mag je hem niet verwijderen
if ($checkDate["reserveer_datum"] == $currentDate) {
    $_SESSION["status"] = "Je baan is op dezelfde dag gereserveerd als wanneer je hem wilt verwijderen. Dit is helaas niet mogelijk.";
    $_SESSION["statusCode"] = "error";
    header("Location: ../gereserveerd-door-mij.php");
} else {
    // verwijderd hier de reservering als het niet dezelfde dag is als vandaag
    $sql = $con->prepare("DELETE FROM reservering WHERE reserveer_id = :reserveerID AND lid_id = :lidID");
    $sql->bindParam(":reserveerID", $id);
    $sql->bindParam("lidID", $lidID);
    $sql->execute();

    $_SESSION["status"] = "Je baan reservering is succesvol verwijderd!";
    $_SESSION["statusCode"] = "success";
    header("Location: ../gereserveerd-door-mij.php");
}

