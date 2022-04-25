<?php
session_start();
require_once ("../db/dbconfig.php");

$con = new Dbh();
$con = $con->connect(); //hier zorg ik ervoor dat mijn object connect

if(isset($_SESSION["lidID"]) && !empty($_SESSION["lidID"]) && $_SESSION["lidRol"] == "Admin") {

$date1 = new DateTime("29-11-2021");
$date2 = new DateTime("+7 days");
$date3 = new DateTime("+14 days");
$week1 = $date1->format("W");
$week2 = $date2->format("W");
$week3 = $date3->format("W");

if (isset($_GET["week"])) {
    $_SESSION["week"] = $_GET["week"];
}

if (isset($_GET["soort"])) {
    $soort = $_SESSION["soort"] = $_GET["soort"];
} elseif (isset($_SESSION["soort"])) {
    $soort = $_SESSION["soort"];
} else {
    $soort = "Training";
}

if (isset($_GET["baan"]) ) {
    $baan = $_SESSION["baan"] = $_GET["baan"];
} elseif (isset($_SESSION["baan"])){
    $baan = $_SESSION["baan"];
} else {
    $baan = 1;
}

$selectBaanGegevens = $con->prepare("SELECT * FROM baan WHERE baan_id = :baanID"); //haalt alle gegevens van de baan op
$selectBaanGegevens->bindParam(":baanID", $baan);
$selectBaanGegevens->execute();
$baanGegevens = $selectBaanGegevens->fetch();

if (isset($_SESSION["week"])) {
    if ($_SESSION["week"] == $week1) {
        $dag1 = new DateTime('now');
        $dag2 = new DateTime('+1 day');
        $dag3 = new DateTime('+2 day');
        $dag4 = new DateTime('+3 day');
        $dag5 = new DateTime('+4 day');
        $dag6 = new DateTime('+5 day');
        $dag7 = new DateTime('+6 day');

    } elseif ($_SESSION["week"] == $week2) {
        $dag1 = new DateTime('+7 day');
        $dag2 = new DateTime('+8 day');
        $dag3 = new DateTime('+9 day');
        $dag4 = new DateTime('+10 day');
        $dag5 = new DateTime('+11 day');
        $dag6 = new DateTime('+12 day');
        $dag7 = new DateTime('+13 day');
    } elseif ($_SESSION["week"] == $week3) {
        $dag1 = new DateTime('+14 day');
        $dag2 = new DateTime('+15 day');
        $dag3 = new DateTime('+16 day');
        $dag4 = new DateTime('+17 day');
        $dag5 = new DateTime('+18 day');
        $dag6 = new DateTime('+19 day');
        $dag7 = new DateTime('+20 day');
    }
} else {
    $dag1 = new DateTime('now');
    $dag2 = new DateTime('+1 day');
    $dag3 = new DateTime('+2 day');
    $dag4 = new DateTime('+3 day');
    $dag5 = new DateTime('+4 day');
    $dag6 = new DateTime('+5 day');
    $dag7 = new DateTime('+6 day');
}
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
    <link rel="stylesheet" href="../css/baan-reserveren.css" type="text/css"> <!-- Dashboard CSS -->
    <link rel="stylesheet" href="../css/melding.css" type="text/css">
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
                <a href="index.php" class="nav-link link-dark" aria-current="page">
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
            <li>
                <a href="toernooi-overzicht.php" class="nav-link link-dark">
                    <i class='bx bx-table me-2'></i>
                    <span>Toernooien overzicht</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="baan-reserveren.php" class="nav-link active" style="width:100%">
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
                            <div class="col-md-6">
                                <h5>Baan Reserveren</h5>
                            </div>
                            <div class="col-md-2">
                                <form>
                                    <select class="form-select" name="soort" onchange="this.form.submit();">
                                        <?php if (isset($_SESSION["soort"])) {
                                            echo "<option value='" . $_SESSION["soort"] . "'> " . $_SESSION["soort"] . "</option>";
                                            echo "<option disabled>-----------------------</option>";
                                        } ?>
                                        <option value="Training">Training</option>
                                        <option value="Toernooi">Toernooi</option>
                                    </select>
                                    <small>Selecteer hier waarvoor je wilt reserveren</small>
                                </form>
                            </div>
                            <div class="col-md-2">
                                <form>
                                    <select class="form-select" name="week" onchange="this.form.submit();">
                                        <?php if (isset($_SESSION["week"])) {
                                            echo "<option value='" . $_SESSION["week"] . "'>Week " . $_SESSION["week"] . "</option>";
                                            echo "<option disabled>-----------------------</option>";
                                        } ?>
                                        <option value="<?php echo $week1 ?>">Week <?php echo $week1 ?></option>
                                        <option value="<?php echo $week2 ?>">Week <?php echo $week2 ?></option>
                                        <option value="<?php echo $week3 ?>">Week <?php echo $week3 ?></option>
                                    </select>
                                </form>
                            </div>
                            <div class="col-md-2">
                                <form>
                                    <select class="form-select" name="baan" onchange="this.form.submit();">
                                        <?php if (isset($_SESSION["baan"])) {
                                            echo "<option value='" . $_SESSION["baan"] . "'>Baan " . $_SESSION["baan"] . " | " . ucfirst($baanGegevens["baan_naam"]) . " </option>";
                                            echo "<option disabled>-----------------------</option>";
                                        } ?>
                                        <option value="1">Baan 1 | Buiten tennis</option>
                                        <option value="2">Baan 2 | Buiten tennis</option>
                                        <option value="3">Baan 3 | Buiten tennis</option>
                                        <option value="4">Baan 4 | Buiten tennis</option>
                                        <option value="5">Baan 5 | Buiten tennis</option>
                                        <option value="6">Baan 6 | binnen squash</option>
                                        <option value="7">Baan 7 | binnen squash</option>
                                    </select>
                                </form>
                            </div>
                        </div>
                        <hr>

                        <?php
                        if(isset($_SESSION["status1"]) && $_SESSION["status1"] != "") {
                            ?>
                            <div class="melding  <?php echo $_SESSION["statusCode"]; ?>" style="width: 100%;">
                                <h6><?php echo $_SESSION["status1"]; ?></h6>
                            </div>

                            <?php
                            unset($_SESSION["status1"]);
                        }
                        ?>

                        <div class="table-responsive">
                            <table class="table table-bordered text-center overflow-auto">
                                <thead>
                                <tr class="bg-light-gray">
                                    <th class="text-uppercase">Tijd</th>

                                    <th class="text-uppercase "><?php echo $dag1->format('Y-m-d'); ?></th>
                                    <th class="text-uppercase "><?php echo $dag2->format('Y-m-d'); ?></th>
                                    <th class="text-uppercase "><?php echo $dag3->format('Y-m-d'); ?></th>
                                    <th class="text-uppercase "><?php echo $dag4->format('Y-m-d'); ?></th>
                                    <th class="text-uppercase "><?php echo $dag5->format('Y-m-d'); ?></th>
                                    <th class="text-uppercase "><?php echo $dag6->format('Y-m-d'); ?></th>
                                    <th class="text-uppercase "><?php echo $dag7->format('Y-m-d'); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td class="align-middle">12:00</td>
                                    <?php

                                    $dagLoop = 0;
                                    for ($i = 0; $i <= 6; $i++) {
                                        $dagLoop++;

                                        $reserveringenResult["reservering_per_uur"] = '';

                                        $newDate = ${"dag$dagLoop"}->format('Y-m-d');

                                        $reserveringenSql = $con->prepare("SELECT *, (SELECT reserveer_tijd FROM reservering
                                                                                 WHERE reserveer_tijd >= '11:59:00' AND reserveer_tijd <= '13:00:00' AND baan_id = :baanID 
                                                                                   AND reserveer_datum = :reserveerDatum LIMIT 1) AS reservering_per_uur FROM reservering
                                                                                  WHERE reserveer_datum = :reserveerDatum AND reserveer_tijd like '12%' AND baan_id = :baanID");
                                        $reserveringenSql->bindParam(":reserveerDatum", $newDate);
                                        $reserveringenSql->bindParam(":baanID", $baan);
                                        $reserveringenSql->execute();
                                        $reserveringenResult = $reserveringenSql->fetch();
                                        $reserveringenNum = $reserveringenSql->rowCount();

                                        if ($reserveringenNum > 0) {
                                            if ($reserveringenResult["lid_id"] == 0) {
                                                $doel = "voor " . $reserveringenResult["reserveer_doel"];
                                                $deleteLink = "<a href='../actions/verwijder-reserveren-admin.php?id=" . $reserveringenResult['reserveer_id'] . " ' style='cursor:pointer; text-decoration: none'' class='bg-warning padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16 xs-font-size13'>Gereserveerd</a>";
                                            } else {
                                                $doel = "door lid";
                                                $deleteLink = "<span class='bg-warning padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16 xs-font-size13'>Gereserveerd</span>";
                                            }
                                        }

//                                         var_dump($reserveringenResult);

                                        if (isset($reserveringenResult["reserveer_datum"]) && isset($reserveringenResult["reserveer_tijd"])) {
                                            if ($reserveringenResult["reserveer_datum"] == $newDate && $reserveringenResult["reserveer_tijd"] == "12:00:00" && empty($reserveringenResult["reservering_per_uur"])) {
                                                //RESERVERING VAN HALF UUR
                                                ?>
                                                <td>
                                                    <?php echo $deleteLink; ?>
                                                    <div class="margin-10px-top font-size14">12:00-12:30</div>
                                                    <div class="font-size13 text-light-gray">Gereserveerd <?php echo $doel; ?></div>
                                                </td>
                                            <?php } elseif(!empty($reserveringenResult["reservering_per_uur"])) {
                                                //RESERVERING VAN UUR DOOR LID
                                                ?>
                                                <td>
                                                    <?php echo $deleteLink; ?>
                                                    <div class="margin-10px-top font-size14">12:00-12:30</div>
                                                    <div class="font-size13 text-light-gray">Gereserveerd <?php echo $doel; ?></div>
                                                </td>
                                            <?php  } else {  //NOG TE RESERVEREN ?>
                                                <td>
                                                    <a href="../actions/baan-reserveren-admin.php?tijd=12:00&&datum=<?php echo ${"dag$dagLoop"}->format('Y-m-d'); ?>&&baan=<?php echo $baan ?>&&soort=<?php echo $soort; ?>" style="cursor:pointer; text-decoration: none" class="bg-green padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16  xs-font-size13">Reserveer</a>
                                                    <div class="margin-10px-top font-size14">12:00-12:30</div>
                                                    <div class="font-size13 text-light-gray">Reserveerbaar</div>
                                                </td>
                                            <?php } ?>
                                        <?php  } else {
                                            //NOG TE RESERVEREN
                                            ?>
                                            <td>
                                                <a href="../actions/baan-reserveren-admin.php?tijd=12:00&&datum=<?php echo ${"dag$dagLoop"}->format('Y-m-d'); ?>&&baan=<?php echo $baan ?>&&soort=<?php echo $soort; ?>" style="cursor:pointer; text-decoration: none" class="bg-green padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16  xs-font-size13">Reserveer</a>
                                                <div class="margin-10px-top font-size14">12:00-12:30</div>
                                                <div class="font-size13 text-light-gray">Reserveerbaar</div>
                                            </td>


                                        <?php } } ?>
                                </tr>
                                <tr>
                                    <td class="align-middle">12:30</td>
                                    <?php

                                    $dagLoop = 0;
                                    for ($i = 0; $i <= 6; $i++) {
                                        $dagLoop++;

                                        $reserveringenResult["reservering_per_uur"] = '';

                                        $newDate = ${"dag$dagLoop"}->format('Y-m-d');

                                        $reserveringenSql = $con->prepare("SELECT *, (SELECT reserveer_tijd FROM reservering
                                                                                 WHERE reserveer_tijd >= '11:59:00' AND reserveer_tijd <= '13:00:00' AND baan_id = :baanID 
                                                                                   AND reserveer_datum = :reserveerDatum LIMIT 1) AS reservering_per_uur FROM reservering
                                                                                  WHERE reserveer_datum = :reserveerDatum AND reserveer_tijd like '12%' AND baan_id = :baanID");
                                        $reserveringenSql->bindParam(":reserveerDatum", $newDate);
                                        $reserveringenSql->bindParam(":baanID", $baan);
                                        $reserveringenSql->execute();
                                        $reserveringenResult = $reserveringenSql->fetch();
                                        $reserveringenNum = $reserveringenSql->rowCount();

                                        if ($reserveringenNum > 0) {
                                            if ($reserveringenResult["lid_id"] == 0) {
                                                $doel = "voor " . $reserveringenResult["reserveer_doel"];
                                                $deleteLink = "<a href='../actions/verwijder-reserveren-admin.php?id=" . $reserveringenResult['reserveer_id'] . " ' style='cursor:pointer; text-decoration: none'' class='bg-warning padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16 xs-font-size13'>Gereserveerd</a>";
                                            } else {
                                                $doel = "door lid";
                                                $deleteLink = "<span class='bg-warning padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16 xs-font-size13'>Gereserveerd</span>";
                                            }
                                        }

//                                         var_dump($reserveringenResult["reservering_per_uur"]);

                                        if (isset($reserveringenResult["reserveer_datum"]) && isset($reserveringenResult["reserveer_tijd"])) {
                                            if ($reserveringenResult["reserveer_datum"] == $newDate && $reserveringenResult["reserveer_tijd"] == "12:30:00" && empty($reserveringenResult["reservering_per_uur"])) {
                                                //RESERVERING VAN HALF UUR
                                                ?>
                                                <td>
                                                    <?php echo $deleteLink; ?>
                                                    <div class="margin-10px-top font-size14">12:30-13:00</div>
                                                    <div class="font-size13 text-light-gray">Gereserveerd <?php echo $doel; ?></div>
                                                </td>
                                            <?php } elseif(!empty($reserveringenResult["reservering_per_uur"]) && $reserveringenResult["lid_id"] != 0) {
                                                //RESERVERING VAN UUR DOOR LID
                                                ?>
                                                <td>
                                                    <?php echo $deleteLink; ?>
                                                    <div class="margin-10px-top font-size14">12:30-13:00</div>
                                                    <div class="font-size13 text-light-gray">Gereserveerd <?php echo $doel; ?></div>
                                                </td>
                                            <?php  } else {  //NOG TE RESERVEREN ?>
                                                <td>
                                                    <a href="../actions/baan-reserveren-admin.php?tijd=12:30&&datum=<?php echo ${"dag$dagLoop"}->format('Y-m-d'); ?>&&baan=<?php echo $baan ?>&&soort=<?php echo $soort; ?>" style="cursor:pointer; text-decoration: none" class="bg-green padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16  xs-font-size13">Reserveer</a>
                                                    <div class="margin-10px-top font-size14">12:30-13:00</div>
                                                    <div class="font-size13 text-light-gray">Reserveerbaar</div>
                                                </td>
                                            <?php } ?>
                                        <?php  } else {
                                            //NOG TE RESERVEREN
                                            ?>
                                            <td>
                                                <a href="../actions/baan-reserveren-admin.php?tijd=12:30&&datum=<?php echo ${"dag$dagLoop"}->format('Y-m-d'); ?>&&baan=<?php echo $baan ?>&&soort=<?php echo $soort; ?>" style="cursor:pointer; text-decoration: none" class="bg-green padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16  xs-font-size13">Reserveer</a>
                                                <div class="margin-10px-top font-size14">12:30-13:00</div>
                                                <div class="font-size13 text-light-gray">Reserveerbaar</div>
                                            </td>


                                        <?php } } ?>
                                </tr>
                                <tr>
                                    <td class="align-middle">13:00</td>
                                    <?php

                                    $dagLoop = 0;
                                    for ($i = 0; $i <= 6; $i++) {
                                        $dagLoop++;

                                        $reserveringenResult["reservering_per_uur"] = '';

                                        $newDate = ${"dag$dagLoop"}->format('Y-m-d');

                                        $reserveringenSql = $con->prepare("SELECT *, (SELECT reserveer_tijd FROM reservering
                                                                                 WHERE reserveer_tijd >= '12:59:00' AND reserveer_tijd <= '14:00:00' AND baan_id = :baanID 
                                                                                   AND reserveer_datum = :reserveerDatum LIMIT 1) AS reservering_per_uur FROM reservering
                                                                                  WHERE reserveer_datum = :reserveerDatum AND reserveer_tijd like '13%' AND baan_id = :baanID");
                                        $reserveringenSql->bindParam(":reserveerDatum", $newDate);
                                        $reserveringenSql->bindParam(":baanID", $baan);
                                        $reserveringenSql->execute();
                                        $reserveringenResult = $reserveringenSql->fetch();
                                        $reserveringenNum = $reserveringenSql->rowCount();

                                        if ($reserveringenNum > 0) {
                                            if ($reserveringenResult["lid_id"] == 0) {
                                                $doel = "voor " . $reserveringenResult["reserveer_doel"];
                                                $deleteLink = "<a href='../actions/verwijder-reserveren-admin.php?id=" . $reserveringenResult['reserveer_id'] . " ' style='cursor:pointer; text-decoration: none'' class='bg-warning padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16 xs-font-size13'>Gereserveerd</a>";
                                            } else {
                                                $doel = "door lid";
                                                $deleteLink = "<span class='bg-warning padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16 xs-font-size13'>Gereserveerd</span>";
                                            }
                                        }

//                                         var_dump($reserveringenResult["reservering_per_uur"]);

                                        if (isset($reserveringenResult["reserveer_datum"]) && isset($reserveringenResult["reserveer_tijd"])) {
                                            if ($reserveringenResult["reserveer_datum"] == $newDate && $reserveringenResult["reserveer_tijd"] == "13:00:00" && empty($reserveringenResult["reservering_per_uur"])) {
                                                //RESERVERING VAN HALF UUR
                                                ?>
                                                <td>
                                                    <?php echo $deleteLink; ?>
                                                    <div class="margin-10px-top font-size14">13:00-13:30</div>
                                                    <div class="font-size13 text-light-gray">Gereserveerd <?php echo $doel; ?></div>
                                                </td>
                                            <?php } elseif(!empty($reserveringenResult["reservering_per_uur"])) {
                                                //RESERVERING VAN UUR DOOR LID
                                                ?>
                                                <td>
                                                    <?php echo $deleteLink; ?>
                                                    <div class="margin-10px-top font-size14">13:00-13:30</div>
                                                    <div class="font-size13 text-light-gray">Gereserveerd <?php echo $doel; ?></div>
                                                </td>
                                            <?php  } else {  //NOG TE RESERVEREN ?>
                                                <td>
                                                    <a href="../actions/baan-reserveren-admin.php?tijd=13:00&&datum=<?php echo ${"dag$dagLoop"}->format('Y-m-d'); ?>&&baan=<?php echo $baan ?>&&soort=<?php echo $soort; ?>" style="cursor:pointer; text-decoration: none" class="bg-green padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16  xs-font-size13">Reserveer</a>
                                                    <div class="margin-10px-top font-size14">13:00-13:30</div>
                                                    <div class="font-size13 text-light-gray">Reserveerbaar</div>
                                                </td>
                                            <?php } ?>
                                        <?php  } else {
                                            //NOG TE RESERVEREN
                                            ?>
                                            <td>
                                                <a href="../actions/baan-reserveren-admin.php?tijd=13:00&&datum=<?php echo ${"dag$dagLoop"}->format('Y-m-d'); ?>&&baan=<?php echo $baan ?>&&soort=<?php echo $soort; ?>" style="cursor:pointer; text-decoration: none" class="bg-green padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16  xs-font-size13">Reserveer</a>
                                                <div class="margin-10px-top font-size14">13:00-13:00</div>
                                                <div class="font-size13 text-light-gray">Reserveerbaar</div>
                                            </td>


                                        <?php } } ?>
                                </tr>
                                <tr>
                                    <td class="align-middle">13:30</td>
                                    <?php

                                    $dagLoop = 0;
                                    for ($i = 0; $i <= 6; $i++) {
                                        $dagLoop++;

                                        $reserveringenResult["reservering_per_uur"] = '';

                                        $newDate = ${"dag$dagLoop"}->format('Y-m-d');

                                        $reserveringenSql = $con->prepare("SELECT *, (SELECT reserveer_tijd FROM reservering
                                                                                 WHERE reserveer_tijd >= '12:59:00' AND reserveer_tijd <= '14:00:00' AND baan_id = :baanID 
                                                                                   AND reserveer_datum = :reserveerDatum LIMIT 1) AS reservering_per_uur FROM reservering
                                                                                  WHERE reserveer_datum = :reserveerDatum AND reserveer_tijd like '13%' AND baan_id = :baanID");
                                        $reserveringenSql->bindParam(":reserveerDatum", $newDate);
                                        $reserveringenSql->bindParam(":baanID", $baan);
                                        $reserveringenSql->execute();
                                        $reserveringenResult = $reserveringenSql->fetch();
                                        $reserveringenNum = $reserveringenSql->rowCount();

                                        if ($reserveringenNum > 0) {
                                            if ($reserveringenResult["lid_id"] == 0) {
                                                $doel = "voor " . $reserveringenResult["reserveer_doel"];
                                                $deleteLink = "<a href='../actions/verwijder-reserveren-admin.php?id=" . $reserveringenResult['reserveer_id'] . " ' style='cursor:pointer; text-decoration: none'' class='bg-warning padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16 xs-font-size13'>Gereserveerd</a>";
                                            } else {
                                                $doel = "door lid";
                                                $deleteLink = "<span class='bg-warning padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16 xs-font-size13'>Gereserveerd</span>";
                                            }
                                        }

//                                         var_dump($reserveringenResult["reservering_per_uur"]);

                                        if (isset($reserveringenResult["reserveer_datum"]) && isset($reserveringenResult["reserveer_tijd"])) {
                                            if ($reserveringenResult["reserveer_datum"] == $newDate && $reserveringenResult["reserveer_tijd"] == "13:30:00" && empty($reserveringenResult["reservering_per_uur"])) {
                                                //RESERVERING VAN HALF UUR
                                                ?>
                                                <td>
                                                    <?php echo $deleteLink; ?>
                                                    <div class="margin-10px-top font-size14">13:30-14:00</div>
                                                    <div class="font-size13 text-light-gray">Gereserveerd <?php echo $doel; ?></div>
                                                </td>
                                            <?php } elseif(!empty($reserveringenResult["reservering_per_uur"]) && $reserveringenResult["lid_id"] != 0) {
                                                //RESERVERING VAN UUR DOOR LID
                                                ?>
                                                <td>
                                                    <?php echo $deleteLink; ?>
                                                    <div class="margin-10px-top font-size14">13:30-14:00</div>
                                                    <div class="font-size13 text-light-gray">Gereserveerd <?php echo $doel; ?></div>
                                                </td>
                                            <?php  } else {  //NOG TE RESERVEREN ?>
                                                <td>
                                                    <a href="../actions/baan-reserveren-admin.php?tijd=13:30&&datum=<?php echo ${"dag$dagLoop"}->format('Y-m-d'); ?>&&baan=<?php echo $baan ?>&&soort=<?php echo $soort; ?>" style="cursor:pointer; text-decoration: none" class="bg-green padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16  xs-font-size13">Reserveer</a>
                                                    <div class="margin-10px-top font-size14">13:30-14:00</div>
                                                    <div class="font-size13 text-light-gray">Reserveerbaar</div>
                                                </td>
                                            <?php } ?>
                                        <?php  } else {
                                            //NOG TE RESERVEREN
                                            ?>
                                            <td>
                                                <a href="../actions/baan-reserveren-admin.php?tijd=13:30&&datum=<?php echo ${"dag$dagLoop"}->format('Y-m-d'); ?>&&baan=<?php echo $baan ?>&&soort=<?php echo $soort; ?>" style="cursor:pointer; text-decoration: none" class="bg-green padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16  xs-font-size13">Reserveer</a>
                                                <div class="margin-10px-top font-size14">13:30-14:00</div>
                                                <div class="font-size13 text-light-gray">Reserveerbaar</div>
                                            </td>


                                        <?php } } ?>
                                </tr>
                                <tr>
                                    <td class="align-middle">14:00</td>
                                    <?php

                                    $dagLoop = 0;
                                    for ($i = 0; $i <= 6; $i++) {
                                        $dagLoop++;

                                        $reserveringenResult["reservering_per_uur"] = '';

                                        $newDate = ${"dag$dagLoop"}->format('Y-m-d');

                                        $reserveringenSql = $con->prepare("SELECT *, (SELECT reserveer_tijd FROM reservering
                                                                                 WHERE reserveer_tijd >= '13:59:00' AND reserveer_tijd <= '15:00:00' AND baan_id = :baanID 
                                                                                   AND reserveer_datum = :reserveerDatum LIMIT 1) AS reservering_per_uur FROM reservering
                                                                                  WHERE reserveer_datum = :reserveerDatum AND reserveer_tijd like '14%' AND baan_id = :baanID");
                                        $reserveringenSql->bindParam(":reserveerDatum", $newDate);
                                        $reserveringenSql->bindParam(":baanID", $baan);
                                        $reserveringenSql->execute();
                                        $reserveringenResult = $reserveringenSql->fetch();
                                        $reserveringenNum = $reserveringenSql->rowCount();

                                        if ($reserveringenNum > 0) {
                                            if ($reserveringenResult["lid_id"] == 0) {
                                                $doel = "voor " . $reserveringenResult["reserveer_doel"];
                                                $deleteLink = "<a href='../actions/verwijder-reserveren-admin.php?id=" . $reserveringenResult['reserveer_id'] . " ' style='cursor:pointer; text-decoration: none'' class='bg-warning padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16 xs-font-size13'>Gereserveerd</a>";
                                            } else {
                                                $doel = "door lid";
                                                $deleteLink = "<span class='bg-warning padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16 xs-font-size13'>Gereserveerd</span>";
                                            }
                                        }

//                                         var_dump($reserveringenResult["reservering_per_uur"]);

                                        if (isset($reserveringenResult["reserveer_datum"]) && isset($reserveringenResult["reserveer_tijd"])) {
                                            if ($reserveringenResult["reserveer_datum"] == $newDate && $reserveringenResult["reserveer_tijd"] == "14:00:00" && empty($reserveringenResult["reservering_per_uur"])) {
                                                //RESERVERING VAN HALF UUR
                                                ?>
                                                <td>
                                                    <?php echo $deleteLink; ?>
                                                    <div class="margin-10px-top font-size14">14:00-14:30</div>
                                                    <div class="font-size13 text-light-gray">Gereserveerd <?php echo $doel; ?></div>
                                                </td>
                                            <?php } elseif(!empty($reserveringenResult["reservering_per_uur"])) {
                                                //RESERVERING VAN UUR DOOR LID
                                                ?>
                                                <td>
                                                    <?php echo $deleteLink; ?>
                                                    <div class="margin-10px-top font-size14">14:00-14:30</div>
                                                    <div class="font-size13 text-light-gray">Gereserveerd <?php echo $doel; ?></div>
                                                </td>
                                            <?php  } else {  //NOG TE RESERVEREN ?>
                                                <td>
                                                    <a href="../actions/baan-reserveren-admin.php?tijd=14:00&&datum=<?php echo ${"dag$dagLoop"}->format('Y-m-d'); ?>&&baan=<?php echo $baan ?>&&soort=<?php echo $soort; ?>" style="cursor:pointer; text-decoration: none" class="bg-green padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16  xs-font-size13">Reserveer</a>
                                                    <div class="margin-10px-top font-size14">14:00-14:30</div>
                                                    <div class="font-size13 text-light-gray">Reserveerbaar</div>
                                                </td>
                                            <?php } ?>
                                        <?php  } else {
                                            //NOG TE RESERVEREN
                                            ?>
                                            <td>
                                                <a href="../actions/baan-reserveren-admin.php?tijd=14:00&&datum=<?php echo ${"dag$dagLoop"}->format('Y-m-d'); ?>&&baan=<?php echo $baan ?>&&soort=<?php echo $soort; ?>" style="cursor:pointer; text-decoration: none" class="bg-green padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16  xs-font-size13">Reserveer</a>
                                                <div class="margin-10px-top font-size14">14:00-14:30</div>
                                                <div class="font-size13 text-light-gray">Reserveerbaar</div>
                                            </td>


                                        <?php } } ?>
                                </tr>
                                <tr>
                                    <td class="align-middle">14:30</td>
                                    <?php

                                    $dagLoop = 0;
                                    for ($i = 0; $i <= 6; $i++) {
                                        $dagLoop++;

                                        $reserveringenResult["reservering_per_uur"] = '';

                                        $newDate = ${"dag$dagLoop"}->format('Y-m-d');

                                        $reserveringenSql = $con->prepare("SELECT *, (SELECT reserveer_tijd FROM reservering
                                                                                 WHERE reserveer_tijd >= '13:59:00' AND reserveer_tijd <= '15:00:00' AND baan_id = :baanID 
                                                                                   AND reserveer_datum = :reserveerDatum LIMIT 1) AS reservering_per_uur FROM reservering
                                                                                  WHERE reserveer_datum = :reserveerDatum AND reserveer_tijd like '14%' AND baan_id = :baanID");
                                        $reserveringenSql->bindParam(":reserveerDatum", $newDate);
                                        $reserveringenSql->bindParam(":baanID", $baan);
                                        $reserveringenSql->execute();
                                        $reserveringenResult = $reserveringenSql->fetch();
                                        $reserveringenNum = $reserveringenSql->rowCount();

                                        if ($reserveringenNum > 0) {
                                            if ($reserveringenResult["lid_id"] == 0) {
                                                $doel = "voor " . $reserveringenResult["reserveer_doel"];
                                                $deleteLink = "<a href='../actions/verwijder-reserveren-admin.php?id=" . $reserveringenResult['reserveer_id'] . " ' style='cursor:pointer; text-decoration: none'' class='bg-warning padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16 xs-font-size13'>Gereserveerd</a>";
                                            } else {
                                                $doel = "door lid";
                                                $deleteLink = "<span class='bg-warning padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16 xs-font-size13'>Gereserveerd</span>";
                                            }
                                        }

//                                         var_dump($reserveringenResult["reservering_per_uur"]);

                                        if (isset($reserveringenResult["reserveer_datum"]) && isset($reserveringenResult["reserveer_tijd"])) {
                                            if ($reserveringenResult["reserveer_datum"] == $newDate && $reserveringenResult["reserveer_tijd"] == "14:30:00" && empty($reserveringenResult["reservering_per_uur"])) {
                                                //RESERVERING VAN HALF UUR
                                                ?>
                                                <td>
                                                    <?php echo $deleteLink; ?>
                                                    <div class="margin-10px-top font-size14">14:30-15:00</div>
                                                    <div class="font-size13 text-light-gray">Gereserveerd <?php echo $doel; ?></div>
                                                </td>
                                            <?php } elseif(!empty($reserveringenResult["reservering_per_uur"]) && $reserveringenResult["lid_id"] != 0) {
                                                //RESERVERING VAN UUR DOOR LID
                                                ?>
                                                <td>
                                                    <?php echo $deleteLink; ?>
                                                    <div class="margin-10px-top font-size14">14:30-15:00</div>
                                                    <div class="font-size13 text-light-gray">Gereserveerd <?php echo $doel; ?></div>
                                                </td>
                                            <?php  } else {  //NOG TE RESERVEREN ?>
                                                <td>
                                                    <a href="../actions/baan-reserveren-admin.php?tijd=14:30&&datum=<?php echo ${"dag$dagLoop"}->format('Y-m-d'); ?>&&baan=<?php echo $baan ?>&&soort=<?php echo $soort; ?>" style="cursor:pointer; text-decoration: none" class="bg-green padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16  xs-font-size13">Reserveer</a>
                                                    <div class="margin-10px-top font-size14">14:30-15:00</div>
                                                    <div class="font-size13 text-light-gray">Reserveerbaar</div>
                                                </td>
                                            <?php } ?>
                                        <?php  } else {
                                            //NOG TE RESERVEREN
                                            ?>
                                            <td>
                                                <a href="../actions/baan-reserveren-admin.php?tijd=14:30&&datum=<?php echo ${"dag$dagLoop"}->format('Y-m-d'); ?>&&baan=<?php echo $baan ?>&&soort=<?php echo $soort; ?>" style="cursor:pointer; text-decoration: none" class="bg-green padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16  xs-font-size13">Reserveer</a>
                                                <div class="margin-10px-top font-size14">14:30-15:00</div>
                                                <div class="font-size13 text-light-gray">Reserveerbaar</div>
                                            </td>


                                        <?php } } ?>
                                </tr>
                                <tr>
                                    <td class="align-middle">15:00</td>
                                    <?php

                                    $dagLoop = 0;
                                    for ($i = 0; $i <= 6; $i++) {
                                        $dagLoop++;

                                        $reserveringenResult["reservering_per_uur"] = '';

                                        $newDate = ${"dag$dagLoop"}->format('Y-m-d');

                                        $reserveringenSql = $con->prepare("SELECT *, (SELECT reserveer_tijd FROM reservering
                                                                                 WHERE reserveer_tijd >= '14:59:00' AND reserveer_tijd <= '16:00:00' AND baan_id = :baanID 
                                                                                   AND reserveer_datum = :reserveerDatum LIMIT 1) AS reservering_per_uur FROM reservering
                                                                                  WHERE reserveer_datum = :reserveerDatum AND reserveer_tijd like '14%' AND baan_id = :baanID");
                                        $reserveringenSql->bindParam(":reserveerDatum", $newDate);
                                        $reserveringenSql->bindParam(":baanID", $baan);
                                        $reserveringenSql->execute();
                                        $reserveringenResult = $reserveringenSql->fetch();
                                        $reserveringenNum = $reserveringenSql->rowCount();

                                        if ($reserveringenNum > 0) {
                                            if ($reserveringenResult["lid_id"] == 0) {
                                                $doel = "voor " . $reserveringenResult["reserveer_doel"];
                                                $deleteLink = "<a href='../actions/verwijder-reserveren-admin.php?id=" . $reserveringenResult['reserveer_id'] . " ' style='cursor:pointer; text-decoration: none'' class='bg-warning padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16 xs-font-size13'>Gereserveerd</a>";
                                            } else {
                                                $doel = "door lid";
                                                $deleteLink = "<span class='bg-warning padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16 xs-font-size13'>Gereserveerd</span>";
                                            }
                                        }

//                                         var_dump($reserveringenResult["reservering_per_uur"]);

                                        if (isset($reserveringenResult["reserveer_datum"]) && isset($reserveringenResult["reserveer_tijd"])) {
                                            if ($reserveringenResult["reserveer_datum"] == $newDate && $reserveringenResult["reserveer_tijd"] == "15:00:00" && empty($reserveringenResult["reservering_per_uur"])) {
                                                //RESERVERING VAN HALF UUR
                                                ?>
                                                <td>
                                                    <?php echo $deleteLink; ?>
                                                    <div class="margin-10px-top font-size14">15:00-15:30</div>
                                                    <div class="font-size13 text-light-gray">Gereserveerd <?php echo $doel; ?></div>
                                                </td>
                                            <?php } elseif(!empty($reserveringenResult["reservering_per_uur"])) {
                                                //RESERVERING VAN UUR DOOR LID
                                                ?>
                                                <td>
                                                    <?php echo $deleteLink; ?>
                                                    <div class="margin-10px-top font-size14">15:00-15:30</div>
                                                    <div class="font-size13 text-light-gray">Gereserveerd <?php echo $doel; ?></div>
                                                </td>
                                            <?php  } else {  //NOG TE RESERVEREN ?>
                                                <td>
                                                    <a href="../actions/baan-reserveren-admin.php?tijd=15:00&&datum=<?php echo ${"dag$dagLoop"}->format('Y-m-d'); ?>&&baan=<?php echo $baan ?>&&soort=<?php echo $soort; ?>" style="cursor:pointer; text-decoration: none" class="bg-green padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16  xs-font-size13">Reserveer</a>
                                                    <div class="margin-10px-top font-size14">15:00-15:30</div>
                                                    <div class="font-size13 text-light-gray">Reserveerbaar</div>
                                                </td>
                                            <?php } ?>
                                        <?php  } else {
                                            //NOG TE RESERVEREN
                                            ?>
                                            <td>
                                                <a href="../actions/baan-reserveren-admin.php?tijd=15:00&&datum=<?php echo ${"dag$dagLoop"}->format('Y-m-d'); ?>&&baan=<?php echo $baan ?>&&soort=<?php echo $soort; ?>" style="cursor:pointer; text-decoration: none" class="bg-green padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16  xs-font-size13">Reserveer</a>
                                                <div class="margin-10px-top font-size14">15:00-15:30</div>
                                                <div class="font-size13 text-light-gray">Reserveerbaar</div>
                                            </td>


                                        <?php } } ?>
                                </tr>
                                <tr>
                                    <td class="align-middle">15:30</td>
                                    <?php

                                    $dagLoop = 0;
                                    for ($i = 0; $i <= 6; $i++) {
                                        $dagLoop++;

                                        $reserveringenResult["reservering_per_uur"] = '';

                                        $newDate = ${"dag$dagLoop"}->format('Y-m-d');

                                        $reserveringenSql = $con->prepare("SELECT *, (SELECT reserveer_tijd FROM reservering
                                                                                 WHERE reserveer_tijd >= '14:59:00' AND reserveer_tijd <= '16:00:00' AND baan_id = :baanID 
                                                                                   AND reserveer_datum = :reserveerDatum LIMIT 1) AS reservering_per_uur FROM reservering
                                                                                  WHERE reserveer_datum = :reserveerDatum AND reserveer_tijd like '15%' AND baan_id = :baanID");
                                        $reserveringenSql->bindParam(":reserveerDatum", $newDate);
                                        $reserveringenSql->bindParam(":baanID", $baan);
                                        $reserveringenSql->execute();
                                        $reserveringenResult = $reserveringenSql->fetch();
                                        $reserveringenNum = $reserveringenSql->rowCount();

                                        if ($reserveringenNum > 0) {
                                            if ($reserveringenResult["lid_id"] == 0) {
                                                $doel = "voor " . $reserveringenResult["reserveer_doel"];
                                                $deleteLink = "<a href='../actions/verwijder-reserveren-admin.php?id=" . $reserveringenResult['reserveer_id'] . " ' style='cursor:pointer; text-decoration: none'' class='bg-warning padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16 xs-font-size13'>Gereserveerd</a>";
                                            } else {
                                                $doel = "door lid";
                                                $deleteLink = "<span class='bg-warning padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16 xs-font-size13'>Gereserveerd</span>";
                                            }
                                        }

//                                         var_dump($reserveringenResult["reservering_per_uur"]);

                                        if (isset($reserveringenResult["reserveer_datum"]) && isset($reserveringenResult["reserveer_tijd"])) {
                                            if ($reserveringenResult["reserveer_datum"] == $newDate && $reserveringenResult["reserveer_tijd"] == "15:30:00" && empty($reserveringenResult["reservering_per_uur"])) {
                                                //RESERVERING VAN HALF UUR
                                                ?>
                                                <td>
                                                    <?php echo $deleteLink; ?>
                                                    <div class="margin-10px-top font-size14">15:30-16:00</div>
                                                    <div class="font-size13 text-light-gray">Gereserveerd <?php echo $doel; ?></div>
                                                </td>
                                            <?php } elseif(!empty($reserveringenResult["reservering_per_uur"]) && $reserveringenResult["lid_id"] != 0) {
                                                //RESERVERING VAN UUR DOOR LID
                                                ?>
                                                <td>
                                                    <?php echo $deleteLink; ?>
                                                    <div class="margin-10px-top font-size14">15:30-16:00</div>
                                                    <div class="font-size13 text-light-gray">Gereserveerd <?php echo $doel; ?></div>
                                                </td>
                                            <?php  } else {  //NOG TE RESERVEREN ?>
                                                <td>
                                                    <a href="../actions/baan-reserveren-admin.php?tijd=15:30&&datum=<?php echo ${"dag$dagLoop"}->format('Y-m-d'); ?>&&baan=<?php echo $baan ?>&&soort=<?php echo $soort; ?>" style="cursor:pointer; text-decoration: none" class="bg-green padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16  xs-font-size13">Reserveer</a>
                                                    <div class="margin-10px-top font-size14">15:30-16:00</div>
                                                    <div class="font-size13 text-light-gray">Reserveerbaar</div>
                                                </td>
                                            <?php } ?>
                                        <?php  } else {
                                            //NOG TE RESERVEREN
                                            ?>
                                            <td>
                                                <a href="../actions/baan-reserveren-admin.php?tijd=15:30&&datum=<?php echo ${"dag$dagLoop"}->format('Y-m-d'); ?>&&baan=<?php echo $baan ?>&&soort=<?php echo $soort; ?>" style="cursor:pointer; text-decoration: none" class="bg-green padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16  xs-font-size13">Reserveer</a>
                                                <div class="margin-10px-top font-size14">15:30-16:00</div>
                                                <div class="font-size13 text-light-gray">Reserveerbaar</div>
                                            </td>


                                        <?php } } ?>
                                </tr>
                                <tr>
                                    <td class="align-middle">16:00</td>
                                    <?php

                                    $dagLoop = 0;
                                    for ($i = 0; $i <= 6; $i++) {
                                        $dagLoop++;

                                        $reserveringenResult["reservering_per_uur"] = '';

                                        $newDate = ${"dag$dagLoop"}->format('Y-m-d');

                                        $reserveringenSql = $con->prepare("SELECT *, (SELECT reserveer_tijd FROM reservering
                                                                                 WHERE reserveer_tijd >= '15:59:00' AND reserveer_tijd <= '17:00:00' AND baan_id = :baanID 
                                                                                   AND reserveer_datum = :reserveerDatum LIMIT 1) AS reservering_per_uur FROM reservering
                                                                                  WHERE reserveer_datum = :reserveerDatum AND reserveer_tijd like '16%' AND baan_id = :baanID");
                                        $reserveringenSql->bindParam(":reserveerDatum", $newDate);
                                        $reserveringenSql->bindParam(":baanID", $baan);
                                        $reserveringenSql->execute();
                                        $reserveringenResult = $reserveringenSql->fetch();
                                        $reserveringenNum = $reserveringenSql->rowCount();

                                        if ($reserveringenNum > 0) {
                                            if ($reserveringenResult["lid_id"] == 0) {
                                                $doel = "voor " . $reserveringenResult["reserveer_doel"];
                                                $deleteLink = "<a href='../actions/verwijder-reserveren-admin.php?id=" . $reserveringenResult['reserveer_id'] . " ' style='cursor:pointer; text-decoration: none'' class='bg-warning padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16 xs-font-size13'>Gereserveerd</a>";
                                            } else {
                                                $doel = "door lid";
                                                $deleteLink = "<span class='bg-warning padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16 xs-font-size13'>Gereserveerd</span>";
                                            }
                                        }

//                                         var_dump($reserveringenResult["reservering_per_uur"]);

                                        if (isset($reserveringenResult["reserveer_datum"]) && isset($reserveringenResult["reserveer_tijd"])) {
                                            if ($reserveringenResult["reserveer_datum"] == $newDate && $reserveringenResult["reserveer_tijd"] == "16:00:00" && empty($reserveringenResult["reservering_per_uur"])) {
                                                //RESERVERING VAN HALF UUR
                                                ?>
                                                <td>
                                                    <?php echo $deleteLink; ?>
                                                    <div class="margin-10px-top font-size14">16:00-16:30</div>
                                                    <div class="font-size13 text-light-gray">Gereserveerd <?php echo $doel; ?></div>
                                                </td>
                                            <?php } elseif(!empty($reserveringenResult["reservering_per_uur"])) {
                                                //RESERVERING VAN UUR DOOR LID
                                                ?>
                                                <td>
                                                    <?php echo $deleteLink; ?>
                                                    <div class="margin-10px-top font-size14">16:00-16:30</div>
                                                    <div class="font-size13 text-light-gray">Gereserveerd <?php echo $doel; ?></div>
                                                </td>
                                            <?php  } else {  //NOG TE RESERVEREN ?>
                                                <td>
                                                    <a href="../actions/baan-reserveren-admin.php?tijd=16:00&&datum=<?php echo ${"dag$dagLoop"}->format('Y-m-d'); ?>&&baan=<?php echo $baan ?>&&soort=<?php echo $soort; ?>" style="cursor:pointer; text-decoration: none" class="bg-green padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16  xs-font-size13">Reserveer</a>
                                                    <div class="margin-10px-top font-size14">16:00-16:30</div>
                                                    <div class="font-size13 text-light-gray">Reserveerbaar</div>
                                                </td>
                                            <?php } ?>
                                        <?php  } else {
                                            //NOG TE RESERVEREN
                                            ?>
                                            <td>
                                                <a href="../actions/baan-reserveren-admin.php?tijd=16:00&&datum=<?php echo ${"dag$dagLoop"}->format('Y-m-d'); ?>&&baan=<?php echo $baan ?>&&soort=<?php echo $soort; ?>" style="cursor:pointer; text-decoration: none" class="bg-green padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16  xs-font-size13">Reserveer</a>
                                                <div class="margin-10px-top font-size14">16:00-16:30</div>
                                                <div class="font-size13 text-light-gray">Reserveerbaar</div>
                                            </td>


                                        <?php } } ?>
                                </tr>
                                <tr>
                                    <td class="align-middle">16:30</td>
                                    <?php

                                    $dagLoop = 0;
                                    for ($i = 0; $i <= 6; $i++) {
                                        $dagLoop++;

                                        $reserveringenResult["reservering_per_uur"] = '';

                                        $newDate = ${"dag$dagLoop"}->format('Y-m-d');

                                        $reserveringenSql = $con->prepare("SELECT *, (SELECT reserveer_tijd FROM reservering
                                                                                 WHERE reserveer_tijd >= '15:59:00' AND reserveer_tijd <= '17:00:00' AND baan_id = :baanID 
                                                                                   AND reserveer_datum = :reserveerDatum LIMIT 1) AS reservering_per_uur FROM reservering
                                                                                  WHERE reserveer_datum = :reserveerDatum AND reserveer_tijd like '16%' AND baan_id = :baanID");
                                        $reserveringenSql->bindParam(":reserveerDatum", $newDate);
                                        $reserveringenSql->bindParam(":baanID", $baan);
                                        $reserveringenSql->execute();
                                        $reserveringenResult = $reserveringenSql->fetch();
                                        $reserveringenNum = $reserveringenSql->rowCount();

                                        if ($reserveringenNum > 0) {
                                            if ($reserveringenResult["lid_id"] == 0) {
                                                $doel = "voor " . $reserveringenResult["reserveer_doel"];
                                                $deleteLink = "<a href='../actions/verwijder-reserveren-admin.php?id=" . $reserveringenResult['reserveer_id'] . " ' style='cursor:pointer; text-decoration: none'' class='bg-warning padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16 xs-font-size13'>Gereserveerd</a>";
                                            } else {
                                                $doel = "door lid";
                                                $deleteLink = "<span class='bg-warning padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16 xs-font-size13'>Gereserveerd</span>";
                                            }
                                        }

//                                         var_dump($reserveringenResult["reservering_per_uur"]);

                                        if (isset($reserveringenResult["reserveer_datum"]) && isset($reserveringenResult["reserveer_tijd"])) {
                                            if ($reserveringenResult["reserveer_datum"] == $newDate && $reserveringenResult["reserveer_tijd"] == "16:30:00" && empty($reserveringenResult["reservering_per_uur"])) {
                                                //RESERVERING VAN HALF UUR
                                                ?>
                                                <td>
                                                    <?php echo $deleteLink; ?>
                                                    <div class="margin-10px-top font-size14">16:30-17:00</div>
                                                    <div class="font-size13 text-light-gray">Gereserveerd <?php echo $doel; ?></div>
                                                </td>
                                            <?php } elseif(!empty($reserveringenResult["reservering_per_uur"]) && $reserveringenResult["lid_id"] != 0) {
                                                //RESERVERING VAN UUR DOOR LID
                                                ?>
                                                <td>
                                                    <?php echo $deleteLink; ?>
                                                    <div class="margin-10px-top font-size14">16:30-17:00</div>
                                                    <div class="font-size13 text-light-gray">Gereserveerd <?php echo $doel; ?></div>
                                                </td>
                                            <?php  } else {  //NOG TE RESERVEREN ?>
                                                <td>
                                                    <a href="../actions/baan-reserveren-admin.php?tijd=16:30&&datum=<?php echo ${"dag$dagLoop"}->format('Y-m-d'); ?>&&baan=<?php echo $baan ?>&&soort=<?php echo $soort; ?>" style="cursor:pointer; text-decoration: none" class="bg-green padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16  xs-font-size13">Reserveer</a>
                                                    <div class="margin-10px-top font-size14">16:30-17:00</div>
                                                    <div class="font-size13 text-light-gray">Reserveerbaar</div>
                                                </td>
                                            <?php } ?>
                                        <?php  } else {
                                            //NOG TE RESERVEREN
                                            ?>
                                            <td>
                                                <a href="../actions/baan-reserveren-admin.php?tijd=16:30&&datum=<?php echo ${"dag$dagLoop"}->format('Y-m-d'); ?>&&baan=<?php echo $baan ?>&&soort=<?php echo $soort; ?>" style="cursor:pointer; text-decoration: none" class="bg-green padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16  xs-font-size13">Reserveer</a>
                                                <div class="margin-10px-top font-size14">16:30-17:00</div>
                                                <div class="font-size13 text-light-gray">Reserveerbaar</div>
                                            </td>


                                        <?php } } ?>
                                </tr>
                                <tr>
                                    <td class="align-middle">17:00</td>
                                    <?php

                                    $dagLoop = 0;
                                    for ($i = 0; $i <= 6; $i++) {
                                        $dagLoop++;

                                        $reserveringenResult["reservering_per_uur"] = '';

                                        $newDate = ${"dag$dagLoop"}->format('Y-m-d');

                                        $reserveringenSql = $con->prepare("SELECT *, (SELECT reserveer_tijd FROM reservering
                                                                                 WHERE reserveer_tijd >= '16:59:00' AND reserveer_tijd <= '18:00:00' AND baan_id = :baanID 
                                                                                   AND reserveer_datum = :reserveerDatum LIMIT 1) AS reservering_per_uur FROM reservering
                                                                                  WHERE reserveer_datum = :reserveerDatum AND reserveer_tijd like '17%' AND baan_id = :baanID");
                                        $reserveringenSql->bindParam(":reserveerDatum", $newDate);
                                        $reserveringenSql->bindParam(":baanID", $baan);
                                        $reserveringenSql->execute();
                                        $reserveringenResult = $reserveringenSql->fetch();
                                        $reserveringenNum = $reserveringenSql->rowCount();

                                        if ($reserveringenNum > 0) {
                                            if ($reserveringenResult["lid_id"] == 0) {
                                                $doel = "voor " . $reserveringenResult["reserveer_doel"];
                                                $deleteLink = "<a href='../actions/verwijder-reserveren-admin.php?id=" . $reserveringenResult['reserveer_id'] . " ' style='cursor:pointer; text-decoration: none'' class='bg-warning padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16 xs-font-size13'>Gereserveerd</a>";
                                            } else {
                                                $doel = "door lid";
                                                $deleteLink = "<span class='bg-warning padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16 xs-font-size13'>Gereserveerd</span>";
                                            }
                                        }

//                                         var_dump($reserveringenResult["reservering_per_uur"]);

                                        if (isset($reserveringenResult["reserveer_datum"]) && isset($reserveringenResult["reserveer_tijd"])) {
                                            if ($reserveringenResult["reserveer_datum"] == $newDate && $reserveringenResult["reserveer_tijd"] == "17:00:00" && empty($reserveringenResult["reservering_per_uur"])) {
                                                //RESERVERING VAN HALF UUR
                                                ?>
                                                <td>
                                                    <?php echo $deleteLink; ?>
                                                    <div class="margin-10px-top font-size14">17:00-17:30</div>
                                                    <div class="font-size13 text-light-gray">Gereserveerd <?php echo $doel; ?></div>
                                                </td>
                                            <?php } elseif(!empty($reserveringenResult["reservering_per_uur"])) {
                                                //RESERVERING VAN UUR DOOR LID
                                                ?>
                                                <td>
                                                    <?php echo $deleteLink; ?>
                                                    <div class="margin-10px-top font-size14">17:00-17:30</div>
                                                    <div class="font-size13 text-light-gray">Gereserveerd <?php echo $doel; ?></div>
                                                </td>
                                            <?php  } else {  //NOG TE RESERVEREN ?>
                                                <td>
                                                    <a href="../actions/baan-reserveren-admin.php?tijd=17:00&&datum=<?php echo ${"dag$dagLoop"}->format('Y-m-d'); ?>&&baan=<?php echo $baan ?>&&soort=<?php echo $soort; ?>" style="cursor:pointer; text-decoration: none" class="bg-green padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16  xs-font-size13">Reserveer</a>
                                                    <div class="margin-10px-top font-size14">17:00-17:30</div>
                                                    <div class="font-size13 text-light-gray">Reserveerbaar</div>
                                                </td>
                                            <?php } ?>
                                        <?php  } else {
                                            //NOG TE RESERVEREN
                                            ?>
                                            <td>
                                                <a href="../actions/baan-reserveren-admin.php?tijd=17:00&&datum=<?php echo ${"dag$dagLoop"}->format('Y-m-d'); ?>&&baan=<?php echo $baan ?>&&soort=<?php echo $soort; ?>" style="cursor:pointer; text-decoration: none" class="bg-green padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16  xs-font-size13">Reserveer</a>
                                                <div class="margin-10px-top font-size14">17:00-17:30</div>
                                                <div class="font-size13 text-light-gray">Reserveerbaar</div>
                                            </td>


                                        <?php } } ?>
                                </tr>
                                <tr>
                                    <td class="align-middle">17:30</td>
                                    <?php

                                    $dagLoop = 0;
                                    for ($i = 0; $i <= 6; $i++) {
                                        $dagLoop++;

                                        $reserveringenResult["reservering_per_uur"] = '';

                                        $newDate = ${"dag$dagLoop"}->format('Y-m-d');

                                        $reserveringenSql = $con->prepare("SELECT *, (SELECT reserveer_tijd FROM reservering
                                                                                 WHERE reserveer_tijd >= '16:59:00' AND reserveer_tijd <= '18:00:00' AND baan_id = :baanID 
                                                                                   AND reserveer_datum = :reserveerDatum LIMIT 1) AS reservering_per_uur FROM reservering
                                                                                  WHERE reserveer_datum = :reserveerDatum AND reserveer_tijd like '17%' AND baan_id = :baanID");
                                        $reserveringenSql->bindParam(":reserveerDatum", $newDate);
                                        $reserveringenSql->bindParam(":baanID", $baan);
                                        $reserveringenSql->execute();
                                        $reserveringenResult = $reserveringenSql->fetch();
                                        $reserveringenNum = $reserveringenSql->rowCount();

                                        if ($reserveringenNum > 0) {
                                            if ($reserveringenResult["lid_id"] == 0) {
                                                $doel = "voor " . $reserveringenResult["reserveer_doel"];
                                                $deleteLink = "<a href='../actions/verwijder-reserveren-admin.php?id=" . $reserveringenResult['reserveer_id'] . " ' style='cursor:pointer; text-decoration: none'' class='bg-warning padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16 xs-font-size13'>Gereserveerd</a>";
                                            } else {
                                                $doel = "door lid";
                                                $deleteLink = "<span class='bg-warning padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16 xs-font-size13'>Gereserveerd</span>";
                                            }
                                        }

//                                         var_dump($reserveringenResult["reservering_per_uur"]);

                                        if (isset($reserveringenResult["reserveer_datum"]) && isset($reserveringenResult["reserveer_tijd"])) {
                                            if ($reserveringenResult["reserveer_datum"] == $newDate && $reserveringenResult["reserveer_tijd"] == "17:30:00" && empty($reserveringenResult["reservering_per_uur"])) {
                                                //RESERVERING VAN HALF UUR
                                                ?>
                                                <td>
                                                    <?php echo $deleteLink; ?>
                                                    <div class="margin-10px-top font-size14">17:30-18:00</div>
                                                    <div class="font-size13 text-light-gray">Gereserveerd <?php echo $doel; ?></div>
                                                </td>
                                            <?php } elseif(!empty($reserveringenResult["reservering_per_uur"]) && $reserveringenResult["lid_id"] != 0) {
                                                //RESERVERING VAN UUR DOOR LID
                                                ?>
                                                <td>
                                                    <?php echo $deleteLink; ?>
                                                    <div class="margin-10px-top font-size14">17:30-18:00</div>
                                                    <div class="font-size13 text-light-gray">Gereserveerd <?php echo $doel; ?></div>
                                                </td>
                                            <?php  } else {  //NOG TE RESERVEREN ?>
                                                <td>
                                                    <a href="../actions/baan-reserveren-admin.php?tijd=17:30&&datum=<?php echo ${"dag$dagLoop"}->format('Y-m-d'); ?>&&baan=<?php echo $baan ?>&&soort=<?php echo $soort; ?>" style="cursor:pointer; text-decoration: none" class="bg-green padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16  xs-font-size13">Reserveer</a>
                                                    <div class="margin-10px-top font-size14">17:30-18:00</div>
                                                    <div class="font-size13 text-light-gray">Reserveerbaar</div>
                                                </td>
                                            <?php } ?>
                                        <?php  } else {
                                            //NOG TE RESERVEREN
                                            ?>
                                            <td>
                                                <a href="../actions/baan-reserveren-admin.php?tijd=17:30&&datum=<?php echo ${"dag$dagLoop"}->format('Y-m-d'); ?>&&baan=<?php echo $baan ?>&&soort=<?php echo $soort; ?>" style="cursor:pointer; text-decoration: none" class="bg-green padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16  xs-font-size13">Reserveer</a>
                                                <div class="margin-10px-top font-size14">17:30-18:00</div>
                                                <div class="font-size13 text-light-gray">Reserveerbaar</div>
                                            </td>


                                        <?php } } ?>
                                </tr>
                                <tr>
                                    <td class="align-middle">18:00</td>
                                    <?php

                                    $dagLoop = 0;
                                    for ($i = 0; $i <= 6; $i++) {
                                        $dagLoop++;

                                        $reserveringenResult["reservering_per_uur"] = '';

                                        $newDate = ${"dag$dagLoop"}->format('Y-m-d');

                                        $reserveringenSql = $con->prepare("SELECT *, (SELECT reserveer_tijd FROM reservering
                                                                                 WHERE reserveer_tijd >= '17:59:00' AND reserveer_tijd <= '19:00:00' AND baan_id = :baanID 
                                                                                   AND reserveer_datum = :reserveerDatum LIMIT 1) AS reservering_per_uur FROM reservering
                                                                                  WHERE reserveer_datum = :reserveerDatum AND reserveer_tijd like '18%' AND baan_id = :baanID");
                                        $reserveringenSql->bindParam(":reserveerDatum", $newDate);
                                        $reserveringenSql->bindParam(":baanID", $baan);
                                        $reserveringenSql->execute();
                                        $reserveringenResult = $reserveringenSql->fetch();
                                        $reserveringenNum = $reserveringenSql->rowCount();

                                        if ($reserveringenNum > 0) {
                                            if ($reserveringenResult["lid_id"] == 0) {
                                                $doel = "voor " . $reserveringenResult["reserveer_doel"];
                                                $deleteLink = "<a href='../actions/verwijder-reserveren-admin.php?id=" . $reserveringenResult['reserveer_id'] . " ' style='cursor:pointer; text-decoration: none'' class='bg-warning padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16 xs-font-size13'>Gereserveerd</a>";
                                            } else {
                                                $doel = "door lid";
                                                $deleteLink = "<span class='bg-warning padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16 xs-font-size13'>Gereserveerd</span>";
                                            }
                                        }

//                                         var_dump($reserveringenResult["reservering_per_uur"]);

                                        if (isset($reserveringenResult["reserveer_datum"]) && isset($reserveringenResult["reserveer_tijd"])) {
                                            if ($reserveringenResult["reserveer_datum"] == $newDate && $reserveringenResult["reserveer_tijd"] == "18:00:00" && empty($reserveringenResult["reservering_per_uur"])) {
                                                //RESERVERING VAN HALF UUR
                                                ?>
                                                <td>
                                                    <?php echo $deleteLink; ?>
                                                    <div class="margin-10px-top font-size14">18:00-18:30</div>
                                                    <div class="font-size13 text-light-gray">Gereserveerd <?php echo $doel; ?></div>
                                                </td>
                                            <?php } elseif(!empty($reserveringenResult["reservering_per_uur"])) {
                                                //RESERVERING VAN UUR DOOR LID
                                                ?>
                                                <td>
                                                    <?php echo $deleteLink; ?>
                                                    <div class="margin-10px-top font-size14">18:00-18:30</div>
                                                    <div class="font-size13 text-light-gray">Gereserveerd <?php echo $doel; ?></div>
                                                </td>
                                            <?php  } else {  //NOG TE RESERVEREN ?>
                                                <td>
                                                    <a href="../actions/baan-reserveren-admin.php?tijd=18:00&&datum=<?php echo ${"dag$dagLoop"}->format('Y-m-d'); ?>&&baan=<?php echo $baan ?>&&soort=<?php echo $soort; ?>" style="cursor:pointer; text-decoration: none" class="bg-green padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16  xs-font-size13">Reserveer</a>
                                                    <div class="margin-10px-top font-size14">18:00-18:30</div>
                                                    <div class="font-size13 text-light-gray">Reserveerbaar</div>
                                                </td>
                                            <?php } ?>
                                        <?php  } else {
                                            //NOG TE RESERVEREN
                                            ?>
                                            <td>
                                                <a href="../actions/baan-reserveren-admin.php?tijd=18:00&&datum=<?php echo ${"dag$dagLoop"}->format('Y-m-d'); ?>&&baan=<?php echo $baan ?>&&soort=<?php echo $soort; ?>" style="cursor:pointer; text-decoration: none" class="bg-green padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16  xs-font-size13">Reserveer</a>
                                                <div class="margin-10px-top font-size14">18:00-18:30</div>
                                                <div class="font-size13 text-light-gray">Reserveerbaar</div>
                                            </td>


                                        <?php } } ?>
                                </tr>
                                <tr>
                                    <td class="align-middle">18:30</td>
                                    <?php

                                    $dagLoop = 0;
                                    for ($i = 0; $i <= 6; $i++) {
                                        $dagLoop++;

                                        $reserveringenResult["reservering_per_uur"] = '';

                                        $newDate = ${"dag$dagLoop"}->format('Y-m-d');

                                        $reserveringenSql = $con->prepare("SELECT *, (SELECT reserveer_tijd FROM reservering
                                                                                 WHERE reserveer_tijd >= '17:59:00' AND reserveer_tijd <= '19:00:00' AND baan_id = :baanID 
                                                                                   AND reserveer_datum = :reserveerDatum LIMIT 1) AS reservering_per_uur FROM reservering
                                                                                  WHERE reserveer_datum = :reserveerDatum AND reserveer_tijd like '18%' AND baan_id = :baanID");
                                        $reserveringenSql->bindParam(":reserveerDatum", $newDate);
                                        $reserveringenSql->bindParam(":baanID", $baan);
                                        $reserveringenSql->execute();
                                        $reserveringenResult = $reserveringenSql->fetch();
                                        $reserveringenNum = $reserveringenSql->rowCount();

                                        if ($reserveringenNum > 0) {
                                            if ($reserveringenResult["lid_id"] == 0) {
                                                $doel = "voor " . $reserveringenResult["reserveer_doel"];
                                                $deleteLink = "<a href='../actions/verwijder-reserveren-admin.php?id=" . $reserveringenResult['reserveer_id'] . " ' style='cursor:pointer; text-decoration: none'' class='bg-warning padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16 xs-font-size13'>Gereserveerd</a>";
                                            } else {
                                                $doel = "door lid";
                                                $deleteLink = "<span class='bg-warning padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16 xs-font-size13'>Gereserveerd</span>";
                                            }
                                        }

//                                         var_dump($reserveringenResult["reservering_per_uur"]);

                                        if (isset($reserveringenResult["reserveer_datum"]) && isset($reserveringenResult["reserveer_tijd"])) {
                                            if ($reserveringenResult["reserveer_datum"] == $newDate && $reserveringenResult["reserveer_tijd"] == "18:30:00" && empty($reserveringenResult["reservering_per_uur"])) {
                                                //RESERVERING VAN HALF UUR
                                                ?>
                                                <td>
                                                    <?php echo $deleteLink; ?>
                                                    <div class="margin-10px-top font-size14">18:30-19:00</div>
                                                    <div class="font-size13 text-light-gray">Gereserveerd <?php echo $doel; ?></div>
                                                </td>
                                            <?php } elseif(!empty($reserveringenResult["reservering_per_uur"]) && $reserveringenResult["lid_id"] != 0) {
                                                //RESERVERING VAN UUR DOOR LID
                                                ?>
                                                <td>
                                                    <?php echo $deleteLink; ?>
                                                    <div class="margin-10px-top font-size14">18:30-19:00</div>
                                                    <div class="font-size13 text-light-gray">Gereserveerd <?php echo $doel; ?></div>
                                                </td>
                                            <?php  } else {  //NOG TE RESERVEREN ?>
                                                <td>
                                                    <a href="../actions/baan-reserveren-admin.php?tijd=18:30&&datum=<?php echo ${"dag$dagLoop"}->format('Y-m-d'); ?>&&baan=<?php echo $baan ?>&&soort=<?php echo $soort; ?>" style="cursor:pointer; text-decoration: none" class="bg-green padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16  xs-font-size13">Reserveer</a>
                                                    <div class="margin-10px-top font-size14">18:30-19:00</div>
                                                    <div class="font-size13 text-light-gray">Reserveerbaar</div>
                                                </td>
                                            <?php } ?>
                                        <?php  } else {
                                            //NOG TE RESERVEREN
                                            ?>
                                            <td>
                                                <a href="../actions/baan-reserveren-admin.php?tijd=18:30&&datum=<?php echo ${"dag$dagLoop"}->format('Y-m-d'); ?>&&baan=<?php echo $baan ?>&&soort=<?php echo $soort; ?>" style="cursor:pointer; text-decoration: none" class="bg-green padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16  xs-font-size13">Reserveer</a>
                                                <div class="margin-10px-top font-size14">18:30-19:00</div>
                                                <div class="font-size13 text-light-gray">Reserveerbaar</div>
                                            </td>


                                        <?php } } ?>
                                </tr>
                                <tr>
                                    <td class="align-middle">19:00</td>
                                    <?php

                                    $dagLoop = 0;
                                    for ($i = 0; $i <= 6; $i++) {
                                        $dagLoop++;

                                        $reserveringenResult["reservering_per_uur"] = '';

                                        $newDate = ${"dag$dagLoop"}->format('Y-m-d');

                                        $reserveringenSql = $con->prepare("SELECT *, (SELECT reserveer_tijd FROM reservering
                                                                                 WHERE reserveer_tijd >= '18:59:00' AND reserveer_tijd <= '20:00:00' AND baan_id = :baanID 
                                                                                   AND reserveer_datum = :reserveerDatum LIMIT 1) AS reservering_per_uur FROM reservering
                                                                                  WHERE reserveer_datum = :reserveerDatum AND reserveer_tijd like '19%' AND baan_id = :baanID");
                                        $reserveringenSql->bindParam(":reserveerDatum", $newDate);
                                        $reserveringenSql->bindParam(":baanID", $baan);
                                        $reserveringenSql->execute();
                                        $reserveringenResult = $reserveringenSql->fetch();
                                        $reserveringenNum = $reserveringenSql->rowCount();

                                        if ($reserveringenNum > 0) {
                                            if ($reserveringenResult["lid_id"] == 0) {
                                                $doel = "voor " . $reserveringenResult["reserveer_doel"];
                                                $deleteLink = "<a href='../actions/verwijder-reserveren-admin.php?id=" . $reserveringenResult['reserveer_id'] . " ' style='cursor:pointer; text-decoration: none'' class='bg-warning padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16 xs-font-size13'>Gereserveerd</a>";
                                            } else {
                                                $doel = "door lid";
                                                $deleteLink = "<span class='bg-warning padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16 xs-font-size13'>Gereserveerd</span>";
                                            }
                                        }

//                                         var_dump($reserveringenResult["reservering_per_uur"]);

                                        if (isset($reserveringenResult["reserveer_datum"]) && isset($reserveringenResult["reserveer_tijd"])) {
                                            if ($reserveringenResult["reserveer_datum"] == $newDate && $reserveringenResult["reserveer_tijd"] == "19:00:00" && empty($reserveringenResult["reservering_per_uur"])) {
                                                //RESERVERING VAN HALF UUR
                                                ?>
                                                <td>
                                                    <?php echo $deleteLink; ?>
                                                    <div class="margin-10px-top font-size14">19:00-19:30</div>
                                                    <div class="font-size13 text-light-gray">Gereserveerd <?php echo $doel; ?></div>
                                                </td>
                                            <?php } elseif(!empty($reserveringenResult["reservering_per_uur"])) {
                                                //RESERVERING VAN UUR DOOR LID
                                                ?>
                                                <td>
                                                    <?php echo $deleteLink; ?>
                                                    <div class="margin-10px-top font-size14">19:00-19:30</div>
                                                    <div class="font-size13 text-light-gray">Gereserveerd <?php echo $doel; ?></div>
                                                </td>
                                            <?php  } else {  //NOG TE RESERVEREN ?>
                                                <td>
                                                    <a href="../actions/baan-reserveren-admin.php?tijd=19:00&&datum=<?php echo ${"dag$dagLoop"}->format('Y-m-d'); ?>&&baan=<?php echo $baan ?>&&soort=<?php echo $soort; ?>" style="cursor:pointer; text-decoration: none" class="bg-green padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16  xs-font-size13">Reserveer</a>
                                                    <div class="margin-10px-top font-size14">19:00-19:30</div>
                                                    <div class="font-size13 text-light-gray">Reserveerbaar</div>
                                                </td>
                                            <?php } ?>
                                        <?php  } else {
                                            //NOG TE RESERVEREN
                                            ?>
                                            <td>
                                                <a href="../actions/baan-reserveren-admin.php?tijd=19:00&&datum=<?php echo ${"dag$dagLoop"}->format('Y-m-d'); ?>&&baan=<?php echo $baan ?>&&soort=<?php echo $soort; ?>" style="cursor:pointer; text-decoration: none" class="bg-green padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16  xs-font-size13">Reserveer</a>
                                                <div class="margin-10px-top font-size14">19:00-19:30</div>
                                                <div class="font-size13 text-light-gray">Reserveerbaar</div>
                                            </td>


                                        <?php } } ?>
                                </tr>
                                <tr>
                                    <td class="align-middle">19:30</td>
                                    <?php

                                    $dagLoop = 0;
                                    for ($i = 0; $i <= 6; $i++) {
                                        $dagLoop++;

                                        $reserveringenResult["reservering_per_uur"] = '';

                                        $newDate = ${"dag$dagLoop"}->format('Y-m-d');

                                        $reserveringenSql = $con->prepare("SELECT *, (SELECT reserveer_tijd FROM reservering
                                                                                 WHERE reserveer_tijd >= '18:59:00' AND reserveer_tijd <= '20:00:00' AND baan_id = :baanID 
                                                                                   AND reserveer_datum = :reserveerDatum LIMIT 1) AS reservering_per_uur FROM reservering
                                                                                  WHERE reserveer_datum = :reserveerDatum AND reserveer_tijd like '19%' AND baan_id = :baanID");
                                        $reserveringenSql->bindParam(":reserveerDatum", $newDate);
                                        $reserveringenSql->bindParam(":baanID", $baan);
                                        $reserveringenSql->execute();
                                        $reserveringenResult = $reserveringenSql->fetch();
                                        $reserveringenNum = $reserveringenSql->rowCount();

                                        if ($reserveringenNum > 0) {
                                            if ($reserveringenResult["lid_id"] == 0) {
                                                $doel = "voor " . $reserveringenResult["reserveer_doel"];
                                                $deleteLink = "<a href='../actions/verwijder-reserveren-admin.php?id=" . $reserveringenResult['reserveer_id'] . " ' style='cursor:pointer; text-decoration: none'' class='bg-warning padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16 xs-font-size13'>Gereserveerd</a>";
                                            } else {
                                                $doel = "door lid";
                                                $deleteLink = "<span class='bg-warning padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16 xs-font-size13'>Gereserveerd</span>";
                                            }
                                        }

//                                         var_dump($reserveringenResult["reservering_per_uur"]);

                                        if (isset($reserveringenResult["reserveer_datum"]) && isset($reserveringenResult["reserveer_tijd"])) {
                                            if ($reserveringenResult["reserveer_datum"] == $newDate && $reserveringenResult["reserveer_tijd"] == "19:30:00" && empty($reserveringenResult["reservering_per_uur"])) {
                                                //RESERVERING VAN HALF UUR
                                                ?>
                                                <td>
                                                    <?php echo $deleteLink; ?>
                                                    <div class="margin-10px-top font-size14">19:30-20:00</div>
                                                    <div class="font-size13 text-light-gray">Gereserveerd <?php echo $doel; ?></div>
                                                </td>
                                            <?php } elseif(!empty($reserveringenResult["reservering_per_uur"]) && $reserveringenResult["lid_id"] != 0) {
                                                //RESERVERING VAN UUR DOOR LID
                                                ?>
                                                <td>
                                                    <?php echo $deleteLink; ?>
                                                    <div class="margin-10px-top font-size14">19:30-20:00</div>
                                                    <div class="font-size13 text-light-gray">Gereserveerd <?php echo $doel; ?></div>
                                                </td>
                                            <?php  } else {  //NOG TE RESERVEREN ?>
                                                <td>
                                                    <a href="../actions/baan-reserveren-admin.php?tijd=19:30&&datum=<?php echo ${"dag$dagLoop"}->format('Y-m-d'); ?>&&baan=<?php echo $baan ?>&&soort=<?php echo $soort; ?>" style="cursor:pointer; text-decoration: none" class="bg-green padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16  xs-font-size13">Reserveer</a>
                                                    <div class="margin-10px-top font-size14">19:30-20:00</div>
                                                    <div class="font-size13 text-light-gray">Reserveerbaar</div>
                                                </td>
                                            <?php } ?>
                                        <?php  } else {
                                            //NOG TE RESERVEREN
                                            ?>
                                            <td>
                                                <a href="../actions/baan-reserveren-admin.php?tijd=19:30&&datum=<?php echo ${"dag$dagLoop"}->format('Y-m-d'); ?>&&baan=<?php echo $baan ?>&&soort=<?php echo $soort; ?>" style="cursor:pointer; text-decoration: none" class="bg-green padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16  xs-font-size13">Reserveer</a>
                                                <div class="margin-10px-top font-size14">19:30-20:00</div>
                                                <div class="font-size13 text-light-gray">Reserveerbaar</div>
                                            </td>


                                        <?php } } ?>
                                </tr>
                                <tr>
                                    <td class="align-middle">20:00</td>
                                    <?php

                                    $dagLoop = 0;
                                    for ($i = 0; $i <= 6; $i++) {
                                        $dagLoop++;

                                        $reserveringenResult["reservering_per_uur"] = '';

                                        $newDate = ${"dag$dagLoop"}->format('Y-m-d');

                                        $reserveringenSql = $con->prepare("SELECT *, (SELECT reserveer_tijd FROM reservering
                                                                                 WHERE reserveer_tijd >= '19:59:00' AND reserveer_tijd <= '21:00:00' AND baan_id = :baanID 
                                                                                   AND reserveer_datum = :reserveerDatum LIMIT 1) AS reservering_per_uur FROM reservering
                                                                                  WHERE reserveer_datum = :reserveerDatum AND reserveer_tijd like '20%' AND baan_id = :baanID");
                                        $reserveringenSql->bindParam(":reserveerDatum", $newDate);
                                        $reserveringenSql->bindParam(":baanID", $baan);
                                        $reserveringenSql->execute();
                                        $reserveringenResult = $reserveringenSql->fetch();
                                        $reserveringenNum = $reserveringenSql->rowCount();

                                        if ($reserveringenNum > 0) {
                                            if ($reserveringenResult["lid_id"] == 0) {
                                                $doel = "voor " . $reserveringenResult["reserveer_doel"];
                                                $deleteLink = "<a href='../actions/verwijder-reserveren-admin.php?id=" . $reserveringenResult['reserveer_id'] . " ' style='cursor:pointer; text-decoration: none'' class='bg-warning padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16 xs-font-size13'>Gereserveerd</a>";
                                            } else {
                                                $doel = "door lid";
                                                $deleteLink = "<span class='bg-warning padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16 xs-font-size13'>Gereserveerd</span>";
                                            }
                                        }

//                                         var_dump($reserveringenResult["reservering_per_uur"]);

                                        if (isset($reserveringenResult["reserveer_datum"]) && isset($reserveringenResult["reserveer_tijd"])) {
                                            if ($reserveringenResult["reserveer_datum"] == $newDate && $reserveringenResult["reserveer_tijd"] == "20:00:00" && empty($reserveringenResult["reservering_per_uur"])) {
                                                //RESERVERING VAN HALF UUR
                                                ?>
                                                <td>
                                                    <?php echo $deleteLink; ?>
                                                    <div class="margin-10px-top font-size14">20:00-20:30</div>
                                                    <div class="font-size13 text-light-gray">Gereserveerd <?php echo $doel; ?></div>
                                                </td>
                                            <?php } elseif(!empty($reserveringenResult["reservering_per_uur"])) {
                                                //RESERVERING VAN UUR DOOR LID
                                                ?>
                                                <td>
                                                    <?php echo $deleteLink; ?>
                                                    <div class="margin-10px-top font-size14">20:00-20:30</div>
                                                    <div class="font-size13 text-light-gray">Gereserveerd <?php echo $doel; ?></div>
                                                </td>
                                            <?php  } else {  //NOG TE RESERVEREN ?>
                                                <td>
                                                    <a href="../actions/baan-reserveren-admin.php?tijd=20:00&&datum=<?php echo ${"dag$dagLoop"}->format('Y-m-d'); ?>&&baan=<?php echo $baan ?>&&soort=<?php echo $soort; ?>" style="cursor:pointer; text-decoration: none" class="bg-green padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16  xs-font-size13">Reserveer</a>
                                                    <div class="margin-10px-top font-size14">20:00-20:30</div>
                                                    <div class="font-size13 text-light-gray">Reserveerbaar</div>
                                                </td>
                                            <?php } ?>
                                        <?php  } else {
                                            //NOG TE RESERVEREN
                                            ?>
                                            <td>
                                                <a href="../actions/baan-reserveren-admin.php?tijd=20:00&&datum=<?php echo ${"dag$dagLoop"}->format('Y-m-d'); ?>&&baan=<?php echo $baan ?>&&soort=<?php echo $soort; ?>" style="cursor:pointer; text-decoration: none" class="bg-green padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16  xs-font-size13">Reserveer</a>
                                                <div class="margin-10px-top font-size14">20:00-20:30</div>
                                                <div class="font-size13 text-light-gray">Reserveerbaar</div>
                                            </td>


                                        <?php } } ?>
                                </tr>
                                <tr>
                                    <td class="align-middle">20:30</td>
                                    <?php

                                    $dagLoop = 0;
                                    for ($i = 0; $i <= 6; $i++) {
                                        $dagLoop++;

                                        $reserveringenResult["reservering_per_uur"] = '';

                                        $newDate = ${"dag$dagLoop"}->format('Y-m-d');

                                        $reserveringenSql = $con->prepare("SELECT *, (SELECT reserveer_tijd FROM reservering
                                                                                 WHERE reserveer_tijd >= '19:59:00' AND reserveer_tijd <= '21:00:00' AND baan_id = :baanID 
                                                                                   AND reserveer_datum = :reserveerDatum LIMIT 1) AS reservering_per_uur FROM reservering
                                                                                  WHERE reserveer_datum = :reserveerDatum AND reserveer_tijd like '20%' AND baan_id = :baanID");
                                        $reserveringenSql->bindParam(":reserveerDatum", $newDate);
                                        $reserveringenSql->bindParam(":baanID", $baan);
                                        $reserveringenSql->execute();
                                        $reserveringenResult = $reserveringenSql->fetch();
                                        $reserveringenNum = $reserveringenSql->rowCount();

                                        if ($reserveringenNum > 0) {
                                            if ($reserveringenResult["lid_id"] == 0) {
                                                $doel = "voor " . $reserveringenResult["reserveer_doel"];
                                                $deleteLink = "<a href='../actions/verwijder-reserveren-admin.php?id=" . $reserveringenResult['reserveer_id'] . " ' style='cursor:pointer; text-decoration: none'' class='bg-warning padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16 xs-font-size13'>Gereserveerd</a>";
                                            } else {
                                                $doel = "door lid";
                                                $deleteLink = "<span class='bg-warning padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16 xs-font-size13'>Gereserveerd</span>";
                                            }
                                        }

//                                         var_dump($reserveringenResult["reservering_per_uur"]);

                                        if (isset($reserveringenResult["reserveer_datum"]) && isset($reserveringenResult["reserveer_tijd"])) {
                                            if ($reserveringenResult["reserveer_datum"] == $newDate && $reserveringenResult["reserveer_tijd"] == "20:30:00" && empty($reserveringenResult["reservering_per_uur"])) {
                                                //RESERVERING VAN HALF UUR
                                                ?>
                                                <td>
                                                    <?php echo $deleteLink; ?>
                                                    <div class="margin-10px-top font-size14">20:30-21:00</div>
                                                    <div class="font-size13 text-light-gray">Gereserveerd <?php echo $doel; ?></div>
                                                </td>
                                            <?php } elseif(!empty($reserveringenResult["reservering_per_uur"]) && $reserveringenResult["lid_id"] != 0) {
                                                //RESERVERING VAN UUR DOOR LID
                                                ?>
                                                <td>
                                                    <?php echo $deleteLink; ?>
                                                    <div class="margin-10px-top font-size14">20:30-21:00</div>
                                                    <div class="font-size13 text-light-gray">Gereserveerd <?php echo $doel; ?></div>
                                                </td>
                                            <?php  } else {  //NOG TE RESERVEREN ?>
                                                <td>
                                                    <a href="../actions/baan-reserveren-admin.php?tijd=20:30&&datum=<?php echo ${"dag$dagLoop"}->format('Y-m-d'); ?>&&baan=<?php echo $baan ?>&&soort=<?php echo $soort; ?>" style="cursor:pointer; text-decoration: none" class="bg-green padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16  xs-font-size13">Reserveer</a>
                                                    <div class="margin-10px-top font-size14">20:30-21:00</div>
                                                    <div class="font-size13 text-light-gray">Reserveerbaar</div>
                                                </td>
                                            <?php } ?>
                                        <?php  } else {
                                            //NOG TE RESERVEREN
                                            ?>
                                            <td>
                                                <a href="../actions/baan-reserveren-admin.php?tijd=20:30&&datum=<?php echo ${"dag$dagLoop"}->format('Y-m-d'); ?>&&baan=<?php echo $baan ?>&&soort=<?php echo $soort; ?>" style="cursor:pointer; text-decoration: none" class="bg-green padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16  xs-font-size13">Reserveer</a>
                                                <div class="margin-10px-top font-size14">22:00-22:30</div>
                                                <div class="font-size13 text-light-gray">Reserveerbaar</div>
                                            </td>


                                        <?php } } ?>
                                </tr>
                                <tr>
                                    <td class="align-middle">21:00</td>
                                    <?php

                                    $dagLoop = 0;
                                    for ($i = 0; $i <= 6; $i++) {
                                        $dagLoop++;

                                        $reserveringenResult["reservering_per_uur"] = '';

                                        $newDate = ${"dag$dagLoop"}->format('Y-m-d');

                                        $reserveringenSql = $con->prepare("SELECT *, (SELECT reserveer_tijd FROM reservering
                                                                                 WHERE reserveer_tijd >= '20:59:00' AND reserveer_tijd <= '22:00:00' AND baan_id = :baanID 
                                                                                   AND reserveer_datum = :reserveerDatum LIMIT 1) AS reservering_per_uur FROM reservering
                                                                                  WHERE reserveer_datum = :reserveerDatum AND reserveer_tijd like '21%' AND baan_id = :baanID");
                                        $reserveringenSql->bindParam(":reserveerDatum", $newDate);
                                        $reserveringenSql->bindParam(":baanID", $baan);
                                        $reserveringenSql->execute();
                                        $reserveringenResult = $reserveringenSql->fetch();
                                        $reserveringenNum = $reserveringenSql->rowCount();

                                        if ($reserveringenNum > 0) {
                                            if ($reserveringenResult["lid_id"] == 0) {
                                                $doel = "voor " . $reserveringenResult["reserveer_doel"];
                                                $deleteLink = "<a href='../actions/verwijder-reserveren-admin.php?id=" . $reserveringenResult['reserveer_id'] . " ' style='cursor:pointer; text-decoration: none'' class='bg-warning padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16 xs-font-size13'>Gereserveerd</a>";
                                            } else {
                                                $doel = "door lid";
                                                $deleteLink = "<span class='bg-warning padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16 xs-font-size13'>Gereserveerd</span>";
                                            }
                                        }

//                                         var_dump($reserveringenResult["reservering_per_uur"]);

                                        if (isset($reserveringenResult["reserveer_datum"]) && isset($reserveringenResult["reserveer_tijd"])) {
                                            if ($reserveringenResult["reserveer_datum"] == $newDate && $reserveringenResult["reserveer_tijd"] == "21:00:00" && empty($reserveringenResult["reservering_per_uur"])) {
                                                //RESERVERING VAN HALF UUR
                                                ?>
                                                <td>
                                                    <?php echo $deleteLink; ?>
                                                    <div class="margin-10px-top font-size14">21:00-21:30</div>
                                                    <div class="font-size13 text-light-gray">Gereserveerd <?php echo $doel; ?></div>
                                                </td>
                                            <?php } elseif(!empty($reserveringenResult["reservering_per_uur"])) {
                                                //RESERVERING VAN UUR DOOR LID
                                                ?>
                                                <td>
                                                    <?php echo $deleteLink; ?>
                                                    <div class="margin-10px-top font-size14">21:00-21:30</div>
                                                    <div class="font-size13 text-light-gray">Gereserveerd <?php echo $doel; ?></div>
                                                </td>
                                            <?php  } else {  //NOG TE RESERVEREN ?>
                                                <td>
                                                    <a href="../actions/baan-reserveren-admin.php?tijd=21:00&&datum=<?php echo ${"dag$dagLoop"}->format('Y-m-d'); ?>&&baan=<?php echo $baan ?>&&soort=<?php echo $soort; ?>" style="cursor:pointer; text-decoration: none" class="bg-green padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16  xs-font-size13">Reserveer</a>
                                                    <div class="margin-10px-top font-size14">21:00-21:30</div>
                                                    <div class="font-size13 text-light-gray">Reserveerbaar</div>
                                                </td>
                                            <?php } ?>
                                        <?php  } else {
                                            //NOG TE RESERVEREN
                                            ?>
                                            <td>
                                                <a href="../actions/baan-reserveren-admin.php?tijd=21:00&&datum=<?php echo ${"dag$dagLoop"}->format('Y-m-d'); ?>&&baan=<?php echo $baan ?>&&soort=<?php echo $soort; ?>" style="cursor:pointer; text-decoration: none" class="bg-green padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16  xs-font-size13">Reserveer</a>
                                                <div class="margin-10px-top font-size14">21:00-21:30</div>
                                                <div class="font-size13 text-light-gray">Reserveerbaar</div>
                                            </td>


                                        <?php } } ?>
                                </tr>
                                <tr>
                                    <td class="align-middle">21:30</td>
                                    <?php

                                    $dagLoop = 0;
                                    for ($i = 0; $i <= 6; $i++) {
                                        $dagLoop++;

                                        $reserveringenResult["reservering_per_uur"] = '';

                                        $newDate = ${"dag$dagLoop"}->format('Y-m-d');

                                        $reserveringenSql = $con->prepare("SELECT *, (SELECT reserveer_tijd FROM reservering
                                                                                 WHERE reserveer_tijd >= '20:59:00' AND reserveer_tijd <= '22:00:00' AND baan_id = :baanID 
                                                                                   AND reserveer_datum = :reserveerDatum LIMIT 1) AS reservering_per_uur FROM reservering
                                                                                  WHERE reserveer_datum = :reserveerDatum AND reserveer_tijd like '21%' AND baan_id = :baanID");
                                        $reserveringenSql->bindParam(":reserveerDatum", $newDate);
                                        $reserveringenSql->bindParam(":baanID", $baan);
                                        $reserveringenSql->execute();
                                        $reserveringenResult = $reserveringenSql->fetch();
                                        $reserveringenNum = $reserveringenSql->rowCount();

                                        if ($reserveringenNum > 0) {
                                            if ($reserveringenResult["lid_id"] == 0) {
                                                $doel = "voor " . $reserveringenResult["reserveer_doel"];
                                                $deleteLink = "<a href='../actions/verwijder-reserveren-admin.php?id=" . $reserveringenResult['reserveer_id'] . " ' style='cursor:pointer; text-decoration: none'' class='bg-warning padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16 xs-font-size13'>Gereserveerd</a>";
                                            } else {
                                                $doel = "door lid";
                                                $deleteLink = "<span class='bg-warning padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16 xs-font-size13'>Gereserveerd</span>";
                                            }
                                        }

//                                         var_dump($reserveringenResult["reservering_per_uur"]);

                                        if (isset($reserveringenResult["reserveer_datum"]) && isset($reserveringenResult["reserveer_tijd"])) {
                                            if ($reserveringenResult["reserveer_datum"] == $newDate && $reserveringenResult["reserveer_tijd"] == "21:30:00" && empty($reserveringenResult["reservering_per_uur"])) {
                                                //RESERVERING VAN HALF UUR
                                                ?>
                                                <td>
                                                    <?php echo $deleteLink; ?>
                                                    <div class="margin-10px-top font-size14">21:30-22:00</div>
                                                    <div class="font-size13 text-light-gray">Gereserveerd <?php echo $doel; ?></div>
                                                </td>
                                            <?php } elseif(!empty($reserveringenResult["reservering_per_uur"]) && $reserveringenResult["lid_id"] != 0) {
                                                //RESERVERING VAN UUR DOOR LID
                                                ?>
                                                <td>
                                                    <?php echo $deleteLink; ?>
                                                    <div class="margin-10px-top font-size14">21:30-22:00</div>
                                                    <div class="font-size13 text-light-gray">Gereserveerd <?php echo $doel; ?></div>
                                                </td>
                                            <?php  } else {  //NOG TE RESERVEREN ?>
                                                <td>
                                                    <a href="../actions/baan-reserveren-admin.php?tijd=21:30&&datum=<?php echo ${"dag$dagLoop"}->format('Y-m-d'); ?>&&baan=<?php echo $baan ?>&&soort=<?php echo $soort; ?>" style="cursor:pointer; text-decoration: none" class="bg-green padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16  xs-font-size13">Reserveer</a>
                                                    <div class="margin-10px-top font-size14">21:30-22:00</div>
                                                    <div class="font-size13 text-light-gray">Reserveerbaar</div>
                                                </td>
                                            <?php } ?>
                                        <?php  } else {
                                            //NOG TE RESERVEREN
                                            ?>
                                            <td>
                                                <a href="../actions/baan-reserveren-admin.php?tijd=21:30&&datum=<?php echo ${"dag$dagLoop"}->format('Y-m-d'); ?>&&baan=<?php echo $baan ?>&&soort=<?php echo $soort; ?>" style="cursor:pointer; text-decoration: none" class="bg-green padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16  xs-font-size13">Reserveer</a>
                                                <div class="margin-10px-top font-size14">21:30-22:00</div>
                                                <div class="font-size13 text-light-gray">Reserveerbaar</div>
                                            </td>


                                        <?php } } ?>
                                </tr>
                                <tr>
                                    <td class="align-middle">22:00</td>
                                    <?php

                                    $dagLoop = 0;
                                    for ($i = 0; $i <= 6; $i++) {
                                        $dagLoop++;

                                        $reserveringenResult["reservering_per_uur"] = '';

                                        $newDate = ${"dag$dagLoop"}->format('Y-m-d');

                                        $reserveringenSql = $con->prepare("SELECT *, (SELECT reserveer_tijd FROM reservering
                                                                                 WHERE reserveer_tijd >= '21:59:00' AND reserveer_tijd <= '23:00:00' AND baan_id = :baanID 
                                                                                   AND reserveer_datum = :reserveerDatum LIMIT 1) AS reservering_per_uur FROM reservering
                                                                                  WHERE reserveer_datum = :reserveerDatum AND reserveer_tijd like '22%' AND baan_id = :baanID");
                                        $reserveringenSql->bindParam(":reserveerDatum", $newDate);
                                        $reserveringenSql->bindParam(":baanID", $baan);
                                        $reserveringenSql->execute();
                                        $reserveringenResult = $reserveringenSql->fetch();
                                        $reserveringenNum = $reserveringenSql->rowCount();

                                        if ($reserveringenNum > 0) {
                                            if ($reserveringenResult["lid_id"] == 0) {
                                                $doel = "voor " . $reserveringenResult["reserveer_doel"];
                                                $deleteLink = "<a href='../actions/verwijder-reserveren-admin.php?id=" . $reserveringenResult['reserveer_id'] . " ' style='cursor:pointer; text-decoration: none'' class='bg-warning padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16 xs-font-size13'>Gereserveerd</a>";
                                            } else {
                                                $doel = "door lid";
                                                $deleteLink = "<span class='bg-warning padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16 xs-font-size13'>Gereserveerd</span>";
                                            }
                                        }

//                                        var_dump($reserveringenResult);

                                        if (isset($reserveringenResult["reserveer_datum"]) && isset($reserveringenResult["reserveer_tijd"])) {
                                            if ($reserveringenResult["reserveer_datum"] == $newDate && $reserveringenResult["reserveer_tijd"] == "22:00:00" && empty($reserveringenResult["reservering_per_uur"])) {
                                                //RESERVERING VAN HALF UUR
                                                ?>
                                                <td>
                                                    <?php echo $deleteLink; ?>
                                                    <div class="margin-10px-top font-size14">22:00-22:30</div>
                                                    <div class="font-size13 text-light-gray">Gereserveerd <?php echo $doel; ?></div>
                                                </td>
                                            <?php } elseif(!empty($reserveringenResult["reservering_per_uur"])) {
                                                //RESERVERING VAN UUR DOOR LID
                                                ?>
                                                <td>
                                                    <?php echo $deleteLink; ?>
                                                    <div class="margin-10px-top font-size14">22:00-22:30</div>
                                                    <div class="font-size13 text-light-gray">Gereserveerd <?php echo $doel; ?></div>
                                                </td>
                                            <?php  } else {  //NOG TE RESERVEREN ?>
                                                <td>
                                                    <a href="../actions/baan-reserveren-admin.php?tijd=22:00&&datum=<?php echo ${"dag$dagLoop"}->format('Y-m-d'); ?>&&baan=<?php echo $baan ?>&&soort=<?php echo $soort; ?>" style="cursor:pointer; text-decoration: none" class="bg-green padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16  xs-font-size13">Reserveer</a>
                                                    <div class="margin-10px-top font-size14">22:00-22:30</div>
                                                    <div class="font-size13 text-light-gray">Reserveerbaar</div>
                                                </td>
                                            <?php } ?>
                                        <?php  } else {
                                            //NOG TE RESERVEREN
                                            ?>
                                            <td>
                                                <a href="../actions/baan-reserveren-admin.php?tijd=22:00&&datum=<?php echo ${"dag$dagLoop"}->format('Y-m-d'); ?>&&baan=<?php echo $baan ?>&&soort=<?php echo $soort; ?>" style="cursor:pointer; text-decoration: none" class="bg-green padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16  xs-font-size13">Reserveer</a>
                                                <div class="margin-10px-top font-size14">22:00-22:30</div>
                                                <div class="font-size13 text-light-gray">Reserveerbaar</div>
                                            </td>


                                        <?php } } ?>
                                </tr>
                                <tr>
                                    <td class="align-middle">22:30</td>
                                    <?php

                                    $dagLoop = 0;
                                    for ($i = 0; $i <= 6; $i++) {
                                        $dagLoop++;

                                        $reserveringenResult["reservering_per_uur"] = '';

                                        $newDate = ${"dag$dagLoop"}->format('Y-m-d');

                                        $reserveringenSql = $con->prepare("SELECT *, (SELECT reserveer_tijd FROM reservering
                                                                                 WHERE reserveer_tijd >= '21:59:00' AND reserveer_tijd <= '23:00:00' AND baan_id = :baanID 
                                                                                   AND reserveer_datum = :reserveerDatum LIMIT 1) AS reservering_per_uur FROM reservering
                                                                                  WHERE reserveer_datum = :reserveerDatum AND reserveer_tijd like '22%' AND baan_id = :baanID");
                                        $reserveringenSql->bindParam(":reserveerDatum", $newDate);
                                        $reserveringenSql->bindParam(":baanID", $baan);
                                        $reserveringenSql->execute();
                                        $reserveringenResult = $reserveringenSql->fetch();
                                        $reserveringenNum = $reserveringenSql->rowCount();

                                        if ($reserveringenNum > 0) {
                                            if ($reserveringenResult["lid_id"] == 0) {
                                                $doel = "voor " . $reserveringenResult["reserveer_doel"];
                                                $deleteLink = "<a href='../actions/verwijder-reserveren-admin.php?id=" . $reserveringenResult['reserveer_id'] . " ' style='cursor:pointer; text-decoration: none'' class='bg-warning padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16 xs-font-size13'>Gereserveerd</a>";
                                            } else {
                                                $doel = "door lid";
                                                $deleteLink = "<span class='bg-warning padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16 xs-font-size13'>Gereserveerd</span>";
                                            }
                                        }

//                                        var_dump($reserveringenResult);

                                        if (isset($reserveringenResult["reserveer_datum"]) && isset($reserveringenResult["reserveer_tijd"])) {
                                            if ($reserveringenResult["reserveer_datum"] == $newDate && $reserveringenResult["reserveer_tijd"] == "22:30:00" && empty($reserveringenResult["reservering_per_uur"])) {
                                                //RESERVERING VAN HALF UUR
                                                ?>
                                                <td>
                                                    <?php echo $deleteLink; ?>
                                                    <div class="margin-10px-top font-size14">22:30-23:00</div>
                                                    <div class="font-size13 text-light-gray">Gereserveerd <?php echo $doel; ?></div>
                                                </td>
                                            <?php } elseif(!empty($reserveringenResult["reservering_per_uur"])) {
                                                if ($reserveringenResult["lid_id"] != 0) {
                                                //RESERVERING VAN UUR DOOR LID
                                                ?>
                                                <td>
                                                    <?php echo $deleteLink; ?>
                                                    <div class="margin-10px-top font-size14">22:30-23:00</div>
                                                    <div class="font-size13 text-light-gray">Gereserveerd <?php echo $doel; ?></div>
                                                </td>
                                            <?php  } else { ?>
                                                    <td>
                                                        <?php echo $deleteLink; ?>
                                                        <div class="margin-10px-top font-size14">22:30-23:00</div>
                                                        <div class="font-size13 text-light-gray">Reserveerbaar <?php echo $doel; ?></div>
                                                    </td>
                                              <?php  }
                                            } else {  //NOG TE RESERVEREN ?>
                                                <td>
                                                    <a href="../actions/baan-reserveren-admin.php?tijd=22:30&&datum=<?php echo ${"dag$dagLoop"}->format('Y-m-d'); ?>&&baan=<?php echo $baan ?>&&soort=<?php echo $soort; ?>" style="cursor:pointer; text-decoration: none" class="bg-green padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16  xs-font-size13">Reserveer</a>
                                                    <div class="margin-10px-top font-size14">22:30-23:00</div>
                                                    <div class="font-size13 text-light-gray">Reserveerbaar</div>
                                                </td>
                                            <?php } ?>
                                        <?php  } else {
                                            //NOG TE RESERVEREN
                                            ?>
                                            <td>
                                                <a href="../actions/baan-reserveren-admin.php?tijd=22:30&&datum=<?php echo ${"dag$dagLoop"}->format('Y-m-d'); ?>&&baan=<?php echo $baan ?>&&soort=<?php echo $soort; ?>" style="cursor:pointer; text-decoration: none" class="bg-green padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16  xs-font-size13">Reserveer</a>
                                                <div class="margin-10px-top font-size14">22:30-23:00</div>
                                                <div class="font-size13 text-light-gray">Reserveerbaar</div>
                                            </td>


                                        <?php } } ?>
                                </tr>
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