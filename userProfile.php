<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="libraries/bootstrap.min.css" rel="stylesheet">
  <title>Logout Page</title>
  <style>
    main{
      margin: 0;
      padding: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    .info_container{
      background-color: gainsboro;
      width: 400px;
      height: 200px;
      padding: 40px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
      color: blue;
      text-align: center;
    }
    h2{
      color: black;
    }
    a{
      text-decoration: none;
    }
    
  </style>
</head>
<body>
<?php
session_start();

if(isset($_SESSION['user_name'])){
  $user_name = $_SESSION['user_name'];
}
else{
  $user_name = "";
}
?>
<main>
  <div class="info_container py-4">
    <h2>Welcome Back!</h2>
    <p class="text-success"><?php echo "Dear " . $user_name . "❤️!"?></p>
    <div class="d-flex justify-content-evenly py-4">
    <a class="btn btn-danger btn-sm" href="./login.php">Logout</a>
    <a class="btn btn-secondary btn-sm" href="./taskList.php">Back</a>
    </div>
  </div>
</main>
<script src="libraries/bootstrap.min.js"></script>
</body>
</html>