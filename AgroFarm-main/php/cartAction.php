<?php 
// Include the database connection file 
require_once 'dbConnect.php'; 
 
// Initialize shopping cart class 
require_once 'Cart.class.php'; 
$cart = new Cart; 
 
// Default redirect page 
$redirectURL = 'index.php'; 
 
// Process request based on the specified action 
if(isset($_REQUEST['action']) && !empty($_REQUEST['action'])){ 
    if($_REQUEST['action'] == 'addToCart' && !empty($_REQUEST['id'])){ 
        $product_id = $_REQUEST['id']; 
 
        // Fetch product details from the database 
        $sqlQ = "SELECT * FROM products WHERE id=?"; 
        $stmt = $db->prepare($sqlQ); 
        $stmt->bind_param("i", $db_id); 
        $db_id = $product_id; 
        $stmt->execute(); 
        $result = $stmt->get_result(); 
        $productRow = $result->fetch_assoc(); 
 
        $itemData = array( 
            'id' => $productRow['id'], 
            'image' => $productRow['image'], 
            'name' => $productRow['name'], 
            'price' => $productRow['price'], 
            'qty' => 1 
        ); 
         
        // Insert item to cart 
        $insertItem = $cart->insert($itemData); 
         
        // Redirect to cart page 
        $redirectURL = $insertItem?'viewCart.php':'index.php'; 
    }elseif($_REQUEST['action'] == 'updateCartItem' && !empty($_REQUEST['id'])){ 
        // Update item data in cart 
        $itemData = array( 
            'rowid' => $_REQUEST['id'], 
            'qty' => $_REQUEST['qty'] 
        ); 
        $updateItem = $cart->update($itemData); 
         
        // Return status 
        echo $updateItem?'ok':'err';die; 
    }elseif($_REQUEST['action'] == 'removeCartItem' && !empty($_REQUEST['id'])){ 
        // Remove item from cart 
        $deleteItem = $cart->remove($_REQUEST['id']); 
         
        // Redirect to cart page 
        $redirectURL = 'viewCart.php'; 
    }elseif($_REQUEST['action'] == 'placeOrder' && $cart->total_items() > 0){ 
        $redirectURL = 'checkout.php'; 
         
        // Store post data 
        $_SESSION['postData'] = $_POST; 
     
        $first_name = strip_tags($_POST['first_name']); 
        $last_name = strip_tags($_POST['last_name']); 
        $email = strip_tags($_POST['email']); 
        $phone = strip_tags($_POST['phone']); 
        $address = strip_tags($_POST['address']); 
         
        $errorMsg = ''; 
        if(empty($first_name)){ 
            $errorMsg .= 'Please enter your first name.<br/>'; 
        } 
        if(empty($last_name)){ 
            $errorMsg .= 'Please enter your last name.<br/>'; 
        } 
        if(empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)){ 
            $errorMsg .= 'Please enter a valid email.<br/>'; 
        } 
        if(empty($phone)){ 
            $errorMsg .= 'Please enter your contact number.<br/>'; 
        } 
        if(empty($address)){ 
            $errorMsg .= 'Please enter your address.<br/>'; 
        } 
         
        if(empty($errorMsg)){ 
            // Insert customer data into the database 
            $sqlQ = "INSERT INTO customers (first_name,last_name,email,phone,address,created,modified) VALUES (?,?,?,?,?,NOW(),NOW())"; 
            $stmt = $db->prepare($sqlQ); 
            $stmt->bind_param("sssss", $db_first_name, $db_last_name, $db_email, $db_phone, $db_address); 
            $db_first_name = $first_name; 
            $db_last_name = $last_name; 
            $db_email = $email; 
            $db_phone = $phone; 
            $db_address = $address; 
            $insertCust = $stmt->execute(); 
             
            if($insertCust){ 
                $custID = $stmt->insert_id; 
                 
                // Insert order info in the database 
                $sqlQ = "INSERT INTO orders (customer_id,grand_total,created,status) VALUES (?,?,NOW(),?)"; 
                $stmt = $db->prepare($sqlQ); 
                $stmt->bind_param("ids", $db_customer_id, $db_grand_total, $db_status); 
                $db_customer_id = $custID; 
                $db_grand_total = $cart->total(); 
                $db_status = 'Pending'; 
                $insertOrder = $stmt->execute(); 
             
                if($insertOrder){ 
                    $orderID = $stmt->insert_id; 
                     
                    // Retrieve cart items 
                    $cartItems = $cart->contents(); 
                     
                    // Insert order items in the database 
                    if(!empty($cartItems)){ 
                        $sqlQ = "INSERT INTO order_items (order_id, product_id, quantity) VALUES (?,?,?)"; 
                        $stmt = $db->prepare($sqlQ); 
                        foreach($cartItems as $item){ 
                            $stmt->bind_param("ids", $db_order_id, $db_product_id, $db_quantity); 
                            $db_order_id = $orderID; 
                            $db_product_id = $item['id']; 
                            $db_quantity = $item['qty']; 
                            $stmt->execute(); 
                        } 
                         
                        // Remove all items from cart 
                        $cart->destroy(); 
                         
                        // Redirect to the status page 
                        $redirectURL = 'orderSuccess.php?id='.base64_encode($orderID); 
                    }else{ 
                        $sessData['status']['type'] = 'error'; 
                        $sessData['status']['msg'] = 'Something went wrong, please try again.'; 
                    } 
                }else{ 
                    $sessData['status']['type'] = 'error'; 
                    $sessData['status']['msg'] = 'Something went wrong, please try again.'; 
                } 
            }else{ 
                $sessData['status']['type'] = 'error'; 
                $sessData['status']['msg'] = 'Something went wrong, please try again.'; 
            } 
        }else{ 
            $sessData['status']['type'] = 'error'; 
            $sessData['status']['msg'] = '<p>Please fill all the mandatory fields.</p>'.$errorMsg;  
        } 
         
        // Store status in session 
        $_SESSION['sessData'] = $sessData; 
    } 
} 
 
// Redirect to the specific page 
header("Location: $redirectURL"); 
exit();