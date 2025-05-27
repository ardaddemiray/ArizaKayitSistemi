<?php
session_start();
require 'db-con.php';

if (!isset($_SESSION['kullanici_id'])) {
    header("Location: login.php");
    exit;
}

$ariza_id = $_GET['id'] ?? null;
if (!$ariza_id) {
    die("Arıza ID bulunamadı!");
}

$stmt = $conn->prepare("
    SELECT ak.*, b.birim_adi, k.kategori_adi 
    FROM ariza_kayitlari ak
    JOIN birimler b ON ak.birim_id = b.id
    JOIN kategoriler k ON ak.kategori_id = k.id
    WHERE ak.id = ?
");
$stmt->bind_param("i", $ariza_id);
$stmt->execute();
$ariza = $stmt->get_result()->fetch_assoc();
if (!$ariza) {
    die("Arıza kaydı bulunamadı!");
}

$isCozuldu = ($ariza['durum_id'] ?? null) == 4;

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>AKS | Arıza Detay</title>
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
        <div class="chat-wrapper">
            <div class="chat-container">

                <div class="kullanici-chatbox">
                    <div class="kullanici-chatarea">
                        <strong>📌 Başlık:</strong> <?= htmlspecialchars($ariza['baslik']) ?><br>
                        <strong>📝 Açıklama:</strong> <?= nl2br(htmlspecialchars($ariza['aciklama'])) ?><br>
                        <strong>🏷️ Kategori:</strong> <?= htmlspecialchars($ariza['kategori_adi']) ?><br>
                        <strong>🏢 Birim:</strong> <?= htmlspecialchars($ariza['birim_adi']) ?><br>
                        <?php if (!empty($ariza['dosya_yolu'])): ?>
                            <strong>📎 Ek:</strong>
                            <?php if (preg_match('/\.(jpg|jpeg|png)$/i', $ariza['dosya_yolu'])): ?>
                                <br><img src="<?= $ariza['dosya_yolu'] ?>" alt="Ek Dosya" style="max-width: 200px; margin-top:10px;">
                            <?php else: ?>
                                <a href="<?= $ariza['dosya_yolu'] ?>" target="_blank">Dosyayı Görüntüle</a>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                    <img src="images/user.png" width="50" />
                </div>
            </div>

                    <?php if ($isCozuldu): ?>
            <div class="message-input disabled">
                <input type="text" class="message" value="Sorun çözülmüştür." disabled>
                <button class="gndrbutton" disabled><i class='bx bx-check'></i></button>
            </div>
        <?php else: ?>
            <form class="message-input" action="yorum_ekle.php" method="POST">
                <input type="hidden" name="ariza_id" value="<?= $ariza_id ?>">
                <input type="text" class="message" name="mesaj" placeholder="Mesajınızı yazınız..." required>
                <button type="submit" class="gndrbutton"><i class='bx bx-send'></i></button>
            </form>
        <?php endif; ?>
        </div>
    </section>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.9/dist/chart.umd.min.js"></script>
<script src="chart1.js"></script>
<script src="chart2.js"></script>
<script type="text/javascript" src="main.js"></script>

<!-- AJAX ile yorumları her 5 sn'de bir çek -->
<script>
function yorumlariYukle() {
    const arizaId = <?= $ariza_id ?>;

    fetch("yorumlar_getir.php?ariza_id=" + arizaId)
        .then(res => res.json())
        .then(data => {
            const container = document.querySelector(".chat-container");
            const messages = container.querySelectorAll(".teknik-personel-chatbox, .kullanici-chatbox");
            messages.forEach((msg, index) => {
                if (index > 0) msg.remove();
            });

            data.forEach(yorum => {
                const isTeknik = yorum.rol_id == 1;

                // chatbox div oluştur
                const chatbox = document.createElement("div");
                chatbox.className = isTeknik ? "teknik-personel-chatbox" : "kullanici-chatbox";

                // avatar div
                const avatar = document.createElement("div");
                avatar.className = "avatar";
                avatar.innerHTML = `<img src="images/${isTeknik ? 'admin' : 'user'}.png" />`;

                // mesaj div
                const chatarea = document.createElement("div");
                chatarea.className = isTeknik ? "teknik-personel-chatarea" : "kullanici-chatarea";
                chatarea.innerHTML = yorum.mesaj.replace(/\n/g, '<br>');

                // Teknik personel: avatar + mesaj | Kullanıcı: mesaj + avatar
                if (isTeknik) {
                    chatbox.appendChild(avatar);
                    chatbox.appendChild(chatarea);
                } else {
                    chatbox.appendChild(chatarea);
                    chatbox.appendChild(avatar);
                }

                container.appendChild(chatbox);
            });

            container.scrollTop = container.scrollHeight;
        });
}

yorumlariYukle();
setInterval(yorumlariYukle, 5000);
</script>


</body>
</html>


