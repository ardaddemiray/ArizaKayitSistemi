<?php
session_start();
require 'db-con.php'; 

header('Content-Type: application/json');

// Giriş kontrolü
if (!isset($_SESSION['kullanici_id']) || !isset($_SESSION['rol_id'])) {
    echo json_encode(["success" => false, "message" => "Giriş yapılmamış."]);
    exit;
}

$kullanici_id = $_SESSION['kullanici_id'];
$rol_id = $_SESSION['rol_id'];

// Bildirimleri çek
$sql = "
    SELECT * FROM bildirimler
WHERE kullanici_id = ?
ORDER BY olusturulma_tarihi DESC
LIMIT 5

";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $kullanici_id);
$stmt->execute();
$result = $stmt->get_result();

$bildirimler = [];

while ($row = $result->fetch_assoc()) {
    $bildirimler[] = [
        "id" => $row["id"],
        "baslik" => $row["baslik"],
        "mesaj" => $row["mesaj"],
        "goruldu" => $row["goruldu"],
        "tarih" => date("d.m.Y H:i", strtotime($row["olusturulma_tarihi"]))
    ];
}

echo json_encode([
    "success" => true,
    "bildirimler" => $bildirimler
]);
