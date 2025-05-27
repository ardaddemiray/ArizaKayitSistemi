<?php
include "db-con.php";

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $ad = trim($_POST['ad']);
    $soyad = trim($_POST['soyad']);
    $eposta = trim($_POST['eposta']);
    $sifre = $_POST['sifre'];
    $rol = 0;

    if (empty($ad) || empty($soyad) || empty($eposta) || empty($sifre)) {
        echo json_encode(["success" => false, "message" => "Tüm alanları doldurun."]);
        exit;
    }

    if (!filter_var($eposta, FILTER_VALIDATE_EMAIL) || !preg_match('/@saglik\.gov\.tr$/', $eposta)) {
        echo json_encode(["success" => false, "message" => "Sadece saglik.gov.tr uzantılı geçerli e-posta girin."]);
        exit;
    }

    $sifre_hashli = password_hash($sifre, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO kullanicilar (ad, soyad, eposta, sifre, rol_id) VALUES (?, ?, ?, ?, ?)");

    if (!$stmt) {
        echo json_encode(["success" => false, "message" => "Veritabanı hatası."]);
        exit;
    }

    $stmt->bind_param("ssssi", $ad, $soyad, $eposta, $sifre_hashli, $rol);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Kayıt başarılı."]);
    } else {
        echo json_encode(["success" => false, "message" => "E-posta zaten kayıtlı olabilir."]);
    }

    $stmt->close();
    exit;
}


?>

