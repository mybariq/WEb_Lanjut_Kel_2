<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | DataTables</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="assets/plugins/fontawesome-free/css/all.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="assets/dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini">
<?php
include 'koneksi.php'; // Pastikan koneksi database menggunakan PDO
$aksi = isset($_GET['aksi']) ? $_GET['aksi'] : 'list';
switch ($aksi) {
    case 'list':
        // Tampilkan halaman list
?>
<div class="content-wrapper" style="padding-left: 0; margin-left: 0;">
    <section class="content-header">
        <h1>Berita</h1>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row mb-3">
                <div class="col-2">
                    <a href="index.php?p=berita&aksi=input" class="btn btn-primary">
                        <i class="fa fa-plus"></i> Tambah Berita
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-bordered table-striped" id="example1">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Judul</th>
                                        <th>Kategori</th>
                                        <th>User</th>
                                        <th>Tanggal</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $query = "SELECT berita.id, berita.judul, kategori.nama_kategori, user.email, berita.created_at 
                                              FROM berita 
                                              JOIN user ON user.id = berita.user_id 
                                              JOIN kategori ON kategori.id = berita.kategori_id";
                                    $stmt = $db->query($query);
                                    $no = 1;
                                    while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    ?>
                                    <tr>
                                        <td><?= $no ?></td>
                                        <td><?= htmlspecialchars($data['judul']) ?></td>
                                        <td><?= htmlspecialchars($data['nama_kategori']) ?></td>
                                        <td><?= htmlspecialchars($data['email']) ?></td>
                                        <td><?= htmlspecialchars($data['created_at']) ?></td>
                                        <td>
                                            <a href="index.php?p=berita&aksi=edit&id=<?= $data['id'] ?>" class="btn btn-success btn-sm">
                                                <i class="fa fa-pencil"></i> Edit
                                            </a>
                                            <a href="proses_berita.php?proses=delete&id=<?= $data['id'] ?>" 
                                                class="btn btn-danger btn-sm" onclick="return confirm('Yakin akan menghapus data?')">
                                                <i class="fa fa-trash"></i> Delete
                                            </a>
                                        </td>
                                    </tr>
                                    <?php
                                        $no++;
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?php
        break;

    case 'edit':
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        if (!$id) {
            die("ID tidak ditemukan.");
        }

        // Ambil data berdasarkan ID
        $stmt = $db->prepare("SELECT * FROM berita WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$data) {
            die("Data dengan ID $id tidak ditemukan.");
        }
?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>Edit Berita</h1>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Form Edit Berita</h3>
                </div>
                <form action="proses_berita.php?proses=edit" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($data['id']) ?>">
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Judul</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="judul" value="<?= htmlspecialchars($data['judul']) ?>" required autofocus>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Kategori</label>
                            <div class="col-sm-10">
                                <select name="kategori_id" class="form-control" required>
                                    <option value="">-Pilih kategori-</option>
                                    <?php
                                    $stmt_kategori = $db->query("SELECT * FROM kategori");
                                    while ($data_kategori = $stmt_kategori->fetch(PDO::FETCH_ASSOC)) {
                                        $selected = $data_kategori['id'] == $data['kategori_id'] ? "selected" : "";
                                        echo "<option value='" . $data_kategori['id'] . "' $selected>" . htmlspecialchars($data_kategori['nama_kategori']) . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">File Upload</label>
                            <div class="col-sm-10">
                                <input type="file" name="fileToUpload" class="form-control" id="file-upload">
                                <?php if (!empty($data['file_upload'])): ?>
                                <img src="upload/<?= htmlspecialchars($data['file_upload']) ?>" alt="Preview" id="file-preview" style="margin-top:10px;" width="150">
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Berita</label>
                            <div class="col-sm-10">
                                <textarea name="isi_berita" class="form-control" rows="5" required><?= htmlspecialchars($data['isi_berita']) ?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <button type="reset" class="btn btn-warning">Reset</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
<?php
        break;
}
?>


<script>
document.getElementById('file-upload').addEventListener('change', function() {
    const file = this.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('file-preview').src = e.target.result;
        };
        reader.readAsDataURL(file);
    }
});
</script>

<!-- jQuery -->
<script src="assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables -->
<script src="assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="assets/dist/js/adminlte.min.js"></script>

<script>
$(function () {
    $("#example1").DataTable({
        "responsive": true,
        "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
});
</script>
</body>
</html>
