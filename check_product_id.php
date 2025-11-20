<?php
// Checks whether a given SKU already exists in any of the product tables.
// Returns "exists" or "not_exists" for the AJAX call in add_product.php.

$sku = $_POST["sku"] ?? null;

if ($sku === null || $sku === '') {
    echo "not_exists";
    exit;
}

require_once __DIR__ . '/config.php';

$conn = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName);

if (!$conn) {
    http_response_code(500);
    die("Database connection failed: " . mysqli_connect_error());
}

// Check if SKU exists in any table (dvd, furniture, book)
$sql = "
    SELECT sku FROM (
        SELECT sku FROM book
        UNION
        SELECT sku FROM dvd
        UNION
        SELECT sku FROM furniture
    ) AS all_skus
    WHERE sku = ?
    LIMIT 1
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $sku);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    echo "exists";
} else {
    echo "not_exists";
}

$stmt->close();
$conn->close();
?>
