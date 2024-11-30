<?php
include 'koneksi.php';
$aksi = isset($_GET['aksi']) ? $_GET['aksi'] : 'list';

switch ($aksi) {
    case 'list': 
?>
    <section class="content">
                <div class="container">
                <div class="box-header with-border mb-3">
                        <h1 class="h2">Daftar Mata Kuliah</h1>
                        <a href="index.php?p=matkul&aksi=input" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tambah Matakuliah</a>
                </a>
                    </div>
                    <div class="table-responsive small">
                        <table class="table table-bordered table-striped table-sm" id="example">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>ID</th>
                        <th>Kode Matakuliah</th>
                        <th>Nama Matakuliah</th>
                        <th>Semester</th>
                        <th>Jenis Matakuliah</th>
                        <th>SKS</th>
                        <th>Jam</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    $sql = $db->prepare("SELECT * FROM matakuliah");
                    $sql->execute();
                    $no = 1;
                    while ($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $data['id'] ?></td>
                        <td><?= $data['kode_matakuliah'] ?></td>
                        <td><?= $data['nama_matakuliah'] ?></td>
                        <td><?= $data['semester'] ?></td>
                        <td><?= $data['jenis_matakuliah'] ?></td>
                        <td><?= $data['sks'] ?></td>
                        <td><?= $data['jam'] ?></td>
                        <td><?= $data['keterangan'] ?></td>
                        <td>
                            <a href="index.php?p=matkul&aksi=edit&id=<?= $data['id'] ?>" class="btn btn-success"><i class="fas fa-edit"></i> Edit</a>
                            <a href="proses_matakuliah.php?proses=delete&id=<?= $data['id'] ?>" class="btn btn-danger" onclick="return confirm('Yakin mau dihapus?')"><i class="fas fa-trash"></i> Delete</a>
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
                <h1>Input MataKuliah</h1>
            </section>
            <section class="content">
                <div class="container">
                <form action="proses_matkul.php?proses=insert" method="post">
                        <div class="mb-3">
                            <label for="kodeMatakuliah" class="form-label">Kode Matakuliah</label>
                            <input type="text" id="kodeMatakuliah" class="form-control" name="kode_matakuliah" placeholder="Contoh: IF101" required>
                        </div>
                        <div class="mb-3">
                            <label for="namaMatakuliah" class="form-label">Nama Matakuliah</label>
                            <input type="text" id="namaMatakuliah" class="form-control" name="nama_matakuliah" placeholder="Contoh: Algoritma dan Pemrograman" required>
                        </div>
                        <div class="mb-3">
                            <label for="semester" class="form-label">Semester</label>
                            <input type="number" id="semester" class="form-control" name="semester" placeholder="Contoh: 3" required>
                        </div>
                        <div class="mb-3">
                            <label for="jenisMatakuliah" class="form-label">Jenis Matakuliah</label>
                            <select id="jenisMatakuliah" class="form-control" name="jenis_matakuliah" required>
                                <option value="" disabled selected>Pilih Jenis</option>
                                <option value="t">Teori</option>
                                <option value="p">Praktikum</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="sks" class="form-label">SKS</label>
                            <input type="number" id="sks" class="form-control" name="sks" placeholder="Contoh: 3" required>
                        </div>
                        <div class="mb-3">
                            <label for="jam" class="form-label">Jam</label>
                            <input type="number" id="jam" class="form-control" name="jam" placeholder="Contoh: 45" required>
                        </div>
                        <div class="mb-3">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <textarea id="keterangan" class="form-control" name="keterangan" rows="3" placeholder="Tambahkan keterangan tambahan (opsional)"></textarea>
                        </div>
                        <div class="mb-3 text-center">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="index.php?p=matkul" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                    </div>
            </div>
        </div>
     </section>
<?php
    break;

    case 'edit':
        $sql = $db->prepare("SELECT * FROM matakuliah WHERE id = :id");
        $sql->bindParam(':id', $_GET['id']);
        $sql->execute();
        $data = $sql->fetch(PDO::FETCH_ASSOC);
?>
    <section class="content-header">
                <h1>Edit MataKuliah</h1>
            </section>
            <section class="content">
                <div class="container">
            <form action="proses_matakuliah.php?proses=edit" method="post">
                <input type="hidden" name="id" value="<?= $data['id'] ?>">
                <div class="mb-3">
                    <label class="form-label">Kode Matakuliah</label>
                    <input type="text" class="form-control" name="kode_matakuliah" value="<?= $data['kode_matakuliah'] ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Nama Matakuliah</label>
                    <input type="text" class="form-control" name="nama_matakuliah" value="<?= $data['nama_matakuliah'] ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Semester</label>
                    <input type="number" class="form-control" name="semester" value="<?= $data['semester'] ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Jenis Matakuliah</label>
                    <select class="form-control" name="jenis_matakuliah" required>
                        <option value="T" <?= ($data['jenis_matakuliah'] == 'T') ? 'selected' : '' ?>>Teori</option>
                        <option value="P" <?= ($data['jenis_matakuliah'] == 'P') ? 'selected' : '' ?>>Praktikum</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">SKS</label>
                    <input type="number" class="form-control" name="sks" value="<?= $data['sks'] ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Jam</label>
                    <input type="number" class="form-control" name="jam" value="<?= $data['jam'] ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Keterangan</label>
                    <textarea class="form-control" name="keterangan" rows="3"><?= $data['keterangan'] ?></textarea>
                </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
    </section>
<?php
    break;
}
?>
