<?php
// Handles saving a new product to the database based on the selected type.

require_once __DIR__ . '/config.php';

$conn = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName);

if (!$conn) {
    http_response_code(500);
    die("Database connection failed: " . mysqli_connect_error());
}

// Basic product data from the form
$sku         = $_POST['sku'] ?? null;
$name        = $_POST['name'] ?? null;
$price       = $_POST['price'] ?? null;
$productType = $_POST['productType'] ?? null;

// Simple guard: if required base fields missing, stop.
if (!$sku || !$name || !$price || !$productType) {
    die("Missing required fields.");
}

switch ($productType) {
    case 'DVD':
        $size = $_POST['size'] ?? null;

        $stmt = $conn->prepare("INSERT INTO dvd (sku, name, price, size) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $sku, $name, $price, $size);
        break;

    case 'Furniture':
        $height = $_POST['height'] ?? null;
        $width  = $_POST['width'] ?? null;
        $length = $_POST['length'] ?? null;

        $stmt = $conn->prepare("INSERT INTO furniture (sku, name, price, height, width, length) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $sku, $name, $price, $height, $width, $length);
        break;

    case 'Book':
        $weight = $_POST['weight'] ?? null;

        $stmt = $conn->prepare("INSERT INTO book (sku, name, price, weight) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $sku, $name, $price, $weight);
        break;

    default:
        die("Invalid product type.");
}

// Execute insert and redirect or show error
if (isset($stmt) && $stmt->execute()) {
    $stmt->close();
    header("Location: index.php");
    exit();
} else {
    echo "Error saving product.";
    if (isset($stmt)) {
        $stmt->close();
    }
}

$conn->close();
?>
