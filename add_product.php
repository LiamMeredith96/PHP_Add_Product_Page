<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Add Product</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="header">
        <h1>Add Product</h1>
    </div>
    <hr/>

    <!-- Main product form -->
    <form name="form" id="product_form" method="post" action="save_product.php">
        <div class="formcontainer">
            <div class="container">

                <!-- Basic product fields -->
                <label for="sku"><strong>SKU</strong></label>
                <input type="text" id="sku" name="sku">

                <label for="name"><strong>Name</strong></label>
                <input type="text" id="name" name="name">

                <label for="price"><strong>Price</strong></label>
                <input type="text" id="price" name="price">

                <!-- Product type selector -->
                <label for="product"><strong>Product Type</strong></label>
                <select id="productType" name="productType">
                    <option value="0">Switch Type</option>
                    <option value="DVD">DVD</option>
                    <option value="Furniture">Furniture</option>
                    <option value="Book">Book</option>
                </select>

                <!-- DVD-specific inputs -->
                <div id="DVD">
                    <label for="size"><strong>Size (MB)</strong></label>
                    <input type="text" id="size" name="size">
                    <p>Please provide DVD size in MB</p>
                </div>

                <!-- Furniture-specific inputs -->
                <div id="Furniture">
                    <label for="height"><strong>Height (CM)</strong></label>
                    <input type="text" id="height" name="height">

                    <label for="width"><strong>Width (CM)</strong></label>
                    <input type="text" id="width" name="width">

                    <label for="length"><strong>Length (CM)</strong></label>
                    <input type="text" id="length" name="length">
                    <p>Please provide dimensions in HxWxL format</p>
                </div>

                <!-- Book-specific inputs -->
                <div id="Book">
                    <label for="weight"><strong>Weight (KG)</strong></label>
                    <input type="text" id="weight" name="weight">
                    <p>Please provide book weight in KG</p>
                </div>

            </div>

            <!-- Form actions -->
            <button type="submit" name="submit">Save</button>
            <button type="button" onclick="window.location.href='index.php'">CANCEL</button>
        </div>
    </form>

    <script>
        $(document).ready(function () {
            // Map product type -> corresponding detail section
            $.viewMap = {
                '0': $([]),
                'DVD': $('#DVD'),
                'Furniture': $('#Furniture'),
                'Book': $('#Book')
            };

            // Show/hide the attribute fields when product type changes
            $('#productType').change(function () {
                $.each($.viewMap, function () {
                    this.hide();
                });

                $.viewMap[$(this).val()].show();
            }).change(); // Trigger once on load to set initial state


            // Checks if the SKU already exists on the server before submitting the form.
            // This request is synchronous (async: false) so the browser waits for the response
            // before continuing with the submit.
            $("#product_form").on("submit", function (event) {
                var sku = $("#sku").val();
                var form = this;
                var blocked = false;

                $.ajax({
                    url: "check_product_id.php",
                    data: { sku: sku },
                    method: "POST",
                    async: false, // synchronous for simple flow; not ideal in real-world apps
                    success: function (response) {
                        if (response === "exists") {
                            alert("Product SKU already exists in database!");
                            blocked = true;
                        }
                    },
                    error: function () {
                        // In case the check fails, you might want to block submission or allow it.
                        // For now, we just allow it to continue.
                    }
                });

                if (blocked) {
                    event.preventDefault();
                    return;
                }

                // Additional client-side validation
                if ($('#productType').val() === "DVD" &&
                    (!$('#size').val())) {
                    alert("Please enter a valid DVD size in MB.");
                    event.preventDefault();
                }
                else if ($('#productType').val() === "Furniture" &&
                    (!$('#height').val() || !$('#width').val() || !$('#length').val())) {
                    alert("Please enter valid dimensions in HxWxL format.");
                    event.preventDefault();
                }
                else if ($('#productType').val() === "Book" &&
                    (!$('#weight').val())) {
                    alert("Please enter a valid book weight in KG.");
                    event.preventDefault();
                }
                else if ($('#productType').val() === "0") {
                    alert("Please select a product type.");
                    event.preventDefault();
                }
                else if (!$('#sku').val()) {
                    alert("Please enter a valid SKU.");
                    event.preventDefault();
                }
                else if (!$('#name').val()) {
                    alert("Please enter a valid name.");
                    event.preventDefault();
                }
                else if (!$('#price').val()) {
                    alert("Please enter a valid price.");
                    event.preventDefault();
                }
            });
        });
    </script>
</body>
</html>
