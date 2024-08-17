<?php
  require "./dbConnection.php";
  
  $taskId = $_GET['taskId'];
  $userId = $_GET['userId'];

  $sql = "UPDATE tasks SET user_id = $userId WHERE id = $taskId";

  if(mysqli_query($connection, $sql))
  {
    header("Location: taskList.php");
    exit();
  }
  else
  {
    echo "Error updating record: " . mysqli_error($connection);
  }
?>
