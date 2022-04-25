<?php
session_start(); //start eerst de sessie voor de zekerheid
session_destroy(); //verwijderd nu alle sessies die momenteel gezet zijn
header ("Location: ../index.php"); 
exit();