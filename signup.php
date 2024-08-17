
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="libraries/bootstrap.min.css" rel="stylesheet">
  <title>Form Validation</title>
  <style>
    body {
      margin: 0;
      padding: 0;
    }
    main {
      display: flex;
      justify-content: center;
      align-items:center;
      margin-top:80px;
      padding: 20px 0px;
      

    }
    form {
      background-color: gainsboro;
      width: 600px;
      padding: 30px 40px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
      color: grey;
      
    }
    h1{
      text-align: center;
      color: #333;
    }
    .error{
      color: red;
      font-size: 12px;
    }
    label {
      display: block;
      margin-bottom: 1px;
      font-weight: bold;
    }
    input[type="text"],
    input[type="email"],
    input[type="password"],
    textarea {
      width: 100%;
      padding: 10px 8px;
      border: none;
      border-radius: 4px;
      background-color: #f4f4f4;
      color: #333;
    }
    input[type="radio"] {
      margin-right: 10px;
    }
    textarea {
      resize: vertical;
      margin-bottom: 8px;
    }
    input[type="submit"] {
      width: 100%;
      padding: 8px;
      margin-block:20px;
      border: none;
      border-radius: 4px;
      color: #fff;
      font-size: 16px;
      cursor: pointer;
    }
   
    a{
      text-decoration: none;
      margin-bottom: 10%;
    }
  </style>
</head>
<body>
<?php
require "./dbConnection.php";

$nameError = $emailError = $passwordError = $genderError = "";
if($_SERVER['REQUEST_METHOD'] == 'POST'){
  $name = $email = $password = $gender = $message = "";

  //String/Name Validation  
  if(empty($_POST['name'])){
    $nameError = "Name is required *";
  }
  else{
    $name = $_POST['name'];

    if(!preg_match("/^[a-zA-Z\s]*$/", $name)){
      $nameError = "Only alphabets and white space are allowed"; 
    }
  }

  //Email Validation  
  if(empty($_POST['email'])){
    $emailError = "Email is required *";
  }
  else{
    $email = $_POST['email'];

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
      $emailError = "Invalid Email *";
    }
  }

  //password validation

  if(empty($_POST['password'])){
    $passwordError = " password is required *";
  }
  else{
    $password =password_hash($_POST['password'],PASSWORD_DEFAULT);
  }

  //gender validation

  if(empty($_POST['gender'])){
    $genderError = " Gender is required *";
  }
  else{
    $gender = $_POST['gender'];
  }

  //message validation
  if(empty($_POST['message'])){
    $message = "";
  }
  else{
    $message = $_POST['message'];
  }

  if(isset($_POST['submit'])){
    if($nameError == "" && $emailError == "" && $passwordError == "" &&$genderError == ""){

      //check if email already exists
      $emailCheckQuery = "SELECT * FROM users WHERE email = '$email' LIMIT 1";

      $result = mysqli_query($connection, $emailCheckQuery);

      if(mysqli_num_rows($result)>0){

        $emailError = "Email already exists !";
        echo "Email already exists!";

      }
      else{

        $sql ="INSERT INTO Users (name, email, password, gender, message) VALUES(
          '$name', '$email', '$password', '$gender', '$message'
        )";
        if(mysqli_query($connection, $sql)){

          // echo " Data is inserted successfully!";
          header("Location: login.php");
          //clear input fields after form submission
          $name = $email = $password = $gender = $message = "";

        }
        else{
          echo " Failed data insertion!" . mysqli_error($connection);
        }
      }
    }
  }
}
?>
  <main>
      <form action="signup.php" method="post" >
      <h1>Sign Up</h1>
      <label>Full Name:</label><br>
      <span class="error"><?php echo $nameError?></span>
      <input type="text" name="name" class="form-control" placeholder="Enter your full Name" autocomplete="off">

      <div class="mb-3">
        <label for="exampleFormControlInput1" class="form-label">Email address</label><br>
        <span class="error"><?php echo $emailError?></span>
        <input type="email" name="email" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
      </div>

      <label>Password:</label><br>
      <span class="error"><?php echo $passwordError?></span>
      <input type="password" name="password" placeholder="Enter your password" autocomplete="off"><br>

      <label>Gender:</label>
      <span class="error"><?php echo $genderError?></span><br>
      <input type="radio" name="gender" value="male">Male
      <input type="radio" name="gender" value="female">Female
      <input type="radio" name="gender" value="other">Other
      <br><br>

      <div class="mb-3">
        <label for="exampleFormControlTextarea1" class="form-label">Message</label>
        <textarea class="form-control" name="message" id="exampleFormControlTextarea1" rows="3"></textarea>
      </div>


      <!-- <label>Message</label><br>
      <textarea name="message" id="" cols="30" rows="8" placeholder="Enter your message here..."></textarea> -->
      <input type="submit" value="Submit" name="submit" class="btn btn-primary">
      <a href="./login.php">Already Registered?login here</a>
    </form>
  </main>
  <script src="libraries/bootstrap.min.js"></script>
</body>
</html>