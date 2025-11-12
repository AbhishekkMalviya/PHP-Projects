<!-- <?php include "db.php"; ?>

<?php
$id = $_GET['id'];

$result = mysqli_query($conn, "SELECT * FROM student WHERE id=$id");
$data = mysqli_fetch_assoc($result);

if(isset($_POST['update'])){
    $name = $_POST['name'];
    $class = $_POST['class'];
    $roll_number = $_POST['roll_number'];

    mysqli_query($conn, "UPDATE student SET name='$name', class='$class', roll_number='$roll_number' WHERE id=$id");

    header("Location: index.php");
}
?>

<h2>Edit Student</h2>

<form method="POST">
  Name: <input type="text" name="name" value="<?= $data['name'] ?>"><br><br>
  Class: <input type="text" name="class" value="<?= $data['class'] ?>"><br><br>
  Roll No: <input type="number" name="roll_number" value="<?= $data['roll_number'] ?>"><br><br>
  
  <button name="update"> Update</button>
</form> -->



<?php include "db.php"; ?>

<?php
$id = $_GET['id'];

$result = mysqli_query($conn, "SELECT * FROM student WHERE id=$id");
$data = mysqli_fetch_assoc($result);

if(isset($_POST['update'])){
    $name = $_POST['name'];
    $class = $_POST['class'];
    $roll_number = $_POST['roll_number'];

    mysqli_query($conn, "UPDATE student SET name='$name', class='$class', roll_number='$roll_number' WHERE id=$id");

    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            padding: 40px;
            width: 100%;
            max-width: 500px;
            animation: slideUp 0.5s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header h2 {
            color: #333;
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .header p {
            color: #666;
            font-size: 14px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            font-weight: 500;
            font-size: 14px;
        }

        .form-control {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e1e5e9;
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }

        .form-control:focus {
            outline: none;
            border-color: #667eea;
            background: white;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 14px 30px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        }

        .btn:active {
            transform: translateY(0);
        }

        .back-link {
            text-align: center;
            margin-top: 20px;
        }

        .back-link a {
            color: #667eea;
            text-decoration: none;
            font-size: 14px;
            transition: color 0.3s ease;
        }

        .back-link a:hover {
            color: #764ba2;
            text-decoration: underline;
        }

        .student-info {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid #667eea;
        }

        .student-info p {
            margin: 5px 0;
            color: #666;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>✏️ Edit Student</h2>
            <p>Update student information below</p>
        </div>

        <div class="student-info">
            <p><strong>Student ID:</strong> #<?= $id ?></p>
            <p><strong>Current Name:</strong> <?= htmlspecialchars($data['name']) ?></p>
        </div>

        <form method="POST">
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" class="form-control" value="<?= htmlspecialchars($data['name']) ?>" required>
            </div>

            <div class="form-group">
                <label for="class">Class</label>
                <input type="text" id="class" name="class" class="form-control" value="<?= htmlspecialchars($data['class']) ?>" required>
            </div>

            <div class="form-group">
                <label for="roll_number">Roll Number</label>
                <input type="number" id="roll_number" name="roll_number" class="form-control" value="<?= htmlspecialchars($data['roll_number']) ?>" required>
            </div>

            <button type="submit" name="update" class="btn">
                💾 Update Student
            </button>
        </form>

        <div class="back-link">
            <a href="index.php">← Back to Student List</a>
        </div>
    </div>

    <script>
        // Add some interactive effects
        document.addEventListener('DOMContentLoaded', function() {
            const inputs = document.querySelectorAll('.form-control');
            
            inputs.forEach(input => {
                // Add focus effect
                input.addEventListener('focus', function() {
                    this.parentElement.style.transform = 'scale(1.02)';
                });
                
                input.addEventListener('blur', function() {
                    this.parentElement.style.transform = 'scale(1)';
                });
            });

            // Form submission animation
            const form = document.querySelector('form');
            form.addEventListener('submit', function(e) {
                const btn = this.querySelector('.btn');
                btn.innerHTML = '⏳ Updating...';
                btn.style.opacity = '0.8';
            });
        });
    </script>
</body>
</html>