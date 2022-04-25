<?php

class Dbh //Hier maak ik de class Dbh aan
{
    //hier maak ik private variabelen aan
    private $servername;
    private $username;
    private $password;
    private $dbname;
    private $charset;

    public function connect()
    {
        //hier vul ik de variabelen met waardes
        $this->servername = "185.87.187.247"; //verander dit naar localhost als je het op de server zet
        $this->username = "jkrudde_examen-project";
        $this->password = "Bier123Bazen!";
        $this->dbname = "jkrudde_examen-project";
        $this->charset = "utf8mb4";

        try {
            $dsn = "mysql:host=" . $this->servername . ";dbname=" . $this->dbname . ";charset=" . $this->charset;
            $pdo = new PDO($dsn, $this->username, $this->password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //connect hier doormiddel van de pdo manier naar je database

            return $pdo;
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage(); //als de verbinding niet goed gaat krijg je een error op je scherm
        }
    }
}