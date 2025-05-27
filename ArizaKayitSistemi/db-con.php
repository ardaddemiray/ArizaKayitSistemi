<?php
$host = "localhost"; 
$username = "root"; 
$password = ""; 
$database = "arizakayitdatabase"; 

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Veritabanı bağlantısı başarısız: " . $conn->connect_error);
}

?>