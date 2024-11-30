<?php
include 'koneksi.php';

if ($_GET['proses'] == 'insert') {
    // Prepare the INSERT query
    $stmt = $db->prepare("INSERT INTO level (nama_level, keterangan) VALUES (:nama_level, :keterangan)");
    
    // Bind parameters
    $stmt->bindParam(':nama_level', $_POST['nama_level'], PDO::PARAM_STR);
    $stmt->bindParam(':keterangan', $_POST['keterangan'], PDO::PARAM_STR);
    
    // Execute the query
    if ($stmt->execute()) {
        echo "<script>window.location = 'index.php?p=level';</script>";
    }

} elseif ($_GET['proses'] == 'edit') {
    // Prepare the UPDATE query
    $stmt = $db->prepare("UPDATE level SET nama_level = :nama_level, keterangan = :keterangan WHERE id = :id");
    
    // Bind parameters
    $stmt->bindParam(':nama_level', $_POST['nama_level'], PDO::PARAM_STR);
    $stmt->bindParam(':keterangan', $_POST['keterangan'], PDO::PARAM_STR);
    $stmt->bindParam(':id', $_POST['id'], PDO::PARAM_INT);
    
    // Execute the query
    if ($stmt->execute()) {
        echo "<script>window.location = 'index.php?p=level';</script>";
    }

} elseif ($_GET['proses'] == 'delete') {
    // Prepare the DELETE query
    $stmt = $db->prepare("DELETE FROM level WHERE id = :id");
    
    // Bind the id parameter
    $stmt->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
    
    // Execute the query
    if ($stmt->execute()) {
        echo "<script>window.location = 'index.php?p=level';</script>";
    }
}
?>
