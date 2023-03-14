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
    <form name="form" id="product_form" method="post" action="save_product.php">    
        <div class="formcontainer">
           
        <div class="container">

          <label for="sku"><strong>SKU</strong></label>
          <input type="text" id="sku" name="sku" >

          <label for="name"><strong>Name</strong></label>
          <input type="text" id="name" name="name" >

          <label for="price"><strong>Price</strong></label>
          <input type="text"  id="price" name="price" >

          <label for="product"><strong>Product Type</strong></label>
          <select id="productType" name="productType">
            <option value="0">Switch Type</option>       
            <option value="DVD">DVD</option>
            <option value="Furniture">Furniture</option>
            <option value="Book">Book</option>
         </select>
         
         <div id="DVD">
            <label for="size"><strong>Size (MB)</strong></label>
            <input type="text" id="size" name="size">
            <p>Please provide DVD size in MB</p>
         </div>

         <div id="Furniture">
            <label for="height"><strong>Height (CM)</strong></label>
            <input type="text" id="height" name="height" >

            <label for="width"><strong>Width (CM)</strong></label>
            <input type="text" id="width" name="width" >

            <label for="lenght"><strong>Length (CM)</strong></label>
            <input type="text" id="length" name="length" >
            <p>Please provide dimensions in HxWxL format</p>
         </div>
         
         <div id="Book">
            <label for="weight"><strong>Weight (KG)</strong></label>
            <input type="text" id="weight" name="weight">
            <p>Please provide book weight in KG</p>
            
         </div>

        </div>  
        
      
        <button type="submit" name="submit">Save</button>  
         <button type="button" onclick="window.location.href='index.php'">CANCEL</button>
       
         </div>
      </form>

     
      <script>

        
            $(document).ready(function() {
            $.viewMap = {
                '0' : $([]),
                'DVD' : $('#DVD'),
                'Furniture' : $('#Furniture'),
                'Book' : $('#Book')
            };

            $('#productType').change(function() {
          
                $.each($.viewMap, function() { this.hide(); });
      
                $.viewMap[$(this).val()].show();
            }).change();
            });
   

   
   $(document).ready(function() {
    $("#product_form").submit(function(event) {
        var sku = $("#sku").val();

        // Make a synchronous AJAX call to check if the product ID exists in MySQL
        $.ajax({
            url: "check_product_id.php",
            data: {sku: sku},
            method: "POST",
            async: false, // make the AJAX call synchronous
            success: function(response) {
                if (response == "exists") {
                    alert("Product SKU already exists in database!");
                    event.preventDefault(); // prevent form from submitting
                }
            }
        });
    });
});

   
$(document).ready(function() {
  $('#product_form').submit(function(event) {
    if ($('#productType').val() == "DVD" && ($('#size').val() == "" || $('#size').val() == null || $('#size').val() == undefined)) {
      alert("Please enter a valid DVD size in MB.");
      event.preventDefault();
    }
    else if ($('#productType').val() == "Furniture" && ($('#height').val() == "" || $('#width').val() == "" || $('#length').val() == "" || $('#height').val() == null || $('#width').val() == null || $('#length').val() == null)) {
      alert("Please enter valid dimensions in HxWxL format.");
      event.preventDefault();
    }
    else if ($('#productType').val() == "Book" && ($('#weight').val() == "" || $('#weight').val() == null || $('#weight').val() == undefined)) {
      alert("Please enter a valid book weight in KG.");
      event.preventDefault();
    }
    else if ($('#productType').val() == "0") {
      alert("Please select a product type.");
      event.preventDefault();
    }
    else if ($('#sku').val() == "" || $('#sku').val() == null || $('#sku').val() == undefined) {
      alert("Please enter a valid SKU.");
      event.preventDefault();
    }
    else if ($('#name').val() == "" || $('#name').val() == null || $('#name').val() == undefined) {
      alert("Please enter a valid name.");
      event.preventDefault();
    }
    else if ($('#price').val() == "" || $('#price').val() == null || $('#price').val() == undefined) {
      alert("Please enter a valid price.");
      event.preventDefault();
    }
  });
});




</script>

</body>
</html>