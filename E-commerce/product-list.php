<?php
include 'koneksi.php';

// Jika ada filter kategori
$kategori = isset($_GET['kategori']) ? $_GET['kategori'] : "";

// Query default
$query = "SELECT * FROM products";

// Jika kategori dipilih
if ($kategori != "") {
    $query .= " WHERE category = '$kategori'";
}

$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Product List</title>
</head>
<body>

<h2>Daftar Produk</h2>

<!-- FILTER KATEGORI -->
<form method="GET" action="">
    <label>Pilih Kategori:</label>
    <select name="kategori">
        <option value="">Semua</option>
        <option value="fashion" <?php if($kategori=="fashion") echo "selected"; ?>>Fashion</option>
        <option value="elektronik" <?php if($kategori=="elektronik") echo "selected"; ?>>Elektronik</option>
        <option value="rumah" <?php if($kategori=="rumah") echo "selected"; ?>>Perabot Rumah</option>
    </select>

    <button type="submit">Filter</button>
</form>

<hr>

<!-- TAMPILKAN DATA PRODUK -->
<?php
if(mysqli_num_rows($result) > 0){
    while($row = mysqli_fetch_assoc($result)){
        echo "<h3>" . $row['nama_produk'] . "</h3>";
        echo "<p>Harga: Rp " . $row['harga'] . "</p>";
        echo "<p>Deskripsi: " . $row['deskripsi'] . "</p>";
        echo "<p>Kategori: " . $row['category'] . "</p>";
        echo "<hr>";
    }
} else {
    echo "Tidak ada produk ditemukan.";
}
?>

</body>
</html>