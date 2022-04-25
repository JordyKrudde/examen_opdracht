<?php
session_start();

if(isset($_SESSION["lidID"]) && !empty($_SESSION["lidID"]) && $_SESSION["lidRol"] == "Admin") { //als de gebruiker gezet is mag hij hier komen. De gebruiker moet uiteraard wel een admin zijn.

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
    <link rel="stylesheet" href="../css/melding.css" type="text/css"> <!-- Dashboard CSS -->

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
            <?php if (isset($_SESSION["lidRol"]) && $_SESSION["lidRol"] != "") { //als deze sessie is gezet dan mag hij je naam tonen, anders niet ?>
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
                        <h5>Lid toevoegen</h5>
                        <hr>
                        <form action="../actions/lid-toevoegen-action.php" method="post">

                            <div class="col-md-5">
                                <input type="email" placeholder="E-mailadres" class="form-control" name="email" required>
                            </div>

                            <br>

                            <div class="col-md-5">
                                <input type="text" placeholder="Leden nummer" class="form-control" name="ledenNmr" required>
                            </div>

                            <br>

                            <div class="col-md-5">
                                <select class="form-select" name="rolKeuze" required>
                                    <option>Gebruiker</option>
                                    <option>Admin</option>
                                </select>
                            </div>

                            <br>

                            <button class="btn-primary btn">Lid toevoegen</button>

                            <div class="col-md-5">
                                <?php
                                if(isset($_SESSION["status"]) && $_SESSION["status"] != "") { //gebruik ik als melding
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