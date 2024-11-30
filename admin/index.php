<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>App TI</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css"> <!-- Added Bootstrap Icons -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
</head>
<body>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">APP TI</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link <?=(isset($_GET['p']) && $_GET['p']=='home') ? 'active' : '' ?>" aria-current="page" href="index.php?p=home">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?=(isset($_GET['p']) && $_GET['p']=='mhs') ? 'active' : '' ?>" href="index.php?p=mhs">Mahasiswa</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?=(isset($_GET['p']) && $_GET['p']=='prodi') ? 'active' : '' ?>" href="index.php?p=prodi">Prodi</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?=(isset($_GET['p']) && $_GET['p']=='dosen') ? 'active' : '' ?>" href="index.php?p=dosen">Dosen</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?=(isset($_GET['p']) && $_GET['p']=='matkul') ? 'active' : '' ?>" href="index.php?p=matkul">Mata Kuliah</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Dropdown
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#">Action</a></li>
            <li><a class="dropdown-item" href="#">Another action</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">Something else here</a></li>
          </ul>
        </li>
        <li class="nav-item">
          <a class="nav-link disabled" aria-disabled="true">Disabled</a>
        </li>
      </ul>
      <ul class="navbar-nav mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="login.php"><i class="bi bi-box-arrow-in-right"></i> Login</a> <!-- Box Arrow Right icon added -->
        </li>
    </div>
  </div>
</nav>

<div class="container">
    <?php
    $page = isset($_GET['p']) ? $_GET['p'] : 'home';
    if ($page == 'home') {
        include 'home.php';
    } elseif ($page == 'mhs') {
        include 'mahasiswa.php';
    } elseif ($page == 'prodi') {
        include 'prodi.php';
    } elseif ($page == 'dosen') {
        include 'dosen.php';
    } elseif ($page == 'matkul') {
      include 'matakuliah.php';
  }

    ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  $(document).ready(function() {
    $('#example').DataTable();
  });
</script>
</body>
</html>
