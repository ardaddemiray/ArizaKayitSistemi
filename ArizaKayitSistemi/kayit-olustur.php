<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>AKS | Arıza Kaydı Oluştur</title>
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

    <div class="home">
    <div class="talep-container">
<form action="ariza-ekle.php" method="POST" enctype="multipart/form-data" class="content-left">
    <input type="text" name="konu" placeholder="Konu" class="talep-input" required>
    
    <select class="talep-input" name="birim_id" required>
    <option value="">Birim Seçin</option>
    <?php
    include 'db-con.php';
    $result = $conn->query("SELECT * FROM birimler");
    while ($row = $result->fetch_assoc()) {
        echo "<option value='{$row['id']}'>{$row['birim_adi']}</option>";
    }
    ?>
    </select>

    <select class="talep-input" name="kategori_id" required>
    <option value="">Kategori Seçin</option>
    <?php
    $result = $conn->query("SELECT * FROM kategoriler");
    while ($row = $result->fetch_assoc()) {
        echo "<option value='{$row['id']}'>{$row['kategori_adi']}</option>";
    }
    ?>
    </select>

    <select class="talep-input" name="teknik_personel_id" required>
    <option value="">Teknik Personel Seçin</option>
    <?php
    $result = $conn->query("SELECT * FROM kullanicilar WHERE rol_id = 1");
    while ($row = $result->fetch_assoc()) {
        echo "<option value='{$row['id']}'>{$row['ad']} {$row['soyad']}</option>";
    }
    ?>
    </select>

    <textarea name="aciklama" placeholder="Açıklama" class="talep-input" required></textarea>

    <input type="file" name="dosya" class="talep-input" accept=".jpg,.png,.pdf">
    
    <button type="submit">Gönder</button>
</form>

      <div class="content-right">
  <div class="info-box">
    <div class="info-box-icon"><i class='bx  bx-info-circle'></i> </div>
    <h3>Arıza Kaydı Oluşturma</h3>
    <p>Lütfen arıza detaylarını eksiksiz ve açık bir şekilde giriniz. Teknik personel en kısa sürede sizinle iletişime geçecektir.</p>
    <ul>
      <li>Doğru birim seçimi yapın</li>
      <li>Görsel belge ekleyin (isteğe bağlı)</li>
      <li>Açıklama kısmına ayrıntı yazın</li>
    </ul>
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
</div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.9/dist/chart.umd.min.js"></script>
    <script src="chart1.js"></script>
    <script src="chart2.js"></script>
    <script type="text/javascript" src="main.js"></script>

</body>
</html>