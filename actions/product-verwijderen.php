<?php
include('../db/dbconfig.php');

$con = new Dbh();
$con = $con->connect(); //hier zorg ik ervoor dat mijn object connect

$productID = $_GET['product_id'];// product ID ophalen en in variabele zetten

$deleteQuery = $con->prepare("DELETE FROM assortiment WHERE product_id = :product_id");//query voorbereiden
$deleteQuery->bindParam(":product_id", $productID);//bind param tegen sql injection
$deleteQuery->execute();//query uitvoeren

header ("Location: ../dashboard/menukaart-overzicht.php");//terug naar menukaart overzicht