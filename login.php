<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="libraries/bootstrap.min.css" rel="stylesheet">
  <title>Document</title>
</head>
<style>
   main {
      margin: 0;
      padding: 0;
      display: flex;
      justify-content: center;
      align-items: center;
    }
    form {
      background-color: gainsboro;
      width: 600px;
      height: 600px;
      padding: 40px;
      margin-top: 20px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
      color: grey;
    }
    h1{
      text-align: center;
      color: #333;
    }
    .error{
      color: red;
    }
    label {
      display: block;
      margin-bottom: 1px;
      font-weight: bold;
    }
    input[type="email"],
    input[type="password"]{
      width: 100%;
      padding: 10px 8px;
      border: none;
      border-radius: 4px;
      background-color: #f4f4f4;
      color: #333;
    }
    input[type="submit"] {
      width: 100%;
      padding: 10px;
      border: none;
      border-radius: 4px;
      color: #fff;
      font-size: 16px;
      cursor: pointer;
      margin-top: 30px;
      margin-bottom: 30px;
    }
    
    .btn_container{
      display: flex;
      justify-content: space-between;
    }
    a{
      text-decoration: none;
      margin-bottom: 10px;
    }
</style>
<body class="container">
<?php
session_start();
require "./dbConnection.php";
// $connection = new DbConnection();
// $dbConnection = $connection->databaseConnection();

$emailError = $passwordError = $loginError = "";
$email = $password = "";

if($_SERVER['REQUEST_METHOD']== 'POST'){


 if(empty($_POST['email'])){
   $emailError = "Email is required *";
 }else{
  $email =$_POST['email'];
 }

 if(empty($_POST['password'])){
  $passwordError = "Password is required *";
}else{
 $password =$_POST['password'];
}

if(isset($_POST['submit'])){
  if($emailError == "" && $passwordError == ""){

    // Check user credentials
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($connection, $sql);
    var_dump($result);
    if(mysqli_num_rows($result) > 0){

      $row = mysqli_fetch_assoc($result);

      //password verification
      if(password_verify($password, $row['password'])){

        //setting session variables 
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['user_name'] = $row['name'];
          
        header("Location: taskList.php");

        exit();
      }else{
        $loginError = "Incorrect password";
      }
    }else{
      $loginError = "Invalid email or password";
    }
  }

}
}
?>
<main class="d-flex flex-column justify-content-center align-items-center py-4">
    <h1 class="py-4">Login Page</h1> 
    <form action="./login.php" method="post" autocomplete="off" class="w-50">
      <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Email address</label><br>
        <span class="text-danger"><?php echo $emailError?></span>
        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email"    placeholder="Enter your email">
        <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
      </div>

      <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">Password</label><br>
        <span class="text-danger"><?php echo $passwordError?></span>
        <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Enter your password">
      </div>
      <input type="submit" value="Submit" name="submit" class="btn btn-primary"><br>
      <span class="text-danger"><?php echo $loginError?></span><br>

      <div class="btn_container">
      <a href="./signup.php">Don't have account? SignUp</a>
      </div>
    </form>
    </form>
  </main>
  <script src="libraries/bootstrap.min.js"></script>
</body>
</html>

