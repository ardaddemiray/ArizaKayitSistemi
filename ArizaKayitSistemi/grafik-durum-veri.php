<?php
require 'db-con.php';

$sql = "SELECT d.durum_adi, COUNT(*) AS sayi
        FROM ariza_kayitlari ak
        JOIN durumlar d ON ak.durum_id = d.id
        GROUP BY d.durum_adi";

$result = $conn->query($sql);

$data = [
    "labels" => [],
    "counts" => []
];

while ($row = $result->fetch_assoc()) {
    $data["labels"][] = $row["durum_adi"];
    $data["counts"][] = (int) $row["sayi"];
}

echo json_encode($data);
?>
