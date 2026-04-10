<?php
session_start();

// KONEKSI DATABASE
$conn = mysqli_connect("localhost", "root", "", "ecommerce");

if (!$conn) {
  die("Koneksi gagal: " . mysqli_connect_error());
}

// --- FILTER KATEGORI ---
$filterKategori = $_GET['kategori'] ?? 'all';

// --- FILTER HARGA ---
$filterHarga = $_GET['harga'] ?? 'none';

// --- SEARCH ---
$search = $_GET['search'] ?? '';

// QUERY DASAR
$query = "SELECT * FROM products WHERE 1";

// FILTER KATEGORI
if ($filterKategori !== "all") {
  $query .= " AND category = '$filterKategori'";
}

// SEARCH
if ($search !== "") {
  $query .= " AND name LIKE '%$search%'";
}

// FILTER HARGA
if ($filterHarga === "asc") {
  $query .= " ORDER BY price ASC";
} elseif ($filterHarga === "desc") {
  $query .= " ORDER BY price DESC";
}

$result = mysqli_query($conn, $query);
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Daftar Produk</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<!-- ================= NAVBAR ================ -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">

    <a class="navbar-brand" href="index.php">My E-Commerce</a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">

        <li class="nav-item">
          <a class="nav-link" href="index.php">Home</a>
        </li>

        <li class="nav-item">
          <a class="nav-link position-relative" href="cart.php">
            Cart
            <span class="badge bg-danger position-absolute top-0 start-100 translate-middle">
              <?= isset($_SESSION['cart']) ? array_sum($_SESSION['cart']) : 0; ?>
            </span>
          </a>
        </li>

      </ul>
    </div>

  </div>
</nav>

<div class="container py-4">
  <h2 class="text-center mb-4">Daftar Produk</h2>

  <!-- FILTER FORM -->
  <form method="GET">
    <div class="row mb-4">
      <div class="col-md-3">
        <label class="form-label">Filter Kategori</label>
        <select name="kategori" class="form-select">
          <option value="all">Semua Kategori</option>
          <option value="fashion">Fashion</option>
          <option value="kecantikan">Kecantikan</option>
          <option value="elektronik">Elektronik</option>
        </select>
      </div>

      <div class="col-md-3">
        <label class="form-label">Urutkan Harga</label>
        <select name="harga" class="form-select">
          <option value="none">Tanpa Urutan</option>
          <option value="asc">Harga Terendah</option>
          <option value="desc">Harga Tertinggi</option>
        </select>
      </div>

      <div class="col-md-6">
        <label class="form-label">Cari Produk</label>
        <input type="text" name="search" class="form-control" placeholder="Cari nama produk...">
      </div>
    </div>

    <button class="btn btn-primary mb-3">Terapkan Filter</button>
  </form>

  <!-- LIST PRODUK -->
  <div class="row">
    <?php if (mysqli_num_rows($result) === 0): ?>
      <p class='text-center text-muted'>Produk tidak ditemukan</p>
    <?php endif; ?>

    <?php while ($p = mysqli_fetch_assoc($result)): ?>
      <div class='col-md-4 mb-4'>
        <div class='card shadow-sm'>
          <img src='<?= $p['image'] ?>' class='card-img-top'>

          <div class='card-body'>
            <h5 class='card-title'><?= $p['name'] ?></h5>
            <p class='card-text'><?= $p['description'] ?></p>
            <p class='fw-bold text-primary'>Rp <?= number_format($p['price']) ?></p>
            <span class='badge bg-secondary'><?= $p['category'] ?></span>

            <!-- ADD TO CART -->
           <form action="cart.php" method="POST" class="mt-3">
                <input type="hidden" name="product_id" value="<?= $p['id']; ?>">

                <div class="input-group mb-2">
                    <input type="number" name="qty" class="form-control" value="1" min="1">
                </div>

                <button type="submit" class="btn btn-success w-100">
                    Tambah ke Keranjang
                </button>
            </form>

          </div>
        </div>
      </div>
    <?php endwhile; ?>
  </div>
</div>

</body>
</html>