<?php
session_start();
require_once ("db/dbconfig.php");

$con = new Dbh();
$con = $con->connect(); //hier zorg ik ervoor dat mijn object connect

$lidID = $_SESSION["lidID"];

if(isset($_SESSION["lidID"]) && !empty($_SESSION["lidID"])) { //als de gebruiker gezet is mag hij hier komen

$sql = $con->prepare("SELECT * FROM reservering LEFT JOIN baan ON reservering.baan_id = baan.baan_id
WHERE lid_id = :lidID"); //selecteert alle reserveringen van het lid
$sql->bindParam(":lidID", $lidID);
$sql->execute();
$result = $sql->fetchAll();
?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/profiel.css">
    <link rel="stylesheet" href="css/melding.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script> <!-- Jquery for the mobile nav -->

    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.6.0/mdb.min.css" rel="stylesheet"/>

    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>  <!-- Custom icons from BoxIcons.com CSS -->

    <link href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css" rel="stylesheet"> <!-- Datatables bootstrapp 5 theme-->
    <title>DTV | Gereserveerd door mij</title>
</head>
<body>
<?php include('shared/nav.php') ?>

<div class="container">
    <form class="editGegevens">
        <div class="row d-flex justify-content-center">
            <div class="col-md-4">
                <div class="menu-lijst">
                    <div>
                        <ul>
                            <li><a href="profiel-gegevens.php">Profielgegevens</a></li>
                            <li><a href="overzicht-toernooien.php">Overzicht toernooien</a></li>
                            <li><a href="gereserveerd-door-mij.php">Gereserveerd door mij</a></li>
                            <li><a href="actions/uitloggen.php">Uitloggen</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-8" style="padding-top: 20px;">
                <div class="row">
                    <div class="col-md-12">
                        <h5>Gereserveerd door mij</h5>
                    </div>

                </div>
                <hr>
                <?php
                if(isset($_SESSION["status"]) && $_SESSION["status"] != "") { //gebruik ik voor meldingen
                    ?>
                    <div class="melding <?php echo $_SESSION["statusCode"]; ?>" style="width: 100%;">
                        <h6><?php echo $_SESSION["status"]; ?></h6>
                    </div>

                    <?php
                    unset($_SESSION["status"]);
                }
                ?>
                <div class="table-responsive">
                    <table id="dataUserTable" class="table table-striped" style="width:100%">
                        <thead>
                        <tr>
                            <th>Baan</th>
                            <th>Soort</th>
                            <th>Van / tot</th>
                            <th>Datum</th>
                            <th>Verwijderen</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach($result as $results) { //loopt hier door alle resultaten heen
                            $date = date_create($results["reserveer_datum"]); //zet de datum om naar de Europese datum
                            $newDate = date_format($date, 'd-m-Y');

                            $time = date_create($results["reserveer_tijd"]); //zet de datum om naar de Europese datum
                            $newTime = date_format($date, 'g:i');

                            $timestamp = strtotime($results["reserveer_tijd"]) + 60*60;
                            $endTime = date('H:i', $timestamp);
                            ?>
                        <tr>
                            <td>Baan <?php echo $results["baan_id"] ?></td>
                            <td><?php echo ucfirst($results["baan_naam"]) ?></td>
                            <td><?php echo $newTime ?> tot <?php echo $endTime ?></td>
                            <td><?php echo $newDate ?></td>
                            <td><a href="actions/reservatie-verwijderen.php?id=<?php echo $results["reserveer_id"] ?>" class="btn btn-danger">verwijderen</a></td>
                        </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>

            </div>

        </div>
</div>

<?php
} else {
    header ("Location: login.php");
}

include('shared/footer.php')
?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.6.0/mdb.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap5.min.js"></script>
<script>
    $(function (){
        $('#dataUserTable').DataTable();
    });
</script>

</body>