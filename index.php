<?php


$dbHost = "localhost";
$dbUser = "id20433692_scandiweb_project2";
$dbPass = "io&Vb/CPz&h2j)zF";
$dbName = "id20433692_scnadiweb";


$conn = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName);


if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>

<html>
<head>
    <title>Product List</title>
</head>
<link rel="stylesheet" type="text/css" href="css/style.css">
<body>
    <div class="header">
        <h1>Product List</h1>        
    </div>

    <hr>

    <form method="post" action="delete_products.php">
        <div class="contentposition">
           
            <?php
    
                $sql = "SELECT * FROM (
                            SELECT 'dvd' AS type, sku, name, price, CONCAT(size, 'MB') AS size, date_added FROM dvd
                            UNION ALL
                            SELECT 'furniture' AS type, sku, name, price, CONCAT('Dimension: ', height, 'x', width, 'x', length) AS size, date_added FROM furniture
                            UNION ALL
                            SELECT 'book' AS type, sku, name, price, CONCAT(weight, 'KG') AS size, date_added FROM book
                        ) AS all_products
                        ORDER BY date_added DESC";
                $result = mysqli_query($conn, $sql);

                while ($row = mysqli_fetch_assoc($result)) {
        echo "<table  style='position: relative;' class='box'>";
        echo "<tr>";
        echo "<th><input type='checkbox' class='delete-checkbox' name='product[]' value='" . $row['sku'] . "'></th>";       
        echo "</tr>";       
        echo "<tr class='productview'>";
        echo "<td>" . $row['sku'] . "</td>";
        echo "<td>" . $row['name'] . "</td>";
        echo "<td>" . $row['price'] . "$</td>";
        
        if (!empty($row['size'])) {
            echo "<td>" . $row['size'] . "</td>";
        } else {
            echo "";
        }

        if (!empty($row['height']) && !empty($row['width']) && !empty($row['length']))  {
            echo "<td>Dimension: " . $row['height'] . "x" . $row['width'] . "x" . $row['length'] . "</td>";
        } else {
            echo "";
        }
       
        if (!empty($row['weight'])) {
            echo "<td>" . $row['weight'] . "</td>";
        } else {
            echo "";
        }
        echo "</tr>";
        echo "</table>";
      }

          
    ?>
                </div>
                <button type="button" onclick="window.location.href='add-product.php'">ADD</button>
                <button type="submit" name="submit" onclick="checkSelected()">MASS DELETE</button>
  
</form>

<?php

mysqli_close($conn);
?>
<script>
function checkSelected() {
  var checkboxes = document.getElementsByClassName('delete-checkbox');
  var isChecked = false;
  for (var i = 0; i < checkboxes.length; i++) {
    if (checkboxes[i].checked) {
      isChecked = true;
      break;
    }
  }
  if (!isChecked) {

    event.preventDefault();
  }
}
</script>
</body>
</html>
