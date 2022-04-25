<?php
session_start();
require_once ("../db/dbconfig.php");
require_once ("../actions/email-reservering-aangemaakt.php");

$con = new Dbh();
$con = $con->connect(); //hier zorg ik ervoor dat mijn object connect

$lidID = $_SESSION["lidID"];
$tijd =  $_GET["tijd"];
$datum =  $_GET["datum"];
$baan = $_GET["baan"];

//haalt alles van de reserving op waar het lid gelijk is aan het lid_id en reserveer_datum gelijk is aan de datum
$sql = $con->prepare("SELECT * FROM reservering WHERE lid_id = :lidID AND reserveer_datum = :reserveerDatum");
$sql->bindParam(":lidID",  $lidID);
$sql->bindParam(":reserveerDatum", $datum);
$sql->execute();
$result = $sql->rowCount();

if ($result == 1) { //kijkt of je niet op dezelfde dag al een reservering hebt gemaakt, zo ja mag je niet nog een reservering plaatsen
    $_SESSION["status1"] = "Je hebt al een reservering vandaag, probeer een andere dag in te plannen of je
     reservering van vandaag te verwijderen.";
    $_SESSION["statusCode"] = "error";

    header ("Location: ../baan-reserveren.php?baan=" . $_GET["baan"]);
} else {
    //maakt hier de reservering aan en zet hem in de database
    $sql = $con->prepare("INSERT INTO reservering (lid_id, reserveer_datum, reserveer_tijd, baan_id) VALUES (:lidID, :datum, :tijd, :baanID)");
    $sql->bindParam(":lidID",  $lidID);
    $sql->bindParam(":datum", $datum);
    $sql->bindParam(":tijd", $tijd);
    $sql->bindParam(":baanID", $baan);
    $sql->execute();

    $_SESSION["status1"] = "Je hebt een reservering aangemaakt! Kijk in je mail of bij je reserveringen overzicht voor je reservering.";
    $_SESSION["statusCode"] = "success";

    $lidDataSql = $con->prepare("SELECT * FROM lid WHERE lid_id = :lidID"); //haalt alle gegevens van de lid op
    $lidDataSql->bindParam(":lidID",  $lidID);
    $lidDataSql->execute();
    $lidData = $lidDataSql->fetch();

    $selectBaanGegevens = $con->prepare("SELECT * FROM baan WHERE baan_id = :baanID"); //haalt alle gegevens van de baan op
    $selectBaanGegevens->bindParam(":baanID", $baan);
    $selectBaanGegevens->execute();
    $baanGegevens = $selectBaanGegevens->fetch();

    reserveringAangemaaktEmail($lidData["lid_email"], $datum, $tijd, $baanGegevens["baan_naam"], $baan);

    header ("Location: ../baan-reserveren.php?baan=" . $_GET["baan"]);
}


