<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gbov2";

try 
    {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
    }
catch(PDOException $e)
    {
    echo "Pas de connexion: " . $e->getMessage();
    }
?>