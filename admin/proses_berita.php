<?php
include 'koneksi.php'; // Pastikan sudah mengatur koneksi PDO di sini
session_start();

$target_dir = "upload/";
$nama_file = rand() . '-' . basename($_FILES["fileToUpload"]["name"]);
$target_file = $target_dir . $nama_file;
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

if ($_GET['proses'] == 'insert') {
    if (isset($_POST["submit"])) {
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if ($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["fileToUpload"]["size"] > 5000000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if (
        $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif"
    ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        // If file upload is successful
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            echo "The file " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }

    // Insert into database using PDO
    try {
        $stmt = $db->prepare("INSERT INTO berita (user_id, kategori_id, judul, file_upload, isi_berita) 
                              VALUES (:user_id, :kategori_id, :judul, :file_upload, :isi_berita)");

        $stmt->bindParam(':user_id', $_SESSION['user_id']);
        $stmt->bindParam(':kategori_id', $_POST['kategori_id']);
        $stmt->bindParam(':judul', $_POST['judul']);
        $stmt->bindParam(':file_upload', $nama_file);
        $stmt->bindParam(':isi_berita', $_POST['isi_berita']);

        if ($stmt->execute()) {
            echo "<script>window.location='index.php?p=berita'</script>";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

if ($_GET['proses'] == 'edit') {
    $id = $_POST['id'];
    $judul = $_POST['judul'];
    $kategori_id = $_POST['kategori_id'];
    $isi_berita = $_POST['isi_berita'];
    $file_upload = null;

    // Periksa apakah file baru diunggah
    if (!empty($_FILES['fileToUpload']['name'])) {
        $file_upload = rand() . '-' . basename($_FILES['fileToUpload']['name']);
        $target_file = $target_dir . $file_upload;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Memastikan file adalah gambar
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if ($check !== false) {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                echo "The file " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " has been uploaded.";
            } else {
                echo "Sorry, there was an error uploading your file.";
                $file_upload = null; // Jika gagal upload file, set null
            }
        } else {
            echo "File is not an image.";
            $file_upload = null;
        }
    }

    // Update berita
    if ($file_upload) {
        // Jika ada file baru, hapus file lama (opsional)
        $stmt_old = $db->prepare("SELECT file_upload FROM berita WHERE id = :id");
        $stmt_old->execute([':id' => $id]);
        $old_file = $stmt_old->fetchColumn();
        if ($old_file && file_exists($target_dir . $old_file)) {
            unlink($target_dir . $old_file);
        }

        $query = "UPDATE berita SET judul=:judul, kategori_id=:kategori_id, file_upload=:file_upload, isi_berita=:isi_berita WHERE id=:id";
    } else {
        $query = "UPDATE berita SET judul=:judul, kategori_id=:kategori_id, isi_berita=:isi_berita WHERE id=:id";
    }

    try {
        $stmt = $db->prepare($query);
        $stmt->bindParam(':judul', $judul);
        $stmt->bindParam(':kategori_id', $kategori_id);
        $stmt->bindParam(':isi_berita', $isi_berita);
        $stmt->bindParam(':id', $id);

        if ($file_upload) {
            $stmt->bindParam(':file_upload', $file_upload);
        }

        if ($stmt->execute()) {
            header('Location: index.php?p=berita'); // Redirect ke daftar berita
        } else {
            echo "Failed to update berita!";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}



if ($_GET['proses'] == 'delete') {
    $id = $_GET['id'];
    $file_name = $_GET['file']; // file name from GET request

    try {
        // Query untuk menghapus data berita
        $stmt = $db->prepare("DELETE FROM berita WHERE id=:id");
        $stmt->bindParam(':id', $id);

        if ($stmt->execute()) {
            // Delete the file
            if (file_exists("uploads/" . $file_name)) {
                unlink('uploads/' . $file_name);
            }
            header('Location: index.php?p=berita'); // Redirect ke daftar berita
        } else {
            echo "Failed to delete berita!";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
