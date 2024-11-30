<?php 
include 'koneksi.php';
$aksi = isset($_GET['aksi']) ? $_GET['aksi'] : 'list';

switch($aksi) {
    case 'list': 
?>
    <div class="container-fluid">
        <div class="row mb-3">
            <div class="col-sm-6">
                <h1 class="m-0">Prodi</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="index.php?p=prodi&aksi=input" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Prodi</a>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="example">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Prodi</th>
                        <th>Jenjang Prodi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    $query = $db->query("SELECT * FROM prodi");
                    $no = 1;
                    while($data = $query->fetch(PDO::FETCH_ASSOC)) {
                ?>
                    <tr>
                        <td><?=$no++?></td>
                        <td><?=htmlspecialchars($data['nama_prodi'])?></td>
                        <td><?=htmlspecialchars($data['jenjang_std'])?></td>
                        <td>
                            <a href="index.php?p=prodi&aksi=edit&id=<?=htmlspecialchars($data['id'])?>" class="btn btn-success"><i class="fas fa-edit"></i> Edit</a>
                            <a href="proses_prodi.php?proses=delete&id=<?=htmlspecialchars($data['id'])?>" class="btn btn-danger" onclick="return confirm('Yakin mau dihapus?')"><i class="fas fa-trash"></i> Delete</a>
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
                <h1 class="m-0">Input Prodi</h1>
            </div>
        </div>
        <div class="col-8 mx-auto">
            <form action="proses_prodi.php?proses=insert" method="post">
                <div class="mb-3">
                    <label class="form-label">Nama Prodi</label>
                    <input type="text" class="form-control" name="nama_prodi" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Jenjang</label>
                    <select class="form-select" name="jenjang" required>
                        <option selected disabled>~ Pilih Jenjang ~</option>
                        <?php
                            $jenjang = ['D3', 'D4', 'S1', 'S2'];
                            foreach ($jenjang as $jenjangprodi) {
                                echo "<option value='$jenjangprodi'>$jenjangprodi</option>";
                            }
                        ?>
                    </select> 
                </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                    <button type="reset" class="btn btn-warning" name="reset">Reset</button>
                </div>
            </form>
        </div>
    </div>
<?php
    break;

    case 'edit':
        $stmt = $db->prepare("SELECT * FROM prodi WHERE id = :id");
        $stmt->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
        $stmt->execute();
        $data_prodi = $stmt->fetch(PDO::FETCH_ASSOC);
?>
    <div class="container-fluid">
        <div class="row mb-3">
            <div class="col-sm-12">
                <h1 class="m-0">Edit Prodi</h1>
            </div>
        </div>
        <div class="col-8 mx-auto">
            <form action="proses_prodi.php?proses=edit" method="post">
                <div class="mb-3">
                    <label class="form-label">Nama Prodi</label>
                    <input type="hidden" class="form-control" name="id" value="<?=htmlspecialchars($data_prodi['id'])?>">
                    <input type="text" class="form-control" name="nama_prodi" value="<?=htmlspecialchars($data_prodi['nama_prodi'])?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Jenjang</label>
                    <select class="form-select" name="jenjang" required>
                        <option selected disabled>~ Pilih Jenjang ~</option>
                        <?php
                            $jenjang = ['D3', 'D4', 'S1', 'S2'];
                            foreach ($jenjang as $jenjangprodi) {
                                $selected = ($data_prodi['jenjang_std'] == $jenjangprodi) ? 'selected' : ''; 
                                echo "<option value='$jenjangprodi' $selected>$jenjangprodi</option>";
                            }
                        ?>
                    </select> 
                </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-primary" name="submit">Update</button>
                </div>
            </form>
        </div>
    </div>
<?php
    break;
}
?>
