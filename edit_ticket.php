<?php
session_start();
include("db/db_config.php");

$id = $_GET['id'];
$result = $conn->query("SELECT * FROM tickets WHERE id=$id AND user_id={$_SESSION['user_id']}");

if ($result->num_rows != 1) {
    echo "Invalid ticket or access denied.";
    exit();
}

$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Complaint - BHEL</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, #ff416c, #ff4b2b, #1e90ff, #32cd32, #9400d3);
            background-size: 400% 400%;
            animation: gradientBG 12s ease infinite;
        }

        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .form-container {
            background-color: rgba(255, 255, 255, 0.95);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            width: 350px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #1e1e1e;
        }

        input[type="text"],
        textarea {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 16px;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #1e90ff;
            border: none;
            border-radius: 8px;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #3742fa;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Edit Complaint</h2>
    <form method="POST" action="update_ticket.php">
        <input type="hidden" name="id" value="<?= $row['id'] ?>">
        <input type="text" name="title" value="<?= htmlspecialchars($row['title']) ?>" required>
        <textarea name="description" rows="5" required><?= htmlspecialchars($row['description']) ?></textarea>
        <button type="submit">Update</button>
    </form>
</div>

</body>
</html>
