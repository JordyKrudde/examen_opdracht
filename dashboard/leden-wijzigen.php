<?php
session_start();
include('../db/dbconfig.php');

$db = new Dbh();
$pdo = $db->connect();

if(isset($_SESSION["lidID"]) && !empty($_SESSION["lidID"]) && $_SESSION["lidRol"] == "Admin") {

$id = $_GET['id'];

$sth = $pdo->prepare("SELECT * FROM lid WHERE lid_id = :lidID");
$sth->bindParam(":lidID", $id);
$sth->execute();

$data = $sth->fetchAll(PDO::FETCH_ASSOC);

foreach($data as $row) {
    $lidvoornaam = $row['lid_vnaam'];
    $lidtvoegsel = $row['lid_tvoegsel'];
    $lidanaam = $row['lid_anaam'];
    $lidtelnr = $row['lid_tel'];
    $lidemail = $row['lid_email'];
    $lidwachtwoord = $row['lid_wachtwoord'];
    $lidrol = $row['lid_rol'];
    $lidsinds = $row['lid_sinds'];
    $lidnr = $row['lid_nr'];
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
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>  <!-- Custom icons from BoxIcons.com CSS -->

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script> <!-- Jquery for the mobile nav -->

    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css" rel="stylesheet"> <!-- Datatables bootstrapp 5-->
    <link href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css" rel="stylesheet"> <!-- Datatables bootstrapp 5 theme-->

    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet"> <!-- Google font Roboto -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap" rel="stylesheet"> <!-- Google font Poppins -->
    <link href="../css/melding.css" rel="stylesheet">
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
            <li class="nav-item">
                <a href="index.php" class="nav-link active" style="width:100%" aria-current="page">
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
                        <h5>Lid wijzigen</h5>
                        <hr>
                        <form method="POST" action="../actions/update-lid.php?id=<?php echo $id ?>">
                            <div class="input-group">
                                <div class="col-md-4">
                                    <input type="text" name="vnaam" placeholder="Voornaam" class="form-control" value="<?php echo $lidvoornaam ?>">
                                </div>
                                <div class="col-md-3">
                                    <input type="text" name="tvoegsel" placeholder="Tussenvoegsel" class="form-control" value="<?php echo $lidtvoegsel ?>">
                                </div>
                                <div class="col-md-5">
                                    <input type="text" name="anaam" placeholder="Achternaam" class="form-control" value="<?php echo $lidanaam ?>">
                                </div>
                            </div>

                            <br>

                            <div class="col-md-5">
                                <input type="email" name="email" placeholder="E-mailadres" class="form-control" value="<?php echo $lidemail ?>">
                            </div>

                            <br>

                            <div class="col-md-5">
                                <input type="password" name="wachtwoord" placeholder="Wachtwoord" class="form-control"">
                            </div>

                            <br>

                            <div class="col-md-5">
                                <input type="text" name="lidnr" placeholder="Leden nummer" class="form-control" value="<?php echo $lidnr ?>">
                                <label style="font-size:0.8em;">Vul hier je leden nummer in.</label>
                            </div>

                            <br>

                            <?php if($lidrol == 'Admin') { ?>
                                <div class="col-md-5">
                                    <select name="lidrol" class="form-control">
                                        <option>Gebruiker</option>
                                        <option selected>Admin</option>
                                    </select>
                                </div>
                            <?php } ?>
                            <?php if($lidrol == 'Gebruiker') { ?>
                                <div class="col-md-5">
                                    <select name="lidrol" class="form-control">
                                        <option selected>Gebruiker</option>
                                        <option>Admin</option>
                                    </select>
                                </div>
                            <?php } ?>
                            <?php if($lidrol == '') { ?>
                                <div class="col-md-5">
                                    <select name="lidrol" class="form-select">
                                        <option>Gebruiker</option>
                                        <option>Admin</option>
                                    </select>
                                </div>
                            <?php } ?>
                            <br>

                            <button class="btn-primary btn" name="opslaan" type="submit">Lid wijzigen</button>

                            <div class="col-md-5">
                                <?php
                                if(isset($_SESSION["status"]) && $_SESSION["status"] != "") {
                                    ?>
                                    <div class="melding  <?php echo $_SESSION["statusCode"]; ?>" style="width: 100%; margin: 20px 0;">
                                        <h6><?php echo $_SESSION["status"]; ?></h6>
                                    </div>

                                    <?php
                                    unset($_SESSION["status"]);
                                }
                                ?>
                            </div>
                        </form>
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