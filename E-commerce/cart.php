<?php
session_start();
include 'db.php';

// Jika cart belum ada → buat array kosong
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// =============================
// 1. TAMBAH PRODUK via POST
// =============================
if (isset($_POST['product_id'])) {
    $id = $_POST['product_id'];
    $qty = isset($_POST['qty']) ? (int)$_POST['qty'] : 1;

    if (!isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id] = $qty;
    } else {
        $_SESSION['cart'][$id] += $qty;
    }

    header("Location: cart.php");
    exit();
}

// =============================
// 2. TAMBAH PRODUK via GET
// =============================
if (isset($_GET['add'])) {
    $id = intval($_GET['add']);

    if (!isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id] = 1;
    } else {
        $_SESSION['cart'][$id]++;
    }
    header("Location: cart.php");
    exit;
}

// =============================
// 3. UPDATE QTY
// =============================
if (isset($_POST['update'])) {
    $id = intval($_POST['product_id']);
    $qty = intval($_POST['quantity']);

    if ($qty <= 0) {
        unset($_SESSION['cart'][$id]);
    } else {
        $_SESSION['cart'][$id] = $qty;
    }
    header("Location: cart.php");
    exit;
}

// =============================
// 4. HAPUS ITEM
// =============================
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    unset($_SESSION['cart'][$id]);
    header("Location: cart.php");
    exit;
}
?>
<!doctype html>
<html>
<head>
    <title>Keranjang Belanja</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">

    <a class="navbar-brand" href="index.php">My E-Commerce</a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>

        <li class="nav-item">
          <a class="nav-link position-relative" href="cart.php">
            Cart
            <span class="badge bg-danger position-absolute top-0 start-100 translate-middle">
              <?= array_sum($_SESSION['cart']) ?>
            </span>
          </a>
        </li>
      </ul>
    </div>

  </div>
</nav>

<div class="container py-4">
    <h2 class="mb-4">Keranjang Belanja</h2>

    <?php if (empty($_SESSION['cart'])): ?>
        <div class="alert alert-warning text-center">Keranjang masih kosong.</div>
    <?php else: ?>

        <table class="table table-bordered bg-white">
            <thead class="table-secondary">
                <tr>
                    <th>Produk</th>
                    <th>Harga</th>
                    <th>Qty</th>
                    <th>Subtotal</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                <?php
                $total = 0;

                foreach ($_SESSION['cart'] as $id => $qty):
                    $product = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM products WHERE id=$id"));
                    $subtotal = $product['price'] * $qty;
                    $total += $subtotal;
                ?>
                <tr>
                    <td><?= $product['name'] ?></td>
                    <td>Rp <?= number_format($product['price']) ?></td>

                    <!-- EDIT QTY -->
                    <td>
                        <form method="POST" class="d-flex">
                            <input type="hidden" name="product_id" value="<?= $id ?>">
                            <input type="number" name="quantity" value="<?= $qty ?>" min="1" class="form-control w-50 me-2">
                            <button type="submit" name="update" class="btn btn-primary btn-sm">Update</button>
                        </form>
                    </td>

                    <td>Rp <?= number_format($subtotal) ?></td>

                    <td>
                        <a href="cart.php?delete=<?= $id ?>"
                           class="btn btn-danger btn-sm"
                           onclick="return confirm('Hapus produk dari keranjang?')">
                           Hapus
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h4 class="mt-3">Total: Rp <?= number_format($total) ?></h4>

        <a href="index.php" class="btn btn-secondary mt-3">Kembali Belanja</a>

    <?php endif; ?>
</div>
</body>
</html>