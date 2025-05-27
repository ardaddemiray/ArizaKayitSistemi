<?php
session_start();
require 'db-con.php';

if (!isset($_SESSION['kullanici_id'])) {
    header("Location: login.php");
    exit;
}

$kullanici_id = $_SESSION['kullanici_id'];

$sql = "SELECT ak.*, 
               b.birim_adi, 
               d.durum_adi, 
               k.ad AS teknik_ad, 
               k.soyad AS teknik_soyad
        FROM ariza_kayitlari ak
        LEFT JOIN birimler b ON ak.birim_id = b.id
        LEFT JOIN durumlar d ON ak.durum_id = d.id
        LEFT JOIN kullanicilar k ON ak.teknik_personel_id = k.id
        WHERE ak.kullanici_id = ?
        ORDER BY ak.olusturulma_tarihi DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $kullanici_id);
$stmt->execute();
$sonuc = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>AKS | Arıza Kayıtlarım</title>
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
        <?php echo $_SESSION['ad'] . ' ' . $_SESSION['soyad']; ?>
    </span>
    <span class="birim">
        <?php
            if ($_SESSION['rol_id'] == 1) {
                echo "Teknik Personel";
            } else {
                echo "Personel";
            }
        ?>
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
        <h2 class="page-title">AKS - KAYITLARIM</h2>

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
        <div class="ariza-kayit-table-wrapper">
            <div class="ariza-kayit-header">
                <h2>Arıza Kayıtlarım</h2>
            </div>
            <table class="ariza-kayit-table">
                <thead>
                    <tr>
                        <th>Başlık</th>
                        <th>Birim</th>
                        <th>Durum</th>
                        <th>Teknik Personel</th>
                        <th>Tarih</th>
                        <th>Dosya</th>
                        <th>Detay</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($sonuc->num_rows > 0): ?>
                        <?php
                        function getDurumClass($durum) {
                            $siniflar = [
                                'Beklemede' => 'beklemede',
                                'İşlemde' => 'islemde',
                                'Çözüldü' => 'cozuldu',
                                'Yönlendirildi' => 'yonlendirildi'
                            ];
                            return $siniflar[$durum] ?? '';
                        }
                        ?>
                        <?php while ($row = $sonuc->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['baslik']) ?></td>
                                <td><?= htmlspecialchars($row['birim_adi']) ?></td>
                                <td>
                                    <span class="durum-badge <?= getDurumClass($row['durum_adi']) ?>">
                                        <?= htmlspecialchars($row['durum_adi']) ?>
                                    </span>
                                </td>
                                <td><?= $row['teknik_ad'] . ' ' . $row['teknik_soyad'] ?></td>
                                <td><?= date("d.m.Y H:i", strtotime($row['olusturulma_tarihi'])) ?></td>
                                <td>
                                    <?php if (!empty($row['dosya_yolu'])): ?>
                                        <a href="<?= $row['dosya_yolu'] ?>" target="_blank" class="detay-btn">Görüntüle</a>
                                    <?php else: ?>
                                        <span style="color: gray;">Yok</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="ariza-detay.php?id=<?= $row['id'] ?>" class="detay-btn">Detay</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" style="text-align: center;">Hiç kayıt bulunamadı.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
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