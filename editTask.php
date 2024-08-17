<?php

$titleError = "";
$title = $description = $status = $dueDate = $attachment = "";
$task_id = isset($_GET['id']) ? $_GET['id'] : NULL;

// function editTask(){

  global $title, $description, $status, $dueDate, $attachment, $titleError;
  require "./dbConnection.php";

  // $connection = new DbConnection();
  // $dbConnection = $connection->databaseConnection();

  // Get the task ID from the URL using $_GET 




   if(!$task_id){

     echo "<br>Id is not found". mysqli_error($connection);
     exit();
   }
   
   $sql = "SELECT * FROM tasks WHERE id = $task_id";

    // echo $task_id . "Task Id";
    // echo "SQL Query: " . $sql;

   $result = mysqli_query($connection, $sql);


    if($result && mysqli_num_rows($result) > 0){

      $task = mysqli_fetch_assoc($result);
      // print_r($task );

      if($task){
        $title = $task['title'];
        $description = $task['description'];
        $status = $task['status'];
        $dueDate = $task['dueDate'];
        $attachment = $task['attachment']; 
      }
      else{
        echo "Task is not found";
        exit();
      }
  }
  else{
    echo "Unable to fetch task". mysqli_error($connection);
   }

  if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $title = $description = $status = $dueDate = $attachment = "";

    if(empty($_POST['title'])){
      $titleError = "Title is required";
    }
    else{
      $title = $_POST['title'];
      echo $title;
    }

    if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] == 0) {
      $attachment = $_FILES['attachment']['name'];
      // Move uploaded file to a desired directory
      move_uploaded_file($_FILES['attachment']['tmp_name'], "uploads/" . $attachment);
    }
    // $attachment = !empty($_FILES['attachment']) ? $_FILES['attachment'] : "";

    if(isset($_POST['update'] ) && empty($titleError))
    {
      $sql = "Update tasks SET title = '$title'";

      if($description = $_POST['description'])
      {
        $sql = $sql . ", description = '$description'";
      }

      if($status = $_POST['status'])
      {
        $sql = $sql . ", status = '$status'";
      }

      if($dueDate = $_POST['dueDate'])
      {
        $sql = $sql . ", dueDate = '$dueDate'";
      }

      $sql = $sql . " WHERE id = $task_id";

      if(mysqli_query($connection, $sql)){

        header("Location: taskList.php");
        exit();
      }
      else{
        echo "Error occurred!". mysqli_error($connection);
      }
    }
    else{
      echo " Failed to Update Task!" . mysqli_error($connection);
    }
  }
// }
// editTask();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="libraries/bootstrap.min.css" rel="stylesheet">
  <title>Document</title>
</head>
<body>
<?php require "./header.php" ?>
<main class="d-flex justify-content-center align-items-center mt-4">
  <div class="w-50">
    <h2 class="text-center">Edit Task</h2>
    <form action="./editTask.php?id=<?php echo $task_id;?>" method="post" enctype="multipart/form-data">

      <div class="mb-3">
        <span><?php echo $titleError; ?></span>
        <label for="exampleFormControlInput1" class="form-label">Title</label>
        <input type="text" name='title' class="form-control" id="exampleFormControlInput1" placeholder="Enter task title" value='<?php echo $title; ?>' required>
      </div>

      <label for="exampleFormControlTextarea1" class="form-label">Task Description</label>
      <textarea name='description' class="form-control" id="exampleFormControlTextarea1" 
        placeholder="Enter task description here......">
        <?php echo $description; ?>
      </textarea>

      <div class="mb-3 mt-3">
        <label for="formFile" class="form-label">Upload Attachment </label>
        <?php if ($attachment): ?>
            <p >Current Attachment: <?php echo $attachment; ?></p>
            <?php endif; ?>
        <input name='attachment' class="form-control" type="file" id="formFile" value='<?php echo $attachment; ?>'>
      </div>
      
      <div class="d-flex justify-content-evenly">
      <div class="form-check">
        <input class="form-check-input" type="radio" name="status" value="pending" id="flexRadioDefault1" 
        <?php echo ($status == 'pending') ? 'checked' : ''; ?>>
        <label class="form-check-label" for="flexRadioDefault1" >
          Pending
        </label>
      </div>

      <div class="form-check">
        <input class="form-check-input" type="radio" name="status" value="inprogress"  id="flexRadioDefault2" 
        <?php echo ($status == 'inprogress') ? 'checked' : ''; ?>>
        <label class="form-check-label" for="flexRadioDefault2">
          In Progress
        </label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="radio" name="status" value="completed"  id="flexRadioDefault2" 
        <?php echo ($status == 'completed') ? 'checked' : ''; ?>>
        <label class="form-check-label" for="flexRadioDefault2">
          Completed
        </label>
      </div>
      </div>
      <div class="mb-3 mt-3">
        <label for="exampleFormControlInput1" class="form-label">Select due date of task</label>
        <input name='dueDate' class="form-control" type="date" name="date" id="" 
        value="<?php echo $dueDate; ?>">
      </div>
      <div class="col-auto d-flex justify-content-between ">
        <input type="submit" name="update" value="Update" class="btn btn-primary mb-3 px-4">
        <a class="btn btn-secondary text-white mb-3 px-4" href="./taskList.php">Cancel</a>
      </div>
    </form>
  </div>
</main>
<script src="libraries/bootstrap.min.js"></script>
</body>
</html>