<?php
session_start();
include 'db-con.php';
require_once 'bildirim-fonksiyon.php';


if (!isset($_SESSION['kullanici_id'])) {
    die("Giriş yapılmamış.");
}
$kullanici_id = $_SESSION['kullanici_id'];

$konu = $_POST['konu'];
$birim_id = $_POST['birim_id'];
$kategori_id = $_POST['kategori_id'];
$teknik_personel_id = $_POST['teknik_personel_id'];
$aciklama = $_POST['aciklama'];

$dosya_yolu = null;
if (isset($_FILES['dosya']) && $_FILES['dosya']['error'] == 0) {
    $hedef_klasor = "uploads/";
    $dosya_adi = basename($_FILES["dosya"]["name"]);
    $hedef_dosya = $hedef_klasor . time() . "_" . $dosya_adi;

    $uzantilara_izin = ['pdf', 'jpg', 'png'];
    $dosya_uzantisi = strtolower(pathinfo($hedef_dosya, PATHINFO_EXTENSION));

    if (in_array($dosya_uzantisi, $uzantilara_izin)) {
        if (move_uploaded_file($_FILES["dosya"]["tmp_name"], $hedef_dosya)) {
            $dosya_yolu = $hedef_dosya;
        } else {
            die("Dosya yüklenemedi.");
        }
    } else {
        die("Yalnızca PDF, JPG veya PNG dosyalar yüklenebilir.");
    }
}

// Veritabanına kayıt
$sql = "INSERT INTO ariza_kayitlari (baslik, aciklama, kullanici_id, birim_id, kategori_id, teknik_personel_id, durum_id, dosya_yolu)
        VALUES (?, ?, ?, ?, ?, ?, 1, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ssiiiis", $konu, $aciklama, $kullanici_id, $birim_id, $kategori_id, $teknik_personel_id, $dosya_yolu);

if ($stmt->execute()) {
    // Bildirim: Teknik personele — Yeni arıza talebi
    $bildirim_stmt = $conn->prepare("INSERT INTO bildirimler (kullanici_id, rol_id, baslik, mesaj) VALUES (?, 1, ?, ?)");
    $baslik = "Yeni Arıza Talebi";
    $mesaj = "Yeni bir arıza kaydı oluşturuldu.";
    $bildirim_stmt->bind_param("iss", $teknik_personel_id, $baslik, $mesaj);
    $bildirim_stmt->execute();

    // Bildirim: Kullanıcıya — Talebiniz alındı
    $kullanici_id = $_SESSION['kullanici_id'];
    $bildirim_stmt2 = $conn->prepare("INSERT INTO bildirimler (kullanici_id, rol_id, baslik, mesaj) VALUES (?, 2, ?, ?)");
    $baslik2 = "Talebiniz Alındı";
    $mesaj2 = "Arıza kaydınız başarıyla oluşturuldu.";
    $bildirim_stmt2->bind_param("iss", $kullanici_id, $baslik2, $mesaj2);
    $bildirim_stmt2->execute();


    header("Location: ariza-kayitlarim.php");
    exit;
} else {
    echo "Hata: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
