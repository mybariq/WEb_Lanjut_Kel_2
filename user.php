<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data User</title>
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
        <h2>Data User</h2>
        <table id="example" class="display">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Email</th>
                    <th>Nama Lengkap</th>
                    <th>Nomor Telepon</th>
                    <th>Alamat</th>
                    <th>Level ID</th>
                    <th>Photo</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    include 'admin/koneksi.php';

                    try {
                        $stmt = $db->prepare("SELECT * FROM user");
                        $stmt->execute();
                        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        $no = 1;

                        foreach ($users as $data_user) {
                ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= htmlspecialchars($data_user['email']) ?></td>
                    <td><?= htmlspecialchars($data_user['nama_lengkap']) ?></td>
                    <td><?= htmlspecialchars($data_user['notelp']) ?></td>
                    <td><?= htmlspecialchars($data_user['alamat']) ?></td>
                    <td><?= htmlspecialchars($data_user['level_id']) ?></td>
                    <td>
                        <?php if (!empty($data_user['photo'])): ?>
                            <img src="uploads/<?= htmlspecialchars($data_user['photo']) ?>" alt="Photo" width="50">
                        <?php else: ?>
                            Tidak ada foto
                        <?php endif; ?>
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
