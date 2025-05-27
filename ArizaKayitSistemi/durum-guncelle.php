<?php
session_start();
require 'db-con.php';
require_once 'bildirim-fonksiyon.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ariza_id = $_POST['ariza_id'];
    $durum_id = $_POST['durum_id'];

    // Durum güncelle
    $stmt = $conn->prepare("UPDATE ariza_kayitlari SET durum_id = ? WHERE id = ?");
    $stmt->bind_param("ii", $durum_id, $ariza_id);

    if ($stmt->execute()) {

        // Kullanıcı ve teknik personel bilgilerini çek
        $info_stmt = $conn->prepare("SELECT kullanici_id, teknik_personel_id FROM ariza_kayitlari WHERE id = ?");
        $info_stmt->bind_param("i", $ariza_id);
        $info_stmt->execute();
        $result = $info_stmt->get_result();
        $ariza = $result->fetch_assoc();
        $info_stmt->close();

        $kullanici_id = $ariza['kullanici_id'];
        $teknik_id = $ariza['teknik_personel_id'];

        // Duruma göre bildirim mesajı
        $durumlar = [
            1 => "Arıza kaydınız beklemede durumuna getirildi.",
            2 => "Arıza kaydınız işlemde durumuna getirildi.",
            3 => "Arıza kaydınız çözüldü olarak işaretlendi.",
            4 => "Arıza kaydınız yönlendirildi."
        ];

        // Her zaman kullanıcıya bilgi bildirimi
        $baslik = "Durum Güncellendi";
        $mesaj = $durumlar[$durum_id] ?? "Arıza kaydınız güncellendi.";

        $b1 = $conn->prepare("INSERT INTO bildirimler (kullanici_id, rol_id, baslik, mesaj) VALUES (?, 2, ?, ?)");
        $b1->bind_param("iss", $kullanici_id, $baslik, $mesaj);
        $b1->execute();

        // Eğer çözüldü ise ayrıca teknik personele de bildir
        if ($durum_id == 3 && $teknik_id) {
            $b2 = $conn->prepare("INSERT INTO bildirimler (kullanici_id, rol_id, baslik, mesaj) VALUES (?, 1, ?, ?)");
            $b2->bind_param("iss", $teknik_id, $baslik, $mesaj);
            $b2->execute();
        }

        header("Location: arizakayitlari-teknik.php");
        exit;
    } else {
        echo "Hata: " . $stmt->error;
    }

    $stmt->close();
}
?>
