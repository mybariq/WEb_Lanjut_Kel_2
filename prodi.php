<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Prodi</title>
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
        <h2>Data Prodi</h2>
        <table id="example" class="display">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Prodi</th>
                    <th>Jenjang Prodi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    // PDO Database Connection
                    try {
                        $db = new PDO('mysql:host=localhost;dbname=db_mahasiswa', 'root', '');
                        // Set the PDO error mode to exception
                        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                        // Fetch data using PDO
                        $query = "SELECT * FROM prodi";
                        $stmt = $db->prepare($query);
                        $stmt->execute();
                        $prodi = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        $no = 1;
                        foreach ($prodi as $data_prodi) {
                ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= htmlspecialchars($data_prodi['nama_prodi']) ?></td>
                    <td><?= htmlspecialchars($data_prodi['jenjang_std']) ?></td>
                </tr>
                <?php
                        }
                    } catch (PDOException $e) {
                        echo "Connection failed: " . $e->getMessage();
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
