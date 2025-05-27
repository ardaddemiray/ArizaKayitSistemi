<?php
require_once 'db-con.php'; 

function bildirimEkle($baslik, $mesaj, $kullanici_id = null, $rol_id = 0) {
    global $conn;

    $sql = "INSERT INTO bildirimler (baslik, mesaj, kullanici_id, rol_id)
            VALUES (?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    if (!$stmt) return false;

    $stmt->bind_param("ssii", $baslik, $mesaj, $kullanici_id, $rol_id);
    return $stmt->execute();
}
