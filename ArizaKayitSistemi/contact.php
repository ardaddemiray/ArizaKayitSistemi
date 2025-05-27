<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>AKS | İletişim</title>
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
    <div class="text">İLETİŞİM BİLGİLERİ</div>
    <div class="contact-container">
        <div class="contact-form">
            <div class="contact-info">
                <h3>İLETİŞİM</h3>
                <p class="contact-text">
                Talep, öneri ve teknik destek ihtiyaçlarınız için bizimle iletişime geçebilirsiniz.
                </p>
                <div class="infos">
                    <div class="information">
                        <img src="images/placeholder.png" class="info-img">
                        <p>Bademlik Mahallesi Şehit Komiser Yardımcısı Selim Sarıkaya Caddesi No: 43/A MERKEZ / KIRKLARELİ 39010</p>
                    </div>
                    <div class="information">
                        <img src="images/mail.png" class="info-img">
                        <p>hm.39@saglik.gov.tr</p>
                    </div>
                    <div class="information">
                        <img src="images/call.png" class="info-img">
                        <p>Dahili: 1108</p>
                    </div>
                </div>

                <div class="social-media">
                    <p>SOSYAL MEDYA ADRESLERİ</p>
                    <div class="social-icon">
                        <a href="#">
                        <i class='bx bxl-instagram'></i>
                        </a>
                        <a href="#">
                        <i class='bx bxl-facebook' ></i>
                        </a>
                        <a href="#">
                        <i class='bx bxl-twitter'></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="location">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2977.21670857177!2d27.215330675662504!3d41.73741837125757!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x40a753152fd7e9b9%3A0x56eacf92a7c9096a!2zS8SxcmtsYXJlbGkgxLBsIFNhxJ9sxLFrIE3DvGTDvHJsw7zEn8O8!5e0!3m2!1str!2str!4v1746709179938!5m2!1str!2str" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
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
</div>
</div>
    <script type="text/javascript" src="main.js"></script>
</body>
</html>