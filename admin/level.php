<?php
require_once 'koneksi.php';

$aksi = isset($_GET['aksi']) ? $_GET['aksi'] : 'list';
switch($aksi) {
    case 'list':
        // Display the list of levels
?>
    <section class="content">
                <div class="container">
                <div class="box-header with-border mb-3">
                <h1 class="h2">Level</h1>
                <a href="index.php?p=level&aksi=input" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Level</a>
                </a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-sm" id="example">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Level</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    $stmt = $db->query("SELECT * FROM level");
                    $no = 1;
                    while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
                ?>
                    <tr>
                        <td><?=$no++?></td>
                        <td><?=$data['nama_level']?></td>
                        <td><?=$data['keterangan']?></td>
                        <td>
                            <a href="index.php?p=level&aksi=edit&id=<?=$data['id']?>" class="btn btn-success"><i class="fas fa-edit"></i> Edit</a>
                            <a href="proses_level.php?proses=delete&id=<?=$data['id']?>" class="btn btn-danger" onclick="return confirm('Yakin mau dihapus?')"><i class="fas fa-trash"></i> Delete</a>
                        </td>
                    </tr>
                <?php
                    }
                ?>
                 </tbody>
                        </table>
                    </div>
                </div>
            </section>
<?php
    break;

    case 'input':
?>
      <section class="content-header">
                <h1>Input Kategori</h1>
            </section>
            <section class="content">
                <div class="container">
                <form action="proses_level.php?proses=insert" method="post">
                <div class="mb-3">
                    <label class="form-label">Nama Level</label>
                    <input type="text" class="form-control" name="nama_level" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Keterangan</label>
                    <textarea class="form-control" rows="3" name="keterangan" required></textarea>
                </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                    <button type="reset" class="btn btn-warning" name="reset">Reset</button>
                </div>
                <hr>
            </form>
        </div>
    </div>
    </section>
<?php
    break;

    case 'edit':
        // Check if 'id' is passed via GET parameter
        if (isset($_GET['id'])) {
            $id = $_GET['id']; // Get the 'id' from URL
    
            // Query to fetch the level data by id
            $query = "SELECT * FROM level WHERE id = :id";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT); // Bind 'id' to the query
            $stmt->execute();
    
            // Fetch the data for the given id
            $data_level = $stmt->fetch(PDO::FETCH_ASSOC);
    
            // Check if data was found
            if (!$data_level) {
                echo "<p>Level not found!</p>";
                exit;
            }
        } else {
            echo "<p>Invalid request. ID is missing.</p>";
            exit;
        }
    ?>
     <section class="content-header">
                <h1>Edit Level</h1>
            </section>
            <section class="content">
                <div class="container">
                <form action="proses_level.php?proses=edit" method="post">
                <div class="mb-3">
                    <label class="form-label">ID</label>
                    <input type="text" class="form-control" name="id" value="<?= htmlspecialchars($data_level['id']) ?>" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label">Nama Level</label>
                    <input type="text" class="form-control" name="nama_level" value="<?= htmlspecialchars($data_level['nama_level']) ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Keterangan</label>
                    <textarea class="form-control" rows="3" name="keterangan" required><?= htmlspecialchars($data_level['keterangan']) ?></textarea>
                </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-primary" name="submit">Update</button>
                    <button type="reset" class="btn btn-warning" name="reset">Reset</button>
                </div>
                <hr>
            </form>
        </div>
    </div>
    </section>
    <?php
    break;
}
?>
