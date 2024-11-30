<?php
include 'koneksi.php';

if ($_GET['proses'] == 'insert') {
    // Prepare SQL statement for inserting data
    $sql = $db->prepare("INSERT INTO matakuliah (kode_matakuliah, nama_matakuliah, semester, jenis_matakuliah, sks, jam, keterangan) 
                         VALUES (:kode_matakuliah, :nama_matakuliah, :semester, :jenis_matakuliah, :sks, :jam, :keterangan)");

    // Bind the values from POST to the prepared statement
    $sql->bindParam(':kode_matakuliah', $_POST['kode_matakuliah']);
    $sql->bindParam(':nama_matakuliah', $_POST['nama_matakuliah']);
    $sql->bindParam(':semester', $_POST['semester']);
    $sql->bindParam(':jenis_matakuliah', $_POST['jenis_matakuliah']);
    $sql->bindParam(':sks', $_POST['sks']);
    $sql->bindParam(':jam', $_POST['jam']);
    $sql->bindParam(':keterangan', $_POST['keterangan']);

    // Execute the query
    if ($sql->execute()) {
        echo "<script>window.location='index.php?p=matkul'</script>";
    }
}

if ($_GET['proses'] == 'edit') {
    // Prepare SQL statement for updating data
    $sql = $db->prepare("UPDATE matakuliah SET
                         kode_matakuliah = :kode_matakuliah,
                         nama_matakuliah = :nama_matakuliah,
                         semester = :semester,
                         jenis_matakuliah = :jenis_matakuliah,
                         sks = :sks,
                         jam = :jam,
                         keterangan = :keterangan
                         WHERE id = :id");

    // Bind the values from POST to the prepared statement
    $sql->bindParam(':kode_matakuliah', $_POST['kode_matakuliah']);
    $sql->bindParam(':nama_matakuliah', $_POST['nama_matakuliah']);
    $sql->bindParam(':semester', $_POST['semester']);
    $sql->bindParam(':jenis_matakuliah', $_POST['jenis_matakuliah']);
    $sql->bindParam(':sks', $_POST['sks']);
    $sql->bindParam(':jam', $_POST['jam']);
    $sql->bindParam(':keterangan', $_POST['keterangan']);
    $sql->bindParam(':id', $_POST['id']);

    // Execute the query
    if ($sql->execute()) {
        echo "<script>window.location='index.php?p=matkul'</script>";
    }
}

if ($_GET['proses'] == 'delete') {
    // Prepare SQL statement for deleting data
    $sql = $db->prepare("DELETE FROM matakuliah WHERE id = :id");

    // Bind the id parameter
    $sql->bindParam(':id', $_GET['id']);

    // Execute the query
    if ($sql->execute()) {
        header('Location: index.php?p=matkul'); // Redirect
    }
}
?>
