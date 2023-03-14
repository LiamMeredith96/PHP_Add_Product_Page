<?php


$dbHost = "localhost";
$dbUser = "id20433692_scandiweb_project2";
$dbPass = "io&Vb/CPz&h2j)zF";
$dbName = "id20433692_scnadiweb";

$conn = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName);


if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}


if (isset($_POST['submit'])) {

  $product = $_POST['product'];

  
  foreach ($product as $sku) {
    $sql = "DELETE FROM dvd WHERE sku = '" . $sku . "' ";
    mysqli_query($conn, $sql);
  }

   foreach ($product as $sku) {
    $sql = "DELETE FROM furniture WHERE sku = '" . $sku . "' ";
    mysqli_query($conn, $sql);
  }

 
  foreach ($product as $sku) {
    $sql = "DELETE FROM book WHERE sku = '" . $sku . "' ";;
    mysqli_query($conn, $sql);
  }


  header("Location: index.php");
  exit();
}


mysqli_close($conn);
?>