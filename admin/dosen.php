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
include 'koneksi.php';
$aksi = isset($_GET['aksi']) ? $_GET['aksi'] : 'list';

switch ($aksi) {
    case 'list':
?>
<section class="content">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">DataTable Dosen</h3>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <div class="mb-3">
          <a href="index.php?p=dosen&aksi=input" class="btn btn-success btn-lg">
            <i class="fas fa-plus-circle"></i> Tambah Dosen
          </a>
        </div>
        <table id="example1" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>No</th>
              <th>NIP</th>
              <th>Nama Dosen</th>
              <th>Email</th>
              <th>Prodi</th>
              <th>No Telepon</th>
              <th>Alamat</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $stmt = $db->prepare("SELECT dosen.*, prodi.namap FROM dosen INNER JOIN prodi ON dosen.prodi_id = prodi.id");
            $stmt->execute();
            $no = 1;
            while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            ?>
              <tr>
                <td><?= $no ?></td>
                <td><?= htmlspecialchars($data['nik']) ?></td>
                <td><?= htmlspecialchars($data['nama_dosen']) ?></td>
                <td><?= htmlspecialchars($data['email']) ?></td>
                <td><?= htmlspecialchars($data['namap']) ?></td>
                <td><?= htmlspecialchars($data['notelp']) ?></td>
                <td><?= htmlspecialchars($data['alamat']) ?></td>
                <td>
                  <a href="index.php?p=dosen&aksi=edit&id=<?= $data['id'] ?>" class="btn btn-success">
                    <i class="bi bi-pencil"></i> Edit
                  </a>
                  <a href="proses_dosen.php?proses=delete&id=<?= $data['id'] ?>" class="btn btn-danger" onclick="return confirm('Yakin dihapus?')">
                    <i class="bi bi-trash"></i> Delete
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
</section>
<?php
break;

case 'input':
?>
<div class="container">
  <div class="row">
    <div class="col-6">
      <h1 class="h2">Input Dosen</h1>
      <form action="proses_dosen.php?proses=insert" method="POST">
        <div class="mb-3">
          <label class="form-label">NIK</label>
          <input type="number" class="form-control" name="nik" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Nama Dosen</label>
          <input type="text" class="form-control" name="nama_dosen" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Email</label>
          <input type="email" class="form-control" name="email" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Prodi</label>
          <select name="prodi_id" class="form-select" required>
            <option value="">- Pilih Prodi -</option>
            <?php
            $stmt = $db->prepare("SELECT * FROM prodi");
            $stmt->execute();
            while ($data_prodi = $stmt->fetch(PDO::FETCH_ASSOC)) {
              echo "<option value='{$data_prodi['id']}'>{$data_prodi['namap']}</option>";
            }
            ?>
          </select>
        </div>
        <div class="mb-3">
          <label class="form-label">No Telepon</label>
          <input type="tel" class="form-control" name="notelp" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Alamat</label>
          <textarea class="form-control" name="alamat" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
        <button type="reset" class="btn btn-secondary">Reset</button>
      </form>
    </div>
  </div>
</div>
<?php
break;

case 'edit':
$id = $_GET['id'];
$stmt = $db->prepare("SELECT * FROM dosen WHERE id = :id");
$stmt->execute([':id' => $id]);
$data_dosen = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<div class="container">
  <h1 class="h2">Edit Dosen</h1>
  <form action="proses_dosen.php?proses=edit" method="POST">
    <input type="hidden" name="id" value="<?= $data_dosen['id'] ?>">
    <div class="mb-3">
      <label class="form-label">NIK</label>
      <input type="number" class="form-control" name="nik" value="<?= htmlspecialchars($data_dosen['nik']) ?>" readonly>
    </div>
    <div class="mb-3">
      <label class="form-label">Nama Dosen</label>
      <input type="text" class="form-control" name="nama_dosen" value="<?= htmlspecialchars($data_dosen['nama_dosen']) ?>">
    </div>
    <div class="mb-3">
      <label class="form-label">Email</label>
      <input type="email" class="form-control" name="email" value="<?= htmlspecialchars($data_dosen['email']) ?>">
    </div>
    <div class="mb-3">
      <label class="form-label">Prodi</label>
      <select name="prodi_id" class="form-select" required>
        <?php
        $stmt = $db->prepare("SELECT * FROM prodi");
        $stmt->execute();
        while ($data_prodi = $stmt->fetch(PDO::FETCH_ASSOC)) {
          $selected = $data_prodi['id'] == $data_dosen['prodi_id'] ? 'selected' : '';
          echo "<option value='{$data_prodi['id']}' $selected>{$data_prodi['namap']}</option>";
        }
        ?>
      </select>
    </div>
    <div class="mb-3">
      <label class="form-label">No Telepon</label>
      <input type="tel" class="form-control" name="notelp" value="<?= htmlspecialchars($data_dosen['notelp']) ?>">
    </div>
    <div class="mb-3">
      <label class="form-label">Alamat</label>
      <textarea class="form-control" name="alamat"><?= htmlspecialchars($data_dosen['alamat']) ?></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
  </form>
</div>
<?php
break;
}
?>
<!-- Include necessary scripts -->
<script src="assets/plugins/jquery/jquery.min.js"></script>
<script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="assets/dist/js/adminlte.min.js"></script>
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
  });
</script>
</body>
</html>
