<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="libraries/bootstrap.min.css" rel="stylesheet">
  <title>Task Details</title>
</head>
<body class="container">
  <?php require './header.php'; ?>
  <main class="py-4 d-flex flex-column justify-content-center align-items-center">
    <h2 class="text-center py-4">Task Details</h2> 
    <div class="card w-75">
      <div class="card-body">
        <?php
          require "./dbConnection.php";
          $id = isset($_GET['id']) ? intval($_GET['id']) : null;

          if ($id) {
            $sql = "SELECT tasks.*, users.name AS user_name 
                    FROM tasks 
                    LEFT JOIN users ON tasks.user_id = users.id 
                    WHERE tasks.id = $id";
            // echo "<p>SQL Query: $sql</p><br>";

            $result = mysqli_query($connection, $sql);
// print_r($result );
            if (!$result) {
              echo "<p>Error: " . mysqli_error($connection) . "</p>";
            }
            // else {
            //   echo "<p>Number of rows returned: " . mysqli_num_rows($result) . "</p>";
            // }

            if ($result && mysqli_num_rows($result) > 0) {
              $taskDetail = mysqli_fetch_array($result);
              $title = $taskDetail['title'];
              $description = $taskDetail['description'];
              $dueDate = $taskDetail['dueDate'];
              $status = $taskDetail['status'];
              $assignee = $taskDetail['user_name'];
              $attachment = $taskDetail['attachment'];
              
              // Path to the uploaded file
              $filePath = "uploads/" . $attachment;
              ?>
              <h4>Title:<br></h4> <?php echo $title; ?>
              <h4>Description:<br></h4> <?php echo $description; ?>
              <h4>Status:<br></h4> <?php echo $status; ?>
              <h4>Due Date:<br></h4> <?php echo $dueDate; ?>
              <h4>Assignee:<br></h4> <?php echo $assignee; ?>
              
              <?php if (!empty($attachment) && file_exists($filePath)): ?>
                <h4>Attachment:<br></h4>
                <img src="<?php echo $filePath; ?>" alt="Attachment" class="img-fluid">
              <?php else: ?>
                <h4>No Attachment Available</h4>
              <?php endif; ?>
              <?php
            } else {
              echo "Task not found or no rows returned.";
            }
          } else {
            echo "Invalid task ID.";
          }
        ?>
      </div>
    </div>
  </main>
  <script src="libraries/bootstrap.min.js"></script>
</body>
</html>
