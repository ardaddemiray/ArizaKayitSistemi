<?php
session_start();
require 'db-con.php';

if (!isset($_SESSION['kullanici_id'])) {
    header("Location: login.php");
    exit;
}

// Toplam kayıt
$toplamSorgu = $conn->query("SELECT COUNT(*) as toplam FROM ariza_kayitlari");
$toplam = $toplamSorgu->fetch_assoc()['toplam'] ?? 0;

// Çözülen
$cozulenSorgu = $conn->query("SELECT COUNT(*) as cozuldu FROM ariza_kayitlari WHERE durum_id = 3");
$cozuldu = $cozulenSorgu->fetch_assoc()['cozuldu'] ?? 0;

// Bekleyen
$bekleyenSorgu = $conn->query("SELECT COUNT(*) as bekleyen FROM ariza_kayitlari WHERE durum_id = 1");
$bekleyen = $bekleyenSorgu->fetch_assoc()['bekleyen'] ?? 0;

// Yönlendirilen
$yonlendirilenSorgu = $conn->query("SELECT COUNT(*) as yonlendirildi FROM ariza_kayitlari WHERE durum_id = 4");
$yonlendirildi = $yonlendirilenSorgu->fetch_assoc()['yonlendirildi'] ?? 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>AKS | Anasayfa</title>
	<link rel="stylesheet" href="style.css">
	<link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
	<script src="https://kit.fontawesome.com/a81368914c.js"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
    <div class="main-container">
    <nav class="sidebar close">
        <header>
            <div class="user">
                <span class="image">
                    <img src="images/wave.png" alt="logo">
                </span>

<div class="username-text">
    <span class="name">
        <?= isset($_SESSION['ad'], $_SESSION['soyad']) 
            ? htmlspecialchars($_SESSION['ad'] . ' ' . $_SESSION['soyad']) 
            : 'Kullanıcı' ?>
    </span>
    <span class="birim">
        <?= ($_SESSION['rol_id'] ?? 0) == 1 ? 'Teknik Personel' : 'Personel' ?>
    </span>
</div>



            <i class='bx bx-right-arrow ok'></i>
        </header>

        <div class="menu-bar">
            <div class="menu">
                <ul class="links">
                    <li class="nav-link">
                        <a href="main-page.php">
                            <i class='bx bx-home icon'></i>
                            <span class="nav-text">Anasayfa</span>
                        </a>
                    </li>
                    <li class="nav-link" id="ai-shortcut">
                        <a href="#">
                            <i class='bx bx-brain icon'></i>
                            <span class="nav-text">AKS AI'a Sor</span>
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="kayit-olustur.php">
                            <i class='bx bx-plus-circle icon'></i>
                            <span class="nav-text">Arıza Kaydı Oluştur</span>
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="ariza-kayitlarim.php">
                            <i class='bx bx-wrench icon'></i>
                            <span class="nav-text">Arıza Kayıtlarım</span>
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="arizakayitlari-teknik.php">
                            <i class='bx bx-wrench icon'></i>
                            <span class="nav-text">Arıza Kayıtları</span>
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="ambar.php">
                            <i class='bx bx-box icon'></i>
                            <span class="nav-text">Malzeme Deposu</span>
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="contact.php">
                            <i class='bx bx-support icon'></i>
                            <span class="nav-text">İletişim</span>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="bottom-content">
            <li class="">
                        <a href="cikis.php">
                            <i class='bx bx-log-out icon'></i>
                            <span class="nav-text">Çıkış</span>
                        </a>
                    </li>
            </div>
        </div>
    </nav>
        <section class="home">
        <div class="dashboard-top-bar">
        <h2 class="page-title">Arıza Kayıt Sistemi</h2>

        <div class="notification-wrapper">
            <button class="notification" id="notificationBtn">
                <i class='bx bx-bell'></i>
                <span class="notification-num"></span>
            </button>

            <div class="notification-dropdown" id="notificationDropdown">
                <h4>Bildirimler</h4>
                <ul>

                </ul>
            </div>
        </div>
    </div>

            <div class="cards">
                <div class="card">
                    <div class="card-content">
                        <div class="number"><?= $toplam ?></div>
                        <div class="card-name">Arıza Kayıtları</div>
                    </div>
                    <div class="icon-box">
                        <i class='bx bx-wrench'></i>
                    </div>
                </div>
                <div class="card">
                    <div class="card-content">
                        <div class="number"><?= $cozuldu ?></div>
                        <div class="card-name">Çözülen Arıza Kayıtları</div>
                    </div>
                    <div class="icon-box">
                        <i class='bx bx-check-circle'></i>
                    </div>
                </div>
                <div class="card">
                    <div class="card-content">
                        <div class="number"><?= $bekleyen ?></div>
                        <div class="card-name">Bekleyen Arıza Kayıtları</div>
                    </div>
                    <div class="icon-box">
                        <i class='bx bx-time'></i>
                    </div>
                </div>
                <div class="card">
                    <div class="card-content">
                        <div class="number"><?= $yonlendirildi ?></div>
                        <div class="card-name">Yönlendirilen Arıza Kayıtları</div>
                    </div>
                    <div class="icon-box">
                        <i class='bx bx-share-alt'></i>
                    </div>

                </div>
            </div>
            <div class="charts">
                <div class="chart">
                    <h2>Haftalık Arıza Grafiği</h2>
                    <canvas id="cizgi"></canvas>
                </div>
                <div class="chart" id="pasta">
                        <h2>Arıza Durumları</h2>
                        <canvas id="pasta-chart"></canvas>
                    </div>
            </div>

            <div class="chatbox-wrapper">
                <div class="chatbox-toggle">
                    <i class='bx  bx-message-dots'></i> 
                </div>
                <div class="chatbox-message-wrapper">
                    <div class="chatbox-message-header">
                        <div class="chatbox-message-profile">
                            <img src="images/wave.png" alt="" class="chatbox-message-image">
                            <div>
                                <h4 class="chatbox-message-name">AKS AI</h4>
                                <div class="chatbox-message-status">Aktif</div>
                            </div>
                        </div>
                    </div>
                    <div class="chatbox-message-content" id="chatbox-messages">
                        
                    </div>
                    <div class="chatbox-message-bottom">
                        <form method="POST" id="chat-form" class="chatbox-message-form">
                            <textarea id="user-input" rows="1" placeholder="Mesaj yaz" class="chatbox-message-input"></textarea>
                            <button type="submit" class="chatbox-message-submit"><i class='bx  bx-send'></i> </button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.9/dist/chart.umd.min.js"></script>
    <script src="chart1.js"></script>
    <script src="chart2.js"></script>
    <script type="text/javascript" src="main.js"></script>

</body>
</html>