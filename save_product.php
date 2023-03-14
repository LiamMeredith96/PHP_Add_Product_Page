<?php

$dbHost = "localhost";
$dbUser = "id20433692_scandiweb_project2";
$dbPass = "io&Vb/CPz&h2j)zF";
$dbName = "id20433692_scnadiweb";


$conn = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName);


if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


$sku = $_POST['sku'];
$name = $_POST['name'];
$price = $_POST['price'];
$productType = $_POST['productType'];


switch ($productType) {
    case 'DVD':
        $size = $_POST['size'];
        $sql = "INSERT INTO dvd (sku, name, price, size) VALUES ('$sku', '$name', '$price', '$size')";
        break;
    case 'Furniture':
        $height = $_POST['height'];
        $width = $_POST['width'];
        $length = $_POST['length'];
        $sql = "INSERT INTO furniture (sku, name, price, height, width, length) VALUES ('$sku', '$name', '$price', '$height', '$width', '$length')";
        break;
    case 'Book':
        $weight = $_POST['weight'];
        $sql = "INSERT INTO book (sku, name, price, weight) VALUES ('$sku', '$name', '$price', '$weight')";
        break;
    default:
     
        break;
}


if ($conn->query($sql) === TRUE) {
    header("Location: index.php");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}


$conn->close();
?>
