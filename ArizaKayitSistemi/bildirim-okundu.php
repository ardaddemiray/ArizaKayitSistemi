<?php
session_start();
require 'db-con.php';

if (!isset($_SESSION['kullanici_id'])) {
    http_response_code(403);
    exit("Giriş yapılmamış.");
}

$kullanici_id = $_SESSION['kullanici_id'];

$sql = "UPDATE bildirimler SET goruldu = 1 WHERE kullanici_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $kullanici_id);
$stmt->execute();

echo json_encode(["success" => true]);
