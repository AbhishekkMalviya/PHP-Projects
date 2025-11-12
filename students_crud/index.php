<?php include "db.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Student List</title>

 
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Student List</h2>
        <a href="add.php" class="btn btn-primary">Add Student</a>
    </div>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Class</th>
              <th>Roll No</th>
              <th>Actions</th>
            </tr>
        </thead>

        <tbody>
        <?php
        $result = mysqli_query($conn, "SELECT * FROM student");
        while($row = mysqli_fetch_assoc($result)){
        ?>
            <tr>
              <td><?= $row['id'] ?></td>
              <td><?= $row['name'] ?></td>
              <td><?= $row['class'] ?></td>
              <td><?= $row['roll_number'] ?></td>
              <td>
                <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                <a href="delete.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?');">Delete</a>
              </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>

</body>
</html>
