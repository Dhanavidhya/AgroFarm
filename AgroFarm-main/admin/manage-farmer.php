
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
    
    </style>

<?php
session_start();
$did  = '5555';
?>
<center>
    <div class="container" >
       <div class="wrapper"><br>
           <h1><b>Manage Settings</b></h1>
           <br/><br/>
           <?php
           if(isset($_SESSION["delete"])){
            echo $_SESSION["delete"];
            unset($_SESSION['delete']);
           }
           ?>
           <table class="tbl-full">
               <tr style="border-bottom-width: 25px; border-bottom-style: solid; border-bottom-color: white;">
                   <th>S.No</th>
                   <th>Farmer Id</th>
                   <th>Name</th>
                   <th>Price</th>
                   <th>Status</th>
               </tr>

               <?php

               $con = mysqli_connect('localhost', 'root', '','codexworld');
               
                $n = 1;
                $cmp =  "SELECT * FROM `products`";
                
                $qry = mysqli_query($con,$cmp);
                $rows = mysqli_num_rows($qry);
                   if($rows>0){         
                while($rws = mysqli_fetch_assoc($qry)){
                           // getting all data
                           $id = $rws['farmer_id'];
                           $name = $rws['name'];
                           $price = $rws['price'];
                           $sts = $rws['status'];

                           //display
                           ?>
                           <tr style="border-bottom-width: 25px; border-bottom-style: solid; border-bottom-color: white;">
                               <td><?php echo $n; $n=$n+1; ?></td>
                               <td><?php echo $id ?></td>
                               <td><?php echo $name ?></td>
                               <td><?php echo $price ?></td>
                               <td><?php echo $sts ?></td>
                               <td>
                                   <a href="delete-farmer.php?id=<?php echo $id ;?>" class="btn-danger" style="color: white;padding: 7px;border-radius: 34px;">Delete Farmer</a>
                                </td>
                            </tr>
                        <?php
                       }
                   }
                   else{
                       //no data
                       ?>
                       <p>No Farmers!</p>
                       <?php
                   }
               
               ?>
            
           </table>
           
       </div>
        
       <br/>
    <br/>    <br/>
    <br/><br/>
    </div>
 