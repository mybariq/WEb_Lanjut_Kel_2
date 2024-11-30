<?php 
include 'koneksi.php';
$aksi = isset($_GET['aksi']) ? $_GET['aksi'] : 'list';
switch($aksi) {
    case 'list': 
?>
    <section class="content">
                <div class="container">
                <div class="box-header with-border mb-3">
                        <h1 class="h2">Daftar Mahasiswa</h1>
                        <a href="index.php?p=mhs&aksi=input" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Mahasiswa</a>
                    </div>               
                    <div class="table-responsive small">
                        <table class="table table-bordered table-striped table-sm" id="example">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Mahasiswa</th>
                        <th>Tanggal Lahir</th>
                        <th>Email</th>
                        <th>Prodi</th>
                        <th>No Telp</th>
                        <th>Alamat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    try {
                        $stmt = $db->query("SELECT * FROM prodi INNER JOIN mahasiswa ON prodi.id=mahasiswa.prodi_id");
                        $no = 1;
                        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
                ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= htmlspecialchars($data['nama']) ?></td>
                        <td><?= htmlspecialchars($data['tgl_lhr']) ?></td>
                        <td><?= htmlspecialchars($data['email']) ?></td>
                        <td><?= htmlspecialchars($data['nama_prodi']) ?></td>
                        <td><?= htmlspecialchars($data['nohp']) ?></td>
                        <td><?= htmlspecialchars($data['alamat']) ?></td>
                        <td>
                            <a href="index.php?p=mhs&aksi=edit&nim=<?= $data['nim'] ?>" class="btn btn-success"><i class="fas fa-edit"></i> Edit</a>
                            <a href="proses_mahasiswa.php?proses=delete&nim=<?= $data['nim'] ?>" class="btn btn-danger" onclick="return confirm('Yakin mau dihapus?')"><i class="fas fa-trash"></i> Delete</a>
                        </td>
                    </tr>
                <?php
                        }
                    } catch (PDOException $e) {
                        echo "Error: " . $e->getMessage();
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
                <h1>Input Mahasiswa</h1>
            </section>
            <section class="content">
                <div class="container">
                <form action="proses_mahasiswa.php?proses=insert" method="post">
                <div class="mb-3">
                    <label class="form-label">NIM</label>
                    <input type="number" class="form-control" name="nim" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Nama</label>
                    <input type="text" class="form-control" name="nama" required>
                </div>
                <div class="row">
                    <div class="mb-3 col-4">
                        <label class="form-label">Tgl</label>
                        <select class="form-control" name="tgl" required>
                            <option selected>-Tgl-</option>
                            <?php for($i = 1; $i <= 31; $i++) {
                                echo "<option value='$i'>$i</option>";
                            } ?>
                        </select> 
                    </div>
                    <div class="mb-3 col-4">
                        <label class="form-label">Bln</label>
                        <select class="form-control" name="bln" required>
                            <option selected>-Bln-</option>
                            <?php
                                $bulan = [1=>'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                                foreach($bulan as $indexbulan => $namabulan) {
                                    echo "<option value='$indexbulan'>$namabulan</option>";
                                }
                            ?>
                        </select> 
                    </div>
                    <div class="mb-3 col-4">
                        <label class="form-label">Thn</label>
                        <select class="form-control" name="thn" required>
                            <option selected>-Thn-</option>
                            <?php for($i = 2024; $i >= 1900; $i--) {
                                echo "<option value='$i'>$i</option>";
                            } ?>
                        </select> 
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Jenis Kelamin</label><br>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" value="L" name="jekel" required>
                        <label class="form-check-label">Laki-laki</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" value="P" name="jekel" required>
                        <label class="form-check-label">Perempuan</label>
                    </div>
                </div> 
                <div class="mb-3">
                    <label class="form-label">Hobi</label><br>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" value="Membaca" name="hobi[]">
                        <label class="form-check-label">Membaca</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" value="Olahraga" name="hobi[]">
                        <label class="form-check-label">Olahraga</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" value="Travelling" name="hobi[]">
                        <label class="form-check-label">Travelling</label>
                    </div>
                </div>     
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Prodi</label>
                    <select class="form-control" name="id_prodi" required>
                        <option selected>-Pilih Prodi-</option>
                        <?php
                            try {
                                $prodi = $db->query("SELECT * FROM prodi");
                                while ($data_prodi = $prodi->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<option value='".$data_prodi['id']."'>".$data_prodi['nama_prodi']."</option>";
                                }
                            } catch (PDOException $e) {
                                echo "Error: " . $e->getMessage();
                            }
                        ?>
                    </select> 
                </div>
                <div class="mb-3">
                    <label class="form-label">No Telp</label>
                    <input type="number" class="form-control" name="nohp" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Alamat</label>
                    <textarea class="form-control" rows="3" name="alamat" required></textarea>
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
        try {
            $stmt = $db->prepare("SELECT * FROM mahasiswa WHERE nim = :nim");
            $stmt->bindParam(':nim', $_GET['nim'], PDO::PARAM_INT);
            $stmt->execute();
            $data_mhs = $stmt->fetch(PDO::FETCH_ASSOC);
            $tgl = explode("-", $data_mhs['tgl_lhr']);
            $hobies = explode(",", $data_mhs['hobi']);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
?>
    <section class="content-header">
                <h1>Edit Data Mahasiswa</h1>
            </section>
            <section class="content">
                <div class="container">
            <form action="proses_mahasiswa.php?proses=update" method="post">
                <input type="hidden" name="nim" value="<?= $data_mhs['nim'] ?>">
                <div class="mb-3">
                    <label class="form-label">Nama</label>
                    <input type="text" class="form-control" name="nama" value="<?= htmlspecialchars($data_mhs['nama']) ?>" required>
                </div>
                <div class="row">
                    <div class="mb-3 col-4">
                        <label class="form-label">Tgl</label>
                        <select class="form-control" name="tgl" required>
                            <option value="<?= $tgl[2] ?>"><?= $tgl[2] ?></option>
                            <?php for($i = 1; $i <= 31; $i++) {
                                echo "<option value='$i'>$i</option>";
                            } ?>
                        </select> 
                    </div>
                    <div class="mb-3 col-4">
                        <label class="form-label">Bln</label>
                        <select class="form-control" name="bln" required>
                            <?php
                                 $bulan = [1=>'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                                 foreach($bulan as $indexbulan => $namabulan) {
                                     echo "<option value='$indexbulan'>$namabulan</option>";
                                 }
                            ?>
                        </select> 
                    </div>
                    <div class="mb-3 col-4">
                        <label class="form-label">Thn</label>
                        <select class="form-control" name="thn" required>
                            <option value="<?= $tgl[0] ?>"><?= $tgl[0] ?></option>
                            <?php for($i = 2024; $i >= 1900; $i--) {
                                echo "<option value='$i'>$i</option>";
                            } ?>
                        </select> 
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Jenis Kelamin</label><br>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" value="L" name="jekel" <?= $data_mhs['jekel'] == 'L' ? 'checked' : '' ?> required>
                        <label class="form-check-label">Laki-laki</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" value="P" name="jekel" <?= $data_mhs['jekel'] == 'P' ? 'checked' : '' ?> required>
                        <label class="form-check-label">Perempuan</label>
                    </div>
                </div> 
                <div class="mb-3">
                    <label class="form-label">Hobi</label><br>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" value="Membaca" name="hobi[]" <?= in_array("Membaca", $hobies) ? 'checked' : '' ?>>
                        <label class="form-check-label">Membaca</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" value="Olahraga" name="hobi[]" <?= in_array("Olahraga", $hobies) ? 'checked' : '' ?>>
                        <label class="form-check-label">Olahraga</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" value="Travelling" name="hobi[]" <?= in_array("Travelling", $hobies) ? 'checked' : '' ?>>
                        <label class="form-check-label">Travelling</label>
                    </div>
                </div>     
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" value="<?= htmlspecialchars($data_mhs['email']) ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Prodi</label>
                    <select class="form-control" name="id_prodi" required>
                        <option selected>-Pilih Prodi-</option>
                        <?php
                            try {
                                $prodi = $db->query("SELECT * FROM prodi");
                                while ($data_prodi = $prodi->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<option value='".$data_prodi['id']."' ".($data_prodi['id'] == $data_mhs['prodi_id'] ? 'selected' : '').">".$data_prodi['nama_prodi']."</option>";
                                }
                            } catch (PDOException $e) {
                                echo "Error: " . $e->getMessage();
                            }
                        ?>
                    </select> 
                </div>
                <div class="mb-3">
                    <label class="form-label">No Telp</label>
                    <input type="number" class="form-control" name="nohp" value="<?= $data_mhs['nohp'] ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Alamat</label>
                    <textarea class="form-control" rows="3" name="alamat" required><?= $data_mhs['alamat'] ?></textarea>
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
}
?>
