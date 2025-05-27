<?php
session_start();
require 'db-con.php';

if (!isset($_SESSION['kullanici_id']) || $_SESSION['rol_id'] != 1) {
    header("Location: main-page.php");
    exit;
}

$where = [];

if (!empty($_GET['durum_id'])) {
    $durum_id = intval($_GET['durum_id']);
    $where[] = "ak.durum_id = $durum_id";
}

if (!empty($_GET['birim_id'])) {
    $birim_id = intval($_GET['birim_id']);
    $where[] = "ak.birim_id = $birim_id";
}

if (!empty($_GET['tarih1']) && !empty($_GET['tarih2'])) {
    $t1 = $_GET['tarih1'];
    $t2 = $_GET['tarih2'];
    $where[] = "DATE(ak.olusturulma_tarihi) BETWEEN '$t1' AND '$t2'";
}

$kayit_sayisi = 10;
$sayfa = isset($_GET['sayfa']) ? max(1, intval($_GET['sayfa'])) : 1;
$offset = ($sayfa - 1) * $kayit_sayisi;

$sql_toplam = "SELECT COUNT(*) AS toplam FROM ariza_kayitlari ak";
if (!empty($where)) {
    $sql_toplam .= " WHERE " . implode(" AND ", $where);
}
$result_toplam = $conn->query($sql_toplam);
$toplam_kayit = $result_toplam->fetch_assoc()['toplam'];
$toplam_sayfa = ceil($toplam_kayit / $kayit_sayisi);

$sql = "SELECT ak.*, 
               k.ad AS kullanici_ad, 
               k.soyad AS kullanici_soyad, 
               b.birim_adi, 
               d.durum_adi
        FROM ariza_kayitlari ak
        JOIN kullanicilar k ON ak.kullanici_id = k.id
        JOIN birimler b ON ak.birim_id = b.id
        JOIN durumlar d ON ak.durum_id = d.id";
if (!empty($where)) {
    $sql .= " WHERE " . implode(" AND ", $where);
}
$sql .= " ORDER BY ak.olusturulma_tarihi DESC LIMIT $offset, $kayit_sayisi";
$kayitlar = $conn->query($sql);

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
<!DOCTYPE html>
<html lang="en">
<head>
	<title>AKS | Arıza Kayıtları</title>
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
        <div class="ariza-kayit-table-wrapper">
    <div class="ariza-kayit-header">
  <h2 class="table-title">Arıza Kayıtları Yönetimi</h2>
 <input type="text" id="searchInput" class="ariza-search-input" placeholder="Arıza ara">

  <form method="GET" class="filter-form">

    <select name="durum_id" class="filter-select">
      <option value="">Tüm Durumlar</option>
      <?php
      $durumlar = $conn->query("SELECT * FROM durumlar");
      while ($d = $durumlar->fetch_assoc()) {
          $selected = isset($_GET['durum_id']) && $_GET['durum_id'] == $d['id'] ? 'selected' : '';
          echo "<option value='{$d['id']}' $selected>{$d['durum_adi']}</option>";
      }
      ?>
    </select>

    <select name="birim_id" class="filter-select">
      <option value="">Tüm Birimler</option>
      <?php
      $birimler = $conn->query("SELECT * FROM birimler");
      while ($b = $birimler->fetch_assoc()) {
          $selected = isset($_GET['birim_id']) && $_GET['birim_id'] == $b['id'] ? 'selected' : '';
          echo "<option value='{$b['id']}' $selected>{$b['birim_adi']}</option>";
      }
      ?>
    </select>

    <input type="date" name="tarih1" value="<?= $_GET['tarih1'] ?? '' ?>" class="filter-date">
    <input type="date" name="tarih2" value="<?= $_GET['tarih2'] ?? '' ?>" class="filter-date">

    <button type="submit" class="detay-btn">Filtrele</button>
  </form>
</div>


    <table class="ariza-kayit-table">
        <thead>
        <tr>
            <th>#</th>
            <th>Başlık</th>
            <th>Birim</th>
            <th>Kullanıcı</th>
            <th>Tarih</th>
            <th>Durum</th>
            <th>İşlem</th>
            <th>Durum Güncelleme</th>
        </tr>
        </thead>
        <tbody id="ariza-table-body">
        <?php if ($kayitlar->num_rows > 0): ?>
            <?php while ($row = $kayitlar->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= htmlspecialchars($row['baslik']) ?></td>
                    <td><?= htmlspecialchars($row['birim_adi']) ?></td>
                    <td><?= $row['kullanici_ad'] . ' ' . $row['kullanici_soyad'] ?></td>
                    <td><?= date("d M Y", strtotime($row['olusturulma_tarihi'])) ?></td>
                    <td>
                        <span class="durum-badge <?= getDurumClass($row['durum_adi']) ?>">
                            <?= htmlspecialchars($row['durum_adi']) ?>
                        </span>
                    </td>
                    <td>
                        <a href="ariza-detay.php?id=<?= $row['id'] ?>" class="detay-btn">Detay</a>
                    </td>
                    <td>
                        <button class="durum-guncelle-btn" 
                        data-id="<?= $row['id'] ?>" 
                        data-durum="<?= $row['durum_adi'] ?>">Durum Güncelle</button>
                    </td>

                    
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="8" style="text-align:center;">Kayıt bulunamadı.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
    <div class="ariza-pagination">
    <?php if ($sayfa > 1): ?>
        <a href="?sayfa=<?= $sayfa - 1 ?>" class="page-btn"><i class='bx bxs-chevron-left'></i></a>
    <?php endif; ?>

    <?php for ($i = 1; $i <= $toplam_sayfa; $i++): ?>
        <a href="?sayfa=<?= $i ?>" class="page-btn <?= $i == $sayfa ? 'active' : '' ?>"><?= $i ?></a>
    <?php endfor; ?>

    <?php if ($sayfa < $toplam_sayfa): ?>
        <a href="?sayfa=<?= $sayfa + 1 ?>" class="page-btn"><i class='bx bxs-chevron-right'></i></a>
    <?php endif; ?>
</div>

    </div>
    <div id="durumModal" class="modal" style="display:none;">
  <div class="modal-content">
    <span class="close">&times;</span>
    <h3>Durum Güncelle</h3>
    <form id="durumForm">
      <input type="hidden" name="ariza_id" id="modal_ariza_id">
      <select name="durum_id" id="modal_durum_id">
        <option value="1">Beklemede</option>
        <option value="2">İşlemde</option>
        <option value="3">Çözüldü</option>
        <option value="4">Yönlendirildi</option>
      </select>
      <button type="submit">Kaydet</button>
    </form>
  </div>
</div>

        </section>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.9/dist/chart.umd.min.js"></script>
    <script src="chart1.js"></script>
    <script src="chart2.js"></script>
    <script type="text/javascript" src="main.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.querySelector('.ariza-search-input');
    const tableRows = document.querySelectorAll('#ariza-table-body tr');

    if (searchInput) {
        searchInput.addEventListener('input', () => {
            const query = searchInput.value.toLowerCase();
            tableRows.forEach(row => {
                const rowText = row.textContent.toLowerCase();
                row.style.display = rowText.includes(query) ? '' : 'none';
            });
        });
    }

    // Durum güncelleme butonları
    document.querySelectorAll('.durum-guncelle-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const modal = document.getElementById("durumModal");
            document.getElementById("modal_ariza_id").value = btn.dataset.id;
            modal.style.display = "flex";
        });
    });

    const closeBtn = document.querySelector(".modal .close");
    if (closeBtn) {
        closeBtn.addEventListener("click", () => {
            document.getElementById("durumModal").style.display = "none";
        });
    }

    // Modal form gönderimi
    const durumForm = document.getElementById("durumForm");
    if (durumForm) {
        durumForm.addEventListener("submit", function(e) {
            e.preventDefault();
            const formData = new FormData(this);

            fetch("durum-guncelle.php", {
                method: "POST",
                body: formData
            }).then(res => res.text()).then(msg => {
                alert("Durum güncellendi.");
                location.reload();
            });
        });
    }
});
</script>

              
</body>
</html>