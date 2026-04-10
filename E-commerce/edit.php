<?php include 'db.php'; ?>

<?php
$id = $_GET['id'];
$product = mysqli_query($conn, "SELECT * FROM products WHERE id=$id");
$p = mysqli_fetch_assoc($product);

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $category = $_POST['category'];
    $image = $_POST['image'];

    mysqli_query($conn, "UPDATE products SET 
        name='$name',
        description='$description',
        price='$price',
        stock='$stock',
        category='$category',
        image='$image'
        WHERE id=$id
    ");

    header("Location: index.php");
}
?>