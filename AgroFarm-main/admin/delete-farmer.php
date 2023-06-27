<link rel="stylesheet" href="css/admin.css">

<?php

session_start();


$con = mysqli_connect('localhost', 'root', '','codexworld');
$id = $_GET['id'];
$sql = "DELETE FROM `products` WHERE `farmer_id` = '$id'";
$res = mysqli_query($con,$sql);
if($res){
    //echo " deleted";
    $_SESSION['delete'] = "<div style=' color: #1dd1a1;'>Farmer Deleted Successfully</div>";
    header("Location: manage-farmer.php");
}
else{
    //echo "Not deleted!";
    $_SESSION['delete'] = "<div 'color: #ee5253;'>Failed To Delete Farmer. Try Again Later!</div>";
    header("Location: manage-farmer.php");
}

?>