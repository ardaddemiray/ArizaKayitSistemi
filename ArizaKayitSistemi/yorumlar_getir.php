<?php
require 'db-con.php';

$ariza_id = $_GET['ariza_id'] ?? 0;

$stmt = $conn->prepare("
    SELECT y.mesaj, y.tarih, k.ad, k.soyad, k.rol_id
    FROM yorumlar y
    JOIN kullanicilar k ON y.kullanici_id = k.id
    WHERE y.ariza_id = ?
    ORDER BY y.tarih ASC
");
$stmt->bind_param("i", $ariza_id);
$stmt->execute();
$sonuc = $stmt->get_result();

$veriler = [];

while ($row = $sonuc->fetch_assoc()) {
    $veriler[] = $row;
}

header('Content-Type: application/json');
echo json_encode($veriler);
?>
