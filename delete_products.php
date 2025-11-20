<?php
// Handles mass deletion of products from the product list.
// Deletes matching SKUs from dvd, furniture, and book tables.

require_once __DIR__ . '/config.php';

$conn = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName);

if (!$conn) {
    http_response_code(500);
    die("Database connection failed: " . mysqli_connect_error());
}

if (isset($_POST['submit']) && !empty($_POST['product'])) {
    $products = $_POST['product'];

    // Prepare delete statements once and reuse.
    $stmtDvd = $conn->prepare("DELETE FROM dvd WHERE sku = ?");
    $stmtFurniture = $conn->prepare("DELETE FROM furniture WHERE sku = ?");
    $stmtBook = $conn->prepare("DELETE FROM book WHERE sku = ?");

    foreach ($products as $sku) {
        // DVDs
        $stmtDvd->bind_param("s", $sku);
        $stmtDvd->execute();

        // Furniture
        $stmtFurniture->bind_param("s", $sku);
        $stmtFurniture->execute();

        // Books
        $stmtBook->bind_param("s", $sku);
        $stmtBook->execute();
    }

    $stmtDvd->close();
    $stmtFurniture->close();
    $stmtBook->close();

    header("Location: index.php");
    exit();
}

mysqli_close($conn);
?>
