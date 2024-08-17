<?php
require "./dbConnection.php";

$titleError = "";

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(empty($_POST['title'])){
        $titleError = "Title is required!";
    }
    else{
        $title = $_POST['title'];
    }
    $description = $_POST['description'] ?? '';
    $status = $_POST['status'] ?? '';
    $dueDate = $_POST['dueDate'] ?? null;
    $attachment = $_FILES['attachment'] ?? null;
    echo $title;
    echo $description;
    echo $status;
    echo $dueDate;
    // Handle file upload
    // $attachment = "testing";
    // $attachmentName = $attachmentType = $attachmentData = "";
    if(isset($_FILES['attachment']) && $_FILES['attachment']['error'] == UPLOAD_ERR_OK){
        $targetDir = "uploads/";
        $fileExtension = pathinfo($_FILES['attachment']['name'], PATHINFO_EXTENSION);
        $dynamicName = uniqid() . '.' . $fileExtension;
        $attachment = $dynamicName;
        $targetFile = $targetDir . $dynamicName;
        move_uploaded_file($_FILES['attachment']['tmp_name'], $targetFile);
        
        // Check if the file was uploaded without errors
        // if (move_uploaded_file($_FILES['attachment']['tmp_name'], $targetFile)) {
        //     echo "The file has been uploaded with the name: " . $dynamicName;
        // } else {
        //     echo "Sorry, there was an error uploading your file.";
        // }

        // var_dump($_FILES['attachment']);
        // die();
        // $attachmentName = $_FILES['attachment']['name'];
        // $attachmentType = $_FILES['attachment']['type'];
        // $attachmentData = addslashes(file_get_contents($_FILES['attachment']['tmp_name']));
        
        // // echo $attachmentName;
        // $uploadDir = "uploads/";
        // if (!file_exists($uploadDir)) {
        //     mkdir($uploadDir, 0777, true);
        // }
        
        // $uploadFilePath = $uploadDir . $attachmentName;
        // if (!move_uploaded_file($_FILES['attachment']['tmp_name'], $uploadFilePath)) {
        //     echo "Failed to move the uploaded file.";
        // }
    }

   if(isset($_POST['submit']) && empty($titleError)){
        $sql = "INSERT INTO tasks (title, description, status, dueDate, attachment) 
                VALUES (
                    " . (!empty($title) ? "'$title'" : "NULL") . ",
                    " . (!empty($description) ? "'$description'" : "NULL") . ",
                    " . (!empty($status) ? "'$status'" : "NULL") . ",
                    " . (!empty($dueDate) ? "'$dueDate'" : "NULL") . ",
                    " . (!empty($attachment) ? "'$attachment'" : "NULL") . "
                )";
        // $sql = "INSERT INTO tasks (title, description, status, dueDate, attachment_name, attachment_type, attachment_data) 
        // VALUES (
        //     '$title',
        //     '$description',
        //     '$status',
        //     '$dueDate',
        //     '$attachmentName',
        //     '$attachmentType',
        //     '$attachmentData'
        // )";
        // print_r($sql);
        if(mysqli_query($connection, $sql)){
            // echo "Data inserted successfully!";
            header("Location: taskList.php");
            exit();
        } else {
            echo "Error: " . mysqli_error($connection);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="libraries/bootstrap.min.css" rel="stylesheet">
    <title>Create Task</title>
</head>
<body>
    <?php require "./header.php"; ?>
    <main class="d-flex flex-column justify-content-center align-items-center mt-4">
        <h2>Create Task</h2>
        <div class="w-50">
            <form action="./createTask.php" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <span><?php echo $titleError; ?></span>
                    <label for="title" class="form-label">Title</label>
                    <input type="text" name='title' class="form-control" id="title" placeholder="Enter task title" required>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Task Description</label>
                    <textarea name="description" class="form-control" id="description" placeholder="Enter task description here......"></textarea>
                </div>

                <div class="mb-3">
                    <label for="attachment" class="form-label">Upload Attachment</label>
                    <input name='attachment' class="form-control" type="file" id="attachment">
                </div>

                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <div class="d-flex">
                        <div class="form-check me-3">
                            <input class="form-check-input" type="radio" name="status" value="pending" id="statusPending" checked>
                            <label class="form-check-label" for="statusPending">Pending</label>
                        </div>
                        <div class="form-check me-3">
                            <input class="form-check-input" type="radio" name="status" value="inprogress" id="statusInProgress">
                            <label class="form-check-label" for="statusInProgress">In Progress</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" value="completed" id="statusCompleted">
                            <label class="form-check-label" for="statusCompleted">Completed</label>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="dueDate" class="form-label">Due Date</label>
                    <input name='dueDate' class="form-control" type="date" id="dueDate" required>
                </div>

                <div class="d-flex justify-content-between">
                    <input type="submit" name="submit" value="Save" class="btn btn-primary mb-3 px-4">
                    <a class="btn btn-secondary text-white mb-3 px-4" href="./taskList.php">Cancel</a>
                </div>
            </form>
        </div>
    </main>
    <script src="libraries/bootstrap.min.js"></script>
</body>
</html>
