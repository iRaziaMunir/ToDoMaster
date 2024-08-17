<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Task Management System </title>
    <link href="libraries/bootstrap.min.css" rel="stylesheet">
  </head>
  <body class="container-fluid">
  <?php 
      session_start();
      
      if(isset($_SESSION['user_name'])){
        $user_name = $_SESSION['user_name'];
      }
      else{
        $user_name ="";
      }
      ?>
    <header class="py-3 bg-light">
      <ul class="nav justify-content-center align-items-center">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="./taskList.php">TodoMaster</a>
        </li>
        <li class="nav-item">
          <a class="nav-link " href="./logout.php" tabindex="-1" aria-disabled="true">Logout</a>
        </li>
        <li class="nav-item">
        <a class="nav-link " href="./userProfile.php" tabindex="-1" aria-disabled="true"><?php echo $user_name."❤️"; ?></a>
        </li>
     </ul>
    </header>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
  </body>
</html>