<?php
// KONEKSI DATABASE
$conn = mysqli_connect("localhost", "root", "", "ecommerce");

if (!$conn) {
  die("Koneksi gagal: " . mysqli_connect_error());
}

// --- FILTER KATEGORI ---
$filterKategori = isset($_GET['kategori']) ? $_GET['kategori'] : 'all';

// --- FILTER HARGA ---
$filterHarga = isset($_GET['harga']) ? $_GET['harga'] : 'none';

// --- SEARCH ---
$search = isset($_GET['search']) ? $_GET['search'] : '';

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
<div class="container py-4">
  <h2 class="text-center mb-4">Daftar Produk</h2>

  <!-- FILTER FORM (GET) -->
  <form method="GET">
    <div class="row mb-4">

      <!-- FILTER KATEGORI -->
      <div class="col-md-3">
        <label class="form-label">Filter Kategori</label>
        <select name="kategori" class="form-select">
          <option value="all">Semua Kategori</option>
          <option value="fashion">Fashion</option>
          <option value="kecantikan">Kecantikan</option>
          <option value="elektronik">Elektronik</option>
        </select>
      </div>

      <!-- FILTER HARGA -->
      <div class="col-md-3">
        <label class="form-label">Urutkan Harga</label>
        <select name="harga" class="form-select">
          <option value="none">Tanpa Urutan</option>
          <option value="asc">Harga Terendah</option>
          <option value="desc">Harga Tertinggi</option>
        </select>
      </div>

      <!-- SEARCH -->
      <div class="col-md-6">
        <label class="form-label">Cari Produk</label>
        <input type="text" name="search" class="form-control" placeholder="Cari nama produk...">
      </div>
    </div>

    <button class="btn btn-primary mb-3">Terapkan Filter</button>
  </form>

  <!-- LIST PRODUK -->
  <div class="row">
    <?php
    if (mysqli_num_rows($result) === 0) {
      echo "<p class='text-center text-muted'>Produk tidak ditemukan</p>";
    }

    while ($p = mysqli_fetch_assoc($result)) {
      echo "
      <div class='col-md-4 mb-4'>
        <div class='card shadow-sm'>
          <img src='{$p['image']}' class='card-img-top' alt='produk'>
          <div class='card-body'>
            <h5 class='card-title'>{$p['name']}</h5>
            <p class='card-text'>{$p['description']}</p>
            <p class='fw-bold text-primary'>Rp " . number_format($p['price']) . "</p>
            <span class='badge bg-secondary'>{$p['category']}</span>
          </div>
        </div>
      </div>
      ";
    }
    ?>
  </div>
</div>
</body>
</html>