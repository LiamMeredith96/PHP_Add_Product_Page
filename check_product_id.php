<?php
    $sku = $_POST["sku"];


  $dbHost = "localhost";
  $dbUser = "id20433692_scandiweb_project2";
  $dbPass = "io&Vb/CPz&h2j)zF";
  $dbName = "id20433692_scnadiweb";


$conn = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName);


if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

    
$sql = "SELECT sku FROM book
UNION
SELECT sku FROM dvd
UNION
SELECT sku FROM furniture";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
while($row = $result->fetch_assoc()) {
if ($row['sku'] == $sku) {
    echo "exists";
    break;
}
}
} else {
echo "not_exists";
}

    $conn->close();
?>
