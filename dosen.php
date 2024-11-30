<h2>Data Dosen</h2>
<table id="example" class="table table-striped table-bordered">
    
    <thead>
        <tr>
            <th>No</th>
            <th>NIP</th>
            <th>Nama Dosen</th>
            <th>Email</th>
            <th>Prodi</th>
            <th>No Telepon</th>
            <th>Alamat</th>
        </tr>
    </thead>
    <tbody>
        <?php
        include 'admin/koneksi.php';

        // Gunakan PDO untuk query
        $stmt = $db->prepare("SELECT dosen.*, prodi.namap FROM dosen INNER JOIN prodi ON dosen.prodi_id = prodi.id");
        $stmt->execute();
        
        $no = 1;
        while ($data_mhs = $stmt->fetch(PDO::FETCH_ASSOC)) {
            ?>
            <tr>
                <td><?= $no ?></td>
                <td><?= htmlspecialchars($data_mhs['nik']) ?></td>
                <td><?= htmlspecialchars($data_mhs['nama_dosen']) ?></td>
                <td><?= htmlspecialchars($data_mhs['email']) ?></td>
                <td><?= htmlspecialchars($data_mhs['namap']) ?></td>
                <td><?= htmlspecialchars($data_mhs['notelp']) ?></td>
                <td><?= htmlspecialchars($data_mhs['alamat']) ?></td>
            </tr>
            <?php
            $no++;
        }
        ?>
    </tbody>
</table>

<script>
    $(document).ready(function () {
        $('#example').DataTable(); // Mengaktifkan DataTables
    });
</script>
