<?php 
session_start();

include('../db/dbconfig.php');

$dbh = new Dbh();
$pdo = $dbh->connect();

//checkt of alle velden gevuld zijn nadat knop toevoegen ingedrukt is
if (isset($_POST['toevoegen'])) {
    $nieuwProductNaam = ":productNaam";
    $nieuwProductSoort = ":productSoort";
    $nieuwProductPrijs = ":productPrijs";

    //query voorbereiden
    $query = $pdo->prepare("INSERT INTO assortiment (product_naam, product_soort , product_prijs)VALUES ($nieuwProductNaam, $nieuwProductSoort, $nieuwProductPrijs)");

    //bindparam tegen sql injection
    $query->bindParam(':productNaam', $_POST['product_naam']);
    $query->bindParam(':productSoort', $_POST['product_soort']);
    $query->bindParam(':productPrijs', $_POST['product_prijs']);

    $query_exec = $query->execute();//uitvoeren query

    //melding of update gelukt is of niet
    if($query_exec) {
            $_SESSION["status"] = "De gegevens zijn ge-update";
            $_SESSION["statusCode"] = "success";
            header("Location: ../dashboard/menukaart-overzicht.php");
    } else {
        $_SESSION["status"] = "De gegevens zijn niet ge-update";
        $_SESSION["statusCode"] = "error";
        header("Location: ../dashboard/menukaart-overzicht.php.php");
    }
}
?>