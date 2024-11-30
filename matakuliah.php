<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Matakuliah</title>
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
<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <div class="container-fluid">
                <h2 class="text-center my-3">Data Matakuliah</h2>
                <div class="table-responsive">
                    <table id="example" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Kode Matakuliah</th>
                                <th>Nama Matakuliah</th>
                                <th>Semester</th>
                                <th>Jenis</th>
                                <th>SKS</th>
                                <th>Jam</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                include 'admin/koneksi.php';

                                // Prepare the query using PDO
                                $query = $db->prepare("SELECT * FROM matakuliah");
                                $query->execute();

                                // Fetch all the records
                                $no = 1;
                                while ($data = $query->fetch(PDO::FETCH_ASSOC)) {
                            ?>
                            <tr>
                                <td><?= htmlspecialchars($data['id']) ?></td>
                                <td><?= htmlspecialchars($data['kode_matakuliah']) ?></td>
                                <td><?= htmlspecialchars($data['nama_matakuliah']) ?></td>
                                <td><?= htmlspecialchars($data['semester']) ?></td>
                                <td><?= $data['jenis_matakuliah'] == 't' ? 'Teori' : 'Praktikum' ?></td>
                                <td><?= htmlspecialchars($data['sks']) ?></td>
                                <td><?= htmlspecialchars($data['jam']) ?></td>
                                <td><?= htmlspecialchars($data['keterangan']) ?></td>
                            </tr>
                            <?php
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Include jQuery -->
    <script src="path/to/jquery.min.js"></script>
    <!-- Include DataTables JS -->
    <script src="path/to/jquery.dataTables.min.js"></script>
    <!-- Include AdminLTE JS -->
    <script src="path/to/adminlte.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#example').DataTable(); // Initialize DataTable
        });
    </script>
</body>
</html>
