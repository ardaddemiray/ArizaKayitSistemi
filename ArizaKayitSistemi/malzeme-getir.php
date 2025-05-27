<?php
require 'db-con.php';

$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;
$arama = isset($_GET['q']) ? $_GET['q'] : '';

if (!empty($arama)) {
    $sql = "SELECT COUNT(*) as toplam FROM malzemeler WHERE tur LIKE ? OR marka LIKE ? OR model LIKE ?";
    $stmt = $conn->prepare($sql);
    $likeArama = "%" . $arama . "%";
    $stmt->bind_param("sss", $likeArama, $likeArama, $likeArama);
} else {
    $sql = "SELECT COUNT(*) as toplam FROM malzemeler";
    $stmt = $conn->prepare($sql);
}

$stmt->execute();
$result = $stmt->get_result();
$toplam_kayit = $result->fetch_assoc()['toplam'];
$toplam_sayfa = ceil($toplam_kayit / $limit);

if (!empty($arama)) {
    $sql = "SELECT * FROM malzemeler 
            WHERE tur LIKE ? OR marka LIKE ? OR model LIKE ? 
            LIMIT ? OFFSET ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssii", $likeArama, $likeArama, $likeArama, $limit, $offset);
} else {
    $sql = "SELECT * FROM malzemeler LIMIT ? OFFSET ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $limit, $offset);
}

$stmt->execute();
$data = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

echo json_encode([
    'malzemeler' => $data,
    'toplam_sayfa' => $toplam_sayfa
]);
?>
