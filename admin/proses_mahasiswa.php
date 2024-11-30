<?php
include 'koneksi.php';

if ($_GET['proses'] == 'insert') {
    $tgl = $_POST['thn'] . '-' . $_POST['bln'] . '-' . $_POST['tgl'];
    $hobies = implode(",", $_POST['hobi']);
    
    try {
        $sql = $db->prepare("INSERT INTO mahasiswa (nim, nama, tgl_lhr, jekel, hobi, email, prodi_id, nohp, alamat) 
                             VALUES (:nim, :nama, :tgl_lhr, :jekel, :hobi, :email, :prodi_id, :nohp, :alamat)");

        $sql->bindParam(':nim', $_POST['nim']);
        $sql->bindParam(':nama', $_POST['nama']);
        $sql->bindParam(':tgl_lhr', $tgl);
        $sql->bindParam(':jekel', $_POST['jekel']);
        $sql->bindParam(':hobi', $hobies);
        $sql->bindParam(':email', $_POST['email']);
        $sql->bindParam(':prodi_id', $_POST['id_prodi']);
        $sql->bindParam(':nohp', $_POST['nohp']);
        $sql->bindParam(':alamat', $_POST['alamat']);

        if ($sql->execute()) {
            echo "<script>window.location='index.php?p=mhs'</script>";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

if ($_GET['proses'] == 'update') {
    $tgl = $_POST['thn'] . '-' . $_POST['bln'] . '-' . $_POST['tgl'];
    $hobies = implode(",", $_POST['hobi']);
    
    try {
        $sql = $db->prepare("UPDATE mahasiswa SET
                             nama = :nama,
                             tgl_lhr = :tgl_lhr,
                             jekel = :jekel,
                             hobi = :hobi,
                             email = :email,
                             prodi_id = :prodi_id,
                             nohp = :nohp,
                             alamat = :alamat
                             WHERE nim = :nim");

        $sql->bindParam(':nama', $_POST['nama']);
        $sql->bindParam(':tgl_lhr', $tgl);
        $sql->bindParam(':jekel', $_POST['jekel']);
        $sql->bindParam(':hobi', $hobies);
        $sql->bindParam(':email', $_POST['email']);
        $sql->bindParam(':prodi_id', $_POST['id_prodi']);
        $sql->bindParam(':nohp', $_POST['nohp']);
        $sql->bindParam(':alamat', $_POST['alamat']);
        $sql->bindParam(':nim', $_POST['nim']);

        if ($sql->execute()) {
            echo "<script>window.location='index.php?p=mhs'</script>";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

if ($_GET['proses'] == 'delete') {
    try {
        $sql = $db->prepare("DELETE FROM mahasiswa WHERE nim = :nim");
        $sql->bindParam(':nim', $_GET['nim']);
        if ($sql->execute()) {
            header('location:index.php?p=mhs'); //redirect
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
