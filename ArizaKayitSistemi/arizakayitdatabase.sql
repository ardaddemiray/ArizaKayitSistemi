-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 27 May 2025, 12:13:58
-- Sunucu sürümü: 10.4.32-MariaDB
-- PHP Sürümü: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `arizakayitdatabase`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `ariza_kayitlari`
--

CREATE TABLE `ariza_kayitlari` (
  `id` int(11) NOT NULL,
  `kullanici_id` int(11) NOT NULL,
  `birim_id` int(11) NOT NULL,
  `kategori_id` int(11) NOT NULL,
  `teknik_personel_id` int(11) DEFAULT NULL,
  `baslik` varchar(255) NOT NULL,
  `aciklama` text NOT NULL,
  `dosya_yolu` varchar(255) DEFAULT NULL,
  `durum_id` int(11) NOT NULL,
  `olusturulma_tarihi` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `ariza_kayitlari`
--

INSERT INTO `ariza_kayitlari` (`id`, `kullanici_id`, `birim_id`, `kategori_id`, `teknik_personel_id`, `baslik`, `aciklama`, `dosya_yolu`, `durum_id`, `olusturulma_tarihi`) VALUES
(14, 16, 1, 1, 5, 'Ekran Bozuldu', 'Bilgisayar ekranında çizgiler oluşuyor.', NULL, 1, '2025-05-12 23:30:48'),
(15, 17, 1, 2, 5, 'Yazılım Hatası', 'Program açılmıyor.', NULL, 2, '2025-05-12 23:30:48'),
(16, 18, 3, 3, 5, 'İnternet Sorunu', 'İnternet bağlantısı sık sık kopuyor.', NULL, 3, '2025-05-12 23:30:48'),
(17, 19, 2, 4, 5, 'Yazıcı Çalışmıyor', 'Belgeleri yazdıramıyoruz.', NULL, 4, '2025-05-12 23:30:48'),
(18, 20, 2, 5, 5, 'Giriş Hatası', 'Sisteme giriş yapamıyoruz.', NULL, 1, '2025-05-12 23:30:48'),
(19, 21, 1, 1, 5, 'Ses Sorunu', 'Kulaklık sesi vermiyor.', NULL, 3, '2025-05-12 23:30:48'),
(20, 22, 2, 2, 5, 'Program Donuyor', 'İlaç stok programı sık sık donuyor.', NULL, 3, '2025-05-12 23:30:48'),
(21, 23, 3, 3, 5, 'Kablosuz Ağ Sorunu', 'Kablosuz ağdan düşüyor.', NULL, 4, '2025-05-12 23:30:48'),
(22, 24, 1, 4, 5, 'Tarayıcı Tanınmıyor', 'Belgeler taranamıyor.', NULL, 3, '2025-05-12 23:30:48'),
(23, 25, 2, 5, 5, 'VPN Bağlanmıyor', 'Uzaktan bağlantı sağlanamıyor.', NULL, 1, '2025-05-12 23:30:48'),
(30, 26, 4, 2, 5, 'Deneme', 'deneme', 'uploads/1747088717_send.png', 3, '2025-05-13 01:25:17'),
(31, 5, 4, 1, 5, 'Deneme kayıt', 'deneme', 'uploads/1747477556_mail.png', 1, '2025-05-17 13:25:56'),
(32, 27, 5, 2, 5, 'Ariza', 'deneme', 'uploads/1747492787_placeholder.png', 2, '2025-05-17 17:39:47'),
(33, 28, 1, 1, 5, 'Goruntu gelmiyor', '.', NULL, 4, '2025-05-17 18:31:54'),
(34, 28, 1, 5, 5, 'd1', 'd1', NULL, 2, '2025-05-17 18:46:18'),
(35, 29, 1, 1, 29, 'Arıza Deneme', 'Bilgisayarım açılmıyor.', NULL, 1, '2025-05-20 23:18:21'),
(36, 5, 1, 1, 29, 'AKS DENEME', 'Monitöre görüntü gelmiyor.', NULL, 1, '2025-05-20 23:22:19'),
(37, 30, 3, 2, 29, 'Sürücü hatası', 'sürücülerimin güncellenmesi lazım', NULL, 2, '2025-05-21 00:16:59');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `bildirimler`
--

CREATE TABLE `bildirimler` (
  `id` int(11) NOT NULL,
  `kullanici_id` int(11) DEFAULT NULL,
  `rol_id` tinyint(4) DEFAULT NULL,
  `baslik` varchar(255) NOT NULL,
  `mesaj` text NOT NULL,
  `goruldu` tinyint(1) DEFAULT 0,
  `olusturulma_tarihi` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `bildirimler`
--

INSERT INTO `bildirimler` (`id`, `kullanici_id`, `rol_id`, `baslik`, `mesaj`, `goruldu`, `olusturulma_tarihi`) VALUES
(1, 5, 1, 'Yeni Arıza Talebi', 'Yeni bir arıza kaydı oluşturuldu.', 1, '2025-05-17 17:39:47'),
(2, 27, 2, 'Talebiniz Alındı', 'Arıza kaydınız başarıyla oluşturuldu.', 0, '2025-05-17 17:39:47'),
(3, 27, 2, 'Durum Güncellendi', 'Arıza kaydınız işlemde durumuna getirildi.', 0, '2025-05-17 17:42:06'),
(4, 26, 2, 'Durum Güncellendi', 'Arıza kaydınız yönlendirildi.', 0, '2025-05-17 17:43:59'),
(5, 27, 2, 'Yeni Mesaj - Teknik Personel', 'Teknik personel arıza kaydınızda bir mesaj gönderdi.', 0, '2025-05-17 18:16:17'),
(6, 5, 1, 'Yeni Mesaj - Kullanıcı', 'Bir kullanıcı arıza kaydında size mesaj gönderdi.', 1, '2025-05-17 18:16:42'),
(7, 27, 2, 'Yeni Mesaj - Teknik Personel', 'Teknik personel arıza kaydınızda bir mesaj gönderdi.', 0, '2025-05-17 18:17:13'),
(8, 5, 1, 'Yeni Arıza Talebi', 'Yeni bir arıza kaydı oluşturuldu.', 1, '2025-05-17 18:31:54'),
(9, 28, 2, 'Talebiniz Alındı', 'Arıza kaydınız başarıyla oluşturuldu.', 1, '2025-05-17 18:31:54'),
(10, 28, 2, 'Durum Güncellendi', 'Arıza kaydınız çözüldü olarak işaretlendi.', 1, '2025-05-17 18:42:32'),
(12, 5, 1, 'Yeni Arıza Talebi', 'Yeni bir arıza kaydı oluşturuldu.', 1, '2025-05-17 18:46:18'),
(13, 28, 2, 'Talebiniz Alındı', 'Arıza kaydınız başarıyla oluşturuldu.', 1, '2025-05-17 18:46:18'),
(14, 28, 2, 'Durum Güncellendi', 'Arıza kaydınız işlemde durumuna getirildi.', 1, '2025-05-17 18:46:58'),
(15, 5, 1, 'Yeni Mesaj - Kullanıcı', 'Bir kullanıcı arıza kaydında size mesaj gönderdi.', 1, '2025-05-17 18:47:24'),
(16, 28, 2, 'Yeni Mesaj - Teknik Personel', 'Teknik personel arıza kaydınızda bir mesaj gönderdi.', 1, '2025-05-17 18:48:09'),
(17, 5, 1, 'Yeni Mesaj - Kullanıcı', 'Bir kullanıcı arıza kaydında size mesaj gönderdi.', 1, '2025-05-17 21:50:40'),
(18, 29, 1, 'Yeni Arıza Talebi', 'Yeni bir arıza kaydı oluşturuldu.', 1, '2025-05-20 23:18:21'),
(19, 29, 2, 'Talebiniz Alındı', 'Arıza kaydınız başarıyla oluşturuldu.', 1, '2025-05-20 23:18:21'),
(20, 29, 1, 'Yeni Mesaj - Kullanıcı', 'Bir kullanıcı arıza kaydında size mesaj gönderdi.', 1, '2025-05-20 23:19:32'),
(21, 29, 1, 'Yeni Arıza Talebi', 'Yeni bir arıza kaydı oluşturuldu.', 1, '2025-05-20 23:22:19'),
(22, 5, 2, 'Talebiniz Alındı', 'Arıza kaydınız başarıyla oluşturuldu.', 1, '2025-05-20 23:22:19'),
(23, 29, 1, 'Yeni Mesaj - Kullanıcı', 'Bir kullanıcı arıza kaydında size mesaj gönderdi.', 1, '2025-05-20 23:22:56'),
(24, 5, 2, 'Yeni Mesaj - Teknik Personel', 'Teknik personel arıza kaydınızda bir mesaj gönderdi.', 1, '2025-05-20 23:23:45'),
(25, 29, 1, 'Yeni Arıza Talebi', 'Yeni bir arıza kaydı oluşturuldu.', 1, '2025-05-21 00:16:59'),
(26, 30, 2, 'Talebiniz Alındı', 'Arıza kaydınız başarıyla oluşturuldu.', 1, '2025-05-21 00:16:59'),
(27, 30, 2, 'Durum Güncellendi', 'Arıza kaydınız işlemde durumuna getirildi.', 1, '2025-05-21 00:18:11'),
(28, 30, 2, 'Yeni Mesaj - Teknik Personel', 'Teknik personel arıza kaydınızda bir mesaj gönderdi.', 1, '2025-05-21 00:18:54'),
(29, 30, 2, 'Durum Güncellendi', 'Arıza kaydınız çözüldü olarak işaretlendi.', 1, '2025-05-21 00:20:07'),
(30, 29, 1, 'Durum Güncellendi', 'Arıza kaydınız çözüldü olarak işaretlendi.', 1, '2025-05-21 00:20:07'),
(31, 30, 2, 'Durum Güncellendi', 'Arıza kaydınız işlemde durumuna getirildi.', 0, '2025-05-26 11:28:49');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `birimler`
--

CREATE TABLE `birimler` (
  `id` int(11) NOT NULL,
  `birim_adi` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `birimler`
--

INSERT INTO `birimler` (`id`, `birim_adi`) VALUES
(1, 'Bilgi İşlem'),
(2, 'Toplum Sağlığı'),
(3, 'Evrak Kayıt'),
(4, 'İnsan Kaynakları'),
(5, 'Mali Hizmetler');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `durumlar`
--

CREATE TABLE `durumlar` (
  `id` int(11) NOT NULL,
  `durum_adi` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `durumlar`
--

INSERT INTO `durumlar` (`id`, `durum_adi`) VALUES
(1, 'Beklemede'),
(2, 'İşlemde'),
(3, 'Çözüldü'),
(4, 'Yönlendirildi');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kategoriler`
--

CREATE TABLE `kategoriler` (
  `id` int(11) NOT NULL,
  `kategori_adi` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `kategoriler`
--

INSERT INTO `kategoriler` (`id`, `kategori_adi`) VALUES
(1, 'Donanım Arızası'),
(2, 'Yazılım Problemi'),
(3, 'Ağ Bağlantı Sorunu'),
(4, 'Yazıcı / Tarayıcı Hatası'),
(5, 'Erişim / Yetki Problemi');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kullanicilar`
--

CREATE TABLE `kullanicilar` (
  `id` int(11) NOT NULL,
  `ad` varchar(50) NOT NULL,
  `soyad` varchar(50) NOT NULL,
  `eposta` varchar(100) NOT NULL,
  `sifre` varchar(255) NOT NULL,
  `rol_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `kullanicilar`
--

INSERT INTO `kullanicilar` (`id`, `ad`, `soyad`, `eposta`, `sifre`, `rol_id`) VALUES
(4, 'Arda', 'Demiray', 'ardademiray@saglik.gov.tr', '$2y$10$oAksk.SJNHGt0P2S5UoZlu8nKY7o7Y8aXFAAUKHveX7xMtGXSYWSG', 0),
(5, 'Ali', 'Veli', 'aliveli@saglik.gov.tr', '$2y$10$INmGwwuYlhUjPNJUIS56pucjdvqDCZ02LGZ0diLjocxPDWm.JTnPa', 0),
(16, 'Ahmet', 'Yılmaz', 'ahmet.yilmaz@saglik.gov.tr', '$2y$10$ZBqUpQ3mDVN9h69/BZc2E.6xfnbfaOYGQ9ek1IQGSczKz/j1V6fSe', 0),
(17, 'Ayşe', 'Demir', 'ayse.demir@saglik.gov.tr', '$2y$10$ZBqUpQ3mDVN9h69/BZc2E.6xfnbfaOYGQ9ek1IQGSczKz/j1V6fSe', 0),
(18, 'Mehmet', 'Kaya', 'mehmet.kaya@saglik.gov.tr', '$2y$10$ZBqUpQ3mDVN9h69/BZc2E.6xfnbfaOYGQ9ek1IQGSczKz/j1V6fSe', 0),
(19, 'Zeynep', 'Çelik', 'zeynep.celik@saglik.gov.tr', '$2y$10$ZBqUpQ3mDVN9h69/BZc2E.6xfnbfaOYGQ9ek1IQGSczKz/j1V6fSe', 0),
(20, 'Ali', 'Koç', 'ali.koc@saglik.gov.tr', '$2y$10$ZBqUpQ3mDVN9h69/BZc2E.6xfnbfaOYGQ9ek1IQGSczKz/j1V6fSe', 0),
(21, 'Elif', 'Aydın', 'elif.aydin@saglik.gov.tr', '$2y$10$ZBqUpQ3mDVN9h69/BZc2E.6xfnbfaOYGQ9ek1IQGSczKz/j1V6fSe', 0),
(22, 'Mustafa', 'Şahin', 'mustafa.sahin@saglik.gov.tr', '$2y$10$ZBqUpQ3mDVN9h69/BZc2E.6xfnbfaOYGQ9ek1IQGSczKz/j1V6fSe', 0),
(23, 'Fatma', 'Yıldız', 'fatma.yildiz@saglik.gov.tr', '$2y$10$ZBqUpQ3mDVN9h69/BZc2E.6xfnbfaOYGQ9ek1IQGSczKz/j1V6fSe', 0),
(24, 'Burak', 'Arslan', 'burak.arslan@saglik.gov.tr', '$2y$10$ZBqUpQ3mDVN9h69/BZc2E.6xfnbfaOYGQ9ek1IQGSczKz/j1V6fSe', 0),
(25, 'Seda', 'Kurt', 'seda.kurt@saglik.gov.tr', '$2y$10$ZBqUpQ3mDVN9h69/BZc2E.6xfnbfaOYGQ9ek1IQGSczKz/j1V6fSe', 0),
(26, 'Arda', 'Demiray', 'arda.demiray@saglik.gov.tr', '$2y$10$kp9.gXMAGAAn5xcsbmNkCe6OVCYmrR77ukefJZ63z2Wa9Wh7w/1tC', 0),
(27, 'Dilara', 'Demiray', 'dilara@saglik.gov.tr', '$2y$10$kFYUkBItWkPX0tvsvkUqJO0azCM./LUGsBpA.Fj.sZ.0JpvwFcaKu', 0),
(28, 'Doruk', 'Aydemir', 'dorukadmr@saglik.gov.tr', '$2y$10$7OaR4xwB7OSiuhauLkD7BO6gDbzKanw9nagMQtFpkjTn3qfeMTY6u', 0),
(29, 'Arda', 'Demiray', 'arda@saglik.gov.tr', '$2y$10$XghnzbMD6aTYDS/OU9yxJeP81IyJDzNBKF9npdHHYNS9aHsGxkiaa', 1),
(30, 'Ahmet', 'Mehmet', 'ahmet.mehmet@saglik.gov.tr', '$2y$10$DYf8QPkDHZwxsOt4gXfV4.sE8OcXsU4d9UPIM6tJe5/KkmDNHh2WO', 0);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `malzemeler`
--

CREATE TABLE `malzemeler` (
  `id` int(11) NOT NULL,
  `tur` varchar(100) NOT NULL,
  `marka` varchar(100) DEFAULT NULL,
  `model` varchar(100) DEFAULT NULL,
  `adet` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `malzemeler`
--

INSERT INTO `malzemeler` (`id`, `tur`, `marka`, `model`, `adet`) VALUES
(1, 'Klavye', 'Logitech', 'K120', 15),
(2, 'Monitör', 'Samsung', 'S24F350', 8),
(3, 'Yazıcı', 'HP', 'LaserJet M15w', 4),
(4, 'Switch', 'TP-Link', 'TL-SG108', 10),
(5, 'Mouse', 'Logitech', 'M185', 20),
(6, 'Laptop', 'Lenovo', 'ThinkPad E15', 5),
(7, 'Klavye', 'Microsoft', 'Ergonomic 4000', 12),
(8, 'Tarayıcı', 'Canon', 'LiDE 300', 7),
(9, 'Ethernet Kablosu', 'Ugreen', 'Cat6 5m', 50),
(10, 'Access Point', 'Ubiquiti', 'UniFi AP AC Lite', 3),
(11, 'Projeksiyon Cihazı', 'Epson', 'EB-X06', 2),
(12, 'Yazıcı Toneri', 'HP', '85A', 25),
(13, 'USB Bellek', 'SanDisk', 'Cruzer Blade 32GB', 30),
(14, 'Monitör', 'Dell', 'P2419H', 6),
(15, 'Ekran Kartı', 'MSI', 'GTX 1050', 3),
(16, 'Bilgisayar Kasası', 'Asus', 'Tuf', 2);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `roller`
--

CREATE TABLE `roller` (
  `id` int(11) NOT NULL,
  `rol_adi` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `roller`
--

INSERT INTO `roller` (`id`, `rol_adi`) VALUES
(0, 'Personel'),
(1, 'Teknik Personel');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `yorumlar`
--

CREATE TABLE `yorumlar` (
  `id` int(11) NOT NULL,
  `ariza_id` int(11) NOT NULL,
  `kullanici_id` int(11) NOT NULL,
  `mesaj` text NOT NULL,
  `tarih` datetime DEFAULT current_timestamp(),
  `rol_id` tinyint(1) NOT NULL DEFAULT 2
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `yorumlar`
--

INSERT INTO `yorumlar` (`id`, `ariza_id`, `kullanici_id`, `mesaj`, `tarih`, `rol_id`) VALUES
(4, 14, 5, 'merhaba', '2025-05-13 01:04:08', 2),
(5, 32, 5, 's', '2025-05-17 18:16:17', 1),
(6, 32, 27, 'as', '2025-05-17 18:16:42', 0),
(7, 32, 5, 'm', '2025-05-17 18:17:13', 1),
(8, 34, 28, 's', '2025-05-17 18:47:24', 0),
(9, 34, 5, 'a', '2025-05-17 18:48:09', 1),
(10, 31, 5, 'm', '2025-05-17 21:50:40', 1),
(11, 35, 29, 'Kırklareli Üniversitesi', '2025-05-20 23:19:32', 1),
(12, 36, 5, 'merhaba', '2025-05-20 23:22:56', 0),
(13, 36, 29, 'merhaba size nasıl yardımcı olabilirim', '2025-05-20 23:23:45', 1),
(14, 37, 29, 'merhaba', '2025-05-21 00:18:54', 1);

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `ariza_kayitlari`
--
ALTER TABLE `ariza_kayitlari`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kullanici_id` (`kullanici_id`),
  ADD KEY `birim_id` (`birim_id`),
  ADD KEY `teknik_personel_id` (`teknik_personel_id`),
  ADD KEY `durum_id` (`durum_id`),
  ADD KEY `fk_kategori` (`kategori_id`);

--
-- Tablo için indeksler `bildirimler`
--
ALTER TABLE `bildirimler`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kullanici_id` (`kullanici_id`);

--
-- Tablo için indeksler `birimler`
--
ALTER TABLE `birimler`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `durumlar`
--
ALTER TABLE `durumlar`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `kategoriler`
--
ALTER TABLE `kategoriler`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `kullanicilar`
--
ALTER TABLE `kullanicilar`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `eposta` (`eposta`),
  ADD KEY `rol_id` (`rol_id`);

--
-- Tablo için indeksler `malzemeler`
--
ALTER TABLE `malzemeler`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `roller`
--
ALTER TABLE `roller`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `yorumlar`
--
ALTER TABLE `yorumlar`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ariza_id` (`ariza_id`),
  ADD KEY `kullanici_id` (`kullanici_id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `ariza_kayitlari`
--
ALTER TABLE `ariza_kayitlari`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- Tablo için AUTO_INCREMENT değeri `bildirimler`
--
ALTER TABLE `bildirimler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- Tablo için AUTO_INCREMENT değeri `birimler`
--
ALTER TABLE `birimler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Tablo için AUTO_INCREMENT değeri `durumlar`
--
ALTER TABLE `durumlar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Tablo için AUTO_INCREMENT değeri `kategoriler`
--
ALTER TABLE `kategoriler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Tablo için AUTO_INCREMENT değeri `kullanicilar`
--
ALTER TABLE `kullanicilar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- Tablo için AUTO_INCREMENT değeri `malzemeler`
--
ALTER TABLE `malzemeler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Tablo için AUTO_INCREMENT değeri `roller`
--
ALTER TABLE `roller`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Tablo için AUTO_INCREMENT değeri `yorumlar`
--
ALTER TABLE `yorumlar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Dökümü yapılmış tablolar için kısıtlamalar
--

--
-- Tablo kısıtlamaları `ariza_kayitlari`
--
ALTER TABLE `ariza_kayitlari`
  ADD CONSTRAINT `ariza_kayitlari_ibfk_1` FOREIGN KEY (`kullanici_id`) REFERENCES `kullanicilar` (`id`),
  ADD CONSTRAINT `ariza_kayitlari_ibfk_2` FOREIGN KEY (`birim_id`) REFERENCES `birimler` (`id`),
  ADD CONSTRAINT `ariza_kayitlari_ibfk_3` FOREIGN KEY (`teknik_personel_id`) REFERENCES `kullanicilar` (`id`),
  ADD CONSTRAINT `ariza_kayitlari_ibfk_4` FOREIGN KEY (`durum_id`) REFERENCES `durumlar` (`id`),
  ADD CONSTRAINT `fk_kategori` FOREIGN KEY (`kategori_id`) REFERENCES `kategoriler` (`id`) ON UPDATE CASCADE;

--
-- Tablo kısıtlamaları `bildirimler`
--
ALTER TABLE `bildirimler`
  ADD CONSTRAINT `bildirimler_ibfk_1` FOREIGN KEY (`kullanici_id`) REFERENCES `kullanicilar` (`id`) ON DELETE CASCADE;

--
-- Tablo kısıtlamaları `kullanicilar`
--
ALTER TABLE `kullanicilar`
  ADD CONSTRAINT `kullanicilar_ibfk_1` FOREIGN KEY (`rol_id`) REFERENCES `roller` (`id`);

--
-- Tablo kısıtlamaları `yorumlar`
--
ALTER TABLE `yorumlar`
  ADD CONSTRAINT `yorumlar_ibfk_1` FOREIGN KEY (`ariza_id`) REFERENCES `ariza_kayitlari` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `yorumlar_ibfk_2` FOREIGN KEY (`kullanici_id`) REFERENCES `kullanicilar` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
