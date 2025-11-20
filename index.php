<?php
// Main product listing page: shows all products (DVD, Furniture, Book)
// and allows mass delete (MASS DELETE button).

require_once __DIR__ . '/config.php';

$conn = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName);

if (!$conn) {
    http_response_code(500);
    die("Database connection failed: " . mysqli_connect_error());
}
?>

<html>
<head>
    <title>Product List</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
    <div class="header">
        <h1>Product List</h1>
    </div>

    <hr>

    <!-- Form for mass deleting selected products -->
    <form method="post" action="delete_products.php" onsubmit="return checkSelected(event);">
        <div class="contentposition">
            <?php
            // Union all products into a single result set, with a normalised "size" column
            // that contains either MB, dimensions, or weight.
            $sql = "
                SELECT * FROM (
                    SELECT 'dvd' AS type, sku, name, price, CONCAT(size, 'MB') AS size, date_added
                    FROM dvd
                    UNION ALL
                    SELECT 'furniture' AS type, sku, name, price,
                           CONCAT('Dimension: ', height, 'x', width, 'x', length) AS size, date_added
                    FROM furniture
                    UNION ALL
                    SELECT 'book' AS type, sku, name, price, CONCAT(weight, 'KG') AS size, date_added
                    FROM book
                ) AS all_products
                ORDER BY date_added DESC
            ";

            $result = mysqli_query($conn, $sql);

            while ($row = mysqli_fetch_assoc($result)) {
                echo "<table style='position: relative;' class='box'>";
                echo "<tr>";
                echo "<th><input type='checkbox' class='delete-checkbox' name='product[]' value='" . htmlspecialchars($row['sku'], ENT_QUOTES, 'UTF-8') . "'></th>";
                echo "</tr>";

                echo "<tr class='productview'>";
                echo "<td>" . htmlspecialchars($row['sku'], ENT_QUOTES, 'UTF-8') . "</td>";
                echo "<td>" . htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8') . "</td>";
                echo "<td>" . htmlspecialchars($row['price'], ENT_QUOTES, 'UTF-8') . "$</td>";

                // Display the normalised "size"/attribute column for each product.
                if (!empty($row['size'])) {
                    echo "<td>" . htmlspecialchars($row['size'], ENT_QUOTES, 'UTF-8') . "</td>";
                }

                echo "</tr>";
                echo "</table>";
            }

            mysqli_close($conn);
            ?>
        </div>

        <!-- Buttons for adding a new product and mass delete -->
        <button type="button" onclick="window.location.href='add_product.php'">ADD</button>
        <button type="submit" name="submit">MASS DELETE</button>
    </form>

    <script>
        // Ensures at least one checkbox is selected before allowing mass delete.
        function checkSelected(event) {
            var checkboxes = document.getElementsByClassName('delete-checkbox');
            var isChecked = false;

            for (var i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i].checked) {
                    isChecked = true;
                    break;
                }
            }

            if (!isChecked) {
                alert("Please select at least one product to delete.");
                event.preventDefault();
                return false;
            }

            return true;
        }
    </script>
</body>
</html>
