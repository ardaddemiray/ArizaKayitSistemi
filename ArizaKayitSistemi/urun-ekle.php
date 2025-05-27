<?php
require 'db-con.php';

$tur = $_POST['tur'] ?? '';
$marka = $_POST['marka'] ?? '';
$model = $_POST['model'] ?? '';
$adet = $_POST['adet'] ?? '';

if ($tur && $marka && $model && is_numeric($adet)) {
    $stmt = $conn->prepare("INSERT INTO malzemeler (tur, marka, model, adet) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $tur, $marka, $model, $adet);
    $stmt->execute();

    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false]);
}
?>
