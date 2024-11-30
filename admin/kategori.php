<?php 
$aksi = isset($_GET['aksi']) ? $_GET['aksi'] : 'list';
switch ($aksi) {
    case 'list':
        include 'koneksi.php';
?>

    <div class="container-fluid">
        <div class="row mb-3">
            <div class="col-sm-6">
                <h1 class="m-0">Kategori</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="index.php?p=kategori&aksi=input" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Kategori</a>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="example">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Kategori</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $query = $db->query("SELECT * FROM kategori");
                        $no = 1;
                        while ($data = $query->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                    <tr>
                        <td><?=$no++?></td>
                        <td><?=$data['nama_kategori']?></td>
                        <td><?=$data['keterangan']?></td>
                        <td>
                            <a href="index.php?p=kategori&aksi=edit&id=<?=$data['id']?>" class="btn btn-success"><i class="fas fa-pencil-alt"></i> Edit</a>
                            <a href="proses_kategori.php?proses=delete&id=<?=$data['id']?>" class="btn btn-danger" onclick="return confirm('Yakin mau dihapus?')"><i class="fas fa-trash"></i> Delete</a>
                        </td>
                    </tr>
                    <?php
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>    

<?php
    break;

    case 'input':    
?>
    <div class="container-fluid">
        <div class="row mb-3">
            <div class="col-sm-12">
                <h1 class="m-0">Input Kategori</h1>
            </div>
        </div>
        <div class="col-8 mx-auto">
            <form action="proses_kategori.php?proses=insert" method="post">
                <div class="mb-3">
                    <label class="form-label">Nama Kategori</label>
                    <input type="text" class="form-control" name="nama_kategori" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Keterangan</label>
                    <input type="text" class="form-control" name="keterangan" required>
                </div>             
                <div class="mb-3">
                    <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                    <button type="reset" class="btn btn-warning" name="reset">Reset</button>
                </div>
                <hr>
            </form>
        </div>
    </div>

<?php
    break;

    case 'edit':
        include 'koneksi.php';
        $stmt = $db->prepare("SELECT * FROM kategori WHERE id = :id");
        $stmt->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
        $stmt->execute();
        $data_kategori = $stmt->fetch(PDO::FETCH_ASSOC);
?>

    <div class="container-fluid">
        <div class="row mb-3">
            <div class="col-sm-12">
                <h1 class="m-0">Edit Kategori</h1>
            </div>
        </div>
        <div class="col-8 mx-auto">
            <form action="proses_kategori.php?proses=edit" method="post">
                <div class="mb-3">
                    <label class="form-label">Nama Kategori</label>
                    <input type="hidden" class="form-control" name="id" value="<?=$data_kategori['id'] ?>">
                    <input type="text" class="form-control" name="nama_kategori" value="<?=$data_kategori['nama_kategori'] ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Keterangan</label>
                    <input type="text" class="form-control" name="keterangan" value="<?=$data_kategori['keterangan'] ?>" required>
                </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-primary" name="submit">Update</button>
                </div>
                <hr>
            </form>
        </div>
    </div>

<?php
    break;
}
?>
