<?php include "db.php"; ?>

<?php
if(isset($_POST['submit'])){
    $name = $_POST['name'];
    $class = $_POST['class'];
  $roll_number = $_POST['roll_number'];

    $sql = "INSERT INTO student (name, class, roll_number) VALUES ('$name', '$class', '$roll_number')";
    mysqli_query($conn, $sql);

    header("Location: index.php");
}
?>

<h2>Add Student</h2>

<form method="POST">
  Name: <input type="text" name="name"><br><br>
  Class: <input type="text" name="class"><br><br>
  Roll No: <input type="number" name="roll_number"><br><br>
  <button name="submit">Save</button>
</form>
