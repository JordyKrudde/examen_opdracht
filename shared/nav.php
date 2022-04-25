
    <!-- Navbar -->
<nav class="navbar navbar-expand-lg fixed-top bg-light navbar-light">
  <div class="container">
    <a class="navbar-brand" href="index.php"
      ><img
        id="DTV Logo"
        src="img/DTVlogo.jpg"
        alt="DTV Logo"
        draggable="false"
        height="40"
    /></a>
    <button
      class="navbar-toggler"
      type="button"
      data-mdb-toggle="collapse"
      data-mdb-target="#navbarSupportedContent"
      aria-controls="navbarSupportedContent"
      aria-expanded="false"
      aria-label="Toggle navigation"
    >
      <i class="bx bx-menu"></i>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ms-auto align-items-center">
        <li class="nav-item">
          <a class="nav-link mx-2" href="index.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link mx-2" href="menukaart.php">Menukaart</a>
        </li>

          <?php if (isset($_SESSION["lidRol"]) && $_SESSION["lidRol"] != "") { ?>
              <?php if ( $_SESSION["lidRol"] == "Admin" || $_SESSION["lidRol"] == "Gebruiker") { ?>
                  <li class="nav-item">
                      <a class="nav-link mx-2" href="baan-reserveren.php">Baan reserveren</a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link mx-2" href="inschrijven-toernooien.php">Inschrijven toernooien</a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link mx-2" href="profiel-gegevens.php">Profiel</a>
                  </li>
              <?php  } ?>
          <?php  } ?>

          <?php if (isset($_SESSION["lidRol"]) && $_SESSION["lidRol"] != "") { ?>
              <?php if ($_SESSION["lidRol"] == "Admin") { ?>
                  <li class="nav-item">
                      <a class="nav-link mx-2" href="dashboard/index.php">Dashboard</a>
                  </li>
              <?php }?>
          <?php }?>

          <li class="nav-item">
              <?php if(isset($_SESSION["lidID"]) && $_SESSION["lidID"] != "") { ?>
                  <a class="btn btn-primary btn-rounded" href="actions/uitloggen.php">Uitloggen</a>
              <?php } else { ?>
                  <a class="btn btn-primary btn-rounded" href="login.php">Login</a>
              <?php } ?>
        </li>
      </ul>
    </div>
  </div>
</nav>
<!-- Navbar -->
