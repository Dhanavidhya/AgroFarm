<?php 
// Include the database connection file 
require_once 'dbConnect.php'; 
 
// Initialize shopping cart class 
include_once 'Cart.class.php'; 
$cart = new Cart; 
 
// Fetch products from the database 
$sqlQ = "SELECT * FROM products"; 
$stmt = $db->prepare($sqlQ); 
$stmt->execute(); 
$result = $stmt->get_result(); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>PHP Shopping Cart</title>
<meta charset="utf-8">

<!-- Bootstrap core CSS -->
<link href="css/bootstrap.min.css" rel="stylesheet">

<!-- Custom style -->
<link href="css/style.css" rel="stylesheet">

</head>
<body>
<div class="container">
    <h1>PRODUCTS</h1>
	
    <!-- Cart basket -->
    <div class="cart-view">
        <a href="viewCart.php" title="View Cart"><i class="icart"></i> (<?php echo ($cart->total_items() > 0)?$cart->total_items().' Items':0; ?>)</a>
    </div>
    
    <!-- Product list -->
    <div class="row col-lg-12">
    <?php 
    if($result->num_rows > 0){ 
        while($row = $result->fetch_assoc()){ 
            $proImg = !empty($row["image"])?'images/products/'.$row["image"]:'images/demo-img.png'; 
    ?>
        <div class="card" style="width: 18rem;">
            <img src="<?php echo $proImg; ?>" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title"><?php echo $row["name"]; ?></h5>
                <h6 class="card-subtitle mb-2 text-muted">Price: <?php echo CURRENCY_SYMBOL.$row["price"].' '.CURRENCY; ?></h6>
                <p class="card-text"><?php echo $row["description"]; ?></p>
                <a href="cartAction.php?action=addToCart&id=<?php echo $row["id"]; ?>" class="btn btn-primary">Add to Cart</a>
            </div>
        </div>
    <?php } }else{ ?>
        <p>Product(s) not found.....</p>
    <?php } ?>
    </div>
</div>
</body>
</html>