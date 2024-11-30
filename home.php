<h1>Berita</h1>

<div class="row">
    <?php
        include 'admin/koneksi.php';
        // Using PDO to select data from the database
        try {
            $stmt = $db->query("SELECT * FROM berita ORDER BY id DESC");
            $berita_list = isset($_GET['berita']) ? $_GET['berita'] : 'list';

            // Fetch all rows at once to avoid looping within the query execution
            $berita_data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            foreach ($berita_data as $berita) {
                if ($berita_list == 'list') {
    ?>
    <div class="col-4">
        <div class="card" style="width: 18rem;">
        <img src="admin/uploads/<?= htmlspecialchars($berita['file_upload']) ?>" class="card-img-top" alt="...">
        <div class="card-body">
            <h5 class="card-title"><?= htmlspecialchars($berita['judul']) ?></h5>
            <p class="card-text"><?= htmlspecialchars(substr($berita['isi_berita'], 0, 150)) ?></p>
            <a href="index.php?p=home&berita=more&id=<?= $berita['id'] ?>" class="btn btn-primary">Readmore...</a>
        </div>
        </div>
    </div>
    <?php
                }
                else if ($berita_list == 'more' ) {
    ?>
    <div class="card">
        <img src="admin/uploads/<?= htmlspecialchars($berita['file_upload']) ?>" class="card-img-top" alt="...">
        <div class="card-body">
            <h5 class="card-title"><?= htmlspecialchars($berita['judul']) ?></h5>
            <p class="card-text"><?= htmlspecialchars($berita['isi_berita']) ?></p>
            <a href="index.php?p=home" class="btn btn-primary">Back</a>
        </div>
    </div>
    <?php
                }
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    ?>
</div>
