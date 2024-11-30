<?php
include 'koneksi.php';
$aksi = isset($_GET['aksi']) ? $_GET['aksi'] : 'list';

switch ($aksi) {
    case 'list': 
?>
    <div class="container-fluid">
        <div class="row mb-3">
            <div class="col-sm-6">
                <h1 class="m-0">User Data</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="index.php?p=user&aksi=input" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah User</a>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="example">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>ID</th>
                        <th>Email</th>
                        <th>Password</th>
                        <th>Level ID</th>
                        <th>Nama Lengkap</th>
                        <th>Notelp</th>
                        <th>Alamat</th>
                        <th>Photo</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    $stmt = $db->query("SELECT * FROM user");
                    $no = 1;
                    while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
                ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= htmlspecialchars($data['id']) ?></td>
                        <td><?= htmlspecialchars($data['email']) ?></td>
                        <td><?= htmlspecialchars($data['password']) ?></td>
                        <td><?= htmlspecialchars($data['level_id']) ?></td>
                        <td><?= htmlspecialchars($data['nama_lengkap']) ?></td>
                        <td><?= htmlspecialchars($data['notelp']) ?></td>
                        <td><?= htmlspecialchars($data['alamat']) ?></td>
                        <td><img src="<?= htmlspecialchars($data['photo']) ?>" alt="photo" width="50"></td>
                        <td>
                            <a href="index.php?p=user&aksi=edit&id=<?= $data['id'] ?>" class="btn btn-success"><i class="fas fa-edit"></i> Edit</a>
                            <a href="proses_user.php?proses=delete&id=<?= $data['id'] ?>" class="btn btn-danger" onclick="return confirm('Yakin mau dihapus?')"><i class="fas fa-trash"></i> Delete</a>
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
                <h1 class="m-0 text-center">Input Data User</h1>
            </div>
        </div>
        <div class="col-8 mx-auto">
            <div class="card">
                <div class="card-body">
                    <form action="proses_user.php?proses=insert" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" id="email" class="form-control" name="email" placeholder="Contoh: user@example.com" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" id="password" class="form-control" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="level_id" class="form-label">Level ID</label>
                            <input type="number" id="level_id" class="form-control" name="level_id" required>
                        </div>
                        <div class="mb-3">
                            <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                            <input type="text" id="nama_lengkap" class="form-control" name="nama_lengkap" required>
                        </div>
                        <div class="mb-3">
                            <label for="notelp" class="form-label">No Telp</label>
                            <input type="text" id="notelp" class="form-control" name="notelp" required>
                        </div>
                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <textarea id="alamat" class="form-control" name="alamat" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="photo" class="form-label">Photo</label>
                            <input type="file" id="photo" class="form-control" name="photo" accept="image/*">
                        </div>
                        <div class="mb-3 text-center">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="index.php?p=user" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php
    break;

    case 'edit':
        $stmt = $db->prepare("SELECT * FROM user WHERE id=:id");
        $stmt->execute(['id' => $_GET['id']]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
?>
    <div class="container-fluid">
        <div class="row mb-3">
            <div class="col-sm-12">
                <h1 class="m-0">Edit User</h1>
            </div>
        </div>
        <div class="col-8 mx-auto">
            <form action="proses_user.php?proses=edit" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= $data['id'] ?>">
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" value="<?= htmlspecialchars($data['email']) ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" value="<?= htmlspecialchars($data['password']) ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Level ID</label>
                    <input type="number" class="form-control" name="level_id" value="<?= htmlspecialchars($data['level_id']) ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control" name="nama_lengkap" value="<?= htmlspecialchars($data['nama_lengkap']) ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">No Telp</label>
                    <input type="text" class="form-control" name="notelp" value="<?= htmlspecialchars($data['notelp']) ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Alamat</label>
                    <textarea class="form-control" name="alamat" rows="3"><?= htmlspecialchars($data['alamat']) ?></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Photo</label>
                    <input type="file" class="form-control" name="photo" accept="image/*">
                </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
<?php
    break;
}
?>
