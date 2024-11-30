<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mahasiswa</title>
    <!-- Include AdminLTE CSS -->
    <link rel="stylesheet" href="path/to/adminlte.min.css">
    <!-- Include DataTables CSS -->
    <link rel="stylesheet" href="path/to/jquery.dataTables.min.css">
    <style>
        /* Custom styles for better presentation */
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border: 1px solid #ddd;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Data Mahasiswa</h2>
        <table id="example" class="display">
            <thead>
                <tr>
                    <th>No</th>
                    <th>NIM</th>
                    <th>Nama Mahasiswa</th>
                    <th>Email</th>
                    <th>Prodi</th>
                    <th>No Telp</th>
                    <th>Alamat</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    // Include PDO connection
                    include 'admin/koneksi.php';

                    // Define the SQL query using PDO
                    $query = "SELECT mahasiswa.nim, mahasiswa.nama, mahasiswa.email, mahasiswa.nohp, mahasiswa.alamat, prodi.nama_prodi 
                              FROM prodi 
                              INNER JOIN mahasiswa ON prodi.id = mahasiswa.prodi_id";
                    
                    // Prepare and execute the query
                    $stmt = $db->prepare($query);
                    $stmt->execute();

                    // Fetch the results
                    $no = 1;
                    while ($data_mhs = $stmt->fetch(PDO::FETCH_ASSOC)) {
                ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= htmlspecialchars($data_mhs['nim']) ?></td>
                    <td><?= htmlspecialchars($data_mhs['nama']) ?></td>
                    <td><?= htmlspecialchars($data_mhs['email']) ?></td>
                    <td><?= htmlspecialchars($data_mhs['nama_prodi']) ?></td>
                    <td><?= htmlspecialchars($data_mhs['nohp']) ?></td>
                    <td><?= htmlspecialchars($data_mhs['alamat']) ?></td>
                </tr>
                <?php
                    }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Include jQuery -->
    <script src="path/to/jquery.min.js"></script>
    <!-- Include DataTables JS -->
    <script src="path/to/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#example').DataTable(); // Initialize DataTable
        });
    </script>
</body>
</html>
