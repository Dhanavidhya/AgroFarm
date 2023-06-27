<?php
session_start();

if(isset($_POST['user']))
{
    $host = "localhost";  
    $user = "root";  
    $password = '';  
    $db_name = "codexworld";  
      
    $con = mysqli_connect($host, $user, $password, $db_name);  

    if(mysqli_connect_errno()) {  
        die("Failed to connect with MySQL: ". mysqli_connect_error());  
    }  
    $username=$_POST['user'];
    $password=$_POST['pass'];
    $tp = $_POST['tpType'];  
      
    $sql = "select * from login where username = '$username' and password = '$password'";  
    $result = mysqli_query($con, $sql);  
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);  
    $count = mysqli_num_rows($result);  
          
    if($count == 1){ 
        $sql1 = "SELECT * from `login` where `username` = '$username' and `password` = '$password'";  
        $res = mysqli_query($con, $sql1);
      if($res){
        $rws = mysqli_fetch_assoc($res);
        $login = $rws['id'];

        if($tp == 'admin'){
            
            header("Location: admin/manage-farmer.php");
              
        }
        elseif ($tp=='farmer') {
            # code...
            header("Location: addproduct.php");
        }
        else{
            header("Location: home.php");
        }
          }
      }
              
    else{  
        echo "<h1> Login failed. Invalid username or password.</h1>";  
    }     
}

?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/login.css">
    <title>Login Page</title>
</head>
<body style="margin-top: 47px;">
    <div class="box-form">
        <div class="left">
            <div class="overlay">
                <h1>AGROFARM</h1>
                <p></p>
            <span>
                <p>Login with Other Resources</p>
                <a href="#"> Login with Google</a>
            </span>
            </div>
        </div>
        <div class="right">
            <form action="login.php" method="POST">
                <h4>LOGIN</h4>
                <p>Don't have an account? <a href="create.php">Create your account here</a></p>
                <div class="inputs">
                    <input type="text" name="user" id="user" placeholder="User name">
                    <br>
                    <input type="password" name="pass" id="pass" placeholder="Password"> 
                    <br>
                    <p>Choose one </p>
                    <select name="tpType" id="tpType">
                        <option value="customer">Customer</option>
                        <option value="farmer">Farmer</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                <br>
                <div class="remember-me--forget-password">
                    <label>
                        <input type="checkbox" name="item" checked>
                        <span class="text-checkbox">Remember me</span>
                    </label>
                    <p>Forget Password</p>
                </div>
            
                <div class="button">
                    <input type="submit" name="submit" value="Go" >
                  </div>
            </form>
        </div>
    </div>
</body>
</html>