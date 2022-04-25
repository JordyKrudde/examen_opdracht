<?php
session_start();

include('../db/dbconfig.php');


$db = new Dbh();
$pdo = $db->connect();

//check of admin ingelogd is dmv session
if(isset($_SESSION["lidID"]) && !empty($_SESSION["lidID"]) && $_SESSION["lidRol"] == "Admin") {


$queryToernooienDone = $pdo->prepare("SELECT * FROM toernooien");// haalt alle info van toernooien op
$queryToernooienDone->execute(); // voort query hierboven uit
$toernooien = $queryToernooienDone->fetchAll(); //fetch mijn gegevens in een array zodat ze in de forEach kunnen
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="theme-color" content="#4285f4"> <!-- Theme color for Google Chrome -->
    <title>DTV | Dashboard</title>
    <link rel="icon" href="http://example.com/favicon.png"> <!-- Favicon for your site -->

    <!-- Bootstrapp css and js -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">

    <link rel="stylesheet" href="css/dashboard.css" type="text/css"> <!-- Dashboard CSS -->
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>  <!-- Custom icons from BoxIcons.com CSS -->

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script> <!-- Jquery for the mobile nav -->

    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css" rel="stylesheet"> <!-- Datatables bootstrapp 5-->
    <link href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css" rel="stylesheet"> <!-- Datatables bootstrapp 5 theme-->

    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet"> <!-- Google font Roboto -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap" rel="stylesheet"> <!-- Google font Poppins -->
</head>
<body>
<header class="bg-light">
    <a href="index.php" class="link-dark text-decoration-none float-start">
        <span class="fs-4 nameDashboard">Admin dashboard</span>
    </a>

    <div class="mobileHamburgerMenu float-start">
        <div></div>
        <div></div>
        <div></div>
    </div>

    <div class="float-end">
        <div class="dropdown">
            <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownBtn" data-bs-toggle="dropdown" aria-expanded="false">
                <?php if (isset($_SESSION["lidRol"]) && $_SESSION["lidRol"] != "") { ?>
                    <?php if ($_SESSION["lidRol"] == "Admin") { ?>
                        Hoi, <?php echo ucfirst($_SESSION["lidName"]);?>
                    <?php }}?>
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownBtn">
                <li><a class="dropdown-item" href="../profiel-gegevens.php">Profiel</a></li>
                <li><a class="dropdown-item" href="../index.php">terug naar leden site</a></li>
            </ul>
        </div>
    </div>

</header>
<main>
    <div class="d-flex flex-column flex-shrink-0 p-3 bg-light sidebar">
        <ul class="nav nav-pills flex-column mb-auto">
            <li>
                <a href="index.php" class="nav-link link-dark">
                    <i class='bx bxs-group me-2'></i>
                    <span>Leden overzicht</span>
                </a>
            </li>
            <li>
                <a href="menukaart-overzicht.php" class="nav-link link-dark">
                    <i class='bx bxs-food-menu me-2'></i>
                    <span>Menukaart overzicht</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="toernooi-overzicht.php" class="nav-link active" style="width:100%;" aria-current="page">
                    <i class='bx bx-table me-2'></i>
                    <span>Toernooien overzicht</span>
                </a>
            </li>
            <li>
                <a href="baan-reserveren.php" class="nav-link link-dark">
                    <i class='bx bxs-calendar-alt me-2'></i>
                    <span>Baan reserveren</span>
                </a>
            </li>
        </ul>
        <span>
            <hr>
           Version 1.0
        </span>
    </div>

    <div class="line">
    </div>

    <div class="content">
        <section class="contentSection">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12" style="margin:40px auto;">
                        <div class="row">
                            <div class="col-md-8">
                                <h5>Toernooien overzicht</h5>
                            </div>
                            <div class="col-md-4">
                                <a href="toernooi-toevoegen.php" class="btn btn-primary" style="float:right;">Toernooi toevoegen</a>
                            </div>
                        </div>
                        <hr>

                        <div class="table-responsive">
                            <table id="dataUserTable" class="table table-striped" style="width:100%">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Toernooi naam</th>
                                    <th>Aantal deelnemers (max 32)</th>
                                    <th>Van</th>
                                    <th>Tot</th>
                                    <th>Toernooi datum</th>
                                    <th>Toernooi deadline</th>
                                    <th>Wijzigen</th>
                                    <th>Verwijderen</th>
                                </tr>
                                </thead>
                                <tbody>

                                <?php
                                // haalt elk toernooi binnen
                                foreach($toernooien as $toernooiRow) {
                                    $date = date_create($toernooiRow['toernooi_datum']); //zet de datum om naar de Europese datum
                                    $newDate = date_format($date, 'd-m-Y');

                                    $dateEnd = date_create($toernooiRow['toernooi_deadline']); //zet de datum om naar de Europese datum
                                    $toernooiDeadline = date_format($date, 'd-m-Y');

                                    $time = date_create($toernooiRow['toernooi_begintijd']); //zet de datum om naar de Europese datum
                                    $beginTijd = date_format($time, 'H:i');

                                    $timestamp = strtotime($toernooiRow['toernooi_eindtijd']); //zet de datum om naar de juiste tijd
                                    $eindTijd = date('H:i', $timestamp);

                                    ?>
                                    <!-- toont de gegevens van het toernooi in een tabel. -->
                                    <tr>
                                        <td><?php echo $toernooiRow['toernooi_id']?></td>
                                        <td><?php echo $toernooiRow['toernooi_naam']?></td>
                                        <td><?php echo $toernooiRow['toernooi_deelnemers']?></td>
                                        <td><?php echo $beginTijd?></td>
                                        <td><?php echo $eindTijd?></td>
                                        <td><?php echo $newDate?></td>
                                        <td><?php echo $toernooiDeadline?></td>
                                        <td><a href="toernooi-wijzigen.php?toernooi_id=<?php echo $toernooiRow['toernooi_id'];?>" class="btn btn-secondary"> Wijzigen</a></td>
                                        <td><a href="../actions/toernooi-verwijderen.php?toernooi_id=<?php echo $toernooiRow['toernooi_id'];?>" class="btn btn-danger">Verwijderen</a></td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>


</main>

<?php
} else {
    header ("Location: ../login.php");
}
?>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap5.min.js"></script>
<script src="js/mobileNav.js"></script>
<script>
    $(function (){
        $('#dataUserTable').DataTable();
    });

</script>

</body>
</html>