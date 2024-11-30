<?php

include 'koneksi.php';

if ($_GET['proses'] == 'insert') {
    $nik = $_POST['nik'];
    $nama_dosen = $_POST['nama_dosen'];
    $email = $_POST['email'];
    $prodi_id = $_POST['prodi_id'];
    $notelp = $_POST['notelp'];
    $alamat = $_POST['alamat'];

    $stmt = $db->prepare("INSERT INTO dosen (nik, nama_dosen, email, prodi_id, notelp, alamat) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$nik, $nama_dosen, $email, $prodi_id, $notelp, $alamat]);

    // Setelah berhasil, arahkan kembali ke halaman list
    header("Location: index.php?p=dosen&aksi=list");
    
}




if ($_GET['proses'] == 'edit') {
    $id = $_POST['id'];
    $nama_dosen = $_POST['nama_dosen'];
    $email = $_POST['email'];
    $prodi_id = $_POST['prodi_id'];
    $notelp = $_POST['notelp'];
    $alamat = $_POST['alamat'];

    $stmt = $db->prepare("UPDATE dosen SET nama_dosen = :nama_dosen, email = :email, prodi_id = :prodi_id, notelp = :notelp, alamat = :alamat WHERE id = :id");
    $stmt->bindParam(':nama_dosen', $nama_dosen);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':prodi_id', $prodi_id);
    $stmt->bindParam(':notelp', $notelp);
    $stmt->bindParam(':alamat', $alamat);
    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
        header("Location: index.php?p=dosen&aksi=list");
    } else {
        echo "Gagal memperbarui data.";
    }
}



if ($_GET['proses'] == 'delete') {
    include 'koneksi.php';

    try {
        // Prepare the DELETE query
        $stmt = $db->prepare("DELETE FROM dosen WHERE id = :id");

        // Bind parameter
        $stmt->bindParam(':id', $_GET['id']);

        // Execute the query
        $stmt->execute();

        header('Location: index.php?p=dosen');
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}
?>
