<?php 
if(isset($_POST['submit'])){
  $con = mysqli_connect('localhost', 'root', '','codexworld');
  $username=$_POST['username'];
  $password=$_POST['password'];
  $selected_val = $_POST['tpType'];

  $email=$_POST['email'];
  $sql1 = "INSERT INTO `login` (`username`, `password`) VALUES ('$username', '$password')";
  $rs1 = mysqli_query($con, $sql1); 
  if($rs1)
  {
      $sql = "SELECT * from `login` where `username` = '$username' and `password` = '$password'";  
      $res = mysqli_query($con, $sql);
      if($res){
        //echo "---";
        $rws = mysqli_fetch_assoc($res);
        $login = $rws['id'];

        if($selected_val == 'admin'){
            $sql2 = "INSERT INTO `admin` (`id`,`username`, `password`) VALUES ('$login','$username', '$password')";
            $rs2 = mysqli_query($con, $sql2); 
            if($rs2){
              header("Location: login.php");
              //echo "Location: js.php?id=".$login;
            }
        }
        else if($selected_val=='customer'){
            header("lOcation : login.php");
        }
        else{
            header("Location: login.php");
          }
      }
}
}
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="css/create_.css">
    <title>Create Account</title>
</head>
<body>
    <div class="container">
        <div class="content">
          <div class="left-side">
            <a href="/home" width="40" height=5><img src="../images/job.jpg" style="
                width:300px;
                height:300px"></a>  
          </div>
          <div class="right-side">
            <div class="topic-text">Create Your Account</div>

          <form action="signup.php" method="POST">
            <div class="input-box">
              <input type="text" name="username" placeholder="Enter username" required>
            </div>
            <div class="input-box">
              <input type="text" name="password" placeholder="Enter password" required>
            </div>

            <div>
              <label for="tp">Which best describes you </label>
            <select name="tpType" id="tpType">
           
                        <option value="customer">Customer</option>
                        <option value="farmer">Farmer</option>
                        <option value="admin">Admin</option>
            </select>
            </div>
            <div class="button">
              <input type="submit" name="submit" value="Next" >
            </div>
          </form>
        </div>
        </div>
      </div>
</body>
</html>