<?php 

session_start();

if(isset($_SESSION['user_id'])){

  header("Location: taskList.php");

}
else{
  header("Location: login.php");
}


?>