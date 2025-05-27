<?php
session_start();
require 'db-con.php';
require_once 'bildirim-fonksiyon.php';

if (!isset($_SESSION['kullanici_id'])) {
    die("Giriş yapılmadı.");
}

$kullanici_id = $_SESSION['kullanici_id'];
$rol_id = $_SESSION['rol_id'];
$ariza_id = $_POST['ariza_id'] ?? null;
$mesaj = trim($_POST['mesaj'] ?? '');

if (!$ariza_id || $mesaj === '') {
    die("Eksik veri.");
}

// 1. Arızanın çözülüp çözülmediğini kontrol et
$stmt = $conn->prepare("SELECT durum_id, kullanici_id, teknik_personel_id FROM ariza_kayitlari WHERE id = ?");
$stmt->bind_param("i", $ariza_id);
$stmt->execute();
$result = $stmt->get_result();
$kayit = $result->fetch_assoc();

if (!$kayit || $kayit['durum_id'] == 4) {
    die("Bu arıza çözülmüş, mesaj gönderilemez.");
}

// 2. Mesajı yorumlar tablosuna kaydet
$stmt = $conn->prepare("INSERT INTO yorumlar (ariza_id, kullanici_id, mesaj, tarih, rol_id) VALUES (?, ?, ?, NOW(), ?)");
$stmt->bind_param("iisi", $ariza_id, $kullanici_id, $mesaj, $rol_id);

if ($stmt->execute()) {

    $hedef_id = null;
    $hedef_rol = null;

    if ($kullanici_id == $kayit['kullanici_id']) {
        // Kullanıcı mesaj gönderdi → teknik personele bildirim
        $hedef_id = $kayit['teknik_personel_id'];
        $hedef_rol = 1;
        $baslik = "Yeni Mesaj - Personel";
        $icerik = "Bir kullanıcı arıza kaydında size mesaj gönderdi.";
    } else {
        // Teknik personel mesaj gönderdi → kullanıcıya bildirim
        $hedef_id = $kayit['kullanici_id'];
        $hedef_rol = 2;
        $baslik = "Yeni Mesaj - Teknik Personel";
        $icerik = "Teknik personel arıza kaydınızda bir mesaj gönderdi.";
    }

    // 4. Bildirim kaydı oluştur
    if ($hedef_id) {
        $bildirim = $conn->prepare("INSERT INTO bildirimler (kullanici_id, rol_id, baslik, mesaj) VALUES (?, ?, ?, ?)");
        if (!$bildirim) {
            die("Bildirim prepare hatası: " . $conn->error);
        }
        $bildirim->bind_param("iiss", $hedef_id, $hedef_rol, $baslik, $icerik);
        if (!$bildirim->execute()) {
            die("Bildirim ekleme hatası: " . $bildirim->error);
        }
    }

    header("Location: ariza-detay.php?id=$ariza_id");
    exit;

} else {
    echo "Yorum ekleme hatası: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
