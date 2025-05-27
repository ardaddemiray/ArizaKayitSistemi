<?php
session_start();
require 'db-con.php';

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $eposta = trim($_POST['eposta'] ?? '');
    $sifre = $_POST['sifre'] ?? '';

    // 1. Boş alan kontrolü
    if (empty($eposta) || empty($sifre)) {
        echo json_encode(["success" => false, "message" => "Lütfen e-posta ve şifrenizi giriniz."]);
        exit;
    }

    // 2. E-posta format kontrolü
    if (!filter_var($eposta, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(["success" => false, "message" => "Geçerli bir e-posta adresi giriniz."]);
        exit;
    }

    // 3. Veritabanında kullanıcıyı bul
    $stmt = $conn->prepare("SELECT * FROM kullanicilar WHERE eposta = ?");
    if (!$stmt) {
        echo json_encode(["success" => false, "message" => "Veritabanı hatası."]);
        exit;
    }

    $stmt->bind_param("s", $eposta);
    $stmt->execute();
    $sonuc = $stmt->get_result();

    if ($sonuc->num_rows === 1) {
        $kullanici = $sonuc->fetch_assoc();

        // 4. Şifre doğrulama
        if (password_verify($sifre, $kullanici['sifre'])) {
            $_SESSION['kullanici_id'] = $kullanici['id'];
            $_SESSION['ad'] = $kullanici['ad'];
            $_SESSION['soyad'] = $kullanici['soyad'];
            $_SESSION['rol_id'] = $kullanici['rol_id'];

            echo json_encode(["success" => true, "redirect" => "main-page.php"]);
        } else {
            echo json_encode(["success" => false, "message" => "Şifre yanlış."]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "Bu e-posta ile kayıtlı kullanıcı bulunamadı."]);
    }

    $stmt->close();
}
?>
