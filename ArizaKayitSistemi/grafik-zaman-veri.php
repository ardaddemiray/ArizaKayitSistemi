<?php
require 'db-con.php';

// Son 7 günün günlük kayıt sayısını getir
$sql = "
    SELECT DATE(olusturulma_tarihi) as tarih, COUNT(*) as sayi
    FROM ariza_kayitlari
    GROUP BY DATE(olusturulma_tarihi)
    ORDER BY tarih ASC
    LIMIT 7
";

$result = $conn->query($sql);

$data = [
    "tarih" => [],
    "sayi" => []
];

while ($row = $result->fetch_assoc()) {
    $data["tarih"][] = $row["tarih"];
    $data["sayi"][] = (int) $row["sayi"];
}

echo json_encode($data);
?>
