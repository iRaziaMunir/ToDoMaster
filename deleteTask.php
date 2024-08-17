<?php
require "./dbConnection.php";
  $task_id = $_GET['id'];

  $sqlFetchFile = "SELECT attachment FROM tasks WHERE id = $task_id";
  $resultFetchFile = mysqli_query($connection, $sqlFetchFile);

  if($resultFetchFile)
  {
    $row = mysqli_fetch_assoc($resultFetchFile);
    $fileToDelete = 'uploads/' . $row['attachment'];
    
    if(file_exists($fileToDelete))
    {
      unlink($fileToDelete);
    }
  }

  $sql = "DELETE FROM tasks WHERE id = $task_id";
  $result = mysqli_query($connection, $sql);

  if(!$result){
    echo "Unable to delete task!";
  }
  else{
    header("Location: taskList.php");
  }

?>