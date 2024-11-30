<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Level</title>
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
        <h2>Data Level</h2>
        <table id="example" class="display">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Level</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    include 'admin/koneksi.php'; // Include the connection file
                    $stmt = $db->query("SELECT * FROM level"); // Query to fetch data from 'level' table
                    $no = 1;
                    while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
                ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= htmlspecialchars($data['nama_level']) ?></td>
                    <td><?= htmlspecialchars($data['keterangan']) ?></td>
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
