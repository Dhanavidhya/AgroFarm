<?php

if(isset($_POST['submit'])){
  $con = mysqli_connect('localhost', 'root', '','codexworld');

$name = $_POST['name'];
$price = $_POST['price'];
$image  = basename($_FILES["uploadfile"]["name"]);


//echo $image;

$sql = "INSERT INTO `products` ( `image`, `name`, `price`) VALUES ('$image', '$name', '$price')";
//echo $cid;
$rs = mysqli_query($con, $sql);
if($rs)
{
    //echo $sql;
  echo "Location: home.php";
  //die();
	//header("Location: index.php");
}
}
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
<link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- Site CSS -->
    <link rel="stylesheet" href="css/style.css">
    <!-- Responsive CSS -->
    <link rel="stylesheet" href="css/responsive.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/custom.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/foundation/5.0.2/css/foundation.css'>
    <!-- Style CSS -->
    <link rel="stylesheet" href="css/cartstyle.css">
	<!-- Demo CSS (No need to include it into your project) -->
	<link rel="stylesheet" href="css/demo.css">
   <link rel="stylesheet" href="shop.css"> 
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  
<style>
    
    .btn-danger {background-color: #f44336;}
    tr{
    border-bottom-width: 25px;
}
    
.display1{
  margin-bottom: 3rem;
  margin-top: 3rem;
}
    </style>

    <title>Add product</title>
</head>
<body ><center>
    <div class="container">
        <div class="content">
          <div class="right-side">
            <div class="topic-text"><h1 class="display1"><b>Add Products<b></h1></div>
          <table class="tbl-full" >
          <form action="addproduct.php" method="POST" enctype="multipart/form-data"> 
               <tr style="border-bottom-width: 25px; border-bottom-style: solid; border-bottom-color: white;">
                   <td> <input type="text" name="name" id="name" placeholder="Enter name of the product" required>
                  </td>
               </tr>
               <tr>
                <td>  
                  <input type="text" name="name" id="name" placeholder="Enter name of the product" required>
                </td>              
                </tr>

                <tr>
                <td>  
                <input type="number" name="price" id="price" placeholder="Enter price" required>
                </td>              
                </tr>

                <tr>
                <td>  
                <input class="form-control" type="file" name="uploadfile" value="" />
                </td>              
                </tr>

                <tr>
                <td>  
                <button class="btn-danger" style="color: white;padding: 7px;border-radius: 34px;">Create</button>
                </td>              
                </tr>

           </table>
        </div>
        </div>
      </div>
</center>
</body>
</html>