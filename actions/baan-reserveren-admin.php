<?php
session_start();
require_once ("../db/dbconfig.php");

$con = new Dbh();
$con = $con->connect(); //hier zorg ik ervoor dat mijn object connect

$tijd =  $_GET["tijd"];
$datum =  $_GET["datum"];
$baan = $_GET["baan"];
$soort = $_GET["soort"];

//maakt hier de reservering aan en zet hem in de database
$sql = $con->prepare("INSERT INTO reservering (reserveer_datum, reserveer_tijd, baan_id, reserveer_doel) VALUES ( :datum, :tijd, :baanID, :reserveerSoort)");
$sql->bindParam(":datum", $datum);
$sql->bindParam(":tijd", $tijd);
$sql->bindParam(":baanID", $baan);
$sql->bindParam(":reserveerSoort", $soort);
$sql->execute();

$selectBaanGegevens = $con->prepare("SELECT * FROM baan WHERE baan_id = :baanID"); //haalt alle gegevens van de baan op
$selectBaanGegevens->bindParam(":baanID", $baan);
$selectBaanGegevens->execute();
$baanGegevens = $selectBaanGegevens->fetch();

$_SESSION["status1"] = "Je hebt een reservering aangemaakt!";
$_SESSION["statusCode"] = "success";

header ("Location: ../dashboard/baan-reserveren.php");



