<?php
require 'db-con.php';

$rawData = file_get_contents("php://input");
$data = json_decode($rawData, true);

$id = $data['id'];
$islem = $data['islem'];

// Güncel stok bilgisini al
$sorgu = $conn->prepare("SELECT adet FROM malzemeler WHERE id = ?");
$sorgu->bind_param("i", $id);
$sorgu->execute();
$sonuc = $sorgu->get_result();
$malzeme = $sonuc->fetch_assoc();

if (!$malzeme) {
    echo json_encode(["status" => "error", "message" => "Malzeme bulunamadı"]);
    exit;
}

$adet = $malzeme['adet'];

if ($islem === 'artir') {
    $adet++;
} elseif ($islem === 'azalt' && $adet > 0) {
    $adet--;
}

$guncelle = $conn->prepare("UPDATE malzemeler SET adet = ? WHERE id = ?");
$guncelle->bind_param("ii", $adet, $id);
$guncelle->execute();

echo json_encode(["status" => "success", "adet" => $adet]);
?>
