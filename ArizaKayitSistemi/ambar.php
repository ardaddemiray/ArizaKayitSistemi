<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>AKS | Malzeme Deposu</title>
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
    <div class="table">
        <div class="table_header">
            <p>Malzemeler</p>
            <div>
                <input class="urun-ara"placeholder="Ürün ara">
                <button class="add_new">Ürün ekle +</button>
            </div>
        </div>
        <div class="table_section">
            <table class="ambar-table">
                <thead>
                    <tr>
                        <th>Ürün No</th>
                        <th>Tür</th>
                        <th>Marka</th>
                        <th>Model</th>
                        <th>Adet</th>
                        <th>Stok Arttır/Azalt</th>

                    </tr>
                </thead>
                <tbody id="malzeme-tablosu">
                    
                </tbody>
            </table>
        </div>
    <div class="pagination"></div>

<div id="urunEkleModal" class="modal" style="display:none;">
  <div class="modal-content">
    <span id="modalKapat" class="modal-close">&times;</span>
    <h3>Yeni Ürün Ekle</h3>
    <form id="urunEkleForm">
      <input type="text" name="tur" placeholder="Tür" required><br>
      <input type="text" name="marka" placeholder="Marka" required><br>
      <input type="text" name="model" placeholder="Model" required><br>
      <input type="number" name="adet" placeholder="Adet" required><br>
      <button type="submit">Ekle</button>
    </form>
  </div>
</div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.9/dist/chart.umd.min.js"></script>
    <script src="chart1.js"></script>
    <script src="chart2.js"></script>
    <script type="text/javascript" src="main.js"></script>
    <script src="ambar.js"></script>

</body>
</html>