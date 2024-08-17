<?php
  require "./dbConnection.php";

  $userId = $_GET['userId'] ?? null;
  $status = $_GET['status'] ?? null;

  $conditions = [];
  $sql = "SELECT * FROM tasks";
  
  if($userId && is_numeric($userId))
  {
    $conditions[] = "user_id = $userId";
  }

  if($status && !is_numeric($status))
  {
    $conditions[] = "status = '$status'";
  }
  
  if(!empty($conditions))
  {
    $sql .= " WHERE " . implode(" AND ", $conditions);
  }

  $tasks = mysqli_query($connection, $sql);

  $sql = "SELECT * FROM users";
  $users = mysqli_query($connection, $sql);
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Task Management System </title>
    <link href="libraries/bootstrap.min.css" rel="stylesheet">
  </head>
  <body>
  <?php require "./header.php"?>
    <main class="px-4">
      <div class="card text-center m-4 py-4 d-flex justify-content-between">
          <h2 class="">Welcome to TodoMaster</h2>
        </div>
      <div class="card-body m-4 py-4 d-flex justify-content-between">
        <div>
          <a href="./createTask.php" class="btn btn-sm btn-primary ">Add New Task</a>
        </div>
        <div>
        <div class="input-group mb-3">
          <label class="input-group-text" for="inputGroupSelect01">Filter by:</label>
          <select class="form-select" id="inputGroupSelect01" onchange="window.location.href = updateUrlParams('userId', this.value)">
            <option value="null">User</option>
            <?php while ($user = mysqli_fetch_assoc($users)): ?>
                <option value="<?php echo $user['id']; ?>" <?php echo ($user['id'] == $userId) ? 'selected' : ''; ?>>
                    <?php echo $user['name']; ?>
                </option>
            <?php endwhile; ?>
          </select>
          <select class="form-select" id="inputGroupSelect02" onchange="window.location.href = updateUrlParams('status', this.value)">
            <option value="">Status</option>
            <option value="pending" <?php echo ('pending' == $status) ? 'selected' : ''; ?>>Pending</option>
            <option value="inprogress" <?php echo ('inprogress' == $status) ? 'selected' : ''; ?>>Inprogress</option>
            <option value="completed" <?php echo ('completed' == $status) ? 'selected' : ''; ?>>Completed</option>
          </select>
        </div>
        </div>
      </div>
      <div class="w-80 px-4 py-4">
        <table class="table table-striped border">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Tasks List</th>
              <th scope="col">Status</th>
              <th scope="col">Assignee</th>
              <th scope="col">Due Date</th>
              <th scope="col">Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php
              $index = 1;
              while ($task = mysqli_fetch_assoc($tasks)):
              mysqli_data_seek($users, 0);
            ?>
              <tr>
                <th scope='row'><?php echo $index; ?></th>
                <td><a name='task' style='text-decoration:none' href="./taskDetail.php?id=<?php echo $task['id']; ?>"><?php echo $task['title']; ?></a></td>
                <td><?php echo $task['status']; ?></td>
                <td>
                  <select class="form-select" aria-label="Default select example" onchange="if(this.value) { window.location.href = './assignTask.php?userId=' + this.value + '&taskId=' + <?php echo $task['id']; ?>; }">
                    <option value="">-</option>
                    <?php while ($user = mysqli_fetch_assoc($users)): ?>
                        <option value="<?php echo $user['id']; ?>" <?php echo ($user['id'] == $task['user_id']) ? 'selected' : ''; ?>>
                            <?php echo $user['name']; ?>
                        </option>
                    <?php endwhile; ?>
                  </select>
                </td>
                <td><?php echo $task['dueDate']; ?></td>
                <td>
                  <a class='btn btn-primary btn-sm' href="./editTask.php?id=<?php echo $task['id']; ?>">Edit</a>
                  <a class='btn btn-danger btn-sm' href="./deleteTask.php?id=<?php echo $task['id']; ?>">Delete</a>
                </td>
              </tr>
            <?php
              $index++;
              endwhile;
            ?>

          </tbody>
        </table>
      </div>
    </main>
    <script src="libraries/bootstrap.min.js" ></script>
  </body>
</html>
<script>
  function updateUrlParams(param, value)
  {
    let params = new URLSearchParams(window.location.search);
    value ? params.set(param, value) : params.delete(param);
    params.forEach((value, key) => value === '' && params.delete(key));
    return `${window.location.pathname}?${params.toString()}`;
  }
</script>








